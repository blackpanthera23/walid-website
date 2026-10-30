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

		<div class="intl-proof reveal-group">
			<div class="intl-stat"><b>561K</b><span><?php esc_html_e( 'TikTok', 'walid' ); ?></span></div>
			<div class="intl-stat"><b>119K</b><span><?php esc_html_e( 'Facebook', 'walid' ); ?></span></div>
			<div class="intl-stat"><b>30.8K</b><span><?php esc_html_e( 'Instagram', 'walid' ); ?></span></div>
			<div class="intl-stat"><b>4.9&#9733;</b><span><?php esc_html_e( '1,098 reviews', 'walid' ); ?></span></div>
		</div>

		<?php
		// If the editor added page content, show it; otherwise show the branded default blocks.
		the_post();
		if ( trim( get_the_content() ) ) :
			?>
			<div class="entry"><?php the_content(); ?></div>
		<?php else : ?>
			<section class="group">
				<div class="card-grid reveal-group">
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
