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

/**
 * Inline line-icon for a Minor Surgery category card header.
 *
 * Returns an SVG that uses currentColor so the card can tint it. Abstract, non-clinical marks
 * (no blood, needles or gore) in keeping with the brand's calm, premium imagery rules.
 *
 * @param string $key Category icon key.
 * @return string SVG markup.
 */
function walid_category_icon( $key ) {
	$icons = array(
		// Skin and subcutaneous tissue: concentric soft layers.
		'skin'      => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 30c0-9 7-16 16-16s16 7 16 16"/><path d="M15 31c0-5 4-9 9-9s9 4 9 9"/><circle cx="24" cy="31" r="2.6" fill="currentColor" stroke="none"/></svg>',
		// Wound care and trauma repair: dressing / plaster cross.
		'wound'     => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="11" y="18" width="26" height="12" rx="6" transform="rotate(-25 24 24)"/><path d="M24 20v8M20 24h8"/></svg>',
		// Nail and minor dermatological surgeries: fine precision point.
		'nail'      => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 34l16-16 4 4-16 16-6 2z"/><path d="M28 16l4-4 4 4-4 4"/></svg>',
		// Therapeutic and joint injections: joint / pivot marks.
		'injection' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="24" cy="24" r="6"/><path d="M24 6v8M24 34v8M6 24h8M34 24h8"/></svg>',
		// Minor gynaecological and urological: shield of care.
		'gynae'     => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M24 7l14 5v9c0 9-6 15-14 20-8-5-14-11-14-20v-9z"/><path d="M19 24l4 4 7-8"/></svg>',
		// Others: soft cluster of dots.
		'others'    => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="17" cy="19" r="4"/><circle cx="31" cy="19" r="4"/><circle cx="24" cy="31" r="4"/></svg>',
	);
	return isset( $icons[ $key ] ) ? $icons[ $key ] : $icons['others'];
}

/**
 * Convert a two-letter ISO country code to its flag emoji (regional indicator pair).
 *
 * @param string $iso2 Two-letter code, e.g. "MY".
 * @return string Flag emoji, or empty string on bad input.
 */
function walid_flag_emoji( $iso2 ) {
	$iso2 = strtoupper( trim( (string) $iso2 ) );
	if ( ! preg_match( '/^[A-Z]{2}$/', $iso2 ) ) {
		return '';
	}
	$base  = 0x1F1E6; // Regional Indicator Symbol Letter A.
	$out   = '';
	foreach ( str_split( $iso2 ) as $ch ) {
		$out .= mb_convert_encoding( '&#' . ( $base + ( ord( $ch ) - ord( 'A' ) ) ) . ';', 'UTF-8', 'HTML-ENTITIES' );
	}
	return $out;
}

/**
 * Countries that patients travel from, for the International Patients page.
 * Owner-confirmed list. Filterable so it can be extended without template edits.
 *
 * @return array<int,array{name:string,iso:string}>
 */
function walid_international_countries() {
	$countries = array(
		array( 'name' => 'Singapore', 'iso' => 'SG' ),
		array( 'name' => 'Indonesia', 'iso' => 'ID' ),
		array( 'name' => 'Brunei', 'iso' => 'BN' ),
		array( 'name' => 'Thailand', 'iso' => 'TH' ),
		array( 'name' => 'Vietnam', 'iso' => 'VN' ),
		array( 'name' => 'Laos', 'iso' => 'LA' ),
		array( 'name' => 'Myanmar', 'iso' => 'MM' ),
		array( 'name' => 'Philippines', 'iso' => 'PH' ),
		array( 'name' => 'China', 'iso' => 'CN' ),
		array( 'name' => 'Korea', 'iso' => 'KR' ),
		array( 'name' => 'India', 'iso' => 'IN' ),
		array( 'name' => 'Bangladesh', 'iso' => 'BD' ),
		array( 'name' => 'Sri Lanka', 'iso' => 'LK' ),
		array( 'name' => 'Nepal', 'iso' => 'NP' ),
		array( 'name' => 'Pakistan', 'iso' => 'PK' ),
		array( 'name' => 'Afghanistan', 'iso' => 'AF' ),
		array( 'name' => 'Kazakhstan', 'iso' => 'KZ' ),
		array( 'name' => 'Iran', 'iso' => 'IR' ),
		array( 'name' => 'Turkey', 'iso' => 'TR' ),
		array( 'name' => 'Saudi Arabia', 'iso' => 'SA' ),
		array( 'name' => 'Oman', 'iso' => 'OM' ),
		array( 'name' => 'Yemen', 'iso' => 'YE' ),
		array( 'name' => 'Syria', 'iso' => 'SY' ),
		array( 'name' => 'Egypt', 'iso' => 'EG' ),
		array( 'name' => 'Libya', 'iso' => 'LY' ),
		array( 'name' => 'Algeria', 'iso' => 'DZ' ),
		array( 'name' => 'Sudan', 'iso' => 'SD' ),
		array( 'name' => 'Somalia', 'iso' => 'SO' ),
		array( 'name' => 'Nigeria', 'iso' => 'NG' ),
		array( 'name' => 'France', 'iso' => 'FR' ),
		array( 'name' => 'United States', 'iso' => 'US' ),
		array( 'name' => 'Australia', 'iso' => 'AU' ),
	);
	return apply_filters( 'walid_international_countries', $countries );
}
