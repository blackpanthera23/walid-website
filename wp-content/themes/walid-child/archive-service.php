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
			// Per-pillar accent palette (scoped soft-tone panel).
			$accent_class = 'walid-minor'; // default/hero navy
			if ( false !== stripos( $pillar_name, 'Antenatal' ) ) {
				$accent_class = 'walid-antenatal';
			} elseif ( false !== stripos( $pillar_name, 'Aesthetic' ) ) {
				$accent_class = 'walid-aesthetic';
			} elseif ( false !== stripos( $pillar_name, 'General' ) ) {
				$accent_class = 'walid-general';
			}
			?>
			<section class="group pillar-section pillar-tinted <?php echo esc_attr( $accent_class ); ?><?php echo $is_hero ? ' is-hero' : ''; ?>">
				<div class="group-head">
					<h2><?php echo esc_html( $pillar_name ); ?></h2>
					<?php if ( $is_hero ) : ?>
						<span class="pin pin-hero"><?php esc_html_e( 'OUR SPECIALTY', 'walid' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="card-grid reveal-group">

					<?php if ( $is_hero ) : ?>
						<?php
						// Minor surgery procedures, grouped into clinical categories. Each category
						// is its own card listing its procedures; anything that does not fit a
						// category falls into "Others". [confirm grouping with clinic]
						$ms_categories = array(
							array(
								'title' => __( 'Skin and Subcutaneous Tissue', 'walid' ),
								'desc'  => __( 'Lumps, cysts, moles and skin lesions removed under local anaesthetic.', 'walid' ),
								'items' => array(
									array( 'Lipoma', 'A soft fatty lump under the skin, assessed and removed.' ),
									array( 'Sebaceous cyst', 'A fluid-filled lump under the skin.' ),
									array( 'Ganglion cyst', 'A fluid-filled lump, often near a joint or tendon.' ),
									array( 'Skin tag', 'A small, soft skin growth.' ),
									array( 'Giant skin tag', 'A larger skin tag needing removal.' ),
									array( 'Mole', 'A pigmented growth checked before removal.' ),
									array( 'Keloid (surgical removal)', 'An overgrown scar, excised rather than injected.' ),
									array( 'Keratosis', 'A rough, scaly skin patch.' ),
									array( 'Milia', 'Tiny white keratin cysts.' ),
									array( 'Syringoma', 'Small benign sweat-gland growths.' ),
									array( 'Granuloma', 'A small inflammatory nodule.' ),
									array( 'Neurofibromatosis', 'Removal of benign nerve-tissue lumps.' ),
								),
							),
							array(
								'title' => __( 'Wound Care and Trauma Repair', 'walid' ),
								'desc'  => __( 'Drainage and management of abscesses and infected skin conditions.', 'walid' ),
								'items' => array(
									array( 'Abscess', 'A collection of pus, drained under local anaesthetic.' ),
									array( 'Carbuncle', 'A cluster of infected hair follicles, drained.' ),
									array( 'Infected hidradenitis suppurativa (HS)', 'Recurrent skin abscesses, managed and drained.' ),
								),
							),
							array(
								'title' => __( 'Nail and Minor Dermatological Surgeries', 'walid' ),
								'desc'  => __( 'Nail procedures and precise removal of warts and eyelid lesions.', 'walid' ),
								'items' => array(
									array( 'Wart', 'A viral skin growth.' ),
									array( 'Genital warts', 'Viral warts needing discreet, careful care.' ),
									array( 'Eye warts', 'Warts near the eye, removed with precision.' ),
									array( 'Xanthelasma', 'Yellow cholesterol deposits on the eyelid.' ),
									array( 'Ingrown toenail', 'A nail growing into the skin, treated.' ),
								),
							),
							array(
								'title' => __( 'Therapeutic and Joint Injections', 'walid' ),
								'desc'  => __( 'Assessment and management of joint and soft-tissue conditions.', 'walid' ),
								'items' => array(
									array( 'Gout', 'Assessment and management of gout-related lumps.' ),
								),
							),
							array(
								'title' => __( 'Minor Gynaecological and Urological Procedures', 'walid' ),
								'desc'  => __( 'Day-care procedures for common gynaecological and urological needs.', 'walid' ),
								'items' => array(
									array( 'Circumcision', 'For children aged 2 and above, and adults.' ),
									array( 'Gynaecomastia', 'Enlarged male breast tissue, assessed and treated.' ),
									array( 'Accessory breast', 'Extra breast tissue, usually in the armpit.' ),
								),
							),
							array(
								'title' => __( 'Others', 'walid' ),
								'desc'  => __( 'Further day-care procedures performed by our surgeon-led team.', 'walid' ),
								'items' => array(
									array( 'Eyebag', 'Surgical reduction of under-eye bags.' ),
									array( 'Tongue tie', 'A tight band under the tongue, released.' ),
									array( 'Extra finger (polydactyly)', 'Removal of an additional digit.' ),
								),
							),
						);
						foreach ( $ms_categories as $cat ) :
							?>
							<article class="card has-media hero-card">
								<div class="card-media">
									<img src="<?php echo walid_placeholder( 'service' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="<?php echo esc_attr( $cat['title'] ); ?>" loading="lazy" />
								</div>
								<h3><?php echo esc_html( $cat['title'] ); ?></h3>
								<p><?php echo esc_html( $cat['desc'] ); ?></p>
								<?php if ( ! empty( $cat['items'] ) ) : ?>
									<?php
									$cat_first = array_slice( $cat['items'], 0, 6 );
									$cat_rest  = array_slice( $cat['items'], 6 );
									?>
									<div class="proc">
										<ul class="proc-list">
											<?php foreach ( $cat_first as $it ) : ?>
												<li><span class="proc-tick" aria-hidden="true"></span><span class="proc-text"><b><?php echo esc_html( $it[0] ); ?></b><span class="proc-desc"><?php echo esc_html( $it[1] ); ?></span></span></li>
											<?php endforeach; ?>
										</ul>
										<?php if ( $cat_rest ) : ?>
											<div class="proc-extra" hidden>
												<ul class="proc-list">
													<?php foreach ( $cat_rest as $it ) : ?>
														<li><span class="proc-tick" aria-hidden="true"></span><span class="proc-text"><b><?php echo esc_html( $it[0] ); ?></b><span class="proc-desc"><?php echo esc_html( $it[1] ); ?></span></span></li>
													<?php endforeach; ?>
												</ul>
											</div>
											<button type="button" class="proc-toggle" aria-expanded="false"
												data-more="<?php echo esc_attr( sprintf( /* translators: %d: count */ _n( 'Show %d more', 'Show %d more', count( $cat_rest ), 'walid' ), count( $cat_rest ) ) ); ?>"
												data-less="<?php esc_attr_e( 'Show less', 'walid' ); ?>">
												<span class="proc-toggle-label"><?php echo esc_html( sprintf( /* translators: %d: count */ _n( 'Show %d more', 'Show %d more', count( $cat_rest ), 'walid' ), count( $cat_rest ) ) ); ?></span>
												<span class="proc-toggle-icon" aria-hidden="true"></span>
											</button>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<div class="card-foot">
									<a class="btn btn-wa" href="<?php echo walid_whatsapp_url( 'minor_surgery', sprintf( /* translators: %s: category */ __( 'Hi, I would like to ask about %s.', 'walid' ), $cat['title'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp', 'walid' ); ?></a>
								</div>
							</article>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php
					foreach ( $services as $s ) :
						// On the hero (Minor Surgery) pillar, the single "Minor Surgery" service is
						// now represented by the category cards above, so skip rendering it again.
						if ( $is_hero && false !== stripos( get_the_title( $s ), 'minor surgery' ) ) {
							continue;
						}
						?>
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
											<?php list( $p_name, $p_desc ) = array_pad( array_map( 'trim', explode( '|', $p, 2 ) ), 2, '' ); ?>
											<li><span class="proc-tick" aria-hidden="true"></span><span class="proc-text"><b><?php echo esc_html( $p_name ); ?></b><?php echo $p_desc ? '<span class="proc-desc">' . esc_html( $p_desc ) . '</span>' : ''; ?></span></li>
										<?php endforeach; ?>
									</ul>
									<?php if ( $rest ) : ?>
										<div class="proc-extra" hidden>
											<ul class="proc-list">
												<?php foreach ( $rest as $p ) : ?>
													<?php list( $p_name, $p_desc ) = array_pad( array_map( 'trim', explode( '|', $p, 2 ) ), 2, '' ); ?>
													<li><span class="proc-tick" aria-hidden="true"></span><span class="proc-text"><b><?php echo esc_html( $p_name ); ?></b><?php echo $p_desc ? '<span class="proc-desc">' . esc_html( $p_desc ) . '</span>' : ''; ?></span></li>
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
