<?php
/**
 * One-shot live setup: create the template pages, set the static homepage, build + assign the
 * primary menu, and flush permalinks. Safe to re-run (idempotent).
 *
 * Run on the host:
 *   wp eval-file finish-setup.php
 * (or via SSH / the hosting WP-CLI). Does NOT create branch/doctor/service content — that is
 * entered via the CMS (see docs/CONTENT-CHECKLIST.md).
 *
 * @package walid
 */

/**
 * Create (or fetch) a page with a given template, return its ID.
 */
function walid_ensure_page( $title, $slug, $template = '' ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		$id = $existing->ID;
	} else {
		$id = wp_insert_post(
			array(
				'post_type'   => 'page',
				'post_title'  => $title,
				'post_name'   => $slug,
				'post_status' => 'publish',
			)
		);
	}
	if ( $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}
	return $id;
}

// 1. Pages + templates.
$home = walid_ensure_page( 'Home', 'home', '' );
$about = walid_ensure_page( 'About', 'about', 'page-governance.php' );
$intl  = walid_ensure_page( 'International Patients', 'international-patients', 'page-international.php' );
$contact = walid_ensure_page( 'Contact', 'contact', 'page-contact.php' );

// 2. Static front page.
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home );

// 3. Permalinks = Post name (then flush below).
update_option( 'permalink_structure', '/%postname%/' );

// 4. Primary menu.
$menu_name = 'Primary';
$menu      = wp_get_nav_menu_object( $menu_name );
$menu_id   = $menu ? $menu->term_id : wp_create_nav_menu( $menu_name );
// Clear + rebuild so re-runs stay clean.
foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $it ) {
	wp_delete_post( $it->ID, true );
}
$add = function ( $title, $url ) use ( $menu_id ) {
	wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title'  => $title,
			'menu-item-url'    => $url,
			'menu-item-status' => 'publish',
		)
	);
};
$add( 'Home', home_url( '/' ) );
$add( 'Services', get_post_type_archive_link( 'service' ) );
$add( 'Branches', get_post_type_archive_link( 'branch' ) );
$add( 'Doctors', get_post_type_archive_link( 'doctor' ) );
$add( 'About', get_permalink( $about ) );
$add( 'International', get_permalink( $intl ) );
$add( 'Contact', get_permalink( $contact ) );

// Assign to the theme's primary location (Astra uses "primary"/"menu-1"; set both to be safe).
$locations            = get_theme_mod( 'nav_menu_locations', array() );
$locations['primary'] = $menu_id;
$locations['menu-1']  = $menu_id;
set_theme_mod( 'nav_menu_locations', $locations );

// 5. Flush rewrite rules so CPT URLs (/procedures/..., /services/...) resolve.
flush_rewrite_rules();

WP_CLI::success( 'Setup done: pages (home/about/international/contact), static front page, Post-name permalinks, Primary menu assigned, rewrites flushed.' );
WP_CLI::log( 'Next: enter real content via the CMS (docs/CONTENT-CHECKLIST.md).' );
