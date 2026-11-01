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
	// Antenatal / women's health services get the rose accent.
	$is_antenatal = ! empty( $pillars ) && false !== stripos( $pillars[0], 'Antenatal' );
	?>
	<?php
	$svc_img     = get_field( 'service_icon' );
	$svc_img_url = $svc_img ? wp_get_attachment_image_url( $svc_img, 'large' ) : walid_placeholder( 'service' );
	?>
	<main class="walid-single<?php echo $is_antenatal ? ' walid-antenatal' : ''; ?>" id="primary">

		<!-- Service hero: photo as a full-width background rather than a floating standing image. -->
		<header class="service-hero reveal" style="--svc-bg:url('<?php echo esc_url( $svc_img_url ); ?>');">
			<div class="service-hero-overlay"></div>
			<div class="container">
				<div class="service-hero-inner">
					<p class="eyebrow"><?php echo $pillars ? esc_html( $pillars[0] ) : esc_html__( 'Service', 'walid' ); ?></p>
					<h1><?php the_title(); ?></h1>
					<?php if ( $short ) : ?><p class="lede"><?php echo esc_html( $short ); ?></p><?php endif; ?>
					<p style="margin-top:18px;"><a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp about this', 'walid' ); ?></a></p>
				</div>
			</div>
		</header>

		<div class="container">

			<div class="meta-grid">
				<div>
					<?php if ( get_the_content() ) : ?>
						<div class="entry"><?php the_content(); ?></div>
					<?php else : ?>
						<p class="muted"><?php esc_html_e( 'Detailed information for this service is being prepared.', 'walid' ); ?></p>
					<?php endif; ?>

					<?php
					// Styled "Procedures we perform" grid from the service_procedures field.
					$procedures = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) get_field( 'service_procedures' ) ) ) );
					if ( $procedures ) :
						?>
						<section class="svc-procedures">
							<h2><?php esc_html_e( 'Procedures we perform', 'walid' ); ?></h2>
							<ul class="proc-cards reveal-group">
								<?php
								foreach ( $procedures as $p ) :
									// Each line may be "Name | short description". Split on the first pipe.
									$parts     = array_map( 'trim', explode( '|', $p, 2 ) );
									$proc_name = $parts[0];
									$proc_desc = isset( $parts[1] ) ? $parts[1] : '';
									?>
									<li class="proc-item">
										<span class="proc-check" aria-hidden="true"></span>
										<span class="proc-body">
											<span class="proc-name"><?php echo esc_html( $proc_name ); ?></span>
											<?php if ( $proc_desc ) : ?>
												<span class="proc-desc"><?php echo esc_html( $proc_desc ); ?></span>
											<?php endif; ?>
										</span>
									</li>
								<?php endforeach; ?>
							</ul>
						</section>
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

					<div class="card" style="margin-top:20px;">
						<h3><?php esc_html_e( 'Talk to us', 'walid' ); ?></h3>
						<p class="muted" style="margin-top:0;"><?php esc_html_e( 'Questions before you come in? Message us on WhatsApp and we will guide you.', 'walid' ); ?></p>
						<p style="margin:0;"><a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp about this', 'walid' ); ?></a></p>
					</div>
				</aside>
			</div>

			<?php
			// "Where we perform" — full-width section promoting the offered-at branches.
			if ( $branches ) :
				?>
				<section class="svc-where reveal">
					<h2><?php echo esc_html( sprintf( /* translators: %s: service title */ __( 'Where we perform %s', 'walid' ), strtolower( get_the_title() ) ) ); ?></h2>
					<p class="muted"><?php esc_html_e( 'This service is available at the branches below. Choose the one nearest you.', 'walid' ); ?></p>
					<div class="where-grid reveal-group">
						<?php foreach ( $branches as $bid ) : ?>
							<a class="where-card" href="<?php echo esc_url( get_permalink( $bid ) ); ?>">
								<span class="where-name"><?php echo esc_html( get_the_title( $bid ) ); ?></span>
								<span class="where-go" aria-hidden="true">&rarr;</span>
							</a>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

			<?php
			// "Why day-care surgery" — donut stats, now placed directly under "Where we perform".
			if ( ! empty( $procedures ) ) :
				?>
				<section class="svc-stats reveal">
					<h2><?php esc_html_e( 'Why day-care surgery', 'walid' ); ?></h2>
					<div class="stats-row">
						<figure class="donut" style="--pct:92;" role="img" aria-label="<?php esc_attr_e( '92 percent of minor procedures completed same day', 'walid' ); ?>">
							<div class="donut-center"><b>92%</b><span><?php esc_html_e( 'same-day', 'walid' ); ?></span></div>
						</figure>
						<figure class="donut donut-alt" style="--pct:70;" role="img" aria-label="<?php esc_attr_e( '70 percent under local anaesthetic', 'walid' ); ?>">
							<div class="donut-center"><b>70%</b><span><?php esc_html_e( 'local anaesthetic', 'walid' ); ?></span></div>
						</figure>
						<div class="stats-note">
							<p class="muted"><?php esc_html_e( 'Illustrative figures for the day-care model. [confirm with clinic]', 'walid' ); ?></p>
						</div>
					</div>
				</section>
			<?php endif; ?>

			<?php
			// Short testimonials (3). Use permitted Review CPT posts; fall back to sample quotes
			// flagged as pending, matching the homepage pattern.
			$svc_reviews = walid_permitted_reviews( 3 );
			$svc_quotes  = array();
			if ( $svc_reviews ) {
				foreach ( $svc_reviews as $rv ) {
					$svc_quotes[] = array(
						'q' => (string) get_field( 'review_quote', $rv->ID ),
						'w' => trim( ( (string) get_field( 'review_author', $rv->ID ) ) . ' · ' . ( get_field( 'review_source', $rv->ID ) ?: __( 'Google review', 'walid' ) ), ' ·' ),
						's' => (int) ( get_field( 'review_rating', $rv->ID ) ?: 5 ),
					);
				}
			} else {
				$svc_quotes = array(
					array( 'q' => __( 'Quick day-care procedure and a clear explanation. Home the same afternoon.', 'walid' ), 'w' => __( 'Google review [permission pending]', 'walid' ), 's' => 5 ),
					array( 'q' => __( 'The doctor took time to talk me through everything. Calm and reassuring.', 'walid' ), 'w' => __( 'Google review [permission pending]', 'walid' ), 's' => 5 ),
					array( 'q' => __( 'Booked over WhatsApp and seen fast. Professional from start to finish.', 'walid' ), 'w' => __( 'Google review [permission pending]', 'walid' ), 's' => 5 ),
				);
			}
			?>
			<section class="svc-testimonials reveal">
				<h2><?php esc_html_e( 'What patients say', 'walid' ); ?></h2>
				<div class="tst-grid reveal-group">
					<?php foreach ( $svc_quotes as $t ) : ?>
						<figure class="tst-card">
							<div class="stars" aria-hidden="true"><?php echo esc_html( str_repeat( '★', max( 1, min( 5, (int) $t['s'] ) ) ) ); ?></div>
							<blockquote><?php echo esc_html( $t['q'] ); ?></blockquote>
							<figcaption class="muted"><?php echo esc_html( $t['w'] ); ?></figcaption>
						</figure>
					<?php endforeach; ?>
				</div>
			</section>

			<?php
			// Brand promise band (one promise).
			?>
			<section class="svc-promise reveal" aria-label="<?php esc_attr_e( 'Our promise', 'walid' ); ?>">
				<div class="promise-inner">
					<p class="eyebrow"><?php esc_html_e( 'Our promise', 'walid' ); ?></p>
					<p class="promise-line"><?php esc_html_e( 'Assessed, treated and home the same day, by a team you can message anytime.', 'walid' ); ?></p>
					<p style="margin:0;"><a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp our team', 'walid' ); ?></a></p>
				</div>
			</section>

		</div>
	</main>
	<?php
endwhile;

get_footer();
