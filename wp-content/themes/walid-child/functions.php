<?php
/**
 * Walid Child theme bootstrap.
 *
 * Child theme on Astra. Loads brand tokens (ported from the prototype) + Fraunces/Inter,
 * registers the WhatsApp config, and wires custom templates/patterns (added in later tasks).
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ACF safety shim.
 *
 * The theme reads CPT data via get_field(). If ACF is ever missing/deactivated, calling it would
 * be a PHP fatal (white screen). This fallback returns null so templates degrade to their draft
 * copy instead of crashing. When ACF is active, this stub is NOT defined and the real function
 * is used. Also surfaces an admin notice so the missing dependency is obvious.
 */
if ( ! function_exists( 'get_field' ) ) {
	/**
	 * Fallback get_field() when ACF is not active.
	 *
	 * @return null Always null (no field data available).
	 */
	function get_field() {
		return null;
	}

	add_action(
		'admin_notices',
		function () {
			if ( current_user_can( 'activate_plugins' ) ) {
				echo '<div class="notice notice-error"><p><strong>Walid theme:</strong> Advanced Custom Fields (ACF) is required and not active. Activate it so branch, service, doctor, and procedure content displays.</p></div>';
			}
		}
	);
}

/**
 * WhatsApp numbers, in one place (used by the floating button + CTAs).
 * Minor-surgery pages route to the minor-surgery line; everything else to general.
 */
define( 'WALID_WA_GENERAL', '60142521684' );       // 014-252 1684
define( 'WALID_WA_MINOR_SURGERY', '60175497593' ); // 017-549 7593

// Theme helpers (WhatsApp links, social config, CPT queries).
require_once get_stylesheet_directory() . '/inc/helpers.php';

// SEO + schema (branch MedicalClinic, org aggregate rating, skip link).
require_once get_stylesheet_directory() . '/inc/seo.php';

// Google Places reviews (live, cached) for branch pages.
require_once get_stylesheet_directory() . '/inc/google-reviews.php';

// Editor block patterns (reusable branded sections for staff).
require_once get_stylesheet_directory() . '/inc/patterns.php';

/**
 * Enqueue parent styles, child brand tokens, and web fonts.
 */
function walid_enqueue_assets() {
	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );

	// Parent (Astra) stylesheet.
	wp_enqueue_style(
		'astra-parent',
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
		array( 'astra-parent', 'walid-fonts' ),
		$version
	);

	// The theme header file (style.css) so WP registers the active child stylesheet.
	wp_enqueue_style(
		'walid-child',
		get_stylesheet_uri(),
		array( 'walid-brand' ),
		$version
	);

	// UI/UX polish + motion (site-wide).
	wp_enqueue_style(
		'walid-enhance',
		get_stylesheet_directory_uri() . '/assets/css/enhance.css',
		array( 'walid-brand' ),
		$version
	);

	// Scroll-reveal (deferred, reduced-motion aware).
	wp_enqueue_script(
		'walid-reveal',
		get_stylesheet_directory_uri() . '/assets/js/reveal.js',
		array(),
		$version,
		true
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

	// Procedure (per-treatment) page styles.
	if ( is_singular( 'procedure' ) ) {
		wp_enqueue_style(
			'walid-procedure',
			get_stylesheet_directory_uri() . '/assets/css/procedure.css',
			array( 'walid-brand' ),
			$version
		);
	}

	// Archive (listing) + custom page template styles (all use the .walid-archive shell).
	if (
		is_post_type_archive( array( 'branch', 'service', 'doctor' ) )
		|| is_page_template( array( 'page-international.php', 'page-governance.php', 'page-contact.php' ) )
	) {
		wp_enqueue_style(
			'walid-archive',
			get_stylesheet_directory_uri() . '/assets/css/archive.css',
			array( 'walid-brand' ),
			$version
		);
	}

	// Services archive: premium procedure show-more toggle.
	if ( is_post_type_archive( 'service' ) ) {
		wp_enqueue_script(
			'walid-services',
			get_stylesheet_directory_uri() . '/assets/js/services.js',
			array(),
			$version,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'walid_enqueue_assets' );

/**
 * Site-wide brand footer: group blurb, social links (real hrefs), explore links, contact,
 * and the compliance line. Rendered before the floating button.
 */
function walid_brand_footer() {
	$socials = walid_social_links();
	?>
	<footer class="walid-footer" role="contentinfo">
		<div class="container">
			<div class="walid-footer-grid">
				<div>
					<div class="walid-footer-brand">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo.jpg' ); ?>" alt="<?php esc_attr_e( 'Poliklinik Walid', 'walid' ); ?>" width="40" height="40" />
						<span><?php esc_html_e( 'Poliklinik Walid', 'walid' ); ?></span>
					</div>
					<p><?php esc_html_e( 'Surgeon-led day-care minor surgery, aesthetics and women\'s health, with general practice across our branch network.', 'walid' ); ?></p>
					<div class="walid-socials">
						<?php foreach ( $socials as $s ) : ?>
							<a href="<?php echo esc_url( $s['url'] ); ?>" title="<?php echo esc_attr( $s['label'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $s['short'] ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
				<div>
					<h4><?php esc_html_e( 'Explore', 'walid' ); ?></h4>
					<ul>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'service' ) ); ?>"><?php esc_html_e( 'Services', 'walid' ); ?></a></li>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'branch' ) ); ?>"><?php esc_html_e( 'Branches', 'walid' ); ?></a></li>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'doctor' ) ); ?>"><?php esc_html_e( 'Doctors', 'walid' ); ?></a></li>
					</ul>
				</div>
				<div>
					<h4><?php esc_html_e( 'Contact', 'walid' ); ?></h4>
					<ul>
						<li><a href="<?php echo walid_whatsapp_url( 'general' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp (general): 014-252 1684', 'walid' ); ?></a></li>
						<li><a href="<?php echo walid_whatsapp_url( 'minor_surgery' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp (surgery): 017-549 7593', 'walid' ); ?></a></li>
					</ul>
				</div>
			</div>
			<div class="walid-legal">
				<?php esc_html_e( 'MMC-registered doctors. Patient records kept confidential under the PDPA 2010.', 'walid' ); ?><br />
				<?php esc_html_e( 'Walid Healthcare Group Sdn. Bhd. (1466692-A).', 'walid' ); ?>
			</div>
		</div>
	</footer>
	<?php
}
add_action( 'wp_footer', 'walid_brand_footer', 5 );

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
