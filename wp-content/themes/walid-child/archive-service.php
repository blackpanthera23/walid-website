<?php
/**
 * Services archive — grouped by pillar, hero (Minor Surgery) first, then rising, then base.
 *
 * @package walid
 */

get_header();

// Pillar display order: hero first, then rising, then general base.
$pillar_order = array(
	'Minor Surgery',
	'Aesthetics',
	"Antenatal & Women's Health",
	'Pillar 4 (TBD)',
	'General Medicine',
);
$hero_pillar = 'Minor Surgery';
?>
<main class="walid-archive" id="primary">
	<div class="container">

		<div class="archive-head">
			<p class="eyebrow"><?php esc_html_e( 'What we do', 'walid' ); ?></p>
			<h1><?php esc_html_e( 'Our services', 'walid' ); ?></h1>
			<p class="lede"><?php esc_html_e( 'Surgeon-led day-care minor surgery leads our care, with aesthetics and women\'s health as growing specialist areas, and general practice across the network.', 'walid' ); ?></p>
		</div>

		<?php foreach ( $pillar_order as $pillar_name ) : ?>
			<?php
			$term = get_term_by( 'name', $pillar_name, 'pillar' );
			if ( ! $term ) {
				continue;
			}
			$services = get_posts(
				array(
					'post_type'      => 'service',
					'posts_per_page' => -1,
					'orderby'        => 'menu_order title',
					'order'          => 'ASC',
					'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
						array(
							'taxonomy' => 'pillar',
							'field'    => 'term_id',
							'terms'    => $term->term_id,
						),
					),
				)
			);
			if ( ! $services ) {
				continue;
			}
			$is_hero = ( $hero_pillar === $pillar_name );
			?>
			<section class="group pillar-section<?php echo $is_hero ? ' is-hero' : ''; ?>">
				<div class="group-head">
					<h2><?php echo esc_html( $pillar_name ); ?></h2>
					<?php if ( $is_hero ) : ?>
						<span class="pin pin-hero"><?php esc_html_e( 'OUR SPECIALTY', 'walid' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="card-grid reveal-group">
					<?php foreach ( $services as $s ) : ?>
						<?php
						$short      = get_field( 'service_short_desc', $s->ID );
						$routing    = get_field( 'service_wa_routing', $s->ID );
						$procedures = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) get_field( 'service_procedures', $s->ID ) ) ) );
						$icon       = get_field( 'service_icon', $s->ID );
						$wa         = walid_whatsapp_url( $routing ? $routing : 'general', sprintf( /* translators: %s: service */ __( 'Hi, I would like to ask about %s.', 'walid' ), get_the_title( $s ) ) );
						?>
						<article class="card has-media<?php echo $is_hero ? ' hero-card' : ''; ?>">
							<div class="card-media">
								<?php if ( $icon ) : ?>
									<?php echo wp_get_attachment_image( $icon, 'medium', false, array( 'alt' => esc_attr( get_the_title( $s ) ), 'loading' => 'lazy' ) ); ?>
								<?php else : ?>
									<img src="<?php echo walid_placeholder( 'service' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="<?php echo esc_attr( get_the_title( $s ) ); ?>" loading="lazy" />
								<?php endif; ?>
							</div>
							<h3><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a></h3>
							<?php if ( $short ) : ?><p><?php echo esc_html( $short ); ?></p><?php endif; ?>

							<?php if ( $procedures ) : ?>
								<?php
								$first = array_slice( $procedures, 0, 6 );
								$rest  = array_slice( $procedures, 6 );
								?>
								<div class="proc">
									<ul class="proc-list">
										<?php foreach ( $first as $p ) : ?>
											<li><span class="proc-tick" aria-hidden="true"></span><?php echo esc_html( $p ); ?></li>
										<?php endforeach; ?>
									</ul>
									<?php if ( $rest ) : ?>
										<div class="proc-extra" hidden>
											<ul class="proc-list">
												<?php foreach ( $rest as $p ) : ?>
													<li><span class="proc-tick" aria-hidden="true"></span><?php echo esc_html( $p ); ?></li>
												<?php endforeach; ?>
											</ul>
										</div>
										<button type="button" class="proc-toggle" aria-expanded="false"
											data-more="<?php echo esc_attr( sprintf( /* translators: %d: count */ _n( 'Show %d more procedure', 'Show %d more procedures', count( $rest ), 'walid' ), count( $rest ) ) ); ?>"
											data-less="<?php esc_attr_e( 'Show less', 'walid' ); ?>">
											<span class="proc-toggle-label"><?php echo esc_html( sprintf( /* translators: %d: count */ _n( 'Show %d more procedure', 'Show %d more procedures', count( $rest ), 'walid' ), count( $rest ) ) ); ?></span>
											<span class="proc-toggle-icon" aria-hidden="true"></span>
										</button>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<div class="card-foot">
								<a class="btn btn-ghost" href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php esc_html_e( 'Learn more', 'walid' ); ?></a>
								<a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp', 'walid' ); ?></a>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endforeach; ?>

	</div>
</main>
<?php
get_footer();
