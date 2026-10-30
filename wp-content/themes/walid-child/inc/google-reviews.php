<?php
/**
 * Google Places reviews for branch pages.
 *
 * Fetches up to 5 reviews + the overall rating for a branch's Google Place ID, cached in a
 * transient (Google's terms disallow long-term storage; we cache short-term for speed/quota).
 *
 * Requires an API key defined in wp-config.php:
 *     define( 'WALID_GOOGLE_PLACES_KEY', 'your-key' );
 *
 * Degrades gracefully: no key or no Place ID -> returns empty, and the branch template falls
 * back to curated CPT reviews, then to the "read on Google" state.
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Is the Google Places integration configured?
 *
 * @return bool
 */
function walid_google_key() {
	return defined( 'WALID_GOOGLE_PLACES_KEY' ) && WALID_GOOGLE_PLACES_KEY ? WALID_GOOGLE_PLACES_KEY : '';
}

/**
 * Fetch rating + reviews for a Place ID (cached 12h). Uses the Places API (new) Place Details.
 *
 * @param string $place_id Google Place ID.
 * @return array{rating:float,total:int,url:string,reviews:array<int,array{author:string,rating:int,text:string,time:string,url:string}>}|null
 */
function walid_google_reviews( $place_id ) {
	$key = walid_google_key();
	if ( ! $key || ! $place_id ) {
		return null;
	}

	$cache_key = 'walid_gr_' . md5( $place_id );
	$cached    = get_transient( $cache_key );
	if ( false !== $cached ) {
		return $cached ? $cached : null;
	}

	$endpoint = 'https://places.googleapis.com/v1/places/' . rawurlencode( $place_id );
	$response = wp_remote_get(
		$endpoint,
		array(
			'timeout' => 8,
			'headers' => array(
				'X-Goog-Api-Key'   => $key,
				'X-Goog-FieldMask' => 'rating,userRatingCount,googleMapsUri,reviews',
			),
		)
	);

	if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
		// Cache the failure briefly so a bad key/quota doesn't hammer the API on every view.
		set_transient( $cache_key, array(), HOUR_IN_SECONDS );
		return null;
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( ! is_array( $body ) ) {
		set_transient( $cache_key, array(), HOUR_IN_SECONDS );
		return null;
	}

	$reviews = array();
	foreach ( (array) ( $body['reviews'] ?? array() ) as $r ) {
		$reviews[] = array(
			'author' => isset( $r['authorAttribution']['displayName'] ) ? sanitize_text_field( $r['authorAttribution']['displayName'] ) : '',
			'rating' => isset( $r['rating'] ) ? (int) $r['rating'] : 5,
			'text'   => isset( $r['text']['text'] ) ? wp_kses_post( $r['text']['text'] ) : '',
			'time'   => isset( $r['relativePublishTimeDescription'] ) ? sanitize_text_field( $r['relativePublishTimeDescription'] ) : '',
			'url'    => isset( $r['googleMapsUri'] ) ? esc_url_raw( $r['googleMapsUri'] ) : '',
		);
	}

	$data = array(
		'rating'  => isset( $body['rating'] ) ? (float) $body['rating'] : 0,
		'total'   => isset( $body['userRatingCount'] ) ? (int) $body['userRatingCount'] : 0,
		'url'     => isset( $body['googleMapsUri'] ) ? esc_url_raw( $body['googleMapsUri'] ) : '',
		'reviews' => $reviews,
	);

	set_transient( $cache_key, $data, 12 * HOUR_IN_SECONDS );
	return $data;
}

/**
 * Clear all cached Google review data (e.g. after changing keys). Admin bar action or WP-CLI:
 *   wp eval 'walid_flush_google_reviews();'
 */
function walid_flush_google_reviews() {
	global $wpdb;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_walid_gr_%' OR option_name LIKE '_transient_timeout_walid_gr_%'" );
}
