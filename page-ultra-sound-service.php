<?php
/**
 * Template Name: Ultrasound Services
 * SEO: Affordable Ultrasound Scans Nairobi | In-Store & Home Visit | Family Drugmart Kenya
 */

if ( ! defined('ABSPATH') ) { die(); }

/* ══════════════════════════════════════════════════════════════
   SEO — runs BEFORE get_header() so wp_head can output it.
   If an SEO plugin is active (you use Yoast), these tags are skipped:
   set the title/description in the Yoast box under this page instead.
   ══════════════════════════════════════════════════════════════ */
$USP_SEO_TITLE = 'Affordable Ultrasound Scan Nairobi Kenya | In-Store & Home Visit | Family Drugmart';
$USP_SEO_DESC  = 'Professional, affordable ultrasound in Nairobi, Kenya: obs, breast, abdominal, pelvic, scrotal, thyroid, KUBP, Doppler and echo scans. In-store or home visit. PPB licensed.';
$USP_PPB       = 'PPB/F/3208';

$usp_has_seo_plugin = defined( 'WPSEO_VERSION' )          // Yoast
    || defined( 'RANK_MATH_VERSION' )                     // Rank Math
    || defined( 'AIOSEO_VERSION' )                        // All in One SEO
    || defined( 'SEOPRESS_VERSION' )                      // SEOPress
    || defined( 'THE_SEO_FRAMEWORK_VERSION' );            // The SEO Framework

if ( ! $usp_has_seo_plugin ) {

    add_filter( 'pre_get_document_title', function ( $title ) use ( $USP_SEO_TITLE ) {
        return is_page() ? $USP_SEO_TITLE : $title;
    }, 99 );

    add_action( 'wp_head', function () use ( $USP_SEO_DESC, $USP_SEO_TITLE ) {
        if ( ! is_page() ) return;
        $url = get_permalink();
        echo '<meta name="description" content="' . esc_attr( $USP_SEO_DESC ) . '">' . "\n";
        echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr( $USP_SEO_TITLE ) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr( $USP_SEO_DESC ) . '">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    }, 1 );

}

get_header();

$us_wa   = '254796140021';
$us_form = 'https://docs.google.com/forms/d/e/1FAIpQLSex9caqdh6Gjjiibm-mMZlGXUmmUYqh1T7i3uqrSCkHNiMIDg/viewform?pli=1';
$usp_addr = function_exists('medicare_address') ? medicare_address() : 'High Point Plaza, along Ruaka-Banana Road';

/* ── Scan types: id, name, short card text, longer SEO text, icon markup ── */
$USP_SCANS = [
    [ 'thyroid', 'Thyroid Scan', 'Evaluate thyroid gland for nodules or abnormalities.',
      'A thyroid ultrasound in Nairobi checks the size and texture of your thyroid gland and looks for nodules, cysts, goitre or swelling. It is painless, quick and needs no special preparation.',
      '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>' ],
    [ 'obs', 'Obs Scan', 'Pregnancy monitoring and fetal health assessment.',
      'An obs (obstetric) scan, also called a pregnancy scan, checks your baby\'s growth, heartbeat, position and the amount of fluid around the baby. We offer affordable obs scans in Nairobi, in-store or at home.',
      '<path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/>' ],
    [ 'breast', 'Breast Ultrasound', 'Detection of lumps, cysts or breast tissue changes.',
      'A breast ultrasound helps find the cause of a lump, pain or other change in the breast and tells apart fluid-filled cysts from solid areas. It is often used alongside a clinical examination.',
      '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>' ],
    [ 'abdominal', 'Abdominal Scan', 'Liver, kidneys, gallbladder and organ review.',
      'An abdominal ultrasound looks at the liver, gallbladder, pancreas, spleen and kidneys. It is commonly requested for abdominal pain, bloating, gallstones or liver and kidney concerns.',
      '<ellipse cx="12" cy="12" rx="10" ry="6"/><line x1="2" y1="12" x2="22" y2="12"/>' ],
    [ 'pelvic', 'Pelvic Scan', 'Uterus, ovaries and pelvic organ assessment.',
      'A pelvic ultrasound examines the uterus, ovaries and bladder. It is used for pelvic pain, irregular periods, fibroids, ovarian cysts and fertility checks.',
      '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>' ],
    [ 'scrotal', 'Scrotal Scan', 'Assessment of scrotal contents and surrounding tissue.',
      'A scrotal ultrasound checks the scrotum and the structures around the testicles for swelling, lumps, fluid or varicocele.',
      '<circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="9"/>' ],
    [ 'testicular', 'Testicular Scan', 'Detailed testicular imaging for pain or swelling.',
      'A testicular ultrasound gives detailed images of the testicles to investigate pain, swelling, lumps or changes in size. Early assessment matters, so book as soon as you notice a problem.',
      '<circle cx="12" cy="12" r="3"/><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>' ],
    [ 'kubp', 'KUBP', 'Kidney, ureter, bladder and prostate evaluation.',
      'KUBP stands for kidney, ureter, bladder and prostate. This scan checks the urinary tract for stones, blockages, an enlarged prostate or incomplete bladder emptying.',
      '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>' ],
    [ 'echo', 'Echocardiography', 'Heart structure and function ultrasound imaging.',
      'An echocardiogram (echo) is an ultrasound of the heart. It shows the heart\'s chambers, valves and pumping function, and helps assess heart conditions in adults.',
      '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78"/><path d="M12 21.23l7.78-7.78"/>' ],
    [ 'doppler', 'Doppler Scan', 'Blood flow assessment in vessels and organs.',
      'A Doppler ultrasound measures blood flow through your arteries and veins. It is used to check for clots, narrowed vessels, varicose veins and blood flow in pregnancy.',
      '<path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>' ],
    [ 'regional', 'Regional Scan', 'Skin, muscle and soft tissue targeted imaging.',
      'A regional (soft tissue) ultrasound targets one area of the body, such as a lump under the skin, a swollen gland, a muscle injury or a joint, to see what is happening beneath the surface.',
      '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>' ],
    [ 'home', 'Home Visit Scan', 'All scan types available at your home across Nairobi.',
      'Our mobile ultrasound service brings a professional sonographer to your home anywhere in Nairobi. It is ideal for pregnant mothers, the elderly, patients with limited mobility and anyone who prefers privacy.',
      '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>' ],
];

/* ── Keyphrase chips: label => target (anchor on this page) ── */
$USP_CHIPS = [
    [ 'Affordable ultrasound Nairobi',          '#usp-book' ],
    [ 'Cheap ultrasound Nairobi',               '#usp-book' ],
    [ 'Best ultrasound services Nairobi',       '#usp-book' ],
    [ 'Professional ultrasound Kenya',          '#usp-book' ],
    [ 'Ultrasound scan Nairobi',                '#usp-scans' ],
    [ 'Ultrasound near me Nairobi',             '#usp-book' ],
    [ 'Mobile ultrasound Nairobi',              '#scan-home' ],
    [ 'Home visit ultrasound Kenya',            '#scan-home' ],
    [ 'Pregnancy scan Nairobi',                 '#scan-obs' ],
    [ 'Obs scan Nairobi',                       '#scan-obs' ],
    [ 'Breast ultrasound Nairobi',              '#scan-breast' ],
    [ 'Abdominal ultrasound Kenya',             '#scan-abdominal' ],
    [ 'Pelvic ultrasound Nairobi',              '#scan-pelvic' ],
    [ 'Thyroid scan Nairobi',                   '#scan-thyroid' ],
    [ 'Scrotal and testicular scan Nairobi',    '#scan-scrotal' ],
    [ 'KUBP scan Kenya',                        '#scan-kubp' ],
    [ 'Doppler scan Nairobi',                   '#scan-doppler' ],
    [ 'Echocardiography Nairobi',               '#scan-echo' ],
    [ 'Ultrasound without referral Kenya',      '#usp-book' ],
    [ 'Ultrasound clinic Nairobi',              '#usp-book' ],
];

$USP_FAQS = [
    [ 'q' => 'Where can I get an affordable ultrasound scan in Nairobi?',
      'a' => 'Family Drugmart Kenya offers affordable ultrasound scans in Nairobi, in-store at ' . $usp_addr . ' and as home visits across the city. Book on our online form or on WhatsApp and we will confirm your appointment and the price for your scan.' ],
    [ 'q' => 'Do you offer home visit or mobile ultrasound in Nairobi?',
      'a' => 'Yes. Our mobile ultrasound service brings a professional sonographer to your home anywhere in Nairobi. All scan types are available as home visits.' ],
    [ 'q' => 'What types of ultrasound scans do you offer?',
      'a' => 'We offer obs (pregnancy), breast, abdominal, pelvic, thyroid, scrotal, testicular, KUBP (kidney, ureter, bladder and prostate), Doppler, echocardiography and regional soft tissue scans.' ],
    [ 'q' => 'Do I need a doctor\'s referral for an ultrasound?',
      'a' => 'No referral is needed to book a scan with us. If you have a request form from your doctor, bring it or send it on WhatsApp so the sonographer knows what to focus on.' ],
    [ 'q' => 'How do I book an ultrasound scan in Nairobi?',
      'a' => 'Fill our short online booking form or message us on WhatsApp. We confirm your appointment by WhatsApp, share any simple preparation guidelines, and carry out the scan in-store or at your home.' ],
    [ 'q' => 'How should I prepare for an ultrasound scan?',
      'a' => 'Preparation depends on the scan. Some scans, such as pelvic and KUBP, usually need a full bladder, and some abdominal scans need fasting. We share clear instructions when you book.' ],
    [ 'q' => 'How soon will I get my results?',
      'a' => 'You receive your images, report and professional advice after the scan. Our sonographer will explain what they find and what to do next.' ],
    [ 'q' => 'Is Family Drugmart Kenya licensed?',
      'a' => 'Yes. Family Drugmart Kenya is licensed by the Pharmacy and Poisons Board (PPB) of Kenya, License No: ' . $USP_PPB . '.' ],
];

$usp_faq_schema = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map( function ( $f ) {
        return [ '@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => [ '@type' => 'Answer', 'text' => $f['a'] ] ];
    }, $USP_FAQS ),
];
$usp_service_schema = [
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'serviceType' => 'Ultrasound scanning (in-store and home visit)',
    'name'        => 'Ultrasound Scans in Nairobi, Kenya',
    'description' => $USP_SEO_DESC,
    'provider'    => [ '@type' => 'Pharmacy', 'name' => 'Family Drugmart Kenya', 'url' => home_url( '/' ) ],
    'areaServed'  => [
        [ '@type' => 'City',    'name' => 'Nairobi' ],
        [ '@type' => 'Country', 'name' => 'Kenya' ],
    ],
];
?>

<script type="application/ld+json"><?php echo wp_json_encode( $usp_service_schema, JSON_UNESCAPED_SLASHES ); ?></script>
<script type="application/ld+json"><?php echo wp_json_encode( $usp_faq_schema, JSON_UNESCAPED_SLASHES ); ?></script>

<style>
:root {
  --usp-blue:        #1d3f8f;
  --usp-blue-dark:   #15306e;
  --usp-blue-darker: #0e2358;
  --usp-blue-navy:   #0a1228;
  --usp-gold:        #f5a623;
  --usp-text:        #1b2230;
  --usp-text-light:  #6b7280;
  --usp-bg-soft:     #f7f8fa;
  --usp-border:      #edf0f5;
  --usp-font-head:   'Nunito', sans-serif;
  --usp-font-body:   'Lato', sans-serif;
}
*, *::before, *::after { box-sizing: border-box; }
html { scroll-behavior: smooth; }

.usp-wrap {
  max-width: 1100px;
  margin: 40px auto 60px;
  padding: 0 24px;
  font-family: var(--usp-font-body);
  overflow-x: hidden;
}

/* HERO */
.usp-hero {
  background: var(--usp-blue-darker);
  border: 1px solid rgba(245,166,35,.25);
  border-top: 3px solid var(--usp-gold);
  border-radius: 20px;
  padding: 52px 40px;
  text-align: center;
}
.usp-tag {
  display: inline-block;
  font-size: 11px; font-weight: 800; letter-spacing: 1.4px;
  text-transform: uppercase; color: var(--usp-gold);
  background: rgba(245,166,35,.10);
  border: 1px solid rgba(245,166,35,.30);
  padding: 6px 16px; border-radius: 50px;
  margin-bottom: 18px; font-family: var(--usp-font-body);
}
.usp-title {
  font-family: var(--usp-font-head);
  font-size: clamp(20px, 4vw, 34px);
  font-weight: 900; color: #fff;
  margin: 0 0 14px; line-height: 1.25;
}
.usp-title span { color: var(--usp-gold); }
.usp-hero-desc {
  font-size: clamp(13px, 2vw, 15px);
  color: rgba(255,255,255,.70);
  line-height: 1.75; max-width: 660px;
  margin: 0 auto 28px;
}
.usp-btn-row {
  display: flex; justify-content: center;
  gap: 12px; flex-wrap: wrap;
}
.usp-btn {
  display: inline-flex; align-items: center;
  justify-content: center; gap: 8px;
  padding: 13px 26px; border-radius: 50px;
  font-size: 13px; font-weight: 800;
  font-family: var(--usp-font-body);
  text-decoration: none; white-space: nowrap;
  transition: transform .18s, box-shadow .18s, background .18s;
}
.usp-btn-primary {
  background: var(--usp-gold); color: var(--usp-blue-navy);
  box-shadow: 0 8px 22px rgba(245,166,35,.30);
}
.usp-btn-primary:hover { transform: translateY(-2px); }
.usp-btn-outline {
  background: transparent; color: #fff;
  border: 1.5px solid rgba(255,255,255,.30);
}
.usp-btn-outline:hover { border-color: var(--usp-gold); color: var(--usp-gold); transform: translateY(-2px); }
.usp-btn-blue {
  background: var(--usp-blue); color: #fff;
  box-shadow: 0 8px 22px rgba(29,63,143,.25);
}
.usp-btn-blue:hover { background: var(--usp-blue-dark); transform: translateY(-2px); color: #fff; }

/* FEATURE CARDS */
.usp-grid {
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 16px; margin-top: 36px;
}
.usp-card {
  background: #fff; border: 1.5px solid var(--usp-border);
  border-radius: 14px; padding: 22px 16px; text-align: center;
  transition: transform .2s, box-shadow .2s, border-color .2s;
}
.usp-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 28px rgba(13,33,79,.08);
  border-color: rgba(245,166,35,.35);
}
.usp-card-icon {
  width: 46px; height: 46px; margin: 0 auto 12px;
  border-radius: 12px; background: rgba(29,63,143,.08);
  display: flex; align-items: center; justify-content: center;
  color: var(--usp-blue);
}
.usp-card-title {
  font-family: var(--usp-font-head); font-size: 13px;
  font-weight: 800; color: var(--usp-text); margin-bottom: 5px;
}
.usp-card-desc { font-size: 11.5px; color: var(--usp-text-light); line-height: 1.6; }

/* HOW IT WORKS STEPS */
.usp-steps { margin-top: 52px; }
.usp-steps-head { text-align: center; margin-bottom: 32px; }
.usp-steps-head h2 {
  font-family: var(--usp-font-head); font-size: 20px;
  font-weight: 900; color: var(--usp-text); margin: 0 0 8px;
}
.usp-steps-head p { font-size: 13px; color: var(--usp-text-light); margin: 0; }

.usp-steps-wrap {
  background: #fff; border: 1.5px solid var(--usp-border);
  border-radius: 18px; padding: 40px 28px;
}
.usp-steps-row {
  display: flex; align-items: flex-start; gap: 0;
  width: 100%;
}
.usp-step {
  flex: 1; display: flex; flex-direction: column;
  align-items: center; text-align: center;
  padding: 0 6px; min-width: 0;
}
.usp-step-connector {
  flex-shrink: 0; padding-top: 26px;
  color: #d1d5db; display: flex; align-items: flex-start;
}
.usp-step-circle {
  width: 62px; height: 62px; border-radius: 50%;
  border: 2px solid var(--usp-border); background: #fff;
  display: flex; align-items: center; justify-content: center;
  color: var(--usp-blue); margin-bottom: 14px;
  box-shadow: 0 4px 14px rgba(13,33,79,.07);
  position: relative; flex-shrink: 0;
  transition: border-color .2s, box-shadow .2s;
}
.usp-step:hover .usp-step-circle {
  border-color: var(--usp-gold);
  box-shadow: 0 6px 20px rgba(245,166,35,.20);
}
.usp-step-num {
  position: absolute; top: -6px; right: -6px;
  width: 20px; height: 20px; border-radius: 50%;
  background: var(--usp-blue); color: #fff;
  font-size: 10px; font-weight: 800;
  font-family: var(--usp-font-body);
  display: flex; align-items: center; justify-content: center;
}
.usp-step-title {
  font-family: var(--usp-font-head); font-size: 11.5px;
  font-weight: 900; color: var(--usp-text);
  margin-bottom: 6px; text-transform: uppercase; letter-spacing: .5px;
}
.usp-step-desc {
  font-size: 11px; color: var(--usp-text-light);
  line-height: 1.6; max-width: 120px; margin: 0 auto;
}

/* SCAN TYPES */
.usp-scans { margin-top: 52px; scroll-margin-top: 90px; }
.usp-scans-head { text-align: center; margin-bottom: 24px; }
.usp-scans-head h2 {
  font-family: var(--usp-font-head); font-size: 20px;
  font-weight: 900; color: var(--usp-text); margin: 0 0 8px;
}
.usp-scans-head p { font-size: 13px; color: var(--usp-text-light); margin: 0; }
.usp-scans-grid {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;
}
.usp-scan-card {
  background: #fff; border: 1.5px solid var(--usp-border);
  border-radius: 14px; padding: 18px 16px;
  display: flex; align-items: flex-start; gap: 12px;
  transition: transform .2s, box-shadow .2s, border-color .2s;
  scroll-margin-top: 90px;
}
.usp-scan-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(13,33,79,.08);
  border-color: rgba(29,63,143,.20);
}
.usp-scan-card:target { border-color: var(--usp-blue); box-shadow: 0 8px 24px rgba(13,33,79,.12); }
.usp-scan-icon {
  width: 38px; height: 38px; border-radius: 10px;
  background: rgba(29,63,143,.07);
  display: flex; align-items: center; justify-content: center;
  color: var(--usp-blue); flex-shrink: 0;
}
.usp-scan-name {
  font-family: var(--usp-font-head); font-size: 13px;
  font-weight: 800; color: var(--usp-text); margin-bottom: 3px;
}
.usp-scan-desc { font-size: 11.5px; color: var(--usp-text-light); line-height: 1.5; }

.usp-scan-book {
  display: inline-block;
  margin-top: 8px;
  padding: 4px 12px;
  font-size: 10.5px;
  font-weight: 800;
  font-family: var(--usp-font-body);
  color: var(--usp-blue);
  background: rgba(29,63,143,.08);
  border: 1px solid rgba(29,63,143,.20);
  border-radius: 50px;
  text-decoration: none;
  white-space: nowrap;
  transition: background .18s, color .18s, transform .18s;
}
.usp-scan-book:hover {
  background: var(--usp-blue);
  color: #fff;
  transform: translateY(-1px);
}

/* BOOKING STRIP */
.usp-booking {
  margin-top: 44px; background: var(--usp-bg-soft);
  border: 1.5px solid var(--usp-border); border-radius: 16px;
  padding: 28px 24px;
  display: flex; align-items: center;
  justify-content: space-between; gap: 20px; flex-wrap: wrap;
  scroll-margin-top: 90px;
}
.usp-booking-text h3 {
  font-family: var(--usp-font-head); font-size: 16px;
  font-weight: 900; color: var(--usp-text); margin: 0 0 5px;
}
.usp-booking-text p { font-size: 12.5px; color: var(--usp-text-light); margin: 0; }

/* SEO CONTENT + FAQ */
.usp-seo { margin-top: 44px; background: var(--usp-bg-soft); border: 1.5px solid var(--usp-border); border-radius: 16px; padding: 28px; }
.usp-seo h2 { font-family: var(--usp-font-head); font-size: 19px; font-weight: 900; color: var(--usp-text); margin: 0 0 10px; }
.usp-seo > p { font-size: 13.5px; line-height: 1.8; color: var(--usp-text-light); margin: 0 0 14px; max-width: 900px; }
.usp-seo h3.usp-sub { font-family: var(--usp-font-head); font-size: 14.5px; font-weight: 800; color: var(--usp-blue); margin: 22px 0 10px; }

.usp-type-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
.usp-type-box { background: #fff; border: 1.5px solid var(--usp-border); border-radius: 12px; padding: 16px; }
.usp-type-box h3 { font-family: var(--usp-font-head); font-size: 14px; font-weight: 800; color: var(--usp-blue); margin: 0 0 6px; }
.usp-type-box p { font-size: 12.5px; line-height: 1.7; color: var(--usp-text-light); margin: 0; }

.usp-chip { display: inline-block; padding: 7px 12px; border: 1.5px solid #e0e4ec; border-radius: 50px; background: #fff; font-size: 12px; font-weight: 700; color: var(--usp-blue); text-decoration: none; transition: background .2s, border-color .2s; }
.usp-chip:hover { background: #eef1f8; border-color: var(--usp-blue); }

/* Keyphrase chips — DESKTOP: normal wrapped chips, no movement.
   The duplicate group only exists for the mobile loop, so it is hidden here. */
.usp-marq-group { display: flex; flex-wrap: wrap; gap: 8px; }
.usp-marq-group[aria-hidden="true"] { display: none; }

.usp-ppb { margin-top: 18px; padding: 12px 16px; border: 1.5px solid #e0e4ec; border-radius: 10px; background: #fff; font-size: 13px; font-weight: 700; color: var(--usp-text); }

.usp-faq { margin-top: 24px; background: #fff; border: 1.5px solid var(--usp-border); border-radius: 16px; padding: 28px; }
.usp-faq h2 { font-family: var(--usp-font-head); font-size: 19px; font-weight: 900; color: var(--usp-text); margin: 0 0 8px; }
.usp-faq-item { border-bottom: 1px solid var(--usp-border); padding: 14px 0; }
.usp-faq-item summary { font-weight: 700; font-size: 14px; cursor: pointer; color: var(--usp-text); }
.usp-faq-item p { font-size: 13.5px; line-height: 1.7; color: var(--usp-text-light); margin: 10px 0 0; }

/* LICENSE */
.usp-license {
  margin-top: 24px; text-align: center;
  font-size: 11.5px; color: var(--usp-text-light); letter-spacing: .3px;
}
.usp-license strong { color: var(--usp-text); }

/* RESPONSIVE */
@media (max-width: 900px) {
  .usp-grid { grid-template-columns: repeat(2, 1fr); }
  .usp-scans-grid { grid-template-columns: repeat(2, 1fr); }
  .usp-steps-row { flex-wrap: wrap; justify-content: center; gap: 24px; }
  .usp-step { flex: 0 0 calc(33.333% - 16px); }
  .usp-step-connector { display: none; }
  .usp-type-grid { grid-template-columns: 1fr; }

  /* ══ KEYPHRASE CHIPS — MOBILE ONLY: one row, 3 visible, the rest move slowly left ══ */
  @keyframes usp-marq-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }

  .usp-marq {
    --gap: 8px;
    --n: 3;
    container-type: inline-size;
    overflow: hidden;
    width: 100%;
  }
  .usp-marq-track {
    display: flex; width: max-content;
    animation: usp-marq-scroll 80s linear infinite;
    will-change: transform;
  }
  .usp-marq:hover .usp-marq-track,
  .usp-marq:active .usp-marq-track,
  .usp-marq:focus-within .usp-marq-track { animation-play-state: paused; }
  .usp-marq-group,
  .usp-marq-group[aria-hidden="true"] {
    display: flex; flex-wrap: nowrap; gap: var(--gap);
    padding-right: var(--gap); flex-shrink: 0;
  }
  .usp-marq-item { flex: 0 0 auto; width: calc((100cqw - var(--gap) * (var(--n) - 1)) / var(--n)); }
  .usp-marq .usp-chip {
    display: flex; align-items: center; justify-content: center; text-align: center;
    height: 100%; min-height: 54px; padding: 8px 8px;
    border-radius: 12px; font-size: 11px; line-height: 1.3;
  }

  /* Reduced motion: no movement, let people swipe instead */
  @media (prefers-reduced-motion: reduce) {
    .usp-marq { overflow-x: auto; }
    .usp-marq-track { animation: none; }
    .usp-marq-group[aria-hidden="true"] { display: none; }
  }
}
@media (max-width: 640px) {
  .usp-wrap { margin: 20px auto 40px; padding: 0 14px; }
  .usp-hero { padding: 28px 16px; border-radius: 14px; }
  .usp-title { font-size: clamp(18px, 5vw, 24px); }
  .usp-hero-desc { font-size: 12.5px; }
  .usp-btn-row { flex-direction: column; align-items: stretch; }
  .usp-btn { font-size: 12px; padding: 11px 16px; justify-content: center; }
  .usp-grid { grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 24px; }
  .usp-card { padding: 16px 10px; }
  .usp-card-icon { width: 38px; height: 38px; margin-bottom: 8px; }
  .usp-card-title { font-size: 11.5px; }
  .usp-card-desc { font-size: 10.5px; }
  .usp-steps-wrap { padding: 24px 14px; }
  .usp-steps-row { gap: 16px; }
  .usp-step { flex: 0 0 calc(50% - 8px); }
  .usp-step-circle { width: 52px; height: 52px; margin-bottom: 10px; }
  .usp-step-title { font-size: 10.5px; }
  .usp-step-desc { font-size: 10.5px; max-width: 100px; }
  .usp-scans-grid { grid-template-columns: 1fr; gap: 10px; }
  .usp-scan-card { padding: 14px; }
  .usp-scan-name { font-size: 12.5px; }
  .usp-scan-desc { font-size: 11px; }
  .usp-scan-book { font-size: 10px; padding: 4px 10px; }
  .usp-booking { flex-direction: column; align-items: stretch; text-align: center; padding: 20px 16px; }
  .usp-booking .usp-btn { width: 100%; justify-content: center; }
  .usp-seo, .usp-faq { padding: 20px; }
}
@media (max-width: 400px) {
  .usp-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
  .usp-step { flex: 0 0 calc(50% - 8px); }
  .usp-scans-grid { grid-template-columns: 1fr; }
}
</style>

<div class="usp-wrap">

  <!-- HERO (the page's one and only H1) -->
  <div class="usp-hero">
    <span class="usp-tag">Imaging Services</span>
    <h1 class="usp-title">Affordable Ultrasound Scan in Nairobi, <span>In-Store &amp; Home Visit</span></h1>
    <p class="usp-hero-desc">Professional, affordable ultrasound scanning in Nairobi, Kenya from Family Drugmart. Book an obs scan, breast, abdominal, pelvic or any other ultrasound at our pharmacy, or ask for a mobile ultrasound at your home. Safe, accurate, and no referral needed.</p>
    <div class="usp-btn-row">
      <a href="<?php echo esc_url($us_form); ?>" class="usp-btn usp-btn-primary" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Book Your Scan
      </a>
      <a href="https://wa.me/<?php echo esc_attr($us_wa); ?>?text=<?php echo urlencode('Hello Family Drugmart! I would like to book an ultrasound scan.'); ?>" class="usp-btn usp-btn-outline" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
        WhatsApp Us
      </a>
    </div>
  </div>

  <!-- FEATURE CARDS -->
  <div class="usp-grid">
    <div class="usp-card">
      <div class="usp-card-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
      <div class="usp-card-title">Home-Based Scans</div>
      <div class="usp-card-desc">Mobile ultrasound, anywhere in Nairobi.</div>
    </div>
    <div class="usp-card">
      <div class="usp-card-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/></svg></div>
      <div class="usp-card-title">In-Store Scans</div>
      <div class="usp-card-desc">Visit us at High Point Plaza, Ruaka, Nairobi.</div>
    </div>
    <div class="usp-card">
      <div class="usp-card-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L3 7v6c0 5 4 9 9 9s9-4 9-9V7l-9-5z"/></svg></div>
      <div class="usp-card-title">Licensed &amp; Professional</div>
      <div class="usp-card-desc">Certified pharmacy, qualified sonographers.</div>
    </div>
    <div class="usp-card">
      <div class="usp-card-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
      <div class="usp-card-title">Affordable &amp; Quick</div>
      <div class="usp-card-desc">Easy online booking, fast confirmation.</div>
    </div>
  </div>

  <!-- HOW IT WORKS -->
  <div class="usp-steps">
    <div class="usp-steps-head">
      <h2>How It Works</h2>
      <p>Simple, fast, and stress-free, here's what to expect.</p>
    </div>
    <div class="usp-steps-wrap">
      <div class="usp-steps-row">

        <div class="usp-step">
          <div class="usp-step-circle">
            <span class="usp-step-num">1</span>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><polyline points="9 16 11 18 15 14"/></svg>
          </div>
          <div class="usp-step-title">Book Appointment</div>
          <div class="usp-step-desc">Schedule your scan at your convenience online or via WhatsApp.</div>
        </div>

        <div class="usp-step-connector">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        </div>

        <div class="usp-step">
          <div class="usp-step-circle">
            <span class="usp-step-num">2</span>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
          </div>
          <div class="usp-step-title">Preparation</div>
          <div class="usp-step-desc">Simple guidelines shared before your scan so you're fully ready.</div>
        </div>

        <div class="usp-step-connector">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        </div>

        <div class="usp-step">
          <div class="usp-step-circle">
            <span class="usp-step-num">3</span>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="M7 10l2 2 4-4"/></svg>
          </div>
          <div class="usp-step-title">Scan Process</div>
          <div class="usp-step-desc">Our expert performs a safe, painless and professional scan.</div>
        </div>

        <div class="usp-step-connector">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        </div>

        <div class="usp-step">
          <div class="usp-step-circle">
            <span class="usp-step-num">4</span>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          </div>
          <div class="usp-step-title">Results</div>
          <div class="usp-step-desc">Images are analyzed for accurate and reliable findings.</div>
        </div>

        <div class="usp-step-connector">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        </div>

        <div class="usp-step">
          <div class="usp-step-circle">
            <span class="usp-step-num">5</span>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="10" y1="17" x2="8" y2="17"/><polyline points="12 17 14 19 18 15"/></svg>
          </div>
          <div class="usp-step-title">Report &amp; Advice</div>
          <div class="usp-step-desc">You receive your full report and professional advice.</div>
        </div>

      </div>
    </div>
  </div>

  <!-- SCAN TYPES -->
  <div class="usp-scans" id="usp-scans">
    <div class="usp-scans-head">
      <h2>Types of Ultrasound Scans in Nairobi</h2>
      <p>All scans available in-store and as home visits across Nairobi.</p>
    </div>
    <div class="usp-scans-grid">
      <?php foreach ( $USP_SCANS as $s ) : ?>
      <div class="usp-scan-card" id="scan-<?php echo esc_attr( $s[0] ); ?>">
        <div class="usp-scan-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?php echo $s[4]; ?></svg></div>
        <div>
          <div class="usp-scan-name"><?php echo esc_html( $s[1] ); ?></div>
          <div class="usp-scan-desc"><?php echo esc_html( $s[2] ); ?></div>
          <a href="<?php echo esc_url($us_form); ?>" class="usp-scan-book" target="_blank" rel="noopener">Book Now</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- BOOKING STRIP -->
  <div class="usp-booking" id="usp-book">
    <div class="usp-booking-text">
      <h3>Ready to book your ultrasound scan?</h3>
      <p>Fill our short form and we'll confirm your appointment by WhatsApp.</p>
    </div>
    <a href="<?php echo esc_url($us_form); ?>" class="usp-btn usp-btn-blue" target="_blank" rel="noopener">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Book Now
    </a>
  </div>

  <!-- SEO CONTENT -->
  <section class="usp-seo">
    <h2>Affordable, Professional Ultrasound Services in Nairobi, Kenya</h2>
    <p>Family Drugmart Kenya is a PPB licensed pharmacy offering affordable ultrasound scans in Nairobi. Whether you are looking for the best ultrasound services in Nairobi, a professional sonographer, or a cheap ultrasound near you, you can book an in-store scan at <?php echo esc_html( $usp_addr ); ?> or a mobile ultrasound at your home anywhere in Nairobi. No referral is needed, and we share simple preparation guidelines before your scan.</p>

    <h3 class="usp-sub">Ultrasound scan types explained</h3>
    <div class="usp-type-grid">
      <?php foreach ( $USP_SCANS as $s ) : ?>
        <div class="usp-type-box">
          <h3><?php echo esc_html( $s[1] ); ?> Nairobi</h3>
          <p><?php echo esc_html( $s[3] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <h3 class="usp-sub">Popular ultrasound searches in Nairobi &amp; Kenya</h3>

    <!-- Desktop: normal wrapped chips (no movement).
         Mobile: ONE row, 3 visible, the rest move slowly to the left. -->
    <div class="usp-marq" aria-label="Ultrasound services">
      <div class="usp-marq-track">
        <?php for ( $pass = 0; $pass < 2; $pass++ ) : $is_dup = ( $pass === 1 ); ?>
        <div class="usp-marq-group"<?php echo $is_dup ? ' aria-hidden="true"' : ''; ?>>
          <?php foreach ( $USP_CHIPS as $c ) : ?>
            <div class="usp-marq-item">
              <a class="usp-chip" href="<?php echo esc_attr( $c[1] ); ?>"<?php echo $is_dup ? ' tabindex="-1"' : ''; ?>><?php echo esc_html( $c[0] ); ?></a>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endfor; ?>
      </div>
    </div>

    <div class="usp-ppb">Pharmacy and Poisons Board (PPB) Kenya License No: <?php echo esc_html( $USP_PPB ); ?></div>
  </section>

  <!-- FAQ -->
  <section class="usp-faq">
    <h2>Ultrasound Scan Nairobi FAQs</h2>
    <?php foreach ( $USP_FAQS as $f ) : ?>
      <details class="usp-faq-item">
        <summary><?php echo esc_html( $f['q'] ); ?></summary>
        <p><?php echo esc_html( $f['a'] ); ?></p>
      </details>
    <?php endforeach; ?>
  </section>

  <!-- LICENSE -->
  <div class="usp-license">
    Licensed by the Pharmacy and Poisons Board of Kenya &middot; <strong>PPB Reg No: <?php echo esc_html( $USP_PPB ); ?></strong>
  </div>

</div>

<?php get_footer(); ?>