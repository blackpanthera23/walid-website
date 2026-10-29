<?php
/**
 * Set the Kadence Global Palette to the Poliklinik Walid navy brand.
 *
 * Run (reproducible, idempotent):
 *   docker compose run --rm wpcli wp eval-file /scripts/set-palette.php
 *
 * Mapping mirrors docs/07-design-system.md §6. Kadence stores 9 palette slots as
 * `palette[0..8]` plus a second (dark) set it keeps in sync; we set the primary nine.
 *
 * @package walid
 */

$colors = array(
	'#232B8F', // palette1  Brand navy
	'#1E8E66', // palette2  Action green
	'#C9A227', // palette3  Gold accent
	'#1A1D2E', // palette4  Ink
	'#5B607A', // palette5  Muted
	'#DDE0EC', // palette6  Rule
	'#EEF0FB', // palette7  Soft surface
	'#F8F9FC', // palette8  Canvas off-white
	'#FFFFFF', // palette9  White
);

$palette = array();
foreach ( $colors as $i => $hex ) {
	$n           = $i + 1;
	$palette[] = array(
		'color' => $hex,
		'slug'  => 'palette' . $n,
		'name'  => 'Palette Color ' . $n,
	);
}

$value = array(
	'palette'       => $palette,
	'second-palette' => $palette,
);

update_option( 'kadence_global_palette', wp_json_encode( $value ) );

WP_CLI::success( 'Kadence global palette set to the Walid navy brand.' );
