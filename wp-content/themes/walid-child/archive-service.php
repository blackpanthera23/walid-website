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
			<section class="group">
				<div class="group-head">
					<h2><?php echo esc_html( $pillar_name ); ?></h2>
					<?php if ( $is_hero ) : ?>
						<span class="pin pin-hero"><?php esc_html_e( 'OUR SPECIALTY', 'walid' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="card-grid reveal-group">
					<?php foreach ( $services as $s ) : ?>
						<?php
						$short   = get_field( 'service_short_desc', $s->ID );
						$routing = get_field( 'service_wa_routing', $s->ID );
						$wa      = walid_whatsapp_url( $routing ? $routing : 'general', sprintf( /* translators: %s: service */ __( 'Hi, I would like to ask about %s.', 'walid' ), get_the_title( $s ) ) );
						?>
						<article class="card<?php echo $is_hero ? ' hero-card' : ''; ?>">
							<h3><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a></h3>
							<?php if ( $short ) : ?><p><?php echo esc_html( $short ); ?></p><?php endif; ?>
							<div class="card-foot">
								<a class="btn btn-ghost" href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php esc_html_e( 'Learn more', 'walid' ); ?></a>
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
