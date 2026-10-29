<?php
/**
 * SEO + schema for Poliklinik Walid.
 *
 * Branch pages are the local-search engine, so they emit MedicalClinic JSON-LD built from CPT
 * fields. Rank Math handles titles/meta/sitemap; this adds the structured data it does not.
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Emit MedicalClinic / LocalBusiness JSON-LD on single Branch pages.
 * Only outputs fields that exist, so an unfinished branch stays valid.
 */
function walid_branch_schema() {
	if ( ! is_singular( 'branch' ) ) {
		return;
	}

	$id      = get_the_ID();
	$address = get_field( 'branch_address', $id );
	$phone   = get_field( 'branch_phone', $id );
	$hours   = get_field( 'branch_hours', $id );

	$data = array(
		'@context' => 'https://schema.org',
		'@type'    => 'MedicalClinic',
		'name'     => wp_strip_all_tags( get_the_title( $id ) ),
		'url'      => get_permalink( $id ),
		'parentOrganization' => array(
			'@type' => 'Organization',
			'name'  => 'Walid Healthcare Group Sdn. Bhd.',
		),
	);

	if ( $address ) {
		$data['address'] = array(
			'@type'         => 'PostalAddress',
			'streetAddress' => wp_strip_all_tags( $address ),
			'addressCountry' => 'MY',
		);
	}
	if ( $phone ) {
		$data['telephone'] = wp_strip_all_tags( $phone );
	}
	if ( $hours && is_array( $hours ) ) {
		$spec = array();
		foreach ( $hours as $row ) {
			if ( ! empty( $row['day'] ) && ! empty( $row['time'] ) ) {
				$spec[] = array(
					'@type'  => 'OpeningHoursSpecification',
					'dayOfWeek' => wp_strip_all_tags( $row['day'] ),
					'description' => wp_strip_all_tags( $row['time'] ),
				);
			}
		}
		if ( $spec ) {
			$data['openingHoursSpecification'] = $spec;
		}
	}

	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'walid_branch_schema' );

/**
 * Organization + aggregate rating on the front page (the 4.9 / 1,098 proof).
 * Marked owner-confirmed; keep in sync with real figures before launch.
 */
function walid_org_schema() {
	if ( ! is_front_page() ) {
		return;
	}
	$data = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'MedicalOrganization',
		'name'        => 'Poliklinik Walid',
		'legalName'   => 'Walid Healthcare Group Sdn. Bhd.',
		'url'         => home_url( '/' ),
		'sameAs'      => wp_list_pluck( walid_social_links(), 'url' ),
		'aggregateRating' => array(
			'@type'       => 'AggregateRating',
			'ratingValue' => '4.9',
			'reviewCount' => '1098',
		),
	);
	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'walid_org_schema' );

/**
 * Accessibility: a skip link to the main content.
 */
function walid_skip_link() {
	echo '<a class="walid-skip-link screen-reader-text" href="#primary">' . esc_html__( 'Skip to content', 'walid' ) . '</a>';
}
add_action( 'wp_body_open', 'walid_skip_link' );
