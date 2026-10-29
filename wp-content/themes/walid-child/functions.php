<?php
/**
 * Walid Child theme bootstrap.
 *
 * Child theme on Kadence. Loads brand tokens (ported from the prototype) + Fraunces/Inter,
 * registers the WhatsApp config, and wires custom templates/patterns (added in later tasks).
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WhatsApp numbers, in one place (used by the floating button + CTAs).
 * Minor-surgery pages route to the minor-surgery line; everything else to general.
 */
define( 'WALID_WA_GENERAL', '60142521684' );       // 014-252 1684
define( 'WALID_WA_MINOR_SURGERY', '60175497593' ); // 017-549 7593

// Theme helpers (WhatsApp links, social config, CPT queries).
require_once get_stylesheet_directory() . '/inc/helpers.php';

/**
 * Enqueue parent styles, child brand tokens, and web fonts.
 */
function walid_enqueue_assets() {
	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );

	// Parent (Kadence) stylesheet.
	wp_enqueue_style(
		'kadence-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		$theme->parent() ? $theme->parent()->get( 'Version' ) : $version
	);

	// Web fonts: Fraunces (headings) + Inter (body), display=swap, preconnected (see below).
	wp_enqueue_style(
		'walid-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// Child brand tokens (ported 1:1 from the prototype :root).
	wp_enqueue_style(
		'walid-brand',
		get_stylesheet_directory_uri() . '/assets/css/brand.css',
		array( 'kadence-parent', 'walid-fonts' ),
		$version
	);

	// The theme header file (style.css) so WP registers the active child stylesheet.
	wp_enqueue_style(
		'walid-child',
		get_stylesheet_uri(),
		array( 'walid-brand' ),
		$version
	);

	// Homepage-only styles (ported from the prototype).
	if ( is_front_page() ) {
		wp_enqueue_style(
			'walid-homepage',
			get_stylesheet_directory_uri() . '/assets/css/homepage.css',
			array( 'walid-brand' ),
			$version
		);
	}

	// Singular CPT template styles.
	if ( is_singular( array( 'branch', 'service', 'doctor' ) ) ) {
		wp_enqueue_style(
			'walid-single',
			get_stylesheet_directory_uri() . '/assets/css/single.css',
			array( 'walid-brand' ),
			$version
		);
	}
}
add_action( 'wp_enqueue_scripts', 'walid_enqueue_assets' );

/**
 * Site-wide floating WhatsApp button. Minor-surgery singulars route to the surgery line.
 */
function walid_floating_whatsapp() {
	$context = 'general';
	if ( is_singular( 'service' ) && 'minor_surgery' === get_field( 'service_wa_routing' ) ) {
		$context = 'minor_surgery';
	}
	if ( is_singular( 'branch' ) && get_field( 'branch_provides_minor_surgery' ) ) {
		$context = 'minor_surgery';
	}
	printf(
		'<a class="walid-fab" href="%s" target="_blank" rel="noopener">%s %s</a>',
		walid_whatsapp_url( $context, __( 'Hi Poliklinik Walid, I have a question.', 'walid' ) ),
		'&#128172;',
		esc_html__( 'WhatsApp us', 'walid' )
	);
}
add_action( 'wp_footer', 'walid_floating_whatsapp' );

/**
 * Preconnect to Google Fonts so font loading is non-render-blocking.
 */
function walid_font_preconnect( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'walid_font_preconnect', 10, 2 );

/**
 * Theme setup: text domain (translatable later, English-only now) + supports.
 */
function walid_setup() {
	load_child_theme_textdomain( 'walid', get_stylesheet_directory() . '/languages' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'style', 'script', 'navigation-widgets' ) );
}
add_action( 'after_setup_theme', 'walid_setup' );

/**
 * Point ACF local JSON at the child theme so field groups are version-controlled and auto-sync
 * on any install (no manual admin setup needed).
 */
function walid_acf_json_save_point( $path ) {
	return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'walid_acf_json_save_point' );

function walid_acf_json_load_point( $paths ) {
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'walid_acf_json_load_point' );
