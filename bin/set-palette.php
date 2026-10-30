<?php
/**
 * Set the Astra global colour palette (and Spectra's block palette) to the Poliklinik Walid
 * navy brand.
 *
 * Run (reproducible, idempotent):
 *   docker compose run --rm wpcli wp eval-file /scripts/set-palette.php
 *
 * Mapping mirrors docs/07-design-system.md §6. Astra stores its palette in the `astra-settings`
 * option under `global-color-palette` (a 1-indexed set of hexes); the block editor also reads
 * `theme.json` from the child theme, which is already navy-anchored. Spectra keeps its own
 * `spectra_global_colors` entry when present, so we set it too.
 *
 * @package walid
 */

$colors = array(
	1 => '#232B8F', // Brand navy
	2 => '#1E8E66', // Action green
	3 => '#C9A227', // Gold accent
	4 => '#1A1D2E', // Ink
	5 => '#5B607A', // Muted
	6 => '#DDE0EC', // Rule
	7 => '#EEF0FB', // Soft surface
	8 => '#F8F9FC', // Canvas off-white
	9 => '#FFFFFF', // White
);

/* ---- 1. Astra global colour palette --------------------------------------- */
$astra                    = get_option( 'astra-settings', array() );
$astra['global-color-palette'] = array(
	'palette' => $colors,
);

// Astra 4.x also carries a "theme" sub-key for the dark/second set; keep it in sync when present.
if ( isset( $astra['global-color-palette']['theme'] ) ) {
	$astra['global-color-palette']['theme'] = $colors;
}

update_option( 'astra-settings', $astra );

/* ---- 2. Spectra block palette (only if the plugin is active) --------------- */
if ( defined( 'SPECTRA_VERSION' ) || class_exists( 'UAGB_Loader' ) ) {
	$spectra_palette = array();
	foreach ( $colors as $i => $hex ) {
		$spectra_palette[] = array(
			'color' => $hex,
			'slug'  => 'palette' . $i,
			'name'  => 'Palette Color ' . $i,
		);
	}
	update_option( 'spectra_global_colors', wp_json_encode( $spectra_palette ) );
	WP_CLI::log( 'Spectra global colours set.' );
}

WP_CLI::success( 'Astra + Spectra global palette set to the Walid navy brand.' );