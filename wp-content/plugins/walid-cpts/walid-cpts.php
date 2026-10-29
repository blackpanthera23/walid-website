<?php
/**
 * Plugin Name:       Walid CPTs
 * Description:       Custom post types, taxonomies, and fields for Poliklinik Walid
 *                    (Branch, Service, Doctor, Review). Kept in a plugin so the content model
 *                    survives theme switches. See docs/05-content-model.md + docs/11.
 * Version:           0.2.0
 * Requires PHP:      8.2
 * Author:            Poliklinik Walid build
 * Text Domain:       walid
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WALID_CPTS_VERSION', '0.2.0' );

/**
 * Register custom post types: Branch, Service, Doctor, Review.
 */
function walid_register_post_types() {

	// --- Branch -------------------------------------------------------------
	register_post_type(
		'branch',
		array(
			'labels'       => walid_cpt_labels( __( 'Branch', 'walid' ), __( 'Branches', 'walid' ) ),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-location',
			'menu_position' => 20,
			'rewrite'      => array( 'slug' => 'branches', 'with_front' => false ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'show_in_rest' => true,
		)
	);

	// --- Service ------------------------------------------------------------
	register_post_type(
		'service',
		array(
			'labels'       => walid_cpt_labels( __( 'Service', 'walid' ), __( 'Services', 'walid' ) ),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-heart',
			'menu_position' => 21,
			'rewrite'      => array( 'slug' => 'services', 'with_front' => false ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'show_in_rest' => true,
		)
	);

	// --- Doctor -------------------------------------------------------------
	register_post_type(
		'doctor',
		array(
			'labels'       => walid_cpt_labels( __( 'Doctor', 'walid' ), __( 'Doctors', 'walid' ) ),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-businessperson',
			'menu_position' => 22,
			'rewrite'      => array( 'slug' => 'doctors', 'with_front' => false ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest' => true,
		)
	);

	// --- Review -------------------------------------------------------------
	register_post_type(
		'review',
		array(
			'labels'        => walid_cpt_labels( __( 'Review', 'walid' ), __( 'Reviews', 'walid' ) ),
			'public'        => true,
			'has_archive'   => false,
			'menu_icon'     => 'dashicons-star-filled',
			'menu_position' => 23,
			'rewrite'       => array( 'slug' => 'reviews', 'with_front' => false ),
			'supports'      => array( 'title', 'editor' ),
			'show_in_rest'  => true,
		)
	);
}
add_action( 'init', 'walid_register_post_types' );

/**
 * Register taxonomies: Region (Branch) + Pillar (Service).
 */
function walid_register_taxonomies() {

	// Region — powers the two-hub minor-surgery model + branch filtering.
	register_taxonomy(
		'region',
		array( 'branch' ),
		array(
			'labels'            => walid_tax_labels( __( 'Region', 'walid' ), __( 'Regions', 'walid' ) ),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'region' ),
		)
	);

	// Pillar — Minor Surgery (hero) / Aesthetics / Antenatal / Pillar-4-TBD / General.
	register_taxonomy(
		'pillar',
		array( 'service' ),
		array(
			'labels'            => walid_tax_labels( __( 'Pillar', 'walid' ), __( 'Pillars', 'walid' ) ),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'pillar' ),
		)
	);
}
add_action( 'init', 'walid_register_taxonomies' );

/**
 * Seed default taxonomy terms on activation so editors start from the agreed structure.
 * Idempotent: wp_insert_term skips terms that already exist.
 */
function walid_seed_terms() {
	walid_register_taxonomies();

	$regions = array( 'Central (Klang Valley)', 'North (Penang / Kedah)', 'Other' );
	foreach ( $regions as $region ) {
		if ( ! term_exists( $region, 'region' ) ) {
			wp_insert_term( $region, 'region' );
		}
	}

	$pillars = array(
		'Minor Surgery',   // hero
		'Aesthetics',      // rising
		'Antenatal & Women\'s Health', // rising (Dr Anis)
		'Pillar 4 (TBD)',  // reserved placeholder
		'General Medicine', // network base
	);
	foreach ( $pillars as $pillar ) {
		if ( ! term_exists( $pillar, 'pillar' ) ) {
			wp_insert_term( $pillar, 'pillar' );
		}
	}

	flush_rewrite_rules();
}

/**
 * On activation, register types + seed terms, then flush rewrite rules.
 */
function walid_cpts_activate() {
	walid_register_post_types();
	walid_seed_terms();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'walid_cpts_activate' );

/**
 * On deactivation, flush rewrite rules.
 */
function walid_cpts_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'walid_cpts_deactivate' );

/**
 * Build a standard labels array for a CPT.
 *
 * @param string $singular Singular label.
 * @param string $plural   Plural label.
 * @return array
 */
function walid_cpt_labels( $singular, $plural ) {
	return array(
		'name'               => $plural,
		'singular_name'      => $singular,
		'add_new_item'       => sprintf( /* translators: %s: singular post type name */ __( 'Add New %s', 'walid' ), $singular ),
		'edit_item'          => sprintf( /* translators: %s: singular post type name */ __( 'Edit %s', 'walid' ), $singular ),
		'new_item'           => sprintf( /* translators: %s: singular post type name */ __( 'New %s', 'walid' ), $singular ),
		'view_item'          => sprintf( /* translators: %s: singular post type name */ __( 'View %s', 'walid' ), $singular ),
		'search_items'       => sprintf( /* translators: %s: plural post type name */ __( 'Search %s', 'walid' ), $plural ),
		'not_found'          => sprintf( /* translators: %s: plural post type name */ __( 'No %s found', 'walid' ), strtolower( $plural ) ),
		'all_items'          => $plural,
		'menu_name'          => $plural,
	);
}

/**
 * Build a standard labels array for a taxonomy.
 *
 * @param string $singular Singular label.
 * @param string $plural   Plural label.
 * @return array
 */
function walid_tax_labels( $singular, $plural ) {
	return array(
		'name'          => $plural,
		'singular_name' => $singular,
		'search_items'  => sprintf( /* translators: %s: plural taxonomy name */ __( 'Search %s', 'walid' ), $plural ),
		'all_items'     => sprintf( /* translators: %s: plural taxonomy name */ __( 'All %s', 'walid' ), $plural ),
		'edit_item'     => sprintf( /* translators: %s: singular taxonomy name */ __( 'Edit %s', 'walid' ), $singular ),
		'add_new_item'  => sprintf( /* translators: %s: singular taxonomy name */ __( 'Add New %s', 'walid' ), $singular ),
		'menu_name'     => $plural,
	);
}
