<?php
/**
 * Front page — Poliklinik Walid homepage.
 *
 * Rebuilt from /prototype/index.html (see docs/12-homepage-wireframe.md). Sections pull from the
 * CPTs where content exists and fall back to approved draft copy otherwise, so the page looks
 * right before real content is loaded. Minor surgery stays the visual hero.
 *
 * @package walid
 */

get_header();

$wa_general = walid_whatsapp_url( 'general', __( 'Hi Poliklinik Walid, I have a question.', 'walid' ) );
$wa_surgery = walid_whatsapp_url( 'minor_surgery', __( 'Hi, I would like to ask about minor surgery.', 'walid' ) );
?>

<main class="walid-home" id="primary">

	<!-- 1. HERO -->
	<section class="hero">
		<div class="container hero-grid">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Walid Healthcare Group', 'walid' ); ?></p>
				<h1><?php esc_html_e( 'Hospital-grade minor surgery, done in a day.', 'walid' ); ?></h1>
				<p class="lead"><?php esc_html_e( 'Surgeon-led day-care care across our Central and Northern centres. The smart choice hundreds of thousands already trust.', 'walid' ); ?></p>
				<div class="hero-cta">
					<a class="btn btn-wa" href="<?php echo $wa_general; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp us', 'walid' ); ?></a>
					<a class="btn btn-ghost" href="#services"><?php esc_html_e( 'Explore services', 'walid' ); ?></a>
				</div>
				<div class="proof-rail">
					<div class="stat"><b>561K</b> <?php esc_html_e( 'on TikTok', 'walid' ); ?></div>
					<div class="stat"><b>119K</b> <?php esc_html_e( 'on Facebook', 'walid' ); ?></div>
					<div class="stat"><b>4.9&#9733;</b> <?php esc_html_e( 'from 1,098 Google reviews', 'walid' ); ?></div>
				</div>
			</div>
			<div class="hero-art" aria-hidden="true">
				<img class="emblem-img" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/logo.svg' ); ?>" alt="" width="150" height="150" />
				<div class="cap"><?php esc_html_e( 'Real clinic photography to be supplied by the client.', 'walid' ); ?></div>
			</div>
		</div>
	</section>

	<!-- 2. VALUE STRIP -->
	<section class="section-alt" id="services">
		<div class="container">
			<div class="value-grid">
				<div class="value-card">
					<div class="ico">&#9201;</div>
					<h3><?php esc_html_e( 'Day-care surgery', 'walid' ); ?></h3>
					<p><?php esc_html_e( 'Assessed and treated, home the same day.', 'walid' ); ?></p>
				</div>
				<div class="value-card">
					<div class="ico">&#10010;</div>
					<h3><?php esc_html_e( 'Hospital-grade care', 'walid' ); ?></h3>
					<p><?php esc_html_e( 'Surgeon-led, MMC-registered doctors.', 'walid' ); ?></p>
				</div>
				<div class="value-card">
					<div class="ico">&#9733;</div>
					<h3><?php esc_html_e( 'The smart choice', 'walid' ); ?></h3>
					<p><?php esc_html_e( 'Care that respects your time and money.', 'walid' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- 3. HERO PILLAR: MINOR SURGERY -->
	<section>
		<div class="container pillar-hero">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Our specialty', 'walid' ); ?></p>
				<h2><?php esc_html_e( 'Minor surgery, done the smart-value way.', 'walid' ); ?></h2>
				<p><?php esc_html_e( 'Lipoma, cysts, moles, skin tags, warts and more, assessed and treated in a day. Performed at our Central centre in Ampang and our Northern centres in Seberang Perai, Tasek Gelugor and Sungai Petani.', 'walid' ); ?></p>
				<div class="tag-row">
					<span class="tag"><?php esc_html_e( 'Lipoma', 'walid' ); ?></span>
					<span class="tag"><?php esc_html_e( 'Cysts', 'walid' ); ?></span>
					<span class="tag"><?php esc_html_e( 'Moles & skin tags', 'walid' ); ?></span>
					<span class="tag"><?php esc_html_e( 'Warts', 'walid' ); ?></span>
					<span class="tag"><?php esc_html_e( 'Circumcision', 'walid' ); ?></span>
				</div>
				<a class="btn btn-primary" href="<?php echo $wa_surgery; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp the minor surgery team', 'walid' ); ?></a>
			</div>
			<div class="art"><?php esc_html_e( 'Procedure imagery (consented)', 'walid' ); ?></div>
		</div>
	</section>

	<!-- 4. RISING PILLARS -->
	<section class="section-alt">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Also expert in', 'walid' ); ?></p>
			<h2 style="margin-bottom:28px;"><?php esc_html_e( 'A growing range of specialist care.', 'walid' ); ?></h2>
			<div class="rising-grid">
				<div class="rise-card">
					<div class="ico">&#10024;</div>
					<h3><?php esc_html_e( 'Aesthetic procedures', 'walid' ); ?></h3>
					<p class="muted"><?php esc_html_e( 'Refined, doctor-led aesthetic treatments. Full scope to be confirmed.', 'walid' ); ?></p>
				</div>
				<div class="rise-card">
					<div class="ico">&#127925;</div>
					<h3><?php esc_html_e( "Antenatal & women's health", 'walid' ); ?></h3>
					<p class="muted"><?php esc_html_e( 'Pregnancy scans from 7 weeks, led by a dedicated specialist.', 'walid' ); ?></p>
				</div>
				<div class="rise-card tbd">
					<div class="ico">&#43;</div>
					<h3><?php esc_html_e( 'Fourth pillar', 'walid' ); ?></h3>
					<p class="muted"><?php esc_html_e( 'Reserved. To be confirmed by the clinic.', 'walid' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- 5. SPECIALIST SPOTLIGHT -->
	<?php
	// Dynamic: lead doctor of the Antenatal service, if set. Else draft copy.
	$spec_doctor = null;
	$antenatal   = get_posts(
		array(
			'post_type'      => 'service',
			'posts_per_page' => 1,
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'pillar',
					'field'    => 'name',
					'terms'    => "Antenatal & Women's Health",
				),
			),
		)
	);
	if ( $antenatal ) {
		$lead_id = get_field( 'service_lead_doctor', $antenatal[0]->ID );
		if ( $lead_id ) {
			$spec_doctor = get_post( $lead_id );
		}
	}
	$spec_name   = $spec_doctor ? get_the_title( $spec_doctor ) : __( 'Dr Anis', 'walid' );
	$spec_role   = $spec_doctor ? get_field( 'doctor_role', $spec_doctor->ID ) : '';
	$spec_role   = $spec_role ? $spec_role : __( 'O&G specialist [confirm credential]', 'walid' );
	$spec_photo  = $spec_doctor ? get_field( 'doctor_photo', $spec_doctor->ID ) : 0;
	?>
	<section id="specialist">
		<div class="container spec">
			<div class="photo">
				<?php if ( $spec_photo ) : ?>
					<?php echo wp_get_attachment_image( $spec_photo, 'large', false, array( 'alt' => esc_attr( $spec_name ) ) ); ?>
				<?php else : ?>
					<?php esc_html_e( 'Specialist photo (consented)', 'walid' ); ?>
				<?php endif; ?>
			</div>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Specialist care', 'walid' ); ?></p>
				<h2><?php esc_html_e( 'Antenatal care, led by a dedicated specialist.', 'walid' ); ?></h2>
				<p class="gold-line"><?php echo esc_html( sprintf( /* translators: 1: doctor name, 2: role */ __( 'Led by %1$s, %2$s', 'walid' ), $spec_name, $spec_role ) ); ?></p>
				<p><?php esc_html_e( 'Pregnancy scans from 7 weeks onward, with mother-and-child health and family planning. Care delivered with the same standard across every visit.', 'walid' ); ?></p>
				<a class="btn btn-primary" href="<?php echo $wa_general; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp about antenatal', 'walid' ); ?></a>
			</div>
		</div>
	</section>

	<!-- 6. PROOF / SOCIAL WALL -->
	<section class="section-navy">
		<div class="container">
			<p class="eyebrow" style="color:var(--gold-500)"><?php esc_html_e( 'Seen on TikTok', 'walid' ); ?></p>
			<h2><?php esc_html_e( 'The care hundreds of thousands follow.', 'walid' ); ?></h2>
			<p style="max-width:52ch;margin-bottom:28px;"><?php esc_html_e( 'Real procedures and patient stories from the clinic. The content that earned our community of 561K on TikTok and 119K on Facebook.', 'walid' ); ?></p>
			<div class="tiktok-grid">
				<div class="tiktok-card"><div class="play">&#9654;</div><span class="lbl"><?php esc_html_e( 'Procedure clip (embed)', 'walid' ); ?></span></div>
				<div class="tiktok-card"><div class="play">&#9654;</div><span class="lbl"><?php esc_html_e( 'Patient story (embed)', 'walid' ); ?></span></div>
				<div class="tiktok-card"><div class="play">&#9654;</div><span class="lbl"><?php esc_html_e( 'Day-care explainer (embed)', 'walid' ); ?></span></div>
			</div>
		</div>
	</section>

	<!-- 7. BRANCH NETWORK -->
	<?php
	$central = walid_branches_in_region( 'Central (Klang Valley)' );
	$north   = walid_branches_in_region( 'North (Penang / Kedah)' );
	?>
	<section class="section-alt" id="branches">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Our network', 'walid' ); ?></p>
			<h2 style="margin-bottom:8px;"><?php esc_html_e( 'Surgical centres Central and North, general practice everywhere.', 'walid' ); ?></h2>
			<p class="muted" style="margin-bottom:28px;"><?php esc_html_e( 'Minor surgery is performed at our surgical centres. General practice is available across the full branch network.', 'walid' ); ?></p>
			<div class="branch-grid">
				<div class="branch-col">
					<h3><span class="pin"><?php esc_html_e( 'CENTRAL', 'walid' ); ?></span> <?php esc_html_e( 'Klang Valley', 'walid' ); ?></h3>
					<ul>
						<?php if ( $central ) : ?>
							<?php foreach ( $central as $b ) : ?>
								<li><a href="<?php echo esc_url( get_permalink( $b ) ); ?>"><b><?php echo esc_html( get_the_title( $b ) ); ?></b></a><?php echo get_field( 'branch_is_flagship', $b->ID ) ? ' &mdash; ' . esc_html__( 'flagship surgical hub (HQ)', 'walid' ) : ''; ?></li>
							<?php endforeach; ?>
						<?php else : ?>
							<li><b><?php esc_html_e( 'Ampang', 'walid' ); ?></b> &mdash; <?php esc_html_e( 'flagship surgical hub (HQ)', 'walid' ); ?></li>
						<?php endif; ?>
					</ul>
				</div>
				<div class="branch-col">
					<h3><span class="pin"><?php esc_html_e( 'NORTH', 'walid' ); ?></span> <?php esc_html_e( 'Penang & Kedah', 'walid' ); ?></h3>
					<ul>
						<?php if ( $north ) : ?>
							<?php foreach ( $north as $b ) : ?>
								<li><a href="<?php echo esc_url( get_permalink( $b ) ); ?>"><b><?php echo esc_html( get_the_title( $b ) ); ?></b></a></li>
							<?php endforeach; ?>
						<?php else : ?>
							<li><b><?php esc_html_e( 'Jalan Baru', 'walid' ); ?></b> &mdash; <?php esc_html_e( 'Seberang Perai, Penang', 'walid' ); ?></li>
							<li><b><?php esc_html_e( 'Tasek Gelugor', 'walid' ); ?></b></li>
							<li><b><?php esc_html_e( 'Sungai Petani', 'walid' ); ?></b></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- 8. REVIEWS -->
	<?php $reviews = walid_permitted_reviews( 3 ); ?>
	<section>
		<div class="container">
			<div class="rev-head">
				<div class="rev-stat">4.9 &#9733;</div>
				<p class="muted"><?php esc_html_e( 'from 1,098 Google reviews', 'walid' ); ?></p>
			</div>
			<div class="rev-grid">
				<?php if ( $reviews ) : ?>
					<?php foreach ( $reviews as $r ) : ?>
						<div class="rev-card">
							<div class="stars"><?php echo esc_html( str_repeat( '★', (int) ( get_field( 'review_rating', $r->ID ) ?: 5 ) ) ); ?></div>
							<p><?php echo esc_html( get_field( 'review_quote', $r->ID ) ); ?></p>
							<div class="who"><?php echo esc_html( get_field( 'review_author', $r->ID ) ); ?> &middot; <?php echo esc_html( get_field( 'review_source', $r->ID ) ?: 'Google review' ); ?></div>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<div class="rev-card"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p><?php esc_html_e( '"Amazing service with friendly doctors and staff. Highly professional and recommended."', 'walid' ); ?></p><div class="who"><?php esc_html_e( 'Google review [permission pending]', 'walid' ); ?></div></div>
					<div class="rev-card"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p><?php esc_html_e( '"The doctor is so nice and gives good advice. I feel comfortable and safe."', 'walid' ); ?></p><div class="who"><?php esc_html_e( 'Google review [permission pending]', 'walid' ); ?></div></div>
					<div class="rev-card"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p><?php esc_html_e( '"Clean clinic, friendly nurses, caring doctor. Will come again."', 'walid' ); ?></p><div class="who"><?php esc_html_e( 'Google review [permission pending]', 'walid' ); ?></div></div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- 9. INTERNATIONAL -->
	<section class="section-alt intl" id="intl">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'International patients', 'walid' ); ?></p>
			<h2><?php esc_html_e( 'Trusted across the region.', 'walid' ); ?></h2>
			<div class="flags">&#127480;&#127465; &#127480;&#127468; &#127470;&#127465; &#127463;&#127475;</div>
			<p class="muted" style="max-width:48ch;margin:0 auto;"><?php esc_html_e( 'Patients travel from Sudan, Singapore, Indonesia and Brunei for care with us. Message the clinic to plan your visit.', 'walid' ); ?></p>
		</div>
	</section>

	<!-- 10. FINAL CTA -->
	<section class="final" id="contact">
		<div class="container">
			<h2><?php esc_html_e( 'Ready when you are.', 'walid' ); ?></h2>
			<p class="muted"><?php esc_html_e( 'Message us on WhatsApp and the clinic team will help you choose a branch and a time.', 'walid' ); ?></p>
			<a class="btn btn-wa" href="<?php echo $wa_general; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp us', 'walid' ); ?></a>
		</div>
	</section>

</main>

<?php
get_footer();
