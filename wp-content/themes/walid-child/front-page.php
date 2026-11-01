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
		<div class="hero-motion" aria-hidden="true">
			<span class="hero-shape hs1"></span>
			<span class="hero-shape hs2"></span>
			<span class="hero-shape hs3"></span>
		</div>
		<div class="container hero-grid">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Walid Healthcare Group', 'walid' ); ?></p>
				<h1><?php esc_html_e( 'Hospital-grade minor surgery, done in a day.', 'walid' ); ?></h1>
				<p class="lead"><?php esc_html_e( 'Surgeon-led day-care care across our Central and Northern centres. The smart choice hundreds of thousands already trust.', 'walid' ); ?></p>
				<div class="hero-cta">
					<a class="btn btn-wa" href="<?php echo $wa_general; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp us', 'walid' ); ?></a>
					<a class="btn btn-ghost" href="#services"><?php esc_html_e( 'Explore services', 'walid' ); ?></a>
				</div>
				<?php $stats = walid_stats(); ?>
				<div class="proof-rail">
					<div class="stat"><b><?php echo esc_html( $stats['tiktok'] ); ?></b> <?php esc_html_e( 'on TikTok', 'walid' ); ?></div>
					<div class="stat"><b><?php echo esc_html( $stats['facebook'] ); ?></b> <?php esc_html_e( 'on Facebook', 'walid' ); ?></div>
					<div class="stat"><b><?php echo esc_html( $stats['rating'] ); ?>&#9733;</b> <?php echo esc_html( sprintf( /* translators: %s: review count */ __( 'from %s Google reviews', 'walid' ), $stats['reviews'] ) ); ?></div>
				</div>
			</div>
			<div class="hero-art reveal" aria-hidden="true">
				<div class="hero-panel">
					<?php $hero_video = walid_hero_video(); ?>
					<?php if ( $hero_video ) : ?>
						<video class="hero-video" poster="<?php echo $hero_video['poster']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" autoplay muted loop playsinline preload="metadata">
							<?php if ( $hero_video['webm'] ) : ?>
								<source src="<?php echo $hero_video['webm']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" type="video/webm" />
							<?php endif; ?>
							<source src="<?php echo $hero_video['mp4']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" type="video/mp4" />
						</video>
						<img class="hero-photo hero-video-fallback" src="<?php echo $hero_video['poster']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" alt="" loading="eager" />
					<?php else : ?>
						<img class="hero-photo" src="<?php echo walid_placeholder( 'hero' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" alt="" loading="eager" />
					<?php endif; ?>
				</div>
				<span class="float-dot dot-gold"></span>
				<span class="float-dot dot-navy"></span>
				<span class="float-dot dot-gold-sm"></span>
				<span class="float-dot dot-navy-sm"></span>
			</div>
		</div>
	</section>

	<!-- 2. VALUE STRIP -->
	<section class="section-alt" id="services">
		<div class="container">
			<div class="value-grid reveal-group">
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
				<?php
				// Link tags to the Minor Surgery service page if it exists, else to WhatsApp.
				$minor_service = get_posts(
					array(
						'post_type'      => 'service',
						'posts_per_page' => 1,
						'name'           => 'minor-surgery',
					)
				);
				$minor_url = $minor_service ? get_permalink( $minor_service[0] ) : $wa_surgery;
				$tags      = array(
					__( 'Lipoma', 'walid' ),
					__( 'Cysts', 'walid' ),
					__( 'Moles & skin tags', 'walid' ),
					__( 'Warts', 'walid' ),
					__( 'Circumcision', 'walid' ),
				);
				?>
				<div class="tag-row">
					<?php foreach ( $tags as $t ) : ?>
						<a class="tag" href="<?php echo esc_url( $minor_url ); ?>"><?php echo esc_html( $t ); ?></a>
					<?php endforeach; ?>
				</div>
				<a class="btn btn-primary" href="<?php echo $wa_surgery; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="_blank" rel="noopener"><?php esc_html_e( 'WhatsApp the minor surgery team', 'walid' ); ?></a>
			</div>
			<div class="art reveal"><img src="<?php echo walid_placeholder( 'procedure' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="<?php esc_attr_e( 'Minor surgery procedure imagery', 'walid' ); ?>" loading="lazy" /></div>
		</div>
	</section>

	<!-- 4. RISING PILLARS -->
	<section class="section-alt">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Also expert in', 'walid' ); ?></p>
			<h2 style="margin-bottom:28px;"><?php esc_html_e( 'A growing range of specialist care.', 'walid' ); ?></h2>
			<div class="rising-grid reveal-group">
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
	<section id="specialist" class="walid-antenatal">
		<div class="container spec">
			<div class="photo reveal">
				<?php if ( $spec_photo ) : ?>
					<?php echo wp_get_attachment_image( $spec_photo, 'large', false, array( 'alt' => esc_attr( $spec_name ) ) ); ?>
				<?php else : ?>
					<img src="<?php echo walid_placeholder( 'doctor' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="<?php echo esc_attr( $spec_name ); ?>" loading="lazy" />
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
			<p style="max-width:52ch;margin-bottom:28px;"><?php echo esc_html( sprintf( /* translators: 1: tiktok count, 2: facebook count */ __( 'Real procedures and patient stories from the clinic. The content that earned our community of %1$s on TikTok and %2$s on Facebook.', 'walid' ), $stats['tiktok'], $stats['facebook'] ) ); ?></p>
			<div class="tiktok-grid reveal-group">
				<?php foreach ( walid_proof_videos() as $v ) : ?>
					<a class="tiktok-card" href="<?php echo esc_url( $v['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $v['label'] ); ?>">
						<div class="play">&#9654;</div>
						<span class="lbl"><?php echo esc_html( $v['label'] ); ?> &middot; <?php echo esc_html( ucfirst( $v['platform'] ) ); ?></span>
					</a>
				<?php endforeach; ?>
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
			<div class="branch-grid reveal-group">
				<div class="branch-col">
					<h3><span class="pin"><?php esc_html_e( 'CENTRAL', 'walid' ); ?></span> <?php esc_html_e( 'Klang Valley', 'walid' ); ?></h3>
					<ul>
						<?php if ( $central ) : ?>
							<?php foreach ( $central as $b ) : ?>
								<li><a href="<?php echo esc_url( get_permalink( $b ) ); ?>"><b><?php echo esc_html( get_the_title( $b ) ); ?></b></a><?php echo get_field( 'branch_is_flagship', $b->ID ) ? ', ' . esc_html__( 'flagship surgical hub (HQ)', 'walid' ) : ''; ?></li>
							<?php endforeach; ?>
						<?php else : ?>
							<li><b><?php esc_html_e( 'Ampang', 'walid' ); ?></b>, <?php esc_html_e( 'flagship surgical hub (HQ)', 'walid' ); ?></li>
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
							<li><b><?php esc_html_e( 'Jalan Baru', 'walid' ); ?></b>, <?php esc_html_e( 'Seberang Perai, Penang', 'walid' ); ?></li>
							<li><b><?php esc_html_e( 'Tasek Gelugor', 'walid' ); ?></b></li>
							<li><b><?php esc_html_e( 'Sungai Petani', 'walid' ); ?></b></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- 8. REVIEWS -->
	<?php
	$reviews = walid_permitted_reviews( 8 );
	// Fallback sample quotes (shown only until permitted reviews exist). Marked as pending.
	$rev_fallback = array(
		array( 'q' => 'Amazing service with friendly doctors and staff. Highly professional and recommended.', 'w' => 'Google review [permission pending]' ),
		array( 'q' => 'The doctor is so nice and gives good advice. I feel comfortable and safe.', 'w' => 'Google review [permission pending]' ),
		array( 'q' => 'Clean clinic, friendly nurses, caring doctor. Will come again.', 'w' => 'Google review [permission pending]' ),
		array( 'q' => 'Quick day-care procedure and clear explanation. Home the same afternoon.', 'w' => 'Google review [permission pending]' ),
		array( 'q' => 'Booked over WhatsApp and seen fast. Calm and reassuring throughout.', 'w' => 'Google review [permission pending]' ),
	);
	?>
	<section class="proof-motion">
		<div class="container">
			<div class="rev-head">
				<p class="eyebrow"><?php esc_html_e( 'The proof, not the promise', 'walid' ); ?></p>
				<h2><?php esc_html_e( 'Trusted by hundreds of thousands.', 'walid' ); ?></h2>
			</div>
			<div class="statrow reveal-group" id="walid-statrow">
				<div class="statcard" data-target="561" data-suffix="K"><b>0</b><span><?php esc_html_e( 'TikTok followers', 'walid' ); ?></span><i class="bar"></i></div>
				<div class="statcard" data-target="119" data-suffix="K"><b>0</b><span><?php esc_html_e( 'Facebook followers', 'walid' ); ?></span><i class="bar"></i></div>
				<div class="statcard" data-target="<?php echo esc_attr( $stats['rating'] ); ?>" data-suffix="&#9733;"><b>0</b><span><?php esc_html_e( 'Google rating', 'walid' ); ?></span><i class="bar"></i></div>
				<div class="statcard" data-target="<?php echo esc_attr( preg_replace( '/[^0-9.]/', '', (string) $stats['reviews'] ) ); ?>" data-suffix=""><b>0</b><span><?php esc_html_e( 'Google reviews', 'walid' ); ?></span><i class="bar"></i></div>
			</div>
			<div class="rev-marquee" aria-label="<?php esc_attr_e( 'Patient reviews', 'walid' ); ?>">
				<div class="rev-track">
					<?php
					// Duplicate the set so the marquee loop is seamless.
					for ( $pass = 0; $pass < 2; $pass++ ) :
						if ( $reviews ) :
							foreach ( $reviews as $r ) :
								$stars  = (int) ( get_field( 'review_rating', $r->ID ) ?: 5 );
								$quote  = get_field( 'review_quote', $r->ID );
								$author = get_field( 'review_author', $r->ID );
								$source = get_field( 'review_source', $r->ID ) ?: __( 'Google review', 'walid' );
								?>
								<div class="rev-card">
									<div class="stars"><?php echo esc_html( str_repeat( '★', $stars ) ); ?></div>
									<p><?php echo esc_html( $quote ); ?></p>
									<div class="who"><?php echo esc_html( $author ); ?> &middot; <?php echo esc_html( $source ); ?></div>
								</div>
								<?php
							endforeach;
						else :
							foreach ( $rev_fallback as $r ) :
								?>
								<div class="rev-card">
									<div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
									<p><?php echo esc_html( $r['q'] ); ?></p>
									<div class="who"><?php echo esc_html( $r['w'] ); ?></div>
								</div>
								<?php
							endforeach;
						endif;
					endfor;
					?>
				</div>
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
