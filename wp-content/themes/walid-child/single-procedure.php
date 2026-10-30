<?php
/**
 * Single Procedure template (per-treatment page, AB look).
 *
 * 4-section patient-education structure (what it is / methods / what to expect / questions),
 * modelled on the live xanthelasma page. Trust-first, WhatsApp-only. See docs/14.
 *
 * @package walid
 */

get_header();

while ( have_posts() ) :
	the_post();
	$id        = get_the_ID();
	$summary   = get_field( 'proc_summary' );
	$image     = get_field( 'proc_image' );
	$parent    = get_field( 'proc_parent_service' );
	$routing   = get_field( 'proc_wa_routing' );
	$what      = get_field( 'proc_what' );
	$note      = get_field( 'proc_note' );
	$methods   = get_field( 'proc_methods' );
	$expect    = get_field( 'proc_expect' );
	$questions = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) get_field( 'proc_questions' ) ) ) );
	$branches  = get_field( 'proc_branches' );
	$wa        = walid_whatsapp_url( $routing ? $routing : 'minor_surgery', sprintf( /* translators: %s: procedure */ __( 'Hi, I would like to ask about %s.', 'walid' ), get_the_title() ) );
	?>
	<main class="walid-procedure" id="primary">

		<!-- HERO -->
		<section class="proc-hero">
			<div class="container proc-hero-grid">
				<div>
					<?php if ( $parent ) : ?>
						<p class="eyebrow"><a href="<?php echo esc_url( get_permalink( $parent ) ); ?>"><?php echo esc_html( get_the_title( $parent ) ); ?></a></p>
					<?php else : ?>
						<p class="eyebrow"><?php esc_html_e( 'Minor Surgery', 'walid' ); ?></p>
					<?php endif; ?>
					<h1><?php the_title(); ?></h1>
					<?php if ( $summary ) : ?><p class="lead"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
					<a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp the minor surgery team', 'walid' ); ?></a>
				</div>
				<div class="proc-hero-art reveal" aria-hidden="true">
					<div class="proc-panel">
						<?php if ( $image ) : ?>
							<?php echo wp_get_attachment_image( $image, 'large', false, array( 'alt' => esc_attr( get_the_title() ), 'loading' => 'eager' ) ); ?>
						<?php else : ?>
							<img src="<?php echo walid_placeholder( 'procedure' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="" />
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>

		<div class="container proc-body">

			<!-- 01 · WHAT IT IS -->
			<?php if ( $what ) : ?>
				<section class="proc-section reveal">
					<span class="proc-num">01 &middot; <?php esc_html_e( 'What it is', 'walid' ); ?></span>
					<div class="proc-prose"><?php echo wp_kses_post( $what ); ?></div>
					<?php if ( $note ) : ?>
						<div class="proc-note"><?php echo esc_html( $note ); ?></div>
					<?php endif; ?>
				</section>
			<?php endif; ?>

			<!-- 02 · METHODS -->
			<?php if ( $methods ) : ?>
				<section class="proc-section reveal">
					<span class="proc-num">02 &middot; <?php esc_html_e( 'Methods', 'walid' ); ?></span>
					<p class="muted proc-sub"><?php esc_html_e( 'The right method depends on your lesion. A doctor decides after examining it.', 'walid' ); ?></p>
					<div class="proc-methods reveal-group">
						<?php foreach ( $methods as $i => $m ) : ?>
							<article class="proc-method">
								<span class="proc-method-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
								<h3><?php echo esc_html( $m['name'] ); ?></h3>
								<p><?php echo esc_html( $m['body'] ); ?></p>
							</article>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

			<!-- 03 · WHAT TO EXPECT -->
			<?php if ( $expect ) : ?>
				<section class="proc-section reveal">
					<span class="proc-num">03 &middot; <?php esc_html_e( 'What to expect', 'walid' ); ?></span>
					<ol class="proc-steps reveal-group">
						<?php foreach ( $expect as $step ) : ?>
							<li class="proc-step">
								<h3><?php echo esc_html( $step['name'] ); ?></h3>
								<p><?php echo esc_html( $step['body'] ); ?></p>
							</li>
						<?php endforeach; ?>
					</ol>
				</section>
			<?php endif; ?>

			<!-- 04 · QUESTIONS -->
			<?php if ( $questions ) : ?>
				<section class="proc-section reveal">
					<span class="proc-num">04 &middot; <?php esc_html_e( 'Questions worth asking', 'walid' ); ?></span>
					<p class="muted proc-sub"><?php esc_html_e( 'Bring these to the consultation.', 'walid' ); ?></p>
					<ul class="proc-questions">
						<?php foreach ( $questions as $q ) : ?>
							<li><span class="q-tick" aria-hidden="true"></span><?php echo esc_html( $q ); ?></li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>

			<?php if ( $branches ) : ?>
				<section class="proc-section reveal">
					<span class="proc-num"><?php esc_html_e( 'Where', 'walid' ); ?></span>
					<div class="tag-row">
						<?php foreach ( $branches as $bid ) : ?>
							<a class="tag" href="<?php echo esc_url( get_permalink( $bid ) ); ?>"><?php echo esc_html( get_the_title( $bid ) ); ?></a>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

		</div>

		<!-- FINAL CTA -->
		<section class="proc-cta">
			<div class="container">
				<h2><?php esc_html_e( 'Have it assessed first.', 'walid' ); ?></h2>
				<p><?php esc_html_e( 'Message the minor surgery team on WhatsApp and we will arrange an assessment.', 'walid' ); ?></p>
				<a class="btn btn-wa lg" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp us', 'walid' ); ?></a>
			</div>
		</section>

	</main>
	<?php
endwhile;

get_footer();
