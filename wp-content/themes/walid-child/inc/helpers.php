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
 * Social proof / rating stats, in ONE place (owner-confirmed figures).
 * Filterable so they can be updated without touching templates, and so a future options page or
 * live Google data can override them. Verify counts periodically; socials drift.
 *
 * @return array{tiktok:string,facebook:string,instagram:string,rating:string,reviews:string}
 */
function walid_stats() {
	return apply_filters(
		'walid_stats',
		array(
			'tiktok'    => '561K',
			'facebook'  => '119K',
			'instagram' => '30.8K',
			'rating'    => '4.9',
			'reviews'   => '1,098',
		)
	);
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
	$allowed = array( 'hero', 'procedure', 'doctor', 'branch', 'service' );
	$name    = in_array( $name, $allowed, true ) ? $name : 'procedure';
	return esc_url( get_stylesheet_directory_uri() . '/assets/img/placeholder-' . $name . '.svg' );
}

/**
 * Hero ambient loop video, if one has been placed in the theme.
 * Returns an array of source URLs + poster, or false if no video exists yet (so the hero falls
 * back to the placeholder image). Drop the generated files in assets/video/ named:
 *   hero-loop.mp4 · hero-loop.webm (optional) · hero-poster.webp (optional)
 *
 * @return array{mp4:string,webm:string,poster:string}|false
 */
function walid_hero_video() {
	$dir = get_stylesheet_directory() . '/assets/video/';
	$uri = get_stylesheet_directory_uri() . '/assets/video/';
	if ( ! file_exists( $dir . 'hero-loop.mp4' ) ) {
		return false;
	}
	$poster = file_exists( $dir . 'hero-poster.webp' ) ? $uri . 'hero-poster.webp' : walid_placeholder( 'hero' );
	return array(
		'mp4'    => esc_url( $uri . 'hero-loop.mp4' ),
		'webm'   => file_exists( $dir . 'hero-loop.webm' ) ? esc_url( $uri . 'hero-loop.webm' ) : '',
		'poster' => esc_url( $poster ),
	);
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
 * Permitted reviews tied to a specific branch (no cross-branch borrowing).
 *
 * @param int $branch_id Branch post ID.
 * @param int $limit     Max reviews.
 * @return WP_Post[]
 */
function walid_branch_reviews( $branch_id, $limit = 6 ) {
	return get_posts(
		array(
			'post_type'      => 'review',
			'posts_per_page' => $limit,
			// phpcs:disable WordPress.DB.SlowDBQuery
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'   => 'review_permission',
					'value' => '1',
				),
				array(
					'key'   => 'review_branch',
					'value' => $branch_id,
				),
			),
			// phpcs:enable WordPress.DB.SlowDBQuery
		)
	);
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

/**
 * Permitted reviews associated with a pillar (optional review_pillar meta).
 *
 * Lets each pillar page show reviews relevant to it. Reviews are matched when their
 * review_pillar meta equals the pillar name. Returns an empty array when none match, so the
 * caller can fall back to pillar-tailored sample quotes.
 *
 * @param string $pillar_name Pillar term name (e.g. "Minor Surgery").
 * @param int    $limit       Max reviews.
 * @return WP_Post[]
 */
function walid_permitted_reviews_for_pillar( $pillar_name, $limit = 3 ) {
	if ( '' === (string) $pillar_name ) {
		return array();
	}
	return get_posts(
		array(
			'post_type'      => 'review',
			'posts_per_page' => $limit,
			// phpcs:disable WordPress.DB.SlowDBQuery
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'   => 'review_permission',
					'value' => '1',
				),
				array(
					'key'   => 'review_pillar',
					'value' => $pillar_name,
				),
			),
			// phpcs:enable WordPress.DB.SlowDBQuery
		)
	);
}

/**
 * Pillar-tailored sample testimonials for service pages.
 *
 * Used as a graceful fallback until permitted Review CPT posts exist. Each quote is written to
 * feel relevant to the pillar (minor surgery / aesthetics / antenatal / general). Flagged as
 * pending permission so nothing unpermitted is presented as a verified named review.
 *
 * @param string $pillar Pillar name (e.g. "Minor Surgery").
 * @return array<int,array{q:string,w:string,s:int}>
 */
function walid_pillar_sample_reviews( $pillar ) {
	$pending = __( 'Google review [permission pending]', 'walid' );

	if ( false !== stripos( $pillar, 'Antenatal' ) ) {
		$set = array(
			__( 'Dr Anis was gentle and thorough at every visit. I felt safe through the whole pregnancy.', 'walid' ),
			__( 'Clear answers to every question and a calm, caring approach. Highly recommended for mums.', 'walid' ),
			__( 'Warm, professional and never rushed. The women\'s health care here is excellent.', 'walid' ),
		);
	} elseif ( false !== stripos( $pillar, 'Aesthetic' ) ) {
		$set = array(
			__( 'Natural-looking result and honest advice on what would actually suit me.', 'walid' ),
			__( 'Clean, modern and professional. The team explained every step before starting.', 'walid' ),
			__( 'Comfortable throughout and genuinely happy with how it turned out.', 'walid' ),
		);
	} elseif ( false !== stripos( $pillar, 'General' ) ) {
		$set = array(
			__( 'Seen quickly and treated with real care. The doctor listened properly.', 'walid' ),
			__( 'Friendly staff, clean clinic and clear advice. My go-to for the family.', 'walid' ),
			__( 'Easy to reach on WhatsApp and sorted my concern the same day.', 'walid' ),
		);
	} else { // Minor Surgery (default).
		$set = array(
			__( 'Quick day-care procedure and a clear explanation. Home the same afternoon.', 'walid' ),
			__( 'The surgeon talked me through everything first. Calm, clean and professional.', 'walid' ),
			__( 'Booked over WhatsApp and seen fast. Minor surgery done without the hospital wait.', 'walid' ),
		);
	}

	$out = array();
	foreach ( $set as $q ) {
		$out[] = array(
			'q' => $q,
			'w' => $pending,
			's' => 5,
		);
	}
	return $out;
}
