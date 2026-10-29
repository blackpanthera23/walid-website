<?php
/**
 * Single Branch template.
 *
 * Renders branch CPT fields. Flagged/empty fields (address, hours, photos) degrade gracefully
 * so an unfinished branch still produces a clean page. Minor-surgery branches route WhatsApp to
 * the surgery line.
 *
 * @package walid
 */

get_header();

while ( have_posts() ) :
	the_post();
	$id         = get_the_ID();
	$address    = get_field( 'branch_address' );
	$phone      = get_field( 'branch_phone' );
	$hours      = get_field( 'branch_hours' );
	$map        = get_field( 'branch_map_embed' );
	$minor      = (bool) get_field( 'branch_provides_minor_surgery' );
	$flagship   = (bool) get_field( 'branch_is_flagship' );
	$services   = get_field( 'branch_services' );
	$wa_context = $minor ? 'minor_surgery' : 'general';
	$wa         = walid_whatsapp_url( $wa_context, sprintf( /* translators: %s: branch */ __( 'Hi, I would like to ask about %s.', 'walid' ), get_the_title() ) );
	?>
	<main class="walid-single" id="primary">
		<div class="container">

			<div class="single-head">
				<p class="eyebrow">
					<?php esc_html_e( 'Branch', 'walid' ); ?>
					<?php if ( $flagship ) : ?><span class="pin"><?php esc_html_e( 'FLAGSHIP', 'walid' ); ?></span><?php endif; ?>
				</p>
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?><p class="lede"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
				<p style="margin-top:16px;"><a class="btn btn-wa" href="<?php echo $wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp this branch', 'walid' ); ?></a></p>
			</div>

			<div class="meta-grid">
				<div>
					<?php if ( get_the_content() ) : ?>
						<div class="entry"><?php the_content(); ?></div>
					<?php endif; ?>

					<?php if ( $minor ) : ?>
						<p class="flag-note"><?php esc_html_e( 'This branch performs day-care minor surgery.', 'walid' ); ?></p>
					<?php endif; ?>

					<?php if ( $services ) : ?>
						<div class="related">
							<h3><?php esc_html_e( 'Services offered here', 'walid' ); ?></h3>
							<div class="tag-row">
								<?php foreach ( $services as $sid ) : ?>
									<a class="tag" href="<?php echo esc_url( get_permalink( $sid ) ); ?>"><?php echo esc_html( get_the_title( $sid ) ); ?></a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<aside class="card">
					<h3><?php esc_html_e( 'Visit us', 'walid' ); ?></h3>
					<dl class="kv">
						<?php if ( $address ) : ?>
							<dt><?php esc_html_e( 'Address', 'walid' ); ?></dt>
							<dd><?php echo nl2br( esc_html( $address ) ); ?></dd>
						<?php else : ?>
							<dt><?php esc_html_e( 'Address', 'walid' ); ?></dt>
							<dd class="muted"><?php esc_html_e( 'To be confirmed.', 'walid' ); ?></dd>
						<?php endif; ?>

						<?php if ( $phone ) : ?>
							<dt><?php esc_html_e( 'Phone', 'walid' ); ?></dt>
							<dd><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></dd>
						<?php endif; ?>

						<?php if ( $hours ) : ?>
							<dt><?php esc_html_e( 'Opening hours', 'walid' ); ?></dt>
							<dd>
								<?php foreach ( $hours as $row ) : ?>
									<div><?php echo esc_html( $row['day'] ); ?>: <?php echo esc_html( $row['time'] ); ?></div>
								<?php endforeach; ?>
							</dd>
						<?php endif; ?>
					</dl>
					<?php if ( $map ) : ?>
						<p style="margin-top:14px;"><a class="btn btn-ghost" href="<?php echo esc_url( $map ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Open in Maps', 'walid' ); ?></a></p>
					<?php endif; ?>
				</aside>
			</div>

		</div>
	</main>
	<?php
endwhile;

get_footer();
