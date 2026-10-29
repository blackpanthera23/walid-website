<?php
/**
 * Walid Child theme bootstrap.
 *
 * Minimal for now (Task 3 scaffolds it fully). Enqueues the parent + child styles.
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue parent and child stylesheets.
 */
function walid_enqueue_styles() {
	wp_enqueue_style( 'kadence-parent', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->parent()->get( 'Version' ) );
	wp_enqueue_style( 'walid-child', get_stylesheet_uri(), array( 'kadence-parent' ), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'walid_enqueue_styles' );

/**
 * Load the theme text domain (translatable later, English-only now).
 */
function walid_setup() {
	load_child_theme_textdomain( 'walid', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'walid_setup' );
