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
			<?php endif; ?>

			<div class="meta-grid" style="margin-top:28px;">
				<?php if ( $lead_for ) : ?>
					<div class="card">
						<h3><?php esc_html_e( 'Specialist in', 'walid' ); ?></h3>
						<div class="tag-row">
							<?php foreach ( $lead_for as $sid ) : ?>
								<a class="tag" href="<?php echo esc_url( get_permalink( $sid ) ); ?>"><?php echo esc_html( get_the_title( $sid ) ); ?></a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $branches ) : ?>
					<div class="card">
						<h3><?php esc_html_e( 'Practises at', 'walid' ); ?></h3>
						<div class="tag-row">
							<?php foreach ( $branches as $bid ) : ?>
								<a class="tag" href="<?php echo esc_url( get_permalink( $bid ) ); ?>"><?php echo esc_html( get_the_title( $bid ) ); ?></a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</main>
	<?php
endwhile;

get_footer();
