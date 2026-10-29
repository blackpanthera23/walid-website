<?php
/**
 * Seed SAMPLE content for local preview only.
 *
 * Creates placeholder Branches (the two-hub model), a Service, a Doctor (Dr Anis), and a
 * permitted Review so the homepage + singular templates render fully populated. Everything is
 * tagged with meta `_walid_sample = 1` so it can be removed cleanly.
 *
 * Run:    docker compose run --rm wpcli wp eval-file /scripts/seed-sample-content.php
 * Remove: docker compose run --rm wpcli wp eval-file /scripts/seed-sample-content.php -- --purge
 *
 * NOT for production. Real content is entered by the owner via the CMS. Addresses/hours here are
 * placeholders flagged for confirmation (see docs/08-owner-decisions.md).
 *
 * @package walid
 */

$purge = in_array( '--purge', (array) ( $args ?? array() ), true );

/**
 * Delete everything previously seeded by this script.
 */
$existing = get_posts(
	array(
		'post_type'      => array( 'branch', 'service', 'doctor', 'review' ),
		'posts_per_page' => -1,
		'post_status'    => 'any',
		'meta_key'       => '_walid_sample',
		'meta_value'     => '1',
	)
);
foreach ( $existing as $p ) {
	wp_delete_post( $p->ID, true );
}
if ( $existing ) {
	WP_CLI::log( 'Removed ' . count( $existing ) . ' previously seeded items.' );
}
if ( $purge ) {
	WP_CLI::success( 'Sample content purged.' );
	return;
}

/**
 * Helper: insert a post of a type, mark it as sample, return ID.
 */
$mk = function ( $type, $title, $slug, $content = '' ) {
	$id = wp_insert_post(
		array(
			'post_type'    => $type,
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_content' => $content,
		)
	);
	update_post_meta( $id, '_walid_sample', '1' );
	return $id;
};

// --- Branches (two-hub model) ------------------------------------------------
$region_central = get_term_by( 'name', 'Central (Klang Valley)', 'region' );
$region_north   = get_term_by( 'name', 'North (Penang / Kedah)', 'region' );
$region_other   = get_term_by( 'name', 'Other', 'region' );

$ampang = $mk( 'branch', 'Poliklinik Walid Ampang', 'ampang' );
update_field( 'branch_is_flagship', 1, $ampang );
update_field( 'branch_provides_minor_surgery', 1, $ampang );
update_field( 'branch_address', 'Ground Floor, City Garden Commercial Centre, Taman Nirwana, 68000 Ampang Jaya, Selangor [confirm]', $ampang );
update_field( 'branch_phone', '017-224 8275', $ampang );
update_field( 'branch_hours', array( array( 'day' => 'Mon-Sat', 'time' => '9:00am - 6:00pm [confirm]' ) ), $ampang );
wp_set_object_terms( $ampang, array( $region_central->term_id ), 'region' );

$jalanbaru = $mk( 'branch', 'Poliklinik Walid Jalan Baru', 'jalan-baru' );
update_field( 'branch_provides_minor_surgery', 1, $jalanbaru );
update_field( 'branch_address', 'Seberang Perai, Penang [confirm]', $jalanbaru );
wp_set_object_terms( $jalanbaru, array( $region_north->term_id ), 'region' );

$tasek = $mk( 'branch', 'Poliklinik Walid Tasek Gelugor', 'tasek-gelugor' );
update_field( 'branch_provides_minor_surgery', 1, $tasek );
wp_set_object_terms( $tasek, array( $region_north->term_id ), 'region' );

$sgpetani = $mk( 'branch', 'Poliklinik Walid Sungai Petani', 'sungai-petani' );
update_field( 'branch_provides_minor_surgery', 1, $sgpetani );
wp_set_object_terms( $sgpetani, array( $region_north->term_id ), 'region' );

$gp_branch = $mk( 'branch', 'Poliklinik Walid (GP branch)', 'gp-branch-sample' );
update_field( 'branch_provides_minor_surgery', 0, $gp_branch );
wp_set_object_terms( $gp_branch, array( $region_other->term_id ), 'region' );

// --- Doctors -----------------------------------------------------------------
$dr_walid = $mk( 'doctor', 'Dr Walid Utagha', 'dr-walid' );
update_field( 'doctor_role', 'Minor Surgery Specialist [confirm credential]', $dr_walid );
update_field( 'doctor_qualifications', 'MMC-registered [confirm]', $dr_walid );
update_field( 'doctor_is_leadership', 1, $dr_walid );
update_field( 'doctor_bio', 'Principal doctor at Poliklinik Walid, leading the group\'s surgeon-led day-care minor surgery. [confirm bio]', $dr_walid );
update_field( 'doctor_branches', array( $ampang ), $dr_walid );

$dr_anis = $mk( 'doctor', 'Dr Anis', 'dr-anis' );
update_field( 'doctor_role', 'O&G Doctor [confirm credential]', $dr_anis );
update_field( 'doctor_qualifications', 'MMC-registered [confirm]', $dr_anis );
update_field( 'doctor_bio', 'Leads antenatal and women\'s health, with pregnancy scans from 7 weeks and family planning. [confirm]', $dr_anis );
update_field( 'doctor_branches', array( $ampang ), $dr_anis );

// --- Services ----------------------------------------------------------------
$pillar_minor     = get_term_by( 'name', 'Minor Surgery', 'pillar' );
$pillar_antenatal = get_term_by( 'name', "Antenatal & Women's Health", 'pillar' );

$minor_body = implode(
	"\n\n",
	array(
		'<!-- wp:paragraph --><p>Poliklinik Walid is a specialist minor surgery provider. Our surgeon-led team removes common lumps and skin lesions as day-care procedures, which means you are assessed and treated in a single visit and home the same day. Care is delivered to a hospital-grade standard at clinic speed and price, the smart choice for patients who want their time and money respected. [confirm scope]</p><!-- /wp:paragraph -->',
		'<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Procedures we perform</h2><!-- /wp:heading -->',
		'<!-- wp:list --><ul><li>Lipoma removal (fatty lumps)</li><li>Sebaceous cyst and ganglion cyst removal</li><li>Mole and skin tag removal</li><li>Wart removal</li><li>Keloid treatment</li><li>Abscess drainage</li><li>Removal of excess skin</li><li>Xanthelasma removal</li><li>Circumcision (children aged 2 and above, and adults)</li><li>Selected orthopaedic procedures such as bursitis [confirm per branch]</li></ul><!-- /wp:list -->',
		'<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">How day-care surgery works</h2><!-- /wp:heading -->',
		'<!-- wp:paragraph --><p>A doctor assesses the area first and explains your options clearly before anything is done. Many minor procedures are completed under local anaesthetic within the same appointment, so there is no hospital stay and no long wait.</p><!-- /wp:paragraph -->',
		'<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Where we perform minor surgery</h2><!-- /wp:heading -->',
		'<!-- wp:paragraph --><p>Minor surgery is performed at our surgical centres: Ampang in the Klang Valley (our flagship hub) and our Northern centres in Seberang Perai, Tasek Gelugor and Sungai Petani. General practice is available across the full branch network. Message us to confirm availability at the branch nearest you before you travel.</p><!-- /wp:paragraph -->',
		'<!-- wp:paragraph --><p>Pricing is confirmed after assessment, since it depends on the procedure. [confirm public pricing]</p><!-- /wp:paragraph -->',
	)
);
$minor = $mk( 'service', 'Minor Surgery', 'minor-surgery', $minor_body );
update_field( 'service_pillar_weight', 'hero', $minor );
update_field( 'service_wa_routing', 'minor_surgery', $minor );
update_field( 'service_short_desc', 'Surgeon-led day-care minor surgery at our Central and Northern centres.', $minor );
update_field( 'service_branches', array( $ampang, $jalanbaru, $tasek, $sgpetani ), $minor );
update_field( 'service_lead_doctor', $dr_walid, $minor );
wp_set_object_terms( $minor, array( $pillar_minor->term_id ), 'pillar' );
// Back-link Dr Walid -> Minor Surgery (expertise-first).
update_field( 'doctor_lead_for', array( $minor ), $dr_walid );

$antenatal = $mk( 'service', 'Antenatal Care', 'antenatal', 'Pregnancy scans from 7 weeks onward, with mother-and-child health and family planning. [confirm]' );
update_field( 'service_pillar_weight', 'rising', $antenatal );
update_field( 'service_wa_routing', 'general', $antenatal );
update_field( 'service_short_desc', 'Antenatal care led by a dedicated specialist.', $antenatal );
update_field( 'service_lead_doctor', $dr_anis, $antenatal );
update_field( 'service_branches', array( $ampang ), $antenatal );
wp_set_object_terms( $antenatal, array( $pillar_antenatal->term_id ), 'pillar' );

// Back-link doctor -> service.
update_field( 'doctor_lead_for', array( $antenatal ), $dr_anis );

// --- Reviews (real quotes from the Wix site, translated; permission pending) --
// Sourced from websitewalid.wixsite.com/poliklinikwalid (Malay originals, translated to
// English for the English-first site). Names are public on Wix but still require consent:
// the permission toggle is ON here only so they render in LOCAL preview. Do NOT publish
// until the owner confirms consent and supplies source URLs. [permission pending]
$r1 = $mk( 'review', 'Google review — Nur Namira', 'review-namira' );
update_field( 'review_quote', 'Brought my baby girl in for circumcision. The staff were so friendly and gentle, my daughter was even smiling. The doctor and staff were lovely. First time here and we will come again. [permission pending]', $r1 );
update_field( 'review_author', 'Nur Namira Mohamad Rosli', $r1 );
update_field( 'review_rating', 5, $r1 );
update_field( 'review_source', 'Google review', $r1 );
update_field( 'review_permission', 1, $r1 );
update_field( 'review_branch', $ampang, $r1 );

$r2 = $mk( 'review', 'Google review — Sara', 'review-sara' );
update_field( 'review_quote', 'My usual clinic near home was closed, so I came to Poliklinik Walid. The service and treatment were good and courteous. Thank you for the care. [permission pending]', $r2 );
update_field( 'review_author', 'Sara Sofea', $r2 );
update_field( 'review_rating', 5, $r2 );
update_field( 'review_source', 'Google review', $r2 );
update_field( 'review_permission', 1, $r2 );
update_field( 'review_branch', $ampang, $r2 );

$r3 = $mk( 'review', 'Google review — sample', 'review-sample-3' );
update_field( 'review_quote', 'Clean clinic, friendly nurses and a caring doctor. [sample placeholder]', $r3 );
update_field( 'review_author', 'A. Patient [sample]', $r3 );
update_field( 'review_rating', 5, $r3 );
update_field( 'review_source', 'Google review', $r3 );
update_field( 'review_permission', 1, $r3 );
update_field( 'review_branch', $ampang, $r3 );

WP_CLI::success( 'Seeded sample content: 5 branches, 1 doctor, 2 services, 3 reviews. Run with --purge to remove.' );
