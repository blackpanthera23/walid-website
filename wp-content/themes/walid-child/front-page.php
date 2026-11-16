<?php
/**
 * Front page: Poliklinik Walid homepage (Concept 4, editorial split layout).
 *
 * Ported from /prototype-v4. Data comes from the theme helpers and CPTs where it exists (stats, branches,
 * permitted reviews, WhatsApp routing); copy falls back to approved text otherwise. Minor surgery stays the
 * hero pillar. Styles: assets/css/home.css. Motion: assets/js/home.js (reduced-motion safe).
 * Header, footer and the floating WhatsApp button are the theme's own.
 *
 * @package walid
 */

get_header();

$stats      = walid_stats();
$wa_general = walid_whatsapp_url( 'general', __( 'Hi Poliklinik Walid, I have a question.', 'walid' ) );
$wa_surgery = walid_whatsapp_url( 'minor_surgery', __( 'Hi, I would like to ask about minor surgery.', 'walid' ) );
$img        = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/img/';

/**
 * Small local helpers (kept in the template so the page stays self-contained).
 */
$stat_parts = static function ( $value ) {
	$value = trim( (string) $value );
	if ( ! preg_match( '/^([0-9][0-9.,]*)\s*([A-Za-z%]*)$/', $value, $m ) ) {
		return array( 0.0, '', 0 );
	}
	return array( (float) str_replace( ',', '', $m[1] ), $m[2], false !== strpos( $m[1], '.' ) ? 1 : 0 );
};
$page_url   = static function ( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
};
$archive    = static function ( $post_type ) {
	$link = get_post_type_archive_link( $post_type );
	return $link ? $link : home_url( '/' );
};
$phone_fmt  = static function ( $e164 ) {
	$national = '0' . substr( preg_replace( '/\D/', '', (string) $e164 ), 2 );
	return preg_replace( '/^(\d{3})(\d{3})(\d{4})$/', '$1-$2 $3', $national );
};
$social_url = static function ( $label ) {
	foreach ( walid_social_links() as $s ) {
		if ( strtolower( $s['label'] ) === strtolower( $label ) ) {
			return $s['url'];
		}
	}
	return '';
};

// Minor surgery service page if it exists, else the services archive.
$minor_service = get_posts(
	array(
		'post_type'      => 'service',
		'posts_per_page' => 1,
		'name'           => 'minor-surgery',
	)
);
$minor_url     = $minor_service ? get_permalink( $minor_service[0] ) : $archive( 'service' );

list( $tt_n, $tt_s, $tt_d ) = $stat_parts( $stats['tiktok'] );
list( $fb_n, $fb_s, $fb_d ) = $stat_parts( $stats['facebook'] );
list( $rt_n, , $rt_d )      = $stat_parts( $stats['rating'] );
$branch_count               = (int) apply_filters( 'walid_branch_count', 10 );
$hero_default               = walid_photo( 'surgeon-bright' ) ? walid_photo( 'surgeon-bright' ) : $img . 'home/clinic.webp';
$hero_image                 = apply_filters( 'walid_home_hero_image', $hero_default );
$intl_countries             = walid_international_countries();
$intl_count                 = count( $intl_countries );
?>

<main class="walid-home" id="primary">

	<!-- 1. HERO -->
	<section class="wh-hero" id="top">
		<div class="wh-container wh-hero-grid">
			<div class="wh-hero-media">
				<span class="wh-media-outline" aria-hidden="true"></span>
				<div class="wh-media-frame" data-wipe>
					<img class="wh-media-img" data-parallax="0.08" src="<?php echo esc_url( $hero_image ); ?>" alt="<?php esc_attr_e( 'A surgeon at work in an operating theatre (illustrative image)', 'walid' ); ?>" width="1080" height="1350" fetchpriority="high" />
				</div>
				<div class="wh-chip wh-chip-rating" data-pop="0">
					<span class="wh-chip-stars" aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
					<span><?php echo wp_kses( sprintf( /* translators: 1: rating, 2: review count */ __( '<b>%1$s</b> from %2$s Google reviews', 'walid' ), esc_html( $stats['rating'] ), esc_html( $stats['reviews'] ) ), array( 'b' => array() ) ); ?></span>
				</div>
				<div class="wh-chip wh-chip-day" data-pop="1">
					<svg class="wh-ico" viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12.5 4.5 4.5L19 7.5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<span><?php esc_html_e( 'Assessed, treated, home the same day', 'walid' ); ?></span>
				</div>
			</div>

			<div class="wh-hero-copy">
				<p class="wh-eyebrow" data-hero="0"><?php esc_html_e( 'Walid Healthcare Group', 'walid' ); ?></p>
				<h1 data-split data-hero="1"><?php esc_html_e( 'Hospital-grade minor surgery, done in a day.', 'walid' ); ?></h1>
				<p class="wh-lead" data-hero="2"><?php esc_html_e( 'Surgeon-led day-care across our Central and Northern centres. The smart choice hundreds of thousands already trust.', 'walid' ); ?></p>
				<div class="wh-hero-actions" data-hero="3">
					<a class="wh-btn wh-btn-wa" data-magnet href="<?php echo $wa_general; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" target="_blank" rel="noopener">
						<svg class="wh-ico" viewBox="0 0 24 24" aria-hidden="true"><use href="#wh-i-wa"/></svg><span><?php esc_html_e( 'WhatsApp us', 'walid' ); ?></span>
					</a>
					<a class="wh-btn wh-btn-outline" data-magnet href="#services"><span><?php esc_html_e( 'Explore services', 'walid' ); ?></span></a>
				</div>
				<ul class="wh-hero-proof" data-hero="4">
					<li><b><?php echo esc_html( $stats['tiktok'] ); ?></b><span><?php esc_html_e( 'on TikTok', 'walid' ); ?></span></li>
					<li><b><?php echo esc_html( $stats['facebook'] ); ?></b><span><?php esc_html_e( 'on Facebook', 'walid' ); ?></span></li>
					<li><b><?php echo esc_html( $stats['rating'] ); ?>&#9733;</b><span><?php esc_html_e( 'Google rating', 'walid' ); ?></span></li>
				</ul>
			</div>
		</div>
		<a class="wh-scroll-cue" href="#about" aria-label="<?php esc_attr_e( 'Scroll to the next section', 'walid' ); ?>"><i></i><span><?php esc_html_e( 'Scroll', 'walid' ); ?></span></a>
	</section>

	<!-- 2. WHO WE ARE -->
	<section class="wh-section wh-who" id="about">
		<div class="wh-container wh-split">
			<div class="wh-split-head">
				<p class="wh-eyebrow" data-reveal><?php esc_html_e( 'Who we are', 'walid' ); ?></p>
				<h2 class="wh-h-display" data-split><?php esc_html_e( 'A surgeon-led healthcare group, trusted by hundreds of thousands.', 'walid' ); ?></h2>
			</div>
			<div class="wh-split-body">
				<p data-reveal data-d="1"><?php echo wp_kses( __( '<strong>Poliklinik Walid</strong> is a network of ten clinics under Walid Healthcare Group Sdn. Bhd. We are built around day-care minor surgery: you are assessed by a surgeon, treated in one visit and home the same day.', 'walid' ), array( 'strong' => array() ) ); ?></p>
				<p data-reveal data-d="2"><?php esc_html_e( 'Our surgical centres in Ampang, Seberang Perai, Tasek Gelugor and Sungai Petani are backed by general practice across the network, with aesthetics and antenatal care, led by a dedicated specialist, growing alongside.', 'walid' ); ?></p>
				<div class="wh-btn-row" data-reveal data-d="3">
					<a class="wh-btn wh-btn-navy" href="<?php echo esc_url( $page_url( 'about' ) ); ?>"><span><?php esc_html_e( 'About Walid', 'walid' ); ?></span></a>
					<a class="wh-btn wh-btn-outline" href="<?php echo esc_url( $archive( 'doctor' ) ); ?>"><span><?php esc_html_e( 'Meet our doctors', 'walid' ); ?></span></a>
				</div>
			</div>
		</div>

		<div class="wh-container">
			<ul class="wh-stats" data-reveal-group>
				<li>
					<b><i data-count="<?php echo esc_attr( $branch_count ); ?>" data-decimals="0"><?php echo esc_html( $branch_count ); ?></i></b>
					<span><?php esc_html_e( 'branches, Central and North', 'walid' ); ?></span>
				</li>
				<li>
					<?php if ( $social_url( 'TikTok' ) ) : ?><a class="wh-stat-link" href="<?php echo esc_url( $social_url( 'TikTok' ) ); ?>" target="_blank" rel="noopener"><?php endif; ?>
					<b><i data-count="<?php echo esc_attr( $tt_n ); ?>" data-decimals="<?php echo esc_attr( $tt_d ); ?>"><?php echo esc_html( $tt_n ); ?></i><?php echo esc_html( $tt_s ); ?></b>
					<span><?php esc_html_e( 'TikTok followers', 'walid' ); ?></span>
					<?php if ( $social_url( 'TikTok' ) ) : ?></a><?php endif; ?>
				</li>
				<li>
					<?php if ( $social_url( 'Facebook' ) ) : ?><a class="wh-stat-link" href="<?php echo esc_url( $social_url( 'Facebook' ) ); ?>" target="_blank" rel="noopener"><?php endif; ?>
					<b><i data-count="<?php echo esc_attr( $fb_n ); ?>" data-decimals="<?php echo esc_attr( $fb_d ); ?>"><?php echo esc_html( $fb_n ); ?></i><?php echo esc_html( $fb_s ); ?></b>
					<span><?php esc_html_e( 'Facebook followers', 'walid' ); ?></span>
					<?php if ( $social_url( 'Facebook' ) ) : ?></a><?php endif; ?>
				</li>
				<li>
					<b><i data-count="<?php echo esc_attr( $rt_n ); ?>" data-decimals="<?php echo esc_attr( $rt_d ); ?>"><?php echo esc_html( $stats['rating'] ); ?></i><em>&#9733;</em></b>
					<span><?php echo esc_html( sprintf( /* translators: %s: review count */ __( 'from %s Google reviews', 'walid' ), $stats['reviews'] ) ); ?></span>
				</li>
			</ul>
		</div>
	</section>

	<!-- 3. THE WALID STANDARD -->
	<section class="wh-section wh-standard">
		<div class="wh-container">
			<header class="wh-center-head">
				<p class="wh-eyebrow" data-reveal><?php esc_html_e( 'The Walid standard', 'walid' ); ?></p>
				<h2 class="wh-h-display" data-split><?php esc_html_e( 'What you can expect, every visit.', 'walid' ); ?></h2>
			</header>
			<ul class="wh-pillars4" data-reveal-group>
				<li>
					<svg class="wh-draw" viewBox="0 0 48 48" aria-hidden="true"><path pathLength="1" d="M24 4 40 10v12c0 10-7 18-16 22C15 40 8 32 8 22V10z"/><path pathLength="1" d="m17 24 5 5 9-10"/></svg>
					<h3><?php esc_html_e( 'Surgeon-led', 'walid' ); ?></h3>
					<p><?php esc_html_e( 'Assessed by experienced, MMC-registered doctors who explain every option clearly.', 'walid' ); ?></p>
				</li>
				<li>
					<svg class="wh-draw" viewBox="0 0 48 48" aria-hidden="true"><circle pathLength="1" cx="24" cy="24" r="17"/><path pathLength="1" d="M24 13v11l7 4"/></svg>
					<h3><?php esc_html_e( 'Day-care', 'walid' ); ?></h3>
					<p><?php esc_html_e( 'Treated in one visit and home the same day, with less time away from work and family.', 'walid' ); ?></p>
				</li>
				<li>
					<svg class="wh-draw" viewBox="0 0 48 48" aria-hidden="true"><rect pathLength="1" x="8" y="8" width="32" height="32" rx="9"/><path pathLength="1" d="M24 16v16M16 24h16"/></svg>
					<h3><?php esc_html_e( 'Hospital-grade', 'walid' ); ?></h3>
					<p><?php esc_html_e( 'The clinical standard you would expect from a hospital, at the speed and price of a clinic.', 'walid' ); ?></p>
				</li>
				<li>
					<svg class="wh-draw" viewBox="0 0 48 48" aria-hidden="true"><path pathLength="1" d="M8 10h32v22H22l-9 8v-8H8z"/><path pathLength="1" d="M16 19h16M16 25h9"/></svg>
					<h3><?php esc_html_e( 'Always reachable', 'walid' ); ?></h3>
					<p><?php esc_html_e( 'Message our team on WhatsApp before and after your visit. A real person replies.', 'walid' ); ?></p>
				</li>
			</ul>
		</div>
	</section>

	<!-- 4. SERVICES -->
	<?php
	$tiles = array(
		array(
			'mod'   => 'minor',
			'span'  => 4,
			'art'   => 'skin',
			'tag'   => __( 'Our specialty', 'walid' ),
			'title' => __( 'Minor surgery', 'walid' ),
			'text'  => __( 'Lipoma, cysts, moles, skin tags, warts and circumcision, assessed and treated in a day at our surgical centres in Ampang, Seberang Perai, Tasek Gelugor and Sungai Petani.', 'walid' ),
			'chips' => array( __( 'Lipoma', 'walid' ), __( 'Cysts', 'walid' ), __( 'Moles & skin tags', 'walid' ), __( 'Warts', 'walid' ), __( 'Circumcision', 'walid' ) ),
			'cta'   => __( 'Explore minor surgery', 'walid' ),
			'url'   => $minor_url,
			'icon'  => '<path d="M10 38 30 18M30 18l8-8M26 14l8 8M10 38l-2 4 4-2"/>',
		),
		array(
			'mod'   => 'aesthetic',
			'span'  => 2,
			'art'   => 'aesthetics',
			'title' => __( 'Aesthetics', 'walid' ),
			'text'  => __( 'Refined, doctor-led aesthetic treatments.', 'walid' ),
			'cta'   => __( 'Explore', 'walid' ),
			'url'   => $archive( 'service' ),
			'icon'  => '<path d="m24 6 3.5 10.5L38 20l-10.5 3.5L24 34l-3.5-10.5L10 20l10.5-3.5z"/><path d="m37 32 1.5 4.5L43 38l-4.5 1.5L37 44l-1.5-4.5L31 38l4.5-1.5z"/>',
		),
		array(
			'mod'   => 'antenatal',
			'span'  => 2,
			'art'   => 'antenatal',
			'title' => __( "Antenatal & women's health", 'walid' ),
			'text'  => __( 'Pregnancy scans from 7 weeks, led by a dedicated specialist.', 'walid' ),
			'cta'   => __( 'Explore', 'walid' ),
			'url'   => $archive( 'service' ),
			'icon'  => '<path d="M24 40C12 31 8 24 8 17a9 9 0 0 1 16-5.5A9 9 0 0 1 40 17c0 7-4 14-16 23z"/>',
		),
		array(
			'mod'   => 'general',
			'span'  => 2,
			'art'   => 'injection',
			'title' => __( 'General practice', 'walid' ),
			'text'  => __( 'Everyday care across our ten-branch network.', 'walid' ),
			'cta'   => __( 'Explore', 'walid' ),
			'url'   => $archive( 'service' ),
			'icon'  => '<path d="M8 18h8l4-8 8 22 4-14h8"/>',
		),
		array(
			'mod'   => 'intl',
			'span'  => 2,
			'art'   => 'others',
			'title' => __( 'International patients', 'walid' ),
			'text'  => sprintf( /* translators: %d: number of countries */ __( 'Patients travel from %d countries for day-care surgery with us.', 'walid' ), $intl_count ),
			'cta'   => __( 'Plan a visit', 'walid' ),
			'url'   => $page_url( 'international-patients' ),
			'icon'  => '<circle cx="24" cy="24" r="16"/><path d="M8 24h32M24 8c-7 8-7 24 0 32M24 8c7 8 7 24 0 32"/>',
		),
	);
	?>
	<section class="wh-section wh-services" id="services">
		<div class="wh-container">
			<header class="wh-center-head">
				<p class="wh-eyebrow" data-reveal><?php esc_html_e( 'What we do', 'walid' ); ?></p>
				<h2 class="wh-h-display" data-split><?php esc_html_e( 'Services we offer', 'walid' ); ?></h2>
				<p class="wh-sub" data-reveal data-d="1"><?php esc_html_e( 'Minor surgery leads. Specialist pillars are growing alongside it.', 'walid' ); ?></p>
			</header>
			<div class="wh-tiles" data-reveal-group>
				<?php foreach ( $tiles as $t ) : ?>
					<a class="wh-tile wh-tile--<?php echo esc_attr( $t['mod'] ); ?> wh-span-<?php echo esc_attr( $t['span'] ); ?>" href="<?php echo esc_url( $t['url'] ); ?>">
						<span class="wh-tile-art" style="background-image:url('<?php echo esc_url( $img . 'cards/' . $t['art'] . '.webp' ); ?>')"></span>
						<span class="wh-tile-icon"><svg viewBox="0 0 48 48" aria-hidden="true"><?php echo $t['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static theme markup. ?></svg></span>
						<?php if ( ! empty( $t['tag'] ) ) : ?><span class="wh-tile-tag"><?php echo esc_html( $t['tag'] ); ?></span><?php endif; ?>
						<h3><?php echo esc_html( $t['title'] ); ?></h3>
						<p><?php echo esc_html( $t['text'] ); ?></p>
						<?php if ( ! empty( $t['chips'] ) ) : ?>
							<ul class="wh-tile-chips">
								<?php foreach ( $t['chips'] as $chip ) : ?><li><?php echo esc_html( $chip ); ?></li><?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<span class="wh-tile-go"><?php echo esc_html( $t['cta'] ); ?> <svg viewBox="0 0 24 24" aria-hidden="true"><use href="#wh-i-arrow"/></svg></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- 5. SPECIALIST SPOTLIGHT (only when the lead specialist has a real photo; never a placeholder) -->
	<?php
	$spec_doctor = null;
	$antenatal   = get_posts(
		array(
			'post_type'      => 'service',
			'posts_per_page' => 1,
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'pillar',
					'field'    => 'name',
					'terms'    => "Antenatal & Women's Health",
				),
			),
		)
	);
	if ( $antenatal ) {
		$lead_id = get_field( 'service_lead_doctor', $antenatal[0]->ID );
		if ( $lead_id ) {
			$spec_doctor = get_post( $lead_id );
		}
	}
	$spec_photo = $spec_doctor ? get_field( 'doctor_photo', $spec_doctor->ID ) : 0;
	if ( $spec_doctor && $spec_photo ) :
		$spec_name = get_the_title( $spec_doctor );
		$spec_role = (string) get_field( 'doctor_role', $spec_doctor->ID );
		?>
		<section class="wh-spec" id="specialist">
			<div class="wh-container wh-spec-grid">
				<div class="wh-spec-photo" data-wipe>
					<?php echo wp_get_attachment_image( $spec_photo, 'large', false, array( 'alt' => esc_attr( $spec_name ) ) ); ?>
				</div>
				<div class="wh-spec-copy">
					<p class="wh-eyebrow" data-reveal><?php esc_html_e( 'Specialist care', 'walid' ); ?></p>
					<h2 class="wh-h-display" data-split><?php esc_html_e( 'Antenatal care, led by a dedicated specialist.', 'walid' ); ?></h2>
					<p class="wh-spec-line" data-reveal data-d="1"><?php echo esc_html( $spec_role ? sprintf( /* translators: 1: doctor name, 2: role */ __( 'Led by %1$s, %2$s', 'walid' ), $spec_name, $spec_role ) : sprintf( /* translators: %s: doctor name */ __( 'Led by %s', 'walid' ), $spec_name ) ); ?></p>
					<p data-reveal data-d="2"><?php esc_html_e( 'Pregnancy scans from 7 weeks onward, with mother-and-child health and family planning. Care delivered with the same standard across every visit.', 'walid' ); ?></p>
					<div class="wh-btn-row" data-reveal data-d="3">
						<a class="wh-btn wh-btn-wa" href="<?php echo $wa_general; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" target="_blank" rel="noopener"><svg class="wh-ico" viewBox="0 0 24 24" aria-hidden="true"><use href="#wh-i-wa"/></svg><span><?php esc_html_e( 'WhatsApp about antenatal', 'walid' ); ?></span></a>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- 6. CTA BANNER -->
	<section class="wh-banner">
		<div class="wh-container wh-banner-grid">
			<?php $banner_photo = walid_photo( 'consult' ); ?>
			<div class="wh-banner-visual<?php echo $banner_photo ? ' wh-banner-visual--photo' : ''; ?>" data-wipe>
				<span class="wh-banner-art" role="img" aria-label="<?php esc_attr_e( 'A doctor checking a patient\'s wrist during a consultation (illustrative image)', 'walid' ); ?>" style="background-image:url('<?php echo esc_url( $banner_photo ? $banner_photo : $img . 'cards/aesthetics.webp' ); ?>')" data-parallax="0.06"></span>
				<div class="wh-banner-numbers">
					<svg class="wh-ico wh-big" viewBox="0 0 24 24" aria-hidden="true"><use href="#wh-i-wa"/></svg>
					<p><small><?php esc_html_e( 'General enquiries', 'walid' ); ?></small><b><?php echo esc_html( $phone_fmt( WALID_WA_GENERAL ) ); ?></b></p>
					<p><small><?php esc_html_e( 'Minor surgery team', 'walid' ); ?></small><b><?php echo esc_html( $phone_fmt( WALID_WA_MINOR_SURGERY ) ); ?></b></p>
				</div>
			</div>
			<div class="wh-banner-copy">
				<p class="wh-eyebrow" data-reveal><?php esc_html_e( 'Talk to us', 'walid' ); ?></p>
				<h2 class="wh-h-display" data-split><?php esc_html_e( 'Not sure what you need?', 'walid' ); ?></h2>
				<p data-reveal data-d="1"><?php esc_html_e( 'Message the clinic team on WhatsApp. We will help you choose a branch, a doctor and a time.', 'walid' ); ?></p>
				<div class="wh-btn-row" data-reveal data-d="2">
					<a class="wh-btn wh-btn-wa" data-magnet href="<?php echo $wa_surgery; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" target="_blank" rel="noopener">
						<svg class="wh-ico" viewBox="0 0 24 24" aria-hidden="true"><use href="#wh-i-wa"/></svg><span><?php esc_html_e( 'WhatsApp the minor surgery team', 'walid' ); ?></span>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- 7. PROOF: rating + permitted reviews -->
	<?php
	$review_cards = array();
	foreach ( walid_permitted_reviews( 12 ) as $r ) {
		$quote = (string) get_field( 'review_quote', $r->ID );
		if ( '' === $quote ) {
			continue;
		}
		$source         = get_field( 'review_source', $r->ID ) ? get_field( 'review_source', $r->ID ) : __( 'Google review', 'walid' );
		$author         = (string) get_field( 'review_author', $r->ID );
		$review_cards[] = array(
			'q'      => $quote,
			'w'      => trim( $author . ( $author ? ' · ' : '' ) . $source ),
			'sample' => false,
		);
	}
	// Sample quotes only while developing (WP_DEBUG). Production shows real, permitted reviews or none.
	if ( ! $review_cards && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		foreach ( array(
			'Amazing service with friendly doctors and staff. Highly professional and recommended.',
			'The doctor is so nice and gives good advice. I feel comfortable and safe.',
			'Clean clinic, friendly nurses, caring doctor. Will come again.',
			'Quick day-care procedure and clear explanation. Home the same afternoon.',
			'Booked over WhatsApp and seen fast. Calm and reassuring throughout.',
		) as $sample_quote ) {
			$review_cards[] = array(
				'q'      => $sample_quote,
				'w'      => __( 'Google review', 'walid' ),
				'sample' => true,
			);
		}
	}
	?>
	<section class="wh-section wh-proof">
		<div class="wh-container">
			<header class="wh-center-head">
				<p class="wh-eyebrow" data-reveal><?php esc_html_e( 'What patients say', 'walid' ); ?></p>
				<div class="wh-rating" data-reveal data-d="1">
					<b class="wh-rating-num"><i data-count="<?php echo esc_attr( $rt_n ); ?>" data-decimals="<?php echo esc_attr( $rt_d ); ?>"><?php echo esc_html( $stats['rating'] ); ?></i></b>
					<div>
						<div class="wh-stars" role="img" aria-label="<?php esc_attr_e( '5 out of 5 stars', 'walid' ); ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
						<span><?php echo esc_html( sprintf( /* translators: %s: review count */ __( 'from %s Google reviews', 'walid' ), $stats['reviews'] ) ); ?></span>
					</div>
				</div>
			</header>
		</div>
		<?php if ( $review_cards ) : ?>
			<div class="wh-marquee" aria-label="<?php esc_attr_e( 'Patient reviews', 'walid' ); ?>">
				<div class="wh-marquee-track" id="whMarquee">
					<?php foreach ( $review_cards as $rc ) : ?>
						<figure class="wh-rev">
							<?php if ( $rc['sample'] ) : ?><span class="wh-rev-tag"><?php esc_html_e( 'Sample', 'walid' ); ?></span><?php endif; ?>
							<div class="wh-stars" aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
							<blockquote><?php echo esc_html( $rc['q'] ); ?></blockquote>
							<figcaption><?php echo esc_html( $rc['w'] ); ?></figcaption>
						</figure>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</section>

	<!-- 8. BRANCH NETWORK + MAP -->
	<?php
	$central  = walid_branches_in_region( 'Central (Klang Valley)' );
	$north    = walid_branches_in_region( 'North (Penang / Kedah)' );
	$pin_map  = array(
		'ampang'     => array( 'ampang', __( 'Flagship surgical hub (HQ)', 'walid' ) ),
		'jalan baru' => array( 'jalanbaru', __( 'Seberang Perai, Penang', 'walid' ) ),
		'tasek'      => array( 'tasek', __( 'Penang', 'walid' ) ),
		'petani'     => array( 'sp', __( 'Kedah', 'walid' ) ),
	);
	$branch_row = static function ( $title, $url ) use ( $pin_map ) {
		$name = trim( preg_replace( '/^Poliklinik Walid\s+/i', '', $title ) );
		$pin  = '';
		$note = '';
		foreach ( $pin_map as $needle => $info ) {
			if ( false !== stripos( $title, $needle ) ) {
				list( $pin, $note ) = $info;
				break;
			}
		}
		?>
		<li<?php echo $pin ? ' data-pin="' . esc_attr( $pin ) . '"' : ''; ?>>
			<a href="<?php echo esc_url( $url ); ?>"><b><?php echo esc_html( $name ); ?></b></a>
			<?php if ( $note ) : ?><small><?php echo esc_html( $note ); ?></small><?php endif; ?>
		</li>
		<?php
	};
	$central_fallback = array( __( 'Ampang', 'walid' ) );
	$north_fallback   = array( __( 'Jalan Baru', 'walid' ), __( 'Tasek Gelugor', 'walid' ), __( 'Sungai Petani', 'walid' ) );
	?>
	<section class="wh-section wh-branches" id="branches">
		<div class="wh-container wh-branches-grid">
			<div class="wh-branches-copy">
				<p class="wh-eyebrow" data-reveal><?php esc_html_e( 'Our network', 'walid' ); ?></p>
				<h2 class="wh-h-display" data-split><?php esc_html_e( 'Surgical centres Central and North, general practice everywhere.', 'walid' ); ?></h2>
				<p class="wh-muted" data-reveal data-d="1"><?php esc_html_e( 'Minor surgery is performed at our surgical centres. General practice is available across the full branch network.', 'walid' ); ?></p>

				<div class="wh-hub" data-reveal data-d="1">
					<h3><span class="wh-pin-tag"><?php esc_html_e( 'Central', 'walid' ); ?></span> <?php esc_html_e( 'Klang Valley', 'walid' ); ?></h3>
					<ul>
						<?php
						if ( $central ) {
							foreach ( $central as $b ) {
								$branch_row( get_the_title( $b ), get_permalink( $b ) );
							}
						} else {
							foreach ( $central_fallback as $n ) {
								$branch_row( $n, $archive( 'branch' ) );
							}
						}
						?>
					</ul>
				</div>
				<div class="wh-hub" data-reveal data-d="2">
					<h3><span class="wh-pin-tag"><?php esc_html_e( 'North', 'walid' ); ?></span> <?php esc_html_e( 'Penang & Kedah', 'walid' ); ?></h3>
					<ul>
						<?php
						if ( $north ) {
							foreach ( $north as $b ) {
								$branch_row( get_the_title( $b ), get_permalink( $b ) );
							}
						} else {
							foreach ( $north_fallback as $n ) {
								$branch_row( $n, $archive( 'branch' ) );
							}
						}
						?>
					</ul>
				</div>
				<p class="wh-more" data-reveal data-d="3"><?php esc_html_e( 'Plus six more general practice clinics across the network.', 'walid' ); ?></p>
				<div class="wh-btn-row" data-reveal data-d="3">
					<a class="wh-btn wh-btn-navy" href="<?php echo esc_url( $archive( 'branch' ) ); ?>"><span><?php esc_html_e( 'View all branches', 'walid' ); ?></span></a>
				</div>
			</div>
			<?php get_template_part( 'template-parts/home-map' ); ?>
		</div>
	</section>

	<!-- 9. INTERNATIONAL PATIENTS -->
	<?php
	$intl_url    = $page_url( 'international-patients' );
	$wa_intl     = walid_whatsapp_url( 'general', __( 'Hi, I am an international patient and would like to plan a visit.', 'walid' ) );
	$intl_photo  = walid_photo( 'surgeon-dark' );
	$intl_points = array(
		array(
			'h' => __( 'Plan before you fly', 'walid' ),
			'p' => __( 'Message us on WhatsApp with your questions. We confirm the right branch and what to prepare.', 'walid' ),
		),
		array(
			'h' => __( 'Treated in one visit', 'walid' ),
			'p' => __( 'Day-care procedures fit a short trip. Most patients are home the same day.', 'walid' ),
		),
		array(
			'h' => __( 'Still reachable after', 'walid' ),
			'p' => __( 'Aftercare advice before you leave, and a team you can still message once you are home.', 'walid' ),
		),
	);
	?>
	<section class="wh-section wh-intl" id="international">
		<div class="wh-container wh-intl-grid">
			<div class="wh-intl-copy">
				<p class="wh-eyebrow" data-reveal><?php esc_html_e( 'International patients', 'walid' ); ?></p>
				<h2 class="wh-h-display" data-split><?php esc_html_e( 'Trusted across the region and beyond.', 'walid' ); ?></h2>
				<p class="wh-intl-lead" data-reveal data-d="1"><?php echo esc_html( sprintf( /* translators: %d: number of countries */ __( 'Patients from %d countries have travelled to Malaysia for day-care surgery with Poliklinik Walid. Our team helps you plan the visit from start to finish.', 'walid' ), $intl_count ) ); ?></p>
				<ul class="wh-intl-points" data-reveal-group>
					<?php foreach ( $intl_points as $pt ) : ?>
						<li>
							<span class="wh-intl-tick" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m5 12.5 4.5 4.5L19 7.5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
							<span><b><?php echo esc_html( $pt['h'] ); ?></b><?php echo esc_html( $pt['p'] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
				<div class="wh-btn-row" data-reveal data-d="2">
					<a class="wh-btn wh-btn-wa" data-magnet href="<?php echo $wa_intl; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" target="_blank" rel="noopener"><svg class="wh-ico" viewBox="0 0 24 24" aria-hidden="true"><use href="#wh-i-wa"/></svg><span><?php esc_html_e( 'Plan my visit on WhatsApp', 'walid' ); ?></span></a>
					<a class="wh-btn wh-btn-outline" href="<?php echo esc_url( $intl_url ); ?>"><span><?php esc_html_e( 'International patients guide', 'walid' ); ?></span></a>
				</div>
			</div>
			<?php if ( $intl_photo ) : ?>
				<div class="wh-intl-figure">
				<div class="wh-intl-visual" data-wipe>
					<img src="<?php echo esc_url( $intl_photo ); ?>" alt="<?php esc_attr_e( 'A surgeon passing an instrument during a procedure (illustrative image)', 'walid' ); ?>" width="960" height="1200" loading="lazy" decoding="async" />
					<div class="wh-intl-badge">
						<b><?php echo esc_html( $intl_count ); ?></b>
						<span><?php esc_html_e( 'countries our patients travel from', 'walid' ); ?></span>
					</div>
				</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="wh-flags" aria-label="<?php esc_attr_e( 'Countries our patients travel from', 'walid' ); ?>">
			<ul class="wh-flags-track">
				<?php foreach ( $intl_countries as $c ) : ?>
					<li><?php echo walid_flag_img( $c['iso'], 'wh-flag' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?><span><?php echo esc_html( $c['name'] ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- 10. FINAL CTA -->
	<section class="wh-final" id="contact">
		<div class="wh-container">
			<p class="wh-eyebrow" data-reveal><?php esc_html_e( 'Contact', 'walid' ); ?></p>
			<h2 class="wh-h-display" data-split><?php esc_html_e( 'Ready when you are.', 'walid' ); ?></h2>
			<p class="wh-sub" data-reveal data-d="1"><?php esc_html_e( 'Message us on WhatsApp and the clinic team will help you choose a branch and a time.', 'walid' ); ?></p>
			<div class="wh-btn-row wh-center" data-reveal data-d="2">
				<a class="wh-btn wh-btn-wa wh-btn-lg" data-magnet href="<?php echo $wa_general; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" target="_blank" rel="noopener">
					<svg class="wh-ico" viewBox="0 0 24 24" aria-hidden="true"><use href="#wh-i-wa"/></svg><span><?php esc_html_e( 'WhatsApp us', 'walid' ); ?></span>
				</a>
			</div>
		</div>
	</section>

	<!-- Shared icons -->
	<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
		<symbol id="wh-i-wa" viewBox="0 0 24 24"><path d="M20.5 3.5A11 11 0 0 0 3.3 16.9L2 22l5.2-1.4A11 11 0 1 0 20.5 3.5zM12 20.1a9 9 0 0 1-4.6-1.3l-.3-.2-3 .8.8-2.9-.2-.3A9 9 0 1 1 12 20.1zm4.9-6.7c-.3-.1-1.6-.8-1.9-.9-.3-.1-.4-.1-.6.1l-.9 1.1c-.2.2-.3.2-.6.1-.3-.1-1.2-.4-2.3-1.4-.8-.8-1.4-1.7-1.6-2-.2-.3 0-.4.1-.6l.4-.5.3-.4c.1-.2.1-.3 0-.5l-.9-2.1c-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.3-.2.3-.9.9-.9 2.2s.9 2.5 1 2.7c.1.2 1.8 2.8 4.4 3.9 2.6 1.1 2.6.7 3.1.7.5-.1 1.6-.7 1.8-1.3.2-.6.2-1.1.2-1.2-.1-.1-.3-.2-.6-.3z"/></symbol>
		<symbol id="wh-i-arrow" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></symbol>
	</svg>

</main>

<?php
get_footer();
