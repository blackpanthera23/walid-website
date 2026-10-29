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

		<div class="archive-head">
			<p class="eyebrow"><?php esc_html_e( 'International patients', 'walid' ); ?></p>
			<h1><?php esc_html_e( 'Trusted across the region.', 'walid' ); ?></h1>
			<p class="lede"><?php esc_html_e( 'Patients travel from Sudan, Singapore, Indonesia and Brunei for care with Poliklinik Walid. Message the clinic and our team will help you plan your visit.', 'walid' ); ?></p>
			<p style="margin-top:16px;"><a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp us to plan a visit', 'walid' ); ?></a></p>
		</div>

		<?php
		// If the editor added page content, show it; otherwise show the branded default blocks.
		the_post();
		if ( trim( get_the_content() ) ) :
			?>
			<div class="entry"><?php the_content(); ?></div>
		<?php else : ?>
			<section class="group">
				<div class="card-grid">
					<article class="card">
						<h3><?php esc_html_e( 'Why patients travel to us', 'walid' ); ?></h3>
						<p><?php esc_html_e( 'Surgeon-led day-care surgery and specialist care, with a community of hundreds of thousands across TikTok, Facebook and Instagram, and a 4.9 Google rating from over a thousand reviews.', 'walid' ); ?></p>
					</article>
					<article class="card">
						<h3><?php esc_html_e( 'Planning your visit', 'walid' ); ?></h3>
						<p><?php esc_html_e( 'Message us before you travel so we can confirm the right branch, timing and what to prepare. [confirm travel guidance]', 'walid' ); ?></p>
					</article>
					<article class="card">
						<h3><?php esc_html_e( 'Care that respects your time', 'walid' ); ?></h3>
						<p><?php esc_html_e( 'Hospital-grade care, the smart choice, with many procedures completed in a single day.', 'walid' ); ?></p>
					</article>
				</div>
			</section>
		<?php endif; ?>

	</div>
</main>
<?php
get_footer();
