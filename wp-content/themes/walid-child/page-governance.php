<?php
/**
 * Template Name: About / Governance
 *
 * The single home for compliance (MMC, PDPA 2010) per the strategy: compliance lives here + the
 * footer, nowhere else. Also carries the corporate story. English-only.
 *
 * @package walid
 */

get_header();
the_post();
?>
<main class="walid-archive" id="primary">
	<div class="container">

		<div class="archive-head">
			<p class="eyebrow"><?php esc_html_e( 'About the group', 'walid' ); ?></p>
			<h1><?php the_title(); ?></h1>
		</div>

		<?php if ( trim( get_the_content() ) ) : ?>
			<div class="entry narrow"><?php the_content(); ?></div>
		<?php else : ?>
			<section class="group narrow">
				<h2><?php esc_html_e( 'Who we are', 'walid' ); ?></h2>
				<p><?php esc_html_e( 'Poliklinik Walid is a Malaysian healthcare group built around surgeon-led day-care minor surgery, with growing specialist care in aesthetics and women\'s health, and general practice across our branch network.', 'walid' ); ?></p>
				<p><?php esc_html_e( 'Our focus is simple: hospital-grade care at clinic speed and value. Many procedures are assessed and treated in a single visit, so patients are cared for properly and home the same day.', 'walid' ); ?></p>

				<h2><?php esc_html_e( 'What we stand for', 'walid' ); ?></h2>
				<p><?php esc_html_e( 'Qualified doctors, efficient day-care treatment, and care that patients trust. Our minor surgery is concentrated at our Central and Northern surgical centres, so the right expertise is where it is needed.', 'walid' ); ?></p>

				<h2><?php esc_html_e( 'Governance and patient information', 'walid' ); ?></h2>
				<p><?php esc_html_e( 'Our doctors are registered with the Malaysian Medical Council (MMC). Patient records are kept confidential in line with the Personal Data Protection Act 2010 (PDPA).', 'walid' ); ?></p>
				<p class="muted"><?php esc_html_e( 'Walid Healthcare Group Sdn. Bhd. (1466692-A).', 'walid' ); ?></p>
			</section>
		<?php endif; ?>

	</div>
</main>
<?php
get_footer();
