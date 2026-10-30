<?php
/**
 * Single Service template.
 *
 * Renders service CPT fields, the lead specialist (expertise-first), and offered-at branches.
 * WhatsApp routes per the service's routing field.
 *
 * @package walid
 */

get_header();

while ( have_posts() ) :
	the_post();
	$id        = get_the_ID();
	$short     = get_field( 'service_short_desc' );
	$routing   = get_field( 'service_wa_routing' );
	$lead_id   = get_field( 'service_lead_doctor' );
	$branches  = get_field( 'service_branches' );
	$pillars   = wp_get_post_terms( $id, 'pillar', array( 'fields' => 'names' ) );
	$wa        = walid_whatsapp_url( $routing ? $routing : 'general', sprintf( /* translators: %s: service */ __( 'Hi, I would like to ask about %s.', 'walid' ), get_the_title() ) );
	?>
	<main class="walid-single" id="primary">
		<div class="container">

			<div class="single-head">
				<p class="eyebrow"><?php echo $pillars ? esc_html( $pillars[0] ) : esc_html__( 'Service', 'walid' ); ?></p>
				<h1><?php the_title(); ?></h1>
				<?php if ( $short ) : ?><p class="lede"><?php echo esc_html( $short ); ?></p><?php endif; ?>
				<p style="margin-top:16px;"><a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp about this', 'walid' ); ?></a></p>
			</div>

			<?php $svc_img = get_field( 'service_icon' ); ?>
			<div class="service-photo reveal">
				<?php if ( $svc_img ) : ?>
					<?php echo wp_get_attachment_image( $svc_img, 'large', false, array( 'alt' => esc_attr( get_the_title() ), 'loading' => 'lazy' ) ); ?>
				<?php else : ?>
					<img src="<?php echo walid_placeholder( 'service' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
				<?php endif; ?>
			</div>

			<div class="meta-grid">
				<div>
					<?php if ( get_the_content() ) : ?>
						<div class="entry"><?php the_content(); ?></div>
					<?php else : ?>
						<p class="muted"><?php esc_html_e( 'Detailed information for this service is being prepared.', 'walid' ); ?></p>
					<?php endif; ?>
				</div>

				<aside>
					<?php
					// Lead specialist — expertise-first: service context already set above; the
					// doctor validates it.
					if ( $lead_id ) :
						$role  = get_field( 'doctor_role', $lead_id );
						$photo = get_field( 'doctor_photo', $lead_id );
						?>
						<div class="card">
							<h3><?php esc_html_e( 'Led by', 'walid' ); ?></h3>
							<p class="gold-line"><a href="<?php echo esc_url( get_permalink( $lead_id ) ); ?>"><?php echo esc_html( get_the_title( $lead_id ) ); ?></a></p>
							<?php if ( $role ) : ?><p class="muted" style="margin:0;"><?php echo esc_html( $role ); ?></p><?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $branches ) : ?>
						<div class="card" style="margin-top:20px;">
							<h3><?php esc_html_e( 'Available at', 'walid' ); ?></h3>
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
