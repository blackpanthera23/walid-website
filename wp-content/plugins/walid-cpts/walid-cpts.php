<?php
/**
 * Plugin Name:       Walid CPTs
 * Description:       Custom post types, taxonomies, and fields for Poliklinik Walid
 *                    (Branch, Service, Doctor, Review). Kept in a plugin so the content model
 *                    survives theme switches.
 * Version:           0.1.0
 * Requires PHP:      8.2
 * Author:            Poliklinik Walid build
 * Text Domain:       walid
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// CPT and taxonomy registration is added in Task 5. This stub lets the plugin activate cleanly
// so the Docker bind-mount and provisioning work end-to-end first.
