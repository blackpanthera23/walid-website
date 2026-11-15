<?php
/**
 * WhatsApp click tracking: first-party counters, no cookies, no personal data.
 *
 * Stores daily counts keyed by line (general / minor_surgery), placement (fab, footer, header,
 * content) and page path in one non-autoloaded option. Entries older than 90 days are pruned.
 * Report: Tools > WhatsApp clicks (administrators only).
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const WALID_WA_OPTION     = 'walid_wa_clicks';
const WALID_WA_KEEP_DAYS  = 90;
const WALID_WA_MAX_KEYS   = 3000;
const WALID_WA_PLACEMENTS = array( 'fab', 'footer', 'header', 'content', 'hero', 'card' );

/**
 * Load the tracker on the public site.
 */
function walid_wa_enqueue() {
	$file = get_stylesheet_directory() . '/assets/js/wa-track.js';
	wp_enqueue_script(
		'walid-wa-track',
		get_stylesheet_directory_uri() . '/assets/js/wa-track.js',
		array(),
		file_exists( $file ) ? (string) filemtime( $file ) : wp_get_theme()->get( 'Version' ),
		true
	);
	wp_localize_script(
		'walid-wa-track',
		'walidWaTrack',
		array(
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'general'      => WALID_WA_GENERAL,
			'minorSurgery' => WALID_WA_MINOR_SURGERY,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'walid_wa_enqueue', 20 );

/**
 * Record one click. Strict whitelist validation; nothing from the visitor is stored except
 * an allowlisted line, an allowlisted placement and a sanitized URL path.
 */
function walid_wa_record_click() {
	$line      = isset( $_POST['line'] ) ? sanitize_key( wp_unslash( $_POST['line'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
	$placement = isset( $_POST['placement'] ) ? sanitize_key( wp_unslash( $_POST['placement'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
	$page      = isset( $_POST['page'] ) ? wp_unslash( $_POST['page'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

	if ( ! in_array( $line, array( 'general', 'minor_surgery' ), true )
		|| ! in_array( $placement, WALID_WA_PLACEMENTS, true )
		|| ! is_string( $page )
		|| ! preg_match( '#^/[a-z0-9/_-]{0,99}$#i', $page ) ) {
		wp_send_json_error( null, 400 );
	}

	$data = get_option( WALID_WA_OPTION, array() );
	if ( ! is_array( $data ) ) {
		$data = array();
	}

	$cutoff = gmdate( 'Y-m-d', time() - WALID_WA_KEEP_DAYS * DAY_IN_SECONDS );
	foreach ( array_keys( $data ) as $k ) {
		if ( substr( $k, 0, 10 ) < $cutoff ) {
			unset( $data[ $k ] );
		}
	}

	$key = gmdate( 'Y-m-d' ) . '|' . $line . '|' . $placement . '|' . strtolower( $page );
	if ( isset( $data[ $key ] ) || count( $data ) < WALID_WA_MAX_KEYS ) {
		$data[ $key ] = ( isset( $data[ $key ] ) ? (int) $data[ $key ] : 0 ) + 1;
	}

	if ( false === get_option( WALID_WA_OPTION, false ) ) {
		add_option( WALID_WA_OPTION, $data, '', 'no' );
	} else {
		update_option( WALID_WA_OPTION, $data, false );
	}

	wp_send_json_success();
}
add_action( 'wp_ajax_nopriv_walid_wa_click', 'walid_wa_record_click' );
add_action( 'wp_ajax_walid_wa_click', 'walid_wa_record_click' );

/**
 * Admin report under Tools.
 */
function walid_wa_admin_menu() {
	add_management_page(
		__( 'WhatsApp clicks', 'walid' ),
		__( 'WhatsApp clicks', 'walid' ),
		'manage_options',
		'walid-wa-clicks',
		'walid_wa_render_report'
	);
}
add_action( 'admin_menu', 'walid_wa_admin_menu' );

/**
 * Render the last 30 days, totals first, then by line, placement and top pages.
 */
function walid_wa_render_report() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$data   = get_option( WALID_WA_OPTION, array() );
	$data   = is_array( $data ) ? $data : array();
	$cutoff = gmdate( 'Y-m-d', time() - 30 * DAY_IN_SECONDS );

	$total  = 0;
	$lines  = array();
	$places = array();
	$pages  = array();
	foreach ( $data as $key => $count ) {
		$parts = explode( '|', $key, 4 );
		if ( 4 !== count( $parts ) || $parts[0] < $cutoff ) {
			continue;
		}
		$count                  = (int) $count;
		$total                 += $count;
		$lines[ $parts[1] ]     = ( $lines[ $parts[1] ] ?? 0 ) + $count;
		$places[ $parts[2] ]    = ( $places[ $parts[2] ] ?? 0 ) + $count;
		$pages[ $parts[3] ]     = ( $pages[ $parts[3] ] ?? 0 ) + $count;
	}
	arsort( $lines );
	arsort( $places );
	arsort( $pages );
	$pages = array_slice( $pages, 0, 15, true );

	$table = static function ( $title, $rows ) {
		echo '<h2>' . esc_html( $title ) . '</h2><table class="widefat striped" style="max-width:560px"><tbody>';
		if ( ! $rows ) {
			echo '<tr><td>' . esc_html__( 'No clicks yet.', 'walid' ) . '</td></tr>';
		}
		foreach ( $rows as $label => $n ) {
			echo '<tr><td>' . esc_html( $label ) . '</td><td style="width:80px"><strong>' . esc_html( (string) $n ) . '</strong></td></tr>';
		}
		echo '</tbody></table>';
	};

	echo '<div class="wrap"><h1>' . esc_html__( 'WhatsApp clicks (last 30 days)', 'walid' ) . '</h1>';
	echo '<p>' . esc_html__( 'Counts only. No cookies, no personal data. A click is an intent to message, not a confirmed conversation.', 'walid' ) . '</p>';
	echo '<p><strong>' . esc_html__( 'Total:', 'walid' ) . ' ' . esc_html( (string) $total ) . '</strong></p>';
	$table( __( 'By line', 'walid' ), $lines );
	$table( __( 'By placement', 'walid' ), $places );
	$table( __( 'Top pages', 'walid' ), $pages );
	echo '</div>';
}
