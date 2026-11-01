<?php
/**
 * Branches archive — grouped by region (Central, North, Other), surgical branches badged.
 *
 * @package walid
 */

get_header();

$region_order = array( 'Central (Klang Valley)', 'North (Penang / Kedah)', 'Other' );
?>
<main class="walid-archive" id="primary">
	<div class="container">

		<div class="archive-head">
			<p class="eyebrow"><?php esc_html_e( 'Our network', 'walid' ); ?></p>
			<h1><?php esc_html_e( 'Branches', 'walid' ); ?></h1>
			<p class="lede"><?php esc_html_e( 'Minor surgery is performed at our Central and Northern surgical centres. General practice is available across the full branch network.', 'walid' ); ?></p>
		</div>

		<?php
		$any = false;
		foreach ( $region_order as $region_name ) :
			$branches = walid_branches_in_region( $region_name );
			if ( ! $branches ) {
				continue;
			}
			$any = true;
			// Per-region accent, mirroring the services page soft-tone panels.
			// Central = navy (our surgical HQ region), North = teal, Other = aesthetic mauve.
			$region_accent = 'walid-minor';
			if ( false !== stripos( $region_name, 'North' ) ) {
				$region_accent = 'walid-general';
			} elseif ( false !== stripos( $region_name, 'Other' ) ) {
				$region_accent = 'walid-aesthetic';
			}
			$is_central = ( false !== stripos( $region_name, 'Central' ) );
			?>
			<section class="group pillar-section pillar-tinted <?php echo esc_attr( $region_accent ); ?><?php echo $is_central ? ' is-hero' : ''; ?>">
				<div class="group-head">
					<span class="pin<?php echo $is_central ? ' pin-hero' : ''; ?>"><?php echo esc_html( strtoupper( explode( ' ', $region_name )[0] ) ); ?></span>
					<h2><?php echo esc_html( $region_name ); ?></h2>
				</div>
				<div class="card-grid reveal-group">
					<?php foreach ( $branches as $b ) : ?>
						<?php
						$minor    = (bool) get_field( 'branch_provides_minor_surgery', $b->ID );
						$flagship = (bool) get_field( 'branch_is_flagship', $b->ID );
						$address  = get_field( 'branch_address', $b->ID );
						?>
						<?php
						$bphotos = get_field( 'branch_photos', $b->ID );
						$bthumb  = ( $bphotos && is_array( $bphotos ) ) ? $bphotos[0] : 0;
						?>
						<article class="card has-media">
							<div class="card-media">
								<?php if ( $bthumb ) : ?>
									<?php echo wp_get_attachment_image( is_array( $bthumb ) ? $bthumb['ID'] : $bthumb, 'medium', false, array( 'alt' => esc_attr( get_the_title( $b ) ), 'loading' => 'lazy' ) ); ?>
								<?php else : ?>
									<img src="<?php echo walid_placeholder( 'branch' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="<?php echo esc_attr( get_the_title( $b ) ); ?>" loading="lazy" />
								<?php endif; ?>
							</div>
							<h3>
								<a href="<?php echo esc_url( get_permalink( $b ) ); ?>"><?php echo esc_html( get_the_title( $b ) ); ?></a>
								<?php if ( $minor ) : ?><span class="surgery-badge"><?php esc_html_e( 'Minor surgery', 'walid' ); ?></span><?php endif; ?>
							</h3>
							<?php if ( $flagship ) : ?><div class="meta"><?php esc_html_e( 'Flagship surgical hub (HQ)', 'walid' ); ?></div><?php endif; ?>
							<?php if ( $address ) : ?><p><?php echo esc_html( wp_trim_words( $address, 18 ) ); ?></p><?php endif; ?>
							<div class="card-foot">
								<a class="btn btn-ghost" href="<?php echo esc_url( get_permalink( $b ) ); ?>"><?php esc_html_e( 'Branch details', 'walid' ); ?></a>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endforeach; ?>

		<?php if ( ! $any ) : ?>
			<p class="muted"><?php esc_html_e( 'Branch pages will appear here once branches are added in the CMS.', 'walid' ); ?></p>
		<?php endif; ?>

	</div>
</main>
<?php
get_footer();
