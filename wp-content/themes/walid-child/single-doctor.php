<?php
/**
 * Single Doctor template.
 *
 * Renders doctor CPT fields with the expertise-first framing: the services they lead and the
 * branches they practise at. Photo degrades gracefully when not yet supplied (consent pending).
 *
 * @package walid
 */

get_header();

while ( have_posts() ) :
	the_post();
	$id       = get_the_ID();
	$role     = get_field( 'doctor_role' );
	$quals    = get_field( 'doctor_qualifications' );
	$photo    = get_field( 'doctor_photo' );
	$bio      = get_field( 'doctor_bio' );
	$branches = get_field( 'doctor_branches' );
	$lead_for = get_field( 'doctor_lead_for' );
	$wa       = walid_whatsapp_url( 'general', sprintf( /* translators: %s: doctor */ __( 'Hi, I would like to ask about an appointment with %s.', 'walid' ), get_the_title() ) );
	?>
	<main class="walid-single" id="primary">
		<div class="container">

			<div class="doctor-hero single-head">
				<div class="doctor-photo">
					<?php if ( $photo ) : ?>
						<?php echo wp_get_attachment_image( $photo, 'large', false, array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
					<?php else : ?>
						<img src="<?php echo walid_placeholder( 'doctor' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
					<?php endif; ?>
				</div>
				<div>
					<p class="eyebrow"><?php esc_html_e( 'Our doctors', 'walid' ); ?></p>
					<h1><?php the_title(); ?></h1>
					<?php if ( $role ) : ?><p class="gold-line"><?php echo esc_html( $role ); ?></p><?php endif; ?>
					<?php if ( $quals ) : ?><p class="muted"><?php echo esc_html( $quals ); ?></p><?php endif; ?>
					<p style="margin-top:14px;"><a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp us', 'walid' ); ?></a></p>
				</div>
			</div>

			<?php if ( $bio ) : ?>
				<p class="lede"><?php echo esc_html( $bio ); ?></p>
			<?php else : ?>
				<p class="lede"><?php echo esc_html( sprintf( /* translators: %s: doctor name */ __( '%s cares for patients across our network, combining hands-on clinical experience with a calm, patient-first approach. Full profile details are being prepared.', 'walid' ), get_the_title() ) ); ?></p>
			<?php endif; ?>

			<div class="meta-grid doctor-body" style="margin-top:28px;">
				<div>
					<?php if ( get_the_content() ) : ?>
						<div class="entry"><?php the_content(); ?></div>
					<?php endif; ?>

					<section class="doc-block">
						<h2><?php esc_html_e( 'Areas of focus', 'walid' ); ?></h2>
						<?php if ( $lead_for ) : ?>
							<p class="muted"><?php esc_html_e( 'Leads care in these areas across the group:', 'walid' ); ?></p>
							<div class="tag-row">
								<?php foreach ( $lead_for as $sid ) : ?>
									<a class="tag" href="<?php echo esc_url( get_permalink( $sid ) ); ?>"><?php echo esc_html( get_the_title( $sid ) ); ?></a>
								<?php endforeach; ?>
							</div>
						<?php else : ?>
							<p class="muted"><?php esc_html_e( 'Surgeon-led day-care minor surgery, general consultations and patient-first care. [confirm specific focus areas]', 'walid' ); ?></p>
						<?php endif; ?>
					</section>

					<section class="doc-block">
						<h2><?php esc_html_e( 'How we care for you', 'walid' ); ?></h2>
						<ul class="doc-highlights">
							<li><span class="dh-check" aria-hidden="true"></span><span><?php esc_html_e( 'Assessment, treatment and recovery handled in a single day where suitable.', 'walid' ); ?></span></li>
							<li><span class="dh-check" aria-hidden="true"></span><span><?php esc_html_e( 'Clear explanation before anything begins, so you know what to expect.', 'walid' ); ?></span></li>
							<li><span class="dh-check" aria-hidden="true"></span><span><?php esc_html_e( 'Reach the team on WhatsApp before and after your visit.', 'walid' ); ?></span></li>
							<li><span class="dh-check" aria-hidden="true"></span><span><?php esc_html_e( 'Halal-conscious medication and care, delivered with integrity.', 'walid' ); ?></span></li>
						</ul>
					</section>

					<?php $stats = walid_stats(); ?>
					<section class="doc-block doc-proof reveal-group">
						<div class="doc-stat"><b><?php echo esc_html( $stats['rating'] ); ?>&#9733;</b><span><?php echo esc_html( sprintf( /* translators: %s: count */ __( 'from %s Google reviews', 'walid' ), $stats['reviews'] ) ); ?></span></div>
						<div class="doc-stat"><b><?php echo esc_html( $stats['tiktok'] ); ?></b><span><?php esc_html_e( 'following on TikTok', 'walid' ); ?></span></div>
						<div class="doc-stat"><b><?php echo esc_html( $stats['facebook'] ); ?></b><span><?php esc_html_e( 'on Facebook', 'walid' ); ?></span></div>
					</section>
				</div>

				<aside>
					<div class="card doc-at-a-glance">
						<h3><?php esc_html_e( 'At a glance', 'walid' ); ?></h3>
						<dl class="kv">
							<?php if ( $role ) : ?><dt><?php esc_html_e( 'Role', 'walid' ); ?></dt><dd><?php echo esc_html( $role ); ?></dd><?php endif; ?>
							<?php if ( $quals ) : ?><dt><?php esc_html_e( 'Qualifications', 'walid' ); ?></dt><dd><?php echo esc_html( $quals ); ?></dd><?php endif; ?>
							<dt><?php esc_html_e( 'Registration', 'walid' ); ?></dt><dd><?php esc_html_e( 'Malaysian Medical Council (MMC)', 'walid' ); ?></dd>
							<dt><?php esc_html_e( 'Consultations', 'walid' ); ?></dt><dd><?php esc_html_e( 'By WhatsApp appointment', 'walid' ); ?></dd>
						</dl>
						<p style="margin:16px 0 0;"><a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Book via WhatsApp', 'walid' ); ?></a></p>
					</div>

					<?php if ( $branches ) : ?>
						<div class="card" style="margin-top:20px;">
							<h3><?php esc_html_e( 'Practises at', 'walid' ); ?></h3>
							<div class="tag-row">
								<?php foreach ( $branches as $bid ) : ?>
									<a class="tag" href="<?php echo esc_url( get_permalink( $bid ) ); ?>"><?php echo esc_html( get_the_title( $bid ) ); ?></a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</aside>
			</div>

		</div>
	</main>
	<?php
endwhile;

get_footer();
