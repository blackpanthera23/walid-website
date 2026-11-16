<?php
/**
 * Content importer: wp-admin > Tools > Walid content.
 *
 * Creates the site's branches, services, doctors, procedures and reviews from inc/content-data.php.
 * Safe by design:
 * - creates only what is missing (matched by post type + slug); never edits or overwrites a post that
 *   already exists, so content edited in wp-admin is left alone;
 * - remembers what it created, so "Undo" moves exactly those posts to the Trash;
 * - administrators only, nonce-checked.
 * Also available as `wp walid import [--dry-run]` and `wp walid undo` where WP-CLI exists.
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const WALID_IMPORT_LOG = 'walid_import_created';

/**
 * Bundled content data.
 *
 * @return array{version?:string,images?:array<string,string>,posts?:array<int,array>}
 */
function walid_import_data() {
	static $data = null;
	if ( null === $data ) {
		$data = include __DIR__ . '/content-data.php';
		$data = is_array( $data ) ? $data : array();
	}
	return $data;
}

/**
 * Find a post by type + slug in any non-trashed status.
 *
 * @param string $type Post type.
 * @param string $slug Post name.
 * @return WP_Post|null
 */
function walid_import_find( $type, $slug ) {
	$found = get_posts(
		array(
			'post_type'        => $type,
			'name'             => $slug,
			'post_status'      => array( 'publish', 'draft', 'pending', 'private', 'future' ),
			'numberposts'      => 1,
			'suppress_filters' => true,
		)
	);
	return $found ? $found[0] : null;
}

/**
 * ACF field key for a field name on a post type (top-level fields), with sub-field keys for repeaters.
 *
 * @param string $type Post type.
 * @return array<string,array{key:string,type:string,sub:array<string,string>}>
 */
function walid_import_field_map( $type ) {
	static $cache = array();
	if ( isset( $cache[ $type ] ) ) {
		return $cache[ $type ];
	}
	$map = array();
	if ( function_exists( 'acf_get_field_groups' ) ) {
		foreach ( acf_get_field_groups( array( 'post_type' => $type ) ) as $group ) {
			foreach ( (array) acf_get_fields( $group ) as $field ) {
				$sub = array();
				foreach ( (array) ( $field['sub_fields'] ?? array() ) as $sf ) {
					$sub[ $sf['name'] ] = $sf['key'];
				}
				$map[ $field['name'] ] = array(
					'key'  => $field['key'],
					'type' => $field['type'],
					'sub'  => $sub,
				);
			}
		}
	}
	$cache[ $type ] = $map;
	return $map;
}

/**
 * Turn "type:slug" references into post IDs.
 *
 * @param string|array|null $ref Reference(s).
 * @return int|int[]|null
 */
function walid_import_resolve( $ref ) {
	if ( is_array( $ref ) ) {
		return array_values( array_filter( array_map( 'walid_import_resolve', $ref ) ) );
	}
	if ( ! is_string( $ref ) || false === strpos( $ref, ':' ) ) {
		return null;
	}
	list( $type, $slug ) = explode( ':', $ref, 2 );
	$post                = walid_import_find( $type, $slug );
	return $post ? (int) $post->ID : null;
}

/**
 * Attachment for a bundled theme image, created once and reused (keyed by _walid_import_key).
 *
 * @param string $key Image key from the data file.
 * @return int Attachment ID or 0.
 */
function walid_import_image( $key ) {
	$data = walid_import_data();
	if ( empty( $data['images'][ $key ] ) ) {
		return 0;
	}
	$existing = get_posts(
		array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'numberposts' => 1,
			'meta_key'    => '_walid_import_key', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'  => $key, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			'fields'      => 'ids',
		)
	);
	if ( $existing ) {
		return (int) $existing[0];
	}
	$file = get_stylesheet_directory() . '/' . ltrim( $data['images'][ $key ], '/' );
	if ( ! is_readable( $file ) ) {
		return 0;
	}
	$upload = wp_upload_bits( basename( $file ), null, (string) file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}
	$type = wp_check_filetype( $upload['file'] );
	$id   = wp_insert_attachment(
		array(
			'post_mime_type' => $type['type'],
			'post_title'     => sanitize_text_field( preg_replace( '/\.[^.]+$/', '', basename( $file ) ) ),
			'post_status'    => 'inherit',
		),
		$upload['file']
	);
	if ( ! $id || is_wp_error( $id ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
	update_post_meta( $id, '_walid_import_key', $key );
	return (int) $id;
}

/**
 * Plan: which posts would be created and which already exist.
 *
 * @return array{create:array<int,array>,exists:array<int,array>}
 */
function walid_import_plan() {
	$plan = array(
		'create' => array(),
		'exists' => array(),
	);
	foreach ( (array) ( walid_import_data()['posts'] ?? array() ) as $row ) {
		$plan[ walid_import_find( $row['type'], $row['slug'] ) ? 'exists' : 'create' ][] = $row;
	}
	return $plan;
}

/**
 * Run the import (create-only).
 *
 * @param bool $dry_run Only report.
 * @return array{created:string[],skipped:string[],errors:string[]}
 */
function walid_import_run( $dry_run = false ) {
	$result = array(
		'created' => array(),
		'skipped' => array(),
		'errors'  => array(),
	);
	if ( ! function_exists( 'update_field' ) ) {
		$result['errors'][] = 'Advanced Custom Fields is not active.';
		return $result;
	}
	$plan = walid_import_plan();
	foreach ( $plan['exists'] as $row ) {
		$result['skipped'][] = $row['type'] . ':' . $row['slug'];
	}
	if ( $dry_run ) {
		foreach ( $plan['create'] as $row ) {
			$result['created'][] = $row['type'] . ':' . $row['slug'];
		}
		return $result;
	}

	$log     = (array) get_option( WALID_IMPORT_LOG, array() );
	$created = array();

	// Pass 1: posts and terms.
	foreach ( $plan['create'] as $row ) {
		$id = wp_insert_post(
			array(
				'post_type'    => $row['type'],
				'post_name'    => $row['slug'],
				'post_title'   => $row['title'],
				'post_content' => (string) ( $row['content'] ?? '' ),
				'post_excerpt' => (string) ( $row['excerpt'] ?? '' ),
				'post_status'  => in_array( $row['status'] ?? 'publish', array( 'publish', 'draft' ), true ) ? $row['status'] : 'publish',
				'menu_order'   => (int) ( $row['order'] ?? 0 ),
			),
			true
		);
		if ( is_wp_error( $id ) ) {
			$result['errors'][] = $row['type'] . ':' . $row['slug'] . ': ' . $id->get_error_message();
			continue;
		}
		foreach ( (array) ( $row['terms'] ?? array() ) as $taxonomy => $slugs ) {
			$ids = array();
			foreach ( (array) $slugs as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, $taxonomy );
				if ( $term ) {
					$ids[] = (int) $term->term_id;
				} else {
					$result['errors'][] = "Missing {$taxonomy} term {$term_slug} for {$row['slug']}";
				}
			}
			if ( $ids ) {
				wp_set_object_terms( $id, $ids, $taxonomy );
			}
		}
		$created[ $id ]      = $row;
		$log[]               = (int) $id;
		$result['created'][] = $row['type'] . ':' . $row['slug'];
	}

	// Pass 2: fields, references, images, meta (after every post exists, so references resolve).
	foreach ( $created as $id => $row ) {
		$fields = walid_import_field_map( $row['type'] );
		$values = (array) ( $row['fields'] ?? array() );
		foreach ( (array) ( $row['refs'] ?? array() ) as $name => $ref ) {
			$values[ $name ] = walid_import_resolve( $ref );
		}
		foreach ( (array) ( $row['images'] ?? array() ) as $name => $key ) {
			$values[ $name ] = walid_import_image( $key );
		}
		foreach ( $values as $name => $value ) {
			if ( null === $value || array() === $value || 0 === $value && ! isset( $row['fields'][ $name ] ) ) {
				continue;
			}
			if ( ! isset( $fields[ $name ] ) ) {
				$result['errors'][] = "Unknown field {$name} on {$row['type']}";
				continue;
			}
			$f = $fields[ $name ];
			if ( 'repeater' === $f['type'] && is_array( $value ) ) {
				// Rows keyed by sub-field NAME: ACF Pro maps names itself, and free ACF stores the array as
				// is, which is how the templates read it ($row['day'], $row['time']).
				$value = array_values( array_map( static fn( $r ) => (array) $r, $value ) );
			}
			update_field( $f['key'], $value, $id );
		}
		foreach ( (array) ( $row['meta'] ?? array() ) as $meta_key => $meta_value ) {
			if ( 'review_pillar' === $meta_key ) {
				// Stored as the pillar's name exactly as WordPress saved it, which is what pages compare against.
				$term       = get_term_by( 'slug', $meta_value, 'pillar' );
				$meta_value = $term ? $term->name : $meta_value;
			}
			update_post_meta( $id, sanitize_key( $meta_key ), $meta_value );
		}
	}

	update_option( WALID_IMPORT_LOG, array_values( array_unique( array_map( 'intval', $log ) ) ), false );
	return $result;
}

/**
 * Move every post the importer created to the Trash.
 *
 * @return int Number trashed.
 */
function walid_import_undo() {
	$count = 0;
	foreach ( (array) get_option( WALID_IMPORT_LOG, array() ) as $id ) {
		if ( get_post( (int) $id ) && wp_trash_post( (int) $id ) ) {
			++$count;
		}
	}
	delete_option( WALID_IMPORT_LOG );
	return $count;
}

/**
 * Admin page.
 */
function walid_import_admin_menu() {
	add_management_page( __( 'Walid content', 'walid' ), __( 'Walid content', 'walid' ), 'manage_options', 'walid-content', 'walid_import_render' );
}
add_action( 'admin_menu', 'walid_import_admin_menu' );

/**
 * Render the admin page and handle its two actions.
 */
function walid_import_render() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$message = '';
	if ( isset( $_POST['walid_import_action'] ) ) {
		check_admin_referer( 'walid_import' );
		$action = sanitize_key( wp_unslash( $_POST['walid_import_action'] ) );
		if ( 'import' === $action ) {
			$r       = walid_import_run();
			$message = sprintf( 'Created %d, skipped %d (already existed).', count( $r['created'] ), count( $r['skipped'] ) );
			if ( $r['errors'] ) {
				$message .= ' Problems: ' . implode( '; ', $r['errors'] );
			}
		} elseif ( 'undo' === $action ) {
			$message = sprintf( 'Moved %d imported posts to the Trash.', walid_import_undo() );
		}
	}
	$plan    = walid_import_plan();
	$version = walid_import_data()['version'] ?? '';
	$logged  = count( (array) get_option( WALID_IMPORT_LOG, array() ) );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Walid content', 'walid' ); ?></h1>
		<?php if ( $message ) : ?>
			<div class="notice notice-info"><p id="walid-import-message"><?php echo esc_html( $message ); ?></p></div>
		<?php endif; ?>
		<p><?php echo esc_html( sprintf( 'Bundled content (version %s): branches, services, doctors, a procedure page and Google reviews. Importing creates only what is missing and never changes posts that already exist.', $version ) ); ?></p>
		<h2><?php echo esc_html( sprintf( 'Will be created (%d)', count( $plan['create'] ) ) ); ?></h2>
		<p id="walid-import-create"><?php echo esc_html( implode( ', ', array_map( static fn( $r ) => $r['type'] . ': ' . $r['title'], $plan['create'] ) ) ?: '(nothing, everything is already there)' ); ?></p>
		<h2><?php echo esc_html( sprintf( 'Already on the site, left alone (%d)', count( $plan['exists'] ) ) ); ?></h2>
		<p><?php echo esc_html( implode( ', ', array_map( static fn( $r ) => $r['type'] . ': ' . $r['title'], $plan['exists'] ) ) ?: '(none)' ); ?></p>
		<form method="post" style="display:inline-block;margin-right:12px">
			<?php wp_nonce_field( 'walid_import' ); ?>
			<input type="hidden" name="walid_import_action" value="import" />
			<?php submit_button( __( 'Import missing content', 'walid' ), 'primary', 'submit', false, $plan['create'] ? array() : array( 'disabled' => 'disabled' ) ); ?>
		</form>
		<form method="post" style="display:inline-block" onsubmit="return confirm('Move every post created by this importer to the Trash?');">
			<?php wp_nonce_field( 'walid_import' ); ?>
			<input type="hidden" name="walid_import_action" value="undo" />
			<?php submit_button( sprintf( 'Undo import (%d posts)', $logged ), 'secondary', 'submit', false, $logged ? array() : array( 'disabled' => 'disabled' ) ); ?>
		</form>
	</div>
	<?php
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command(
		'walid import',
		static function ( $args, $assoc ) {
			$r = walid_import_run( ! empty( $assoc['dry-run'] ) );
			WP_CLI::log( 'Created: ' . count( $r['created'] ) . ' ' . implode( ', ', $r['created'] ) );
			WP_CLI::log( 'Skipped: ' . count( $r['skipped'] ) );
			foreach ( $r['errors'] as $e ) {
				WP_CLI::warning( $e );
			}
		}
	);
	WP_CLI::add_command(
		'walid undo',
		static function () {
			WP_CLI::success( 'Trashed ' . walid_import_undo() );
		}
	);
}
