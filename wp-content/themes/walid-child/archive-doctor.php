<?php
/**
 * Doctors archive — "our team" index. Expertise-first: role under each name.
 *
 * @package walid
 */

get_header();

$doctors = get_posts(
	array(
		'post_type'      => 'doctor',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	)
);
?>
<main class="walid-archive" id="primary">
	<div class="container">

		<div class="archive-head">
			<p class="eyebrow"><?php esc_html_e( 'Our team', 'walid' ); ?></p>
			<h1><?php esc_html_e( 'Our doctors', 'walid' ); ?></h1>
			<p class="lede"><?php esc_html_e( 'MMC-registered doctors across our network, including the specialists who lead our focused areas of care.', 'walid' ); ?></p>
		</div>

		<?php if ( $doctors ) : ?>
			<div class="card-grid">
				<?php foreach ( $doctors as $d ) : ?>
					<?php
					$role  = get_field( 'doctor_role', $d->ID );
					$photo = get_field( 'doctor_photo', $d->ID );
					?>
					<article class="card doctor-card">
						<div class="avatar">
							<?php if ( $photo ) : ?>
								<?php echo wp_get_attachment_image( $photo, 'thumbnail', false, array( 'alt' => esc_attr( get_the_title( $d ) ) ) ); ?>
							<?php else : ?>
								<span><?php esc_html_e( 'Photo', 'walid' ); ?></span>
							<?php endif; ?>
						</div>
						<h3><a href="<?php echo esc_url( get_permalink( $d ) ); ?>"><?php echo esc_html( get_the_title( $d ) ); ?></a></h3>
						<?php if ( $role ) : ?><div class="role"><?php echo esc_html( $role ); ?></div><?php endif; ?>
						<div class="card-foot" style="margin-top:14px;">
							<a class="btn btn-ghost" href="<?php echo esc_url( get_permalink( $d ) ); ?>"><?php esc_html_e( 'View profile', 'walid' ); ?></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="muted"><?php esc_html_e( 'Doctor profiles will appear here once added in the CMS.', 'walid' ); ?></p>
		<?php endif; ?>

	</div>
</main>
<?php
get_footer();
