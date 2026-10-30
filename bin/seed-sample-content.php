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

$jalanbaru = $mk( 'branch', 'Poliklinik Walid Jalan Baru', 'jalan-baru', '<!-- wp:paragraph --><p>Our Jalan Baru branch in Seberang Perai is one of our Northern surgical centres, offering day-care minor surgery alongside general practice. [confirm details]</p><!-- /wp:paragraph -->' );
update_field( 'branch_provides_minor_surgery', 1, $jalanbaru );
update_field( 'branch_address', 'Jalan Baru, Seberang Perai, Penang [confirm full address]', $jalanbaru );
update_field( 'branch_phone', '017-549 7593', $jalanbaru );
update_field( 'branch_hours', array( array( 'day' => 'Mon-Sat', 'time' => '9:00am - 6:00pm [confirm]' ) ), $jalanbaru );
// Map field left as a plain query so the template renders a Google Maps embed from it.
update_field( 'branch_map_embed', 'Poliklinik Walid Jalan Baru, Seberang Perai, Penang', $jalanbaru );
wp_set_object_terms( $jalanbaru, array( $region_north->term_id ), 'region' );

$tasek = $mk( 'branch', 'Poliklinik Walid Tasek Gelugor', 'tasek-gelugor' );
update_field( 'branch_provides_minor_surgery', 1, $tasek );
wp_set_object_terms( $tasek, array( $region_north->term_id ), 'region' );

$sgpetani = $mk( 'branch', 'Poliklinik Walid Sungai Petani', 'sungai-petani' );
update_field( 'branch_provides_minor_surgery', 1, $sgpetani );
wp_set_object_terms( $sgpetani, array( $region_north->term_id ), 'region' );

$kuala_kangsar = $mk( 'branch', 'Poliklinik Walid Kuala Kangsar', 'kuala-kangsar', '<!-- wp:paragraph --><p>General practice branch in Kuala Kangsar, Perak. [confirm details]</p><!-- /wp:paragraph -->' );
update_field( 'branch_provides_minor_surgery', 0, $kuala_kangsar );
update_field( 'branch_address', 'Kuala Kangsar, Perak [confirm full address]', $kuala_kangsar );
update_field( 'branch_map_embed', 'Poliklinik Walid Kuala Kangsar, Perak', $kuala_kangsar );
wp_set_object_terms( $kuala_kangsar, array( $region_other->term_id ), 'region' );

$parit_buntar = $mk( 'branch', 'Poliklinik Walid Parit Buntar', 'parit-buntar', '<!-- wp:paragraph --><p>General practice branch in Parit Buntar, Perak. [confirm details]</p><!-- /wp:paragraph -->' );
update_field( 'branch_provides_minor_surgery', 0, $parit_buntar );
update_field( 'branch_address', 'Parit Buntar, Perak [confirm full address]', $parit_buntar );
update_field( 'branch_map_embed', 'Poliklinik Walid Parit Buntar, Perak', $parit_buntar );
wp_set_object_terms( $parit_buntar, array( $region_other->term_id ), 'region' );

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
// Minor surgery procedure list (translated from the owner list).
update_field(
	'service_procedures',
	implode(
		"\n",
		array(
			'Lipoma | A soft fatty lump under the skin, assessed and removed.',
			'Sebaceous cyst | A fluid-filled lump under the skin.',
			'Ganglion cyst | A fluid-filled lump, often near a joint or tendon.',
			'Skin tag | A small, soft skin growth.',
			'Giant skin tag | A larger skin tag needing removal.',
			'Mole | A pigmented growth checked before removal.',
			'Wart | A viral skin growth.',
			'Genital warts | Viral warts needing discreet, careful care.',
			'Eye warts | Warts near the eye, removed with precision.',
			'Keloid (surgical removal) | An overgrown scar, excised rather than injected.',
			'Xanthelasma | Yellow cholesterol deposits on the eyelid.',
			'Keratosis | A rough, scaly skin patch.',
			'Milia | Tiny white keratin cysts.',
			'Syringoma | Small benign sweat-gland growths.',
			'Granuloma | A small inflammatory nodule.',
			'Eyebag | Surgical reduction of under-eye bags.',
			'Gynaecomastia | Enlarged male breast tissue, assessed and treated.',
			'Accessory breast | Extra breast tissue, usually in the armpit.',
			'Circumcision | For children aged 2 and above, and adults.',
			'Extra finger (polydactyly) | Removal of an additional digit.',
			'Carbuncle | A cluster of infected hair follicles, drained.',
			'Abscess | A collection of pus, drained under local anaesthetic.',
			'Infected hidradenitis suppurativa (HS) | Recurrent skin abscesses, managed and drained.',
			'Tongue tie | A tight band under the tongue, released.',
			'Ingrown toenail | A nail growing into the skin, treated.',
			'Neurofibromatosis | Removal of benign nerve-tissue lumps.',
			'Gout | Assessment and management of gout-related lumps.',
		)
	),
	$minor
);
wp_set_object_terms( $minor, array( $pillar_minor->term_id ), 'pillar' );
// Back-link Dr Walid -> Minor Surgery (expertise-first).
update_field( 'doctor_lead_for', array( $minor ), $dr_walid );

$antenatal = $mk( 'service', 'Antenatal Care', 'antenatal', 'Pregnancy scans from 7 weeks onward, with mother-and-child health and family planning. [confirm]' );
update_field( 'service_pillar_weight', 'rising', $antenatal );
update_field( 'service_wa_routing', 'general', $antenatal );
update_field( 'service_short_desc', 'Antenatal care led by a dedicated specialist.', $antenatal );
update_field( 'service_lead_doctor', $dr_anis, $antenatal );
update_field( 'service_branches', array( $ampang ), $antenatal );
update_field(
	'service_procedures',
	implode(
		"\n",
		array(
			'2D / 3D / 4D / 5D scan', 'Detailed scan', 'Transvaginal (TVS) scan',
			'Anatomical scan', 'Nuchal translucency (NT) scan', 'Antenatal follow-up (pink book)',
		)
	),
	$antenatal
);
wp_set_object_terms( $antenatal, array( $pillar_antenatal->term_id ), 'pillar' );

// --- Wellness & Aesthetic (rising pillar) ------------------------------------
$aesthetic = $mk( 'service', 'Wellness & Aesthetic', 'wellness-aesthetic', '<!-- wp:paragraph --><p>Doctor-led wellness and aesthetic treatments, from IV drips to skin and body procedures. [confirm scope]</p><!-- /wp:paragraph -->' );
update_field( 'service_short_desc', 'Doctor-led wellness and aesthetic treatments.', $aesthetic );
update_field( 'service_wa_routing', 'general', $aesthetic );
update_field( 'service_branches', array( $ampang ), $aesthetic );
update_field(
	'service_procedures',
	implode(
		"\n",
		array(
			'Weight loss', 'Eye dark circles', 'NAD drip', 'Vitamin C drip',
			'Glutathione drip', 'Peptide injection', 'Chemical peeling', 'Skin booster',
			'Knee injection', 'Keloid injection', 'Trigger finger injection',
			'Frozen shoulder injection',
		)
	),
	$aesthetic
);
$pillar_aesthetic_term = get_term_by( 'name', 'Aesthetics', 'pillar' );
if ( $pillar_aesthetic_term ) {
	wp_set_object_terms( $aesthetic, array( $pillar_aesthetic_term->term_id ), 'pillar' );
}

// Back-link doctor -> service.
update_field( 'doctor_lead_for', array( $antenatal ), $dr_anis );

// --- Full service catalog (from the Wix "Perkhidmatan" page, translated) -----
// Each: title, slug, pillar term name, short description, WA routing.
$pillar_aesthetic = get_term_by( 'name', 'Aesthetics', 'pillar' );
$pillar_general   = get_term_by( 'name', 'General Medicine', 'pillar' );
$catalog = array(
	array( 'Knee Injection', 'knee-injection', $pillar_general, 'PRP knee injections and treatment for knee pain.', 'general' ),
	array( "Men's Health", 'mens-health', $pillar_general, 'Treatment and consultation for men\'s health concerns.', 'general' ),
	array( 'Nebuliser & Suction', 'nebuliser-suction', $pillar_general, 'Nebuliser to loosen phlegm and suction to clear it.', 'general' ),
	array( 'Radiology', 'radiology', $pillar_general, 'Imaging services. Coming soon. [confirm]', 'general' ),
	array( 'Pregnancy Scan', 'pregnancy-scan', $pillar_antenatal, 'Pregnancy checks from 7 weeks of gestation and above.', 'general' ),
	array( 'Family Planning', 'family-planning', $pillar_antenatal, 'A range of family planning options.', 'general' ),
	array( 'Immunisation', 'immunisation', $pillar_general, 'Vaccinations for protection across ages.', 'general' ),
	array( 'ENT', 'ent', $pillar_general, 'Ear, nose and throat examinations.', 'general' ),
	array( 'Physiotherapy', 'physiotherapy', $pillar_general, 'Physiotherapy including rehabilitation and more.', 'general' ),
	array( 'Mother & Child Health', 'mother-child-health', $pillar_antenatal, 'Health checks for mother and child.', 'general' ),
	array( 'Fertility Treatment', 'fertility-treatment', $pillar_antenatal, 'Fertility treatment by an O&G doctor.', 'general' ),
	array( 'Outpatient Care', 'outpatient-care', $pillar_general, 'Outpatient treatment for fever, cough, cold and more.', 'general' ),
	array( 'Occupational Health (OHD)', 'occupational-health', $pillar_general, 'Health services for employees and workplaces.', 'general' ),
	array( 'Medispa', 'medispa', $pillar_aesthetic, 'Hair wash, facials and massage treatments.', 'general' ),
);
$service_ids = array();
foreach ( $catalog as $c ) {
	list( $title, $slug, $pterm, $desc, $routing ) = $c;
	$sid = $mk( 'service', $title, $slug );
	update_field( 'service_short_desc', $desc, $sid );
	update_field( 'service_pillar_weight', ( $pterm && $pterm->name === 'Aesthetics' ) ? 'rising' : 'base', $sid );
	update_field( 'service_wa_routing', $routing, $sid );
	update_field( 'service_branches', array( $ampang ), $sid );
	if ( $pterm ) {
		wp_set_object_terms( $sid, array( $pterm->term_id ), 'pillar' );
	}
	$service_ids[ $slug ] = $sid;
}

// Outpatient care procedure list (translated).
if ( isset( $service_ids['outpatient-care'] ) ) {
	update_field(
		'service_procedures',
		implode(
			"\n",
			array(
				'Fever', 'Cough', 'Cold / flu', 'Gastritis', 'Wound cleaning', 'Asthma',
				'Vaccination', 'Dizziness', 'Muscle aches', 'Medical check-up / GDL',
			)
		),
		$service_ids['outpatient-care']
	);
}

// --- Procedure page: Xanthelasma (worked example from the reference page) ----
$xanth = $mk( 'procedure', 'Xanthelasma treatment', 'xanthelasma-treatment' );
update_field( 'proc_summary', 'Yellow cholesterol deposits in the skin of the eyelid, assessed and removed.', $xanth );
update_field( 'proc_wa_routing', 'minor_surgery', $xanth );
update_field( 'proc_parent_service', $minor, $xanth );
update_field( 'proc_branches', array( $ampang, $jalanbaru ), $xanth );
update_field(
	'proc_what',
	'<p>Xanthelasma is a collection of lipid-laden cells sitting in the upper layer of the skin. It appears as a soft, slightly raised, yellow-to-cream plaque. It is usually painless and does not itch.</p>'
	. '<p>The deposits are common around the inner corner of the upper eyelid, and can appear on all four lids. They are more frequent in middle age and beyond, and in people of Asian and Mediterranean descent.</p>',
	$xanth
);
update_field( 'proc_note', 'Roughly half of people with xanthelasma have abnormal lipid levels, so a doctor will usually ask about your cardiovascular risk and may recommend a lipid profile blood test. Removing the plaque does not change the underlying lipid level, so it can come back if the cause is not addressed. The removal is cosmetic and functional, but the blood test is the part that can matter to your health.', $xanth );
if ( have_rows( 'proc_methods', $xanth ) ) {
	delete_field( 'proc_methods', $xanth );
}
update_field(
	'proc_methods',
	array(
		array( 'name' => 'Surgical excision', 'body' => 'The deposit is cut out under local anaesthetic through a superficial dissection that avoids the deeper eyelid structures. It gives the most complete removal for thicker plaques and has the lowest recurrence rate. It needs a wound that closes, so there is a fine scar.' ),
		array( 'name' => 'Laser ablation', 'body' => 'A laser vaporises the deposit with precision. It suits smaller or more superficial plaques and avoids stitches. It can leave a temporary colour change, and thicker lesions may need more than one session.' ),
		array( 'name' => 'Radiofrequency', 'body' => 'Controlled heat removes the plaque without stitches. Quick, with redness and mild swelling that settles over days. It suits plaques that are not too deep.' ),
	),
	$xanth
);
update_field(
	'proc_expect',
	array(
		array( 'name' => 'Assessment', 'body' => 'The doctor examines the plaques, asks about your health and any family history of high cholesterol, and may arrange a lipid profile blood test.' ),
		array( 'name' => 'Method and consent', 'body' => 'You are told which method is proposed, why, what the scar and recovery are likely to be, and what the recurrence risk is. You decide.' ),
		array( 'name' => 'The procedure', 'body' => 'Performed under local anaesthetic, so the area is numb. Most removals are short and done as an outpatient visit.' ),
		array( 'name' => 'Aftercare and review', 'body' => 'You are given wound care instructions and a review point. Recurrence is possible, so follow-up matters.' ),
	),
	$xanth
);
update_field(
	'proc_questions',
	implode(
		"\n",
		array(
			'Is this definitely xanthelasma, or could it be something else?',
			'Do I need a lipid profile, and who follows up the result?',
			'Which removal method are you recommending for my lesion, and why that one?',
			'What will the scar look like, and how long until it settles?',
			'How likely is it to come back, and what would you do if it does?',
		)
	),
	$xanth
);

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

WP_CLI::success( 'Seeded sample content: 6 branches, 2 doctors, services + aesthetic, 3 reviews. Run with --purge to remove.' );
