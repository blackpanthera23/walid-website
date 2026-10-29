<?php
/**
 * Template Name: Contact
 *
 * WhatsApp-only contact (no forms/booking). Presents both lines clearly and helps choose a branch.
 *
 * @package walid
 */

get_header();
the_post();

$wa_general = walid_whatsapp_url( 'general', __( 'Hi Poliklinik Walid, I have a general enquiry.', 'walid' ) );
$wa_surgery = walid_whatsapp_url( 'minor_surgery', __( 'Hi, I would like to ask about minor surgery.', 'walid' ) );
?>
<main class="walid-archive" id="primary">
	<div class="container">

		<div class="archive-head">
			<p class="eyebrow"><?php esc_html_e( 'Contact', 'walid' ); ?></p>
			<h1><?php esc_html_e( 'Ready when you are.', 'walid' ); ?></h1>
			<p class="lede"><?php esc_html_e( 'Message us on WhatsApp and our team will help you choose a branch and a time. We do not take bookings through a form.', 'walid' ); ?></p>
		</div>

		<section class="group">
			<div class="card-grid two">
				<article class="card">
					<h3><?php esc_html_e( 'General enquiries', 'walid' ); ?></h3>
					<p><?php esc_html_e( 'Appointments, general practice, women\'s health and aesthetics.', 'walid' ); ?></p>
					<div class="meta">014-252 1684</div>
					<div class="card-foot"><a class="btn btn-wa" href="<?php echo $wa_general; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp general', 'walid' ); ?></a></div>
				</article>
				<article class="card">
					<h3><?php esc_html_e( 'Minor surgery', 'walid' ); ?></h3>
					<p><?php esc_html_e( 'Lipoma, cysts, moles, skin tags and more at our Central and Northern surgical centres.', 'walid' ); ?></p>
					<div class="meta">017-549 7593</div>
					<div class="card-foot"><a class="btn btn-wa" href="<?php echo $wa_surgery; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp minor surgery', 'walid' ); ?></a></div>
				</article>
			</div>
		</section>

		<section class="group">
			<div class="group-head"><h2><?php esc_html_e( 'Find a branch', 'walid' ); ?></h2></div>
			<p class="muted" style="margin-bottom:16px;"><?php esc_html_e( 'See all locations and the services offered at each.', 'walid' ); ?></p>
			<a class="btn btn-ghost" href="<?php echo esc_url( get_post_type_archive_link( 'branch' ) ); ?>"><?php esc_html_e( 'Browse branches', 'walid' ); ?></a>
		</section>

		<?php if ( trim( get_the_content() ) ) : ?>
			<div class="entry"><?php the_content(); ?></div>
		<?php endif; ?>

	</div>
</main>
<?php
get_footer();
