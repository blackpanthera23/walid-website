<?php
/**
 * Walid theme helpers: WhatsApp links, social config, and small render utilities.
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build a wa.me link for a given routing context.
 *
 * @param string $context 'general' or 'minor_surgery'.
 * @param string $text    Optional prefilled message.
 * @return string
 */
function walid_whatsapp_url( $context = 'general', $text = '' ) {
	$number = ( 'minor_surgery' === $context ) ? WALID_WA_MINOR_SURGERY : WALID_WA_GENERAL;
	$url    = 'https://wa.me/' . rawurlencode( $number );
	if ( $text ) {
		$url .= '?text=' . rawurlencode( $text );
	}
	return esc_url( $url );
}

/**
 * Social profiles. Every entry MUST have a real URL (a prior build shipped empty hrefs).
 * Owner to confirm/replace these handles; they are the known public profiles.
 *
 * @return array<int,array{label:string,short:string,url:string}>
 */
function walid_social_links() {
	return array(
		array(
			'label' => 'TikTok',
			'short' => 'TikTok',
			'url'   => 'https://www.tiktok.com/@drwalidutagha',
		),
		array(
			'label' => 'Facebook',
			'short' => 'f',
			'url'   => 'https://www.facebook.com/profile.php?id=100080089330356',
		),
		array(
			'label' => 'Instagram',
			'short' => 'IG',
			'url'   => 'https://www.instagram.com/drwalidutagha/',
		),
		array(
			'label' => 'Google',
			'short' => 'G',
			'url'   => 'https://www.google.com/search?q=Poliklinik+Walid',
		),
	);
}

/**
 * Query branches by region term name, returning post objects.
 * Falls back to an empty array if no branches exist yet (template shows draft copy).
 *
 * @param string $region_name Region term name.
 * @return WP_Post[]
 */
function walid_branches_in_region( $region_name ) {
	$term = get_term_by( 'name', $region_name, 'region' );
	if ( ! $term ) {
		return array();
	}
	return get_posts(
		array(
			'post_type'      => 'branch',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'region',
					'field'    => 'term_id',
					'terms'    => $term->term_id,
				),
			),
		)
	);
}

/**
 * URI for a branded placeholder image (used until real photos are supplied).
 *
 * @param string $name One of: hero, procedure, doctor, branch.
 * @return string
 */
function walid_placeholder( $name ) {
	$allowed = array( 'hero', 'procedure', 'doctor', 'branch' );
	$name    = in_array( $name, $allowed, true ) ? $name : 'procedure';
	return esc_url( get_stylesheet_directory_uri() . '/assets/img/placeholder-' . $name . '.svg' );
}

/**
 * Proof-wall videos for the homepage social wall.
 * Each item: platform, url (to the post/profile), label. Owner replaces the URLs with real
 * video links; until then they point at the profiles. Filterable so a future options page can
 * supply them without template edits.
 *
 * @return array<int,array{platform:string,url:string,label:string}>
 */
function walid_proof_videos() {
	$defaults = array(
		array(
			'platform' => 'tiktok',
			'url'      => 'https://www.tiktok.com/@drwalidutagha',
			'label'    => __( 'Procedure clip', 'walid' ),
		),
		array(
			'platform' => 'tiktok',
			'url'      => 'https://www.tiktok.com/@drwalidutagha',
			'label'    => __( 'Patient story', 'walid' ),
		),
		array(
			'platform' => 'instagram',
			'url'      => 'https://www.instagram.com/drwalidutagha/',
			'label'    => __( 'Day-care explainer', 'walid' ),
		),
	);
	/**
	 * Filter the proof-wall videos. Return an array of {platform,url,label}.
	 * [confirm] real video URLs before launch.
	 */
	return apply_filters( 'walid_proof_videos', $defaults );
}

/**
 * Published reviews that have permission to be shown.
 *
 * @param int $limit Max reviews.
 * @return WP_Post[]
 */
function walid_permitted_reviews( $limit = 3 ) {
	return get_posts(
		array(
			'post_type'      => 'review',
			'posts_per_page' => $limit,
			'meta_key'       => 'review_permission', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'     => '1', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
		)
	);
}
