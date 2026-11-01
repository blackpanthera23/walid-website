<?php
/**
 * Template Name: International Patients
 *
 * English branding page (see docs/04-sitemap.md + brief §8). Does the perception-management
 * job for patients travelling from Sudan, Singapore, Indonesia and Brunei. No translation.
 *
 * @package walid
 */

get_header();

$wa = walid_whatsapp_url( 'general', __( 'Hi, I am an international patient and would like to plan a visit.', 'walid' ) );
?>
<main class="walid-archive" id="primary">
	<div class="container">

		<div class="intl-hero reveal">
			<div class="intl-hero-text">
				<p class="eyebrow"><?php esc_html_e( 'International patients', 'walid' ); ?></p>
				<h1><?php esc_html_e( 'Trusted across the region.', 'walid' ); ?></h1>
				<div class="intl-flags" aria-label="<?php esc_attr_e( 'Sudan, Singapore, Indonesia, Brunei', 'walid' ); ?>">
					<span title="Sudan">&#127480;&#127465;</span>
					<span title="Singapore">&#127480;&#127468;</span>
					<span title="Indonesia">&#127470;&#127465;</span>
					<span title="Brunei">&#127463;&#127475;</span>
				</div>
				<p class="lede"><?php esc_html_e( 'Patients travel from Sudan, Singapore, Indonesia and Brunei for care with Poliklinik Walid. Message the clinic and our team will help you plan your visit.', 'walid' ); ?></p>
				<p style="margin-top:16px;"><a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp us to plan a visit', 'walid' ); ?></a></p>
			</div>
			<div class="intl-hero-art">
				<img src="<?php echo walid_placeholder( 'hero' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="" loading="eager" />
			</div>
		</div>

		<?php $stats = walid_stats(); ?>
		<div class="intl-proof reveal-group">
			<div class="intl-stat"><b><?php echo esc_html( $stats['tiktok'] ); ?></b><span><?php esc_html_e( 'TikTok', 'walid' ); ?></span></div>
			<div class="intl-stat"><b><?php echo esc_html( $stats['facebook'] ); ?></b><span><?php esc_html_e( 'Facebook', 'walid' ); ?></span></div>
			<div class="intl-stat"><b><?php echo esc_html( $stats['instagram'] ); ?></b><span><?php esc_html_e( 'Instagram', 'walid' ); ?></span></div>
			<div class="intl-stat"><b><?php echo esc_html( $stats['rating'] ); ?>&#9733;</b><span><?php echo esc_html( sprintf( /* translators: %s: review count */ __( '%s reviews', 'walid' ), $stats['reviews'] ) ); ?></span></div>
		</div>

		<?php
		// If the editor added page content, show it; otherwise show the branded default blocks.
		the_post();
		if ( trim( get_the_content() ) ) :
			?>
			<div class="entry"><?php the_content(); ?></div>
		<?php else : ?>
			<section class="group">
				<div class="card-grid intl-cards reveal-group">
					<article class="card">
						<h3><?php esc_html_e( 'Why patients travel to us', 'walid' ); ?></h3>
						<p><?php esc_html_e( 'Surgeon-led day-care surgery and specialist care, backed by a large and active community across TikTok, Facebook and Instagram and a strong record of Google reviews.', 'walid' ); ?></p>
					</article>
					<article class="card">
						<h3><?php esc_html_e( 'Planning your visit', 'walid' ); ?></h3>
						<p><?php esc_html_e( 'Message us on WhatsApp before you travel. We will confirm which branch to visit, suggest timing, and tell you what to prepare, so your trip is straightforward from the start.', 'walid' ); ?></p>
					</article>
					<article class="card">
						<h3><?php esc_html_e( 'Care that respects your time', 'walid' ); ?></h3>
						<p><?php esc_html_e( 'Hospital-grade care, the smart choice, with many procedures assessed and completed in a single day.', 'walid' ); ?></p>
					</article>
				</div>
			</section>

			<?php
			// Short testimonials from patients, with a clear scroll-in motion.
			$intl_quotes = walid_pillar_sample_reviews( 'Minor Surgery' );
			?>
			<section class="group intl-testimonials reveal">
				<div class="group-head"><h2><?php esc_html_e( 'What patients say', 'walid' ); ?></h2></div>
				<div class="tst-grid reveal-group">
					<?php foreach ( $intl_quotes as $t ) : ?>
						<figure class="tst-card">
							<div class="stars" aria-hidden="true"><?php echo esc_html( str_repeat( '★', max( 1, min( 5, (int) $t['s'] ) ) ) ); ?></div>
							<blockquote><?php echo esc_html( $t['q'] ); ?></blockquote>
							<figcaption class="muted"><?php echo esc_html( $t['w'] ); ?></figcaption>
						</figure>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

	</div>
</main>
<?php
get_footer();
