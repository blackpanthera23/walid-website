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

			<?php
			$photos = get_field( 'branch_photos' );
			$hero_photo = ( $photos && is_array( $photos ) ) ? $photos[0] : 0;
			?>
			<div class="branch-photo reveal">
				<?php if ( $hero_photo ) : ?>
					<?php echo wp_get_attachment_image( is_array( $hero_photo ) ? $hero_photo['ID'] : $hero_photo, 'large', false, array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
				<?php else : ?>
					<img src="<?php echo walid_placeholder( 'branch' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
				<?php endif; ?>
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
					<?php
					// Map: if the field holds a full <iframe> embed, render it; if it is a URL,
					// render a Maps search embed + a link. Falls back to a search link for the
					// branch title.
					$map_query = $map ? $map : get_the_title();
					if ( $map && false !== stripos( $map, '<iframe' ) ) :
						// Allow a pasted Google Maps iframe embed.
						echo '<div class="branch-map">' . wp_kses( $map, array( 'iframe' => array( 'src' => array(), 'width' => array(), 'height' => array(), 'style' => array(), 'loading' => array(), 'allowfullscreen' => array(), 'referrerpolicy' => array(), 'title' => array() ) ) ) . '</div>';
					else :
						?>
						<div class="branch-map">
							<iframe
								title="<?php echo esc_attr( sprintf( /* translators: %s: branch name */ __( 'Map of %s', 'walid' ), get_the_title() ) ); ?>"
								width="100%" height="220" style="border:0;" loading="lazy"
								referrerpolicy="no-referrer-when-downgrade"
								src="https://www.google.com/maps?q=<?php echo rawurlencode( wp_strip_all_tags( $map_query ) ); ?>&output=embed"></iframe>
						</div>
						<p style="margin-top:12px;"><a class="btn btn-ghost" href="https://www.google.com/maps/search/?api=1&query=<?php echo rawurlencode( wp_strip_all_tags( $map_query ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Open in Google Maps', 'walid' ); ?></a></p>
					<?php endif; ?>
				</aside>
			</div>

			<?php
			// Google reviews linked to this branch (permission-gated).
			$branch_reviews = get_posts(
				array(
					'post_type'      => 'review',
					'posts_per_page' => 6,
					'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
						'relation' => 'AND',
						array( 'key' => 'review_permission', 'value' => '1' ),
						array( 'key' => 'review_branch', 'value' => '"' . $id . '"', 'compare' => 'LIKE' ),
					),
				)
			);
			// Fall back to any permitted reviews if none are branch-specific.
			if ( ! $branch_reviews ) {
				$branch_reviews = walid_permitted_reviews( 3 );
			}
			if ( $branch_reviews ) :
				?>
				<section class="branch-reviews">
					<div class="group-head">
						<span class="pin"><?php esc_html_e( '4.9 ★', 'walid' ); ?></span>
						<h2><?php esc_html_e( 'What patients say', 'walid' ); ?></h2>
					</div>
					<div class="card-grid reveal-group">
						<?php foreach ( $branch_reviews as $rv ) : ?>
							<article class="card">
								<div class="stars" style="color:var(--gold-500);margin-bottom:8px;"><?php echo esc_html( str_repeat( '★', (int) ( get_field( 'review_rating', $rv->ID ) ?: 5 ) ) ); ?></div>
								<p><?php echo esc_html( get_field( 'review_quote', $rv->ID ) ); ?></p>
								<div class="meta"><?php echo esc_html( get_field( 'review_author', $rv->ID ) ); ?> &middot; <?php echo esc_html( get_field( 'review_source', $rv->ID ) ?: 'Google review' ); ?></div>
							</article>
						<?php endforeach; ?>
					</div>
					<p class="muted" style="font-size:.85rem;margin-top:12px;"><?php esc_html_e( 'Reviews shown with permission. Source: Google.', 'walid' ); ?></p>
				</section>
			<?php endif; ?>

		</div>
	</main>
	<?php
endwhile;

get_footer();
