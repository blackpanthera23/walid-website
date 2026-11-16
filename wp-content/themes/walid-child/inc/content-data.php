<?php
/**
 * Site content for the importer (inc/content-import.php).
 *
 * Generated 16 Nov 2026 from the local build with every [confirm] / [permission pending] / sample flag
 * removed. Branch addresses, phones and hours come from each branch's public Google Maps listing
 * (16 Nov 2026). Reviews are real 5-star Google reviews of Poliklinik Walid Ampang, chosen to cover
 * different treatments; authors appear as first name + initial.
 *
 * @package walid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return json_decode(
	<<<'WALIDJSON'
{
 "version": "2026-11-16",
 "images": {
  "svc-minor-surgery": "assets/img/services/minor-surgery.webp",
  "svc-aesthetics": "assets/img/services/aesthetics.webp",
  "svc-antenatal": "assets/img/services/antenatal.webp"
 },
 "posts": [
  {
   "type": "branch",
   "slug": "ampang",
   "title": "Poliklinik Walid Ampang",
   "status": "publish",
   "order": 1,
   "excerpt": "Our Klang Valley surgical centre, with day-care minor surgery and general practice.",
   "content": "",
   "terms": {
    "region": [
     "central-klang-valley"
    ]
   },
   "fields": {
    "branch_full_name": "Poliklinik Walid Ampang",
    "branch_is_flagship": 1,
    "branch_provides_minor_surgery": 1,
    "branch_address": "No 1, Ground Floor, Block 2, City Garden Commercial Centre, Taman Nirwana, 68000 Ampang Jaya, Selangor",
    "branch_phone": "017-224 8275",
    "branch_hours": [
     {
      "day": "Daily",
      "time": "9am to 9pm"
     }
    ],
    "branch_map_embed": "Poliklinik Walid Ampang, Taman Nirwana, Ampang Jaya"
   },
   "refs": {},
   "images": {},
   "meta": {
    "branch_google_rating": "4.9",
    "branch_google_count": "1,130",
    "branch_google_name": "Poliklinik Walid Ampang",
    "branch_google_checked": "2026-11-16"
   }
  },
  {
   "type": "branch",
   "slug": "jalan-baru",
   "title": "Poliklinik Walid Jalan Baru",
   "status": "publish",
   "order": 2,
   "excerpt": "A Northern surgical centre in Seberang Perai, with day-care minor surgery and general practice.",
   "content": "<!-- wp:paragraph --><p>Our Jalan Baru branch in Seberang Perai is one of our Northern surgical centres, offering day-care minor surgery alongside general practice.</p><!-- /wp:paragraph -->",
   "terms": {
    "region": [
     "north-penang-kedah"
    ]
   },
   "fields": {
    "branch_full_name": "Poliklinik Walid Jalan Baru",
    "branch_is_flagship": 0,
    "branch_provides_minor_surgery": 1,
    "branch_address": "Signature Avenue, Jalan Baru, Seberang Perai, 13700 Butterworth, Pulau Pinang",
    "branch_phone": "017-622 7457",
    "branch_hours": [
     {
      "day": "Daily",
      "time": "8:30am to 11pm"
     }
    ],
    "branch_map_embed": "Poliklinik Walid Jalan Baru, Seberang Perai"
   },
   "refs": {},
   "images": {},
   "meta": {
    "branch_google_rating": "4.8",
    "branch_google_count": "661",
    "branch_google_name": "Poliklinik Walid Jalan Baru (HQ)",
    "branch_google_checked": "2026-11-16"
   }
  },
  {
   "type": "branch",
   "slug": "kuala-kangsar",
   "title": "Poliklinik Walid Kuala Kangsar",
   "status": "publish",
   "order": 5,
   "excerpt": "General practice in Kuala Kangsar, Perak.",
   "content": "",
   "terms": {
    "region": [
     "other"
    ]
   },
   "fields": {
    "branch_full_name": "Poliklinik Walid Kuala Kangsar",
    "branch_is_flagship": 0,
    "branch_provides_minor_surgery": 0,
    "branch_address": "No 19, Persiaran Medan Suria, Medan Suria, 33000 Kuala Kangsar, Perak",
    "branch_phone": "018-874 6768",
    "branch_hours": [
     {
      "day": "Daily",
      "time": "9am to 11pm"
     }
    ],
    "branch_map_embed": "Poliklinik Walid Kuala Kangsar"
   },
   "refs": {},
   "images": {},
   "meta": {
    "branch_google_rating": "4.9",
    "branch_google_count": "975",
    "branch_google_name": "Poliklinik Walid Kuala Kangsar",
    "branch_google_checked": "2026-11-16"
   }
  },
  {
   "type": "branch",
   "slug": "parit-buntar",
   "title": "Poliklinik Walid Parit Buntar",
   "status": "publish",
   "order": 6,
   "excerpt": "General practice in Parit Buntar, Perak, open 22 hours a day.",
   "content": "",
   "terms": {
    "region": [
     "other"
    ]
   },
   "fields": {
    "branch_full_name": "Poliklinik Walid Parit Buntar",
    "branch_is_flagship": 0,
    "branch_provides_minor_surgery": 0,
    "branch_address": "Ground Floor, No 29 & 31, Jalan Wawasan 3, Taman Wawasan Jaya, 34200 Parit Buntar, Perak",
    "branch_phone": "011-5893 0702",
    "branch_hours": [
     {
      "day": "Daily",
      "time": "8am to 6am the next morning (closed 6am to 8am)"
     }
    ],
    "branch_map_embed": "Poliklinik Walid 22 Jam Parit Buntar"
   },
   "refs": {},
   "images": {},
   "meta": {
    "branch_google_rating": "4.7",
    "branch_google_count": "992",
    "branch_google_name": "Poliklinik Walid 22 Jam Parit Buntar",
    "branch_google_checked": "2026-11-16"
   }
  },
  {
   "type": "branch",
   "slug": "sungai-petani",
   "title": "Poliklinik Walid Sungai Petani",
   "status": "publish",
   "order": 4,
   "excerpt": "A Northern surgical centre in Kedah, with day-care minor surgery and general practice.",
   "content": "",
   "terms": {
    "region": [
     "north-penang-kedah"
    ]
   },
   "fields": {
    "branch_full_name": "Poliklinik Walid Sungai Petani",
    "branch_is_flagship": 0,
    "branch_provides_minor_surgery": 1,
    "branch_address": "18, Ground Floor, Jalan PPZ 1, Pusat Perniagaan Zamrud, 08000 Sungai Petani, Kedah",
    "branch_phone": "012-615 0619",
    "branch_hours": [
     {
      "day": "Daily",
      "time": "9am to 10pm"
     }
    ],
    "branch_map_embed": "Poliklinik Walid Sungai Petani"
   },
   "refs": {},
   "images": {},
   "meta": {
    "branch_google_rating": "4.9",
    "branch_google_count": "195",
    "branch_google_name": "Poliklinik Walid Sungai Petani",
    "branch_google_checked": "2026-11-16"
   }
  },
  {
   "type": "branch",
   "slug": "tasek-gelugor",
   "title": "Poliklinik Walid Tasek Gelugor",
   "status": "publish",
   "order": 3,
   "excerpt": "A Northern surgical centre in Penang, with day-care minor surgery and general practice.",
   "content": "",
   "terms": {
    "region": [
     "north-penang-kedah"
    ]
   },
   "fields": {
    "branch_full_name": "Poliklinik Walid Tasek Gelugor",
    "branch_is_flagship": 0,
    "branch_provides_minor_surgery": 1,
    "branch_address": "No 19, Jalan Tasek Gelugor Jaya, 13300 Tasek Gelugor, Pulau Pinang",
    "branch_phone": "017-432 9173",
    "branch_hours": [
     {
      "day": "Daily",
      "time": "9am to 11pm"
     }
    ],
    "branch_map_embed": "Poliklinik Walid Tasek Gelugor"
   },
   "refs": {},
   "images": {},
   "meta": {
    "branch_google_rating": "4.9",
    "branch_google_count": "427",
    "branch_google_name": "Poliklinik Walid Tasek Gelugor",
    "branch_google_checked": "2026-11-16"
   }
  },
  {
   "type": "service",
   "slug": "antenatal",
   "title": "Antenatal Care",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "Pregnancy scans from 7 weeks onward, with mother-and-child health and family planning.",
   "terms": {
    "pillar": [
     "antenatal-womens-health"
    ]
   },
   "fields": {
    "service_pillar_weight": "rising",
    "service_wa_routing": "general",
    "service_short_desc": "Antenatal care led by a dedicated specialist.",
    "service_procedures": "2D / 3D / 4D / 5D scan\nDetailed scan\nTransvaginal (TVS) scan\nAnatomical scan\nNuchal translucency (NT) scan\nAntenatal follow-up (pink book)"
   },
   "refs": {
    "service_lead_doctor": "doctor:dr-anis",
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {
    "service_icon": "svc-antenatal"
   },
   "meta": {}
  },
  {
   "type": "service",
   "slug": "ent",
   "title": "ENT",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "general-medicine"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Ear, nose and throat examinations."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "family-planning",
   "title": "Family Planning",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "antenatal-womens-health"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "A range of family planning options."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "fertility-treatment",
   "title": "Fertility Treatment",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "antenatal-womens-health"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Fertility treatment by an O&G doctor."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "immunisation",
   "title": "Immunisation",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "general-medicine"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Vaccinations for protection across ages."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "knee-injection",
   "title": "Knee Injection",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "general-medicine"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "PRP knee injections and treatment for knee pain."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "medispa",
   "title": "Medispa",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "aesthetics"
    ]
   },
   "fields": {
    "service_pillar_weight": "rising",
    "service_wa_routing": "general",
    "service_short_desc": "Hair wash, facials and massage treatments."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "mens-health",
   "title": "Men's Health",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "general-medicine"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Treatment and consultation for men's health concerns."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "minor-surgery",
   "title": "Minor Surgery",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "<!-- wp:paragraph --><p>Poliklinik Walid is a specialist minor surgery provider. Our surgeon-led team removes common lumps and skin lesions as day-care procedures, which means you are assessed and treated in a single visit and home the same day. Care is delivered to a hospital-grade standard at clinic speed and price, the smart choice for patients who want their time and money respected.</p><!-- /wp:paragraph -->\n\n<!-- wp:heading {\"level\":2} --><h2 class=\"wp-block-heading\">How day-care surgery works</h2><!-- /wp:heading -->\n\n<!-- wp:paragraph --><p>A doctor assesses the area first and explains your options clearly before anything is done. Many minor procedures are completed under local anaesthetic within the same appointment, so there is no hospital stay and no long wait.</p><!-- /wp:paragraph -->\n\n<!-- wp:heading {\"level\":2} --><h2 class=\"wp-block-heading\">Where we perform minor surgery</h2><!-- /wp:heading -->\n\n<!-- wp:paragraph --><p>Minor surgery is performed at our surgical centres: Ampang in the Klang Valley (our flagship hub) and our Northern centres in Seberang Perai, Tasek Gelugor and Sungai Petani. General practice is available across the full branch network. Message us to confirm availability at the branch nearest you before you travel.</p><!-- /wp:paragraph -->",
   "terms": {
    "pillar": [
     "minor-surgery"
    ]
   },
   "fields": {
    "service_pillar_weight": "hero",
    "service_wa_routing": "minor_surgery",
    "service_short_desc": "Surgeon-led day-care minor surgery at our Central and Northern centres.",
    "service_procedures": "Lipoma | A soft fatty lump under the skin, assessed and removed.\nSebaceous cyst | A fluid-filled lump under the skin.\nGanglion cyst | A fluid-filled lump, often near a joint or tendon.\nSkin tag | A small, soft skin growth.\nGiant skin tag | A larger skin tag needing removal.\nMole | A pigmented growth checked before removal.\nWart | A viral skin growth.\nGenital warts | Viral warts needing discreet, careful care.\nEye warts | Warts near the eye, removed with precision.\nKeloid (surgical removal) | An overgrown scar, excised rather than injected.\nXanthelasma | Yellow cholesterol deposits on the eyelid.\nKeratosis | A rough, scaly skin patch.\nMilia | Tiny white keratin cysts.\nSyringoma | Small benign sweat-gland growths.\nGranuloma | A small inflammatory nodule.\nEyebag | Surgical reduction of under-eye bags.\nGynaecomastia | Enlarged male breast tissue, assessed and treated.\nAccessory breast | Extra breast tissue, usually in the armpit.\nCircumcision | For children aged 2 and above, and adults.\nExtra finger (polydactyly) | Removal of an additional digit.\nCarbuncle | A cluster of infected hair follicles, drained.\nAbscess | A collection of pus, drained under local anaesthetic.\nInfected hidradenitis suppurativa (HS) | Recurrent skin abscesses, managed and drained.\nTongue tie | A tight band under the tongue, released.\nIngrown toenail | A nail growing into the skin, treated.\nNeurofibromatosis | Removal of benign nerve-tissue lumps.\nGout | Assessment and management of gout-related lumps."
   },
   "refs": {
    "service_lead_doctor": "doctor:dr-walid",
    "service_branches": [
     "branch:ampang",
     "branch:jalan-baru",
     "branch:tasek-gelugor",
     "branch:sungai-petani"
    ]
   },
   "images": {
    "service_icon": "svc-minor-surgery"
   },
   "meta": {}
  },
  {
   "type": "service",
   "slug": "mother-child-health",
   "title": "Mother & Child Health",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "antenatal-womens-health"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Health checks for mother and child."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "nebuliser-suction",
   "title": "Nebuliser & Suction",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "general-medicine"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Nebuliser to loosen phlegm and suction to clear it."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "occupational-health",
   "title": "Occupational Health (OHD)",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "general-medicine"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Health services for employees and workplaces."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "outpatient-care",
   "title": "Outpatient Care",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "general-medicine"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Outpatient treatment for fever, cough, cold and more.",
    "service_procedures": "Fever\nCough\nCold / flu\nGastritis\nWound cleaning\nAsthma\nVaccination\nDizziness\nMuscle aches\nMedical check-up / GDL"
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "physiotherapy",
   "title": "Physiotherapy",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "general-medicine"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Physiotherapy including rehabilitation and more."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "pregnancy-scan",
   "title": "Pregnancy Scan",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "antenatal-womens-health"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Pregnancy checks from 7 weeks of gestation and above."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "radiology",
   "title": "Radiology",
   "status": "draft",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {
    "pillar": [
     "general-medicine"
    ]
   },
   "fields": {
    "service_pillar_weight": "base",
    "service_wa_routing": "general",
    "service_short_desc": "Imaging services. Coming soon."
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "service",
   "slug": "wellness-aesthetic",
   "title": "Wellness & Aesthetic",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "<!-- wp:paragraph --><p>Doctor-led wellness and aesthetic treatments, from IV drips to skin and body procedures.</p><!-- /wp:paragraph -->",
   "terms": {
    "pillar": [
     "aesthetics"
    ]
   },
   "fields": {
    "service_wa_routing": "general",
    "service_short_desc": "Doctor-led wellness and aesthetic treatments.",
    "service_procedures": "Weight loss\nEye dark circles\nNAD drip\nVitamin C drip\nGlutathione drip\nPeptide injection\nChemical peeling\nSkin booster\nKnee injection\nKeloid injection\nTrigger finger injection\nFrozen shoulder injection"
   },
   "refs": {
    "service_branches": [
     "branch:ampang"
    ]
   },
   "images": {
    "service_icon": "svc-aesthetics"
   },
   "meta": {}
  },
  {
   "type": "doctor",
   "slug": "dr-anis",
   "title": "Dr Anis",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "doctor_role": "Antenatal & women's health",
    "doctor_qualifications": "MMC-registered",
    "doctor_is_leadership": 0,
    "doctor_bio": "Leads antenatal and women's health, with pregnancy scans from 7 weeks and family planning."
   },
   "refs": {
    "doctor_branches": [
     "branch:ampang"
    ],
    "doctor_lead_for": [
     "service:antenatal"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "doctor",
   "slug": "dr-walid",
   "title": "Dr Walid Utagha",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "doctor_role": "Principal doctor, minor surgery",
    "doctor_qualifications": "MMC-registered",
    "doctor_is_leadership": 1,
    "doctor_bio": "Principal doctor at Poliklinik Walid, leading the group's surgeon-led day-care minor surgery."
   },
   "refs": {
    "doctor_branches": [
     "branch:ampang"
    ],
    "doctor_lead_for": [
     "service:minor-surgery"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "procedure",
   "slug": "xanthelasma-treatment",
   "title": "Xanthelasma treatment",
   "status": "publish",
   "order": 0,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "proc_summary": "Yellow cholesterol deposits in the skin of the eyelid, assessed and removed.",
    "proc_wa_routing": "minor_surgery",
    "proc_what": "<p>Xanthelasma is a collection of lipid-laden cells sitting in the upper layer of the skin. It appears as a soft, slightly raised, yellow-to-cream plaque. It is usually painless and does not itch.</p><p>The deposits are common around the inner corner of the upper eyelid, and can appear on all four lids. They are more frequent in middle age and beyond, and in people of Asian and Mediterranean descent.</p>",
    "proc_note": "Roughly half of people with xanthelasma have abnormal lipid levels, so a doctor will usually ask about your cardiovascular risk and may recommend a lipid profile blood test. Removing the plaque does not change the underlying lipid level, so it can come back if the cause is not addressed. The removal is cosmetic and functional, but the blood test is the part that can matter to your health.",
    "proc_methods": [
     {
      "name": "Surgical excision",
      "body": "The deposit is cut out under local anaesthetic through a superficial dissection that avoids the deeper eyelid structures. It gives the most complete removal for thicker plaques and has the lowest recurrence rate. It needs a wound that closes, so there is a fine scar."
     },
     {
      "name": "Laser ablation",
      "body": "A laser vaporises the deposit with precision. It suits smaller or more superficial plaques and avoids stitches. It can leave a temporary colour change, and thicker lesions may need more than one session."
     },
     {
      "name": "Radiofrequency",
      "body": "Controlled heat removes the plaque without stitches. Quick, with redness and mild swelling that settles over days. It suits plaques that are not too deep."
     }
    ],
    "proc_expect": [
     {
      "name": "Assessment",
      "body": "The doctor examines the plaques, asks about your health and any family history of high cholesterol, and may arrange a lipid profile blood test."
     },
     {
      "name": "Method and consent",
      "body": "You are told which method is proposed, why, what the scar and recovery are likely to be, and what the recurrence risk is. You decide."
     },
     {
      "name": "The procedure",
      "body": "Performed under local anaesthetic, so the area is numb. Most removals are short and done as an outpatient visit."
     },
     {
      "name": "Aftercare and review",
      "body": "You are given wound care instructions and a review point. Recurrence is possible, so follow-up matters."
     }
    ],
    "proc_questions": "Is this definitely xanthelasma, or could it be something else?\nDo I need a lipid profile, and who follows up the result?\nWhich removal method are you recommending for my lesion, and why that one?\nWhat will the scar look like, and how long until it settles?\nHow likely is it to come back, and what would you do if it does?"
   },
   "refs": {
    "proc_parent_service": "service:minor-surgery",
    "proc_branches": [
     "branch:ampang",
     "branch:jalan-baru"
    ]
   },
   "images": {},
   "meta": {}
  },
  {
   "type": "review",
   "slug": "google-malek-amin",
   "title": "Google review: Malek A. (cyst)",
   "status": "publish",
   "order": 1,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "review_quote": "Good experience with the doctor and staffs here. Had a minor surgery for cyst and the procedure only took us less than 30mins to complete. Really recommended!",
    "review_author": "Malek A.",
    "review_rating": 5,
    "review_source": "Google review",
    "review_source_url": "https://www.google.com/maps/place/Poliklinik+Walid+Ampang/@3.1468426,101.7504647,17z/data=!4m6!3m5!1s0x31cc37441fc15897:0x8a0216ccf1df58!8m2!3d3.1468426!4d101.7504647",
    "review_permission": 1
   },
   "refs": {
    "review_branch": "branch:ampang"
   },
   "images": {},
   "meta": {
    "review_pillar": "minor-surgery",
    "review_topic": "cyst"
   }
  },
  {
   "type": "review",
   "slug": "google-hui-xin-mah",
   "title": "Google review: Hui Xin M. (skin tag)",
   "status": "publish",
   "order": 2,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "review_quote": "Dr. Walid was amazing during my visit! He explained the skin tag removal procedure so clearly and patiently, which really helped me feel calm and comfortable. He was very kind and made sure I understood everything before starting. I truly appreciated how caring and friendly he was. Highly recommend him for anyone looking for a gentle and professional doctor!",
    "review_author": "Hui Xin M.",
    "review_rating": 5,
    "review_source": "Google review",
    "review_source_url": "https://www.google.com/maps/place/Poliklinik+Walid+Ampang/@3.1468426,101.7504647,17z/data=!4m6!3m5!1s0x31cc37441fc15897:0x8a0216ccf1df58!8m2!3d3.1468426!4d101.7504647",
    "review_permission": 1
   },
   "refs": {
    "review_branch": "branch:ampang"
   },
   "images": {},
   "meta": {
    "review_pillar": "minor-surgery",
    "review_topic": "skin tag"
   }
  },
  {
   "type": "review",
   "slug": "google-edna-nares",
   "title": "Google review: Edna N. (keloid)",
   "status": "publish",
   "order": 3,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "review_quote": "Done removing 3 pcs keloids on both of my ears. It was done painless . Doctor Walid is very accomodating and good. Highly recomended.",
    "review_author": "Edna N.",
    "review_rating": 5,
    "review_source": "Google review",
    "review_source_url": "https://www.google.com/maps/place/Poliklinik+Walid+Ampang/@3.1468426,101.7504647,17z/data=!4m6!3m5!1s0x31cc37441fc15897:0x8a0216ccf1df58!8m2!3d3.1468426!4d101.7504647",
    "review_permission": 1
   },
   "refs": {
    "review_branch": "branch:ampang"
   },
   "images": {},
   "meta": {
    "review_pillar": "minor-surgery",
    "review_topic": "keloid"
   }
  },
  {
   "type": "review",
   "slug": "google-ellen-marie-hortilano",
   "title": "Google review: Ellen Marie H. (keloid, international)",
   "status": "publish",
   "order": 4,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "review_quote": "I saw your clinic on tiktok and there were so many good feedbacks. So I came here to Malaysia to have ear keloid surgery 🥰 the staff are so friendly and the doctor also so niece. Anyways im from philippine . Thank you so much doc walid for doing great 🥰💕",
    "review_author": "Ellen Marie H.",
    "review_rating": 5,
    "review_source": "Google review",
    "review_source_url": "https://www.google.com/maps/place/Poliklinik+Walid+Ampang/@3.1468426,101.7504647,17z/data=!4m6!3m5!1s0x31cc37441fc15897:0x8a0216ccf1df58!8m2!3d3.1468426!4d101.7504647",
    "review_permission": 1
   },
   "refs": {
    "review_branch": "branch:ampang"
   },
   "images": {},
   "meta": {
    "review_pillar": "minor-surgery",
    "review_topic": "keloid, international",
    "review_international": "1"
   }
  },
  {
   "type": "review",
   "slug": "google-datin-sri-l",
   "title": "Google review: Datin Sri L. (lipoma)",
   "status": "publish",
   "order": 5,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "review_quote": "I had my great experience here & my Lipoma was easily removed by the experience Dr. Walid. Thank You",
    "review_author": "Datin Sri L.",
    "review_rating": 5,
    "review_source": "Google review",
    "review_source_url": "https://www.google.com/maps/place/Poliklinik+Walid+Ampang/@3.1468426,101.7504647,17z/data=!4m6!3m5!1s0x31cc37441fc15897:0x8a0216ccf1df58!8m2!3d3.1468426!4d101.7504647",
    "review_permission": 1
   },
   "refs": {
    "review_branch": "branch:ampang"
   },
   "images": {},
   "meta": {
    "review_pillar": "minor-surgery",
    "review_topic": "lipoma"
   }
  },
  {
   "type": "review",
   "slug": "google-noor-aqilah",
   "title": "Google review: Noor A. (mole)",
   "status": "publish",
   "order": 6,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "review_quote": "the treatment is so fast and not hurt at all. recomended to come here if you want to remove your moles.👍👍 the doctor is friendly too! recommended!",
    "review_author": "Noor A.",
    "review_rating": 5,
    "review_source": "Google review",
    "review_source_url": "https://www.google.com/maps/place/Poliklinik+Walid+Ampang/@3.1468426,101.7504647,17z/data=!4m6!3m5!1s0x31cc37441fc15897:0x8a0216ccf1df58!8m2!3d3.1468426!4d101.7504647",
    "review_permission": 1
   },
   "refs": {
    "review_branch": "branch:ampang"
   },
   "images": {},
   "meta": {
    "review_pillar": "minor-surgery",
    "review_topic": "mole"
   }
  },
  {
   "type": "review",
   "slug": "google-rizman-amir",
   "title": "Google review: Rizman A. (wart)",
   "status": "publish",
   "order": 7,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "review_quote": "Highly recommended! I've been looking for an idea for a week on how to remove warts. Finally found this Walid Polyclinic. It took less than 10 minutes to remove them. Thank God it was done in a short time. The doctor and staff are also very friendly. Highly recommended",
    "review_author": "Rizman A.",
    "review_rating": 5,
    "review_source": "Google review",
    "review_source_url": "https://www.google.com/maps/place/Poliklinik+Walid+Ampang/@3.1468426,101.7504647,17z/data=!4m6!3m5!1s0x31cc37441fc15897:0x8a0216ccf1df58!8m2!3d3.1468426!4d101.7504647",
    "review_permission": 1
   },
   "refs": {
    "review_branch": "branch:ampang"
   },
   "images": {},
   "meta": {
    "review_pillar": "minor-surgery",
    "review_topic": "wart"
   }
  },
  {
   "type": "review",
   "slug": "google-vaachalla-rawindran",
   "title": "Google review: Vaachalla R. (ganglion cyst)",
   "status": "publish",
   "order": 8,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "review_quote": "Very fast and prompt service.came for ganglion cyst removal. Good explanation by doctor and friendly staff",
    "review_author": "Vaachalla R.",
    "review_rating": 5,
    "review_source": "Google review",
    "review_source_url": "https://www.google.com/maps/place/Poliklinik+Walid+Ampang/@3.1468426,101.7504647,17z/data=!4m6!3m5!1s0x31cc37441fc15897:0x8a0216ccf1df58!8m2!3d3.1468426!4d101.7504647",
    "review_permission": 1
   },
   "refs": {
    "review_branch": "branch:ampang"
   },
   "images": {},
   "meta": {
    "review_pillar": "minor-surgery",
    "review_topic": "ganglion cyst"
   }
  },
  {
   "type": "review",
   "slug": "google-kyrie-azry",
   "title": "Google review: Kyrie A. (ingrown toenail)",
   "status": "publish",
   "order": 9,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "review_quote": "Highly recommended doctor. Solved my toe nail issue in less than 15 min before my trip! Will be coming here next for my lipoma surgery 😁",
    "review_author": "Kyrie A.",
    "review_rating": 5,
    "review_source": "Google review",
    "review_source_url": "https://www.google.com/maps/place/Poliklinik+Walid+Ampang/@3.1468426,101.7504647,17z/data=!4m6!3m5!1s0x31cc37441fc15897:0x8a0216ccf1df58!8m2!3d3.1468426!4d101.7504647",
    "review_permission": 1
   },
   "refs": {
    "review_branch": "branch:ampang"
   },
   "images": {},
   "meta": {
    "review_pillar": "minor-surgery",
    "review_topic": "ingrown toenail"
   }
  },
  {
   "type": "review",
   "slug": "google-faezah-masron",
   "title": "Google review: Faezah M. (pregnancy)",
   "status": "publish",
   "order": 10,
   "excerpt": "",
   "content": "",
   "terms": {},
   "fields": {
    "review_quote": "It is my 1st pregnancy while I'm reaching 40ies. I don't have any experience, but the doctor is soo nice and gives me good advice. I feel comfortable and safe. Alhamdulillah..",
    "review_author": "Faezah M.",
    "review_rating": 5,
    "review_source": "Google review",
    "review_source_url": "https://www.google.com/maps/place/Poliklinik+Walid+Ampang/@3.1468426,101.7504647,17z/data=!4m6!3m5!1s0x31cc37441fc15897:0x8a0216ccf1df58!8m2!3d3.1468426!4d101.7504647",
    "review_permission": 1
   },
   "refs": {
    "review_branch": "branch:ampang"
   },
   "images": {},
   "meta": {
    "review_pillar": "antenatal-womens-health",
    "review_topic": "pregnancy"
   }
  }
 ]
}
WALIDJSON
	,
	true
);
