<?php
/**
 * Parent theme (Astra) compatibility.
 *
 * The child theme owns the design. These filters stop parent settings saved in the database (a
 * starter-template palette, a transparent header) from changing the look, so local and live match
 * whatever the Customizer holds. Every filter is a no-op when the parent is not Astra.
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Brand palette in Astra's slot order (0-indexed): Brand, Alternate Brand, Headings, Text,
 * Primary Background, Secondary Background, Alternate Background, Subtle Background, Other.
 *
 * @return string[]
 */
function walid_astra_palette() {
	return array(
		'#232B8F', // 0 Brand (navy).
		'#161B5E', // 1 Alternate brand (deep navy).
		'#161B5E', // 2 Headings.
		'#1A1D2E', // 3 Text.
		'#FFFFFF', // 4 Primary background.
		'#F8F9FC', // 5 Secondary background.
		'#1A1D2E', // 6 Alternate background (dark).
		'#DDE0EC', // 7 Subtle background / borders.
		'#5B607A', // 8 Other supporting (muted text).
	);
}

/**
 * Astra builds its --ast-global-color-N CSS variables from the `global-color-palette` setting.
 *
 * @param mixed $value Saved value.
 * @return array
 */
function walid_astra_palette_option( $value ) {
	$value            = is_array( $value ) ? $value : array();
	$value['palette'] = walid_astra_palette();
	return $value;
}
add_filter( 'astra_get_option_global-color-palette', 'walid_astra_palette_option' );

/**
 * The editor and Customizer read the named palette set; keep the active set on brand too.
 *
 * @param mixed $data Palette data.
 * @return mixed
 */
function walid_astra_palette_sets( $data ) {
	if ( is_array( $data ) ) {
		$current                        = isset( $data['currentPalette'] ) ? $data['currentPalette'] : 'palette_1';
		$data['palettes'][ $current ] = walid_astra_palette();
	}
	return $data;
}
add_filter( 'astra_global_color_palette', 'walid_astra_palette_sets' );

/**
 * No transparent header: the homepage and page heroes are designed to sit below a solid header.
 * (A transparent header made the menu overlap the hero headline on the live site.)
 */
add_filter( 'astra_is_transparent_header', '__return_false' );

/**
 * Our templates manage their own width (each section has its own container), so they need
 * Astra's full-width "page builder" layout. Under Astra's default boxed/plain layout every
 * homepage section (and the service/branch heroes) was squeezed into a 1200px column, which cut
 * the section backgrounds short on wide screens. Kadence did not do this, which is why local and
 * live used to differ.
 *
 * @return bool True on the front page, our CPT views and our page templates.
 */
function walid_is_full_width_view() {
	if ( is_front_page() ) {
		return true;
	}
	if ( is_singular( array( 'service', 'branch', 'doctor', 'procedure' ) ) || is_post_type_archive( array( 'service', 'branch', 'doctor', 'procedure' ) ) ) {
		return true;
	}
	return is_page_template( array( 'page-governance.php', 'page-international.php', 'page-contact.php' ) );
}

/**
 * @param string $layout Astra content layout.
 * @return string
 */
function walid_astra_content_layout( $layout ) {
	return walid_is_full_width_view() ? 'page-builder' : $layout;
}
add_filter( 'astra_get_content_layout', 'walid_astra_content_layout', 20 );

/**
 * No Astra sidebar on our views (the templates have their own asides).
 *
 * @param string $layout Astra sidebar layout.
 * @return string
 */
function walid_astra_sidebar_layout( $layout ) {
	return walid_is_full_width_view() ? 'no-sidebar' : $layout;
}
add_filter( 'astra_page_layout', 'walid_astra_sidebar_layout', 20 );
