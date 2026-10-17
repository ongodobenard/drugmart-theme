<?php
/**
 * Template Name: Submit Prescription
 * SEO: Upload Prescription Online Kenya | Family Drugmart
 */

if ( ! defined('ABSPATH') ) { die(); }

/* ══════════════════════════════════════════════════════════════
   SEO — runs BEFORE get_header() so wp_head can output it.
   If an SEO plugin is active (you use Yoast), these tags are skipped:
   set the title/description in the Yoast box under this page instead.
   ══════════════════════════════════════════════════════════════ */
$RXP_SEO_TITLE  = 'Upload Prescription Online Kenya | Prescribed Drugs Nairobi | Family Drugmart';
$RXP_SEO_DESC   = 'Upload your prescription online in Kenya. Licensed pharmacist review, same day delivery in Nairobi, next day to other counties. PPB licensed pharmacy in Ruaka.';
$RXP_PPB        = 'PPB/F/3208';

$rxp_has_seo_plugin = defined( 'WPSEO_VERSION' )          // Yoast
    || defined( 'RANK_MATH_VERSION' )                     // Rank Math
    || defined( 'AIOSEO_VERSION' )                        // All in One SEO
    || defined( 'SEOPRESS_VERSION' )                      // SEOPress
    || defined( 'THE_SEO_FRAMEWORK_VERSION' );            // The SEO Framework

if ( ! $rxp_has_seo_plugin ) {

    add_filter( 'pre_get_document_title', function ( $title ) use ( $RXP_SEO_TITLE ) {
        return is_page() ? $RXP_SEO_TITLE : $title;
    }, 99 );

    add_action( 'wp_head', function () use ( $RXP_SEO_DESC, $RXP_SEO_TITLE ) {
        if ( ! is_page() ) return;
        $url = get_permalink();
        echo '<meta name="description" content="' . esc_attr( $RXP_SEO_DESC ) . '">' . "\n";
        echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr( $RXP_SEO_TITLE ) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr( $RXP_SEO_DESC ) . '">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    }, 1 );

}

get_header();

$rxp_phone = function_exists('medicare_phone') ? medicare_phone() : '+254 796140021';
$rxp_wa    = function_exists('medicare_wa')    ? medicare_wa()    : '254796140021';
$rxp_addr  = function_exists('medicare_address') ? medicare_address() : 'High Point Plaza, along Ruaka-Banana Road';
$rxp_shop  = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop');

/* Category link helper (same logic as the front page; guarded so it never clashes) */
if ( ! function_exists('fd_cat_url') ) :
function fd_cat_url( array $frags ) {
    foreach ( $frags as $slug ) {
        $t = get_term_by( 'slug', $slug, 'product_cat' );
        if ( $t && ! is_wp_error($t) ) return get_term_link($t);
    }
    $all = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'number' => 200]);
    if ( ! is_wp_error($all) ) {
        foreach ( $all as $t ) {
            foreach ( $frags as $f ) {
                if ( stripos($t->name, $f) !== false ) return get_term_link($t);
            }
        }
    }
    return function_exists('wc_get_page_id')
        ? get_permalink( wc_get_page_id('shop') )
        : home_url('/shop/');
}
endif;

/* Prescription categories (from functions.php) with local keyphrases */
$RXP_CATS = [
    [ 'Prescription medicines Ruaka',                    ['prescription'] ],
    [ 'Blood pressure medicine Nairobi',                 ['blood-pressure-medicine','hypertension'] ],
    [ 'Heart and cardiovascular medicines Kenya',        ['cardiovascular-and-cerebrovascular'] ],
    [ 'Diabetes and weight loss medicines Nairobi',      ['diabetes','weight-management'] ],
    [ 'Vaccines and immunization Nairobi',               ['vaccins-and-immunization'] ],
    [ 'Antibiotics and anti-infectives Kenya',           ['anti-infective'] ],
    [ 'Brain and nervous system medicines Kenya',        ['brain-and-nervous-system-disorder'] ],
    [ 'Hormonal and steroid medicines Kenya',            ['hormonal-and-steroids'] ],
    [ 'Kidney (renal) care Kenya',                       ['renal-wellbeing'] ],
    [ 'Digestive health medicines Nairobi',              ['digestive-system'] ],
    [ 'Reproductive health and sexual wellness Nairobi', ['reproductive-health-and-sexual-wellness'] ],
    [ 'Oncology (cancer care) medicines Kenya',          ['oncology'] ],
];

/* Resolve chip URLs once (the chips are printed twice for the mobile loop) */
$RXP_CHIP_LINKS = [];
foreach ( $RXP_CATS as $c ) {
    $RXP_CHIP_LINKS[] = [ $c[0], fd_cat_url( $c[1] ) ];
}

$RXP_FAQS = [
    [ 'q' => 'Can I upload my prescription online in Kenya?',
      'a' => 'Yes. Fill in the form on this page, attach a clear photo, PDF or Word copy of your prescription, and submit it. Our licensed pharmacist reviews it and contacts you by phone, WhatsApp or email.' ],
    [ 'q' => 'Do I need a valid prescription to order prescribed drugs?',
      'a' => 'Yes. We can only process prescription medicines with a valid prescription signed by a licensed medical practitioner. Over-the-counter products can be ordered from our shop without one.' ],
    [ 'q' => 'Which medicines need a prescription at Family Drugmart Kenya?',
      'a' => 'Prescription medicines include blood pressure, heart, antibiotic, hormonal, brain and nervous system, kidney, vaccine, cancer care, and diabetes and weight loss medicines such as Ozempic, Mounjaro, Wegovy and Rybelsus. Availability and prices are confirmed by our pharmacist.' ],
    [ 'q' => 'How fast is prescription delivery in Nairobi?',
      'a' => 'Verified prescriptions are delivered the same day within Nairobi and the next day to other counties. In Nairobi, delivery is KES 300 and free for orders from KES 2,500. For other counties, contact us on WhatsApp for your county rate.' ],
    [ 'q' => 'What file types can I upload?',
      'a' => 'You can upload JPG, PNG, PDF or Word files up to 10MB. Make sure the doctor\'s name, signature, date and medicine names are clearly visible.' ],
    [ 'q' => 'Where is your pharmacy located?',
      'a' => 'We are at ' . $rxp_addr . ', serving Ruaka, Banana, Kiambu and Nairobi. We are licensed by the Pharmacy and Poisons Board (PPB), License No: ' . $RXP_PPB . '.' ],
];

$rxp_faq_schema = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map( function ( $f ) {
        return [ '@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => [ '@type' => 'Answer', 'text' => $f['a'] ] ];
    }, $RXP_FAQS ),
];
?>

<script type="application/ld+json"><?php echo wp_json_encode( $rxp_faq_schema, JSON_UNESCAPED_SLASHES ); ?></script>

<style>
:root {
  --rxp-blue:        #1d3f8f;
  --rxp-blue-dark:   #15306e;
  --rxp-blue-darker: #0e2358;
  --rxp-blue-navy:   #0a1228;
  --rxp-gold:        #f5a623;
  --rxp-text:        #1b2230;
  --rxp-text-light:  #6b7280;
  --rxp-bg-soft:     #f7f8fa;
  --rxp-font-head:   'Nunito', sans-serif;
  --rxp-font-body:   'Lato', sans-serif;
}

* { box-sizing: border-box; }

/* Flex column so the blocks can be re-ordered on mobile (form right after the hero) */
.rxp-wrap {
  max-width: 1100px;
  margin: 40px auto 60px;
  padding: 0 24px;
  font-family: var(--rxp-font-body);
  overflow-x: hidden;
  display: flex;
  flex-direction: column;
}

/* ── HERO ── */
.rxp-hero {
  background: rgba(14,35,88,.92);
  border: 1px solid rgba(245,166,35,.25);
  border-top: 3px solid var(--rxp-gold);
  border-radius: 20px;
  padding: 48px 40px;
  text-align: center;
}
.rxp-title {
  font-family: var(--rxp-font-head);
  font-size: clamp(22px, 4vw, 32px);
  font-weight: 900;
  color: #fff;
  margin: 0 0 10px;
  line-height: 1.25;
}
.rxp-title span { color: var(--rxp-gold); }
.rxp-hero-desc {
  font-size: 13.5px;
  color: rgba(255,255,255,.70);
  line-height: 1.7;
  max-width: 560px;
  margin: 0 auto;
}

/* ── PRESCRIPTION-ONLY NOTICE ── */
.rxp-notice {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  background: #eef1f8;
  border: 1.5px solid #c7d2e8;
  border-radius: 14px;
  padding: 18px 22px;
  margin-top: 20px;
}
/* Plain icon: no box / badge behind it */
.rxp-notice-icon {
  width: 24px; height: 24px;
  background: none;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  color: var(--rxp-blue);
  margin-top: 1px;
}
.rxp-notice p {
  font-size: 12.5px;
  color: var(--rxp-text);
  line-height: 1.7;
  margin: 0;
}
.rxp-notice strong { color: var(--rxp-blue-darker); }
.rxp-notice a { color: var(--rxp-blue); font-weight: 800; text-decoration: underline; }

/* ── HOW IT WORKS ── */
.rxp-how { margin-top: 40px; }
.rxp-how-head { text-align: center; margin-bottom: 22px; }
.rxp-how-head h2 {
  font-family: var(--rxp-font-head);
  font-size: 19px;
  font-weight: 900;
  color: var(--rxp-text);
  margin: 0;
}
.rxp-how-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}
.rxp-how-card {
  background: var(--rxp-bg-soft);
  border: 1.5px solid #edf0f5;
  border-radius: 14px;
  padding: 20px 16px;
  text-align: center;
}
/* Plain number: no badge / box */
.rxp-how-num {
  margin: 0 0 6px;
  background: none;
  color: var(--rxp-blue);
  font-family: var(--rxp-font-head);
  font-weight: 900;
  font-size: 28px;
  line-height: 1;
}
.rxp-how-title {
  font-family: var(--rxp-font-head);
  font-size: 13px;
  font-weight: 800;
  color: var(--rxp-text);
  margin-bottom: 6px;
}
.rxp-how-desc {
  font-size: 11.5px;
  color: var(--rxp-text-light);
  line-height: 1.6;
}

/* ── FORM SECTION ── */
.rxp-section {
  margin-top: 44px;
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: 40px;
  align-items: start;
}

/* ── IMAGE — FANCY FRAME ── */
.rxp-img-col { position: relative; }
.rxp-img-frame {
  position: relative;
  background: linear-gradient(160deg, #eef1f8, #f7f8fa);
  border-radius: 22px;
  padding: 18px;
  border: 1.5px solid #e3e8f2;
}
.rxp-img-frame::before,
.rxp-img-frame::after {
  content: '';
  position: absolute;
  width: 28px; height: 28px;
  border-color: var(--rxp-gold);
  border-style: solid;
}
.rxp-img-frame::before {
  top: -1px; left: -1px;
  border-width: 3px 0 0 3px;
  border-top-left-radius: 14px;
}
.rxp-img-frame::after {
  bottom: -1px; right: -1px;
  border-width: 0 3px 3px 0;
  border-bottom-right-radius: 14px;
}
.rxp-img-wrap {
  border-radius: 14px;
  overflow: hidden;
}
.rxp-img-wrap img {
  width: 100%;
  height: auto;
  display: block;
  object-fit: cover;
}
.rxp-img-badge {
  position: relative;
  margin: -26px 16px 0;
  background: var(--rxp-blue-darker);
  border: 1px solid rgba(245,166,35,.30);
  border-radius: 14px;
  padding: 14px 18px;
  text-align: center;
  box-shadow: 0 10px 28px rgba(14,35,88,.25);
}
.rxp-img-badge h3 {
  font-family: var(--rxp-font-head);
  font-size: 14px;
  font-weight: 900;
  color: #fff;
  margin: 0 0 3px;
}
.rxp-img-badge p {
  font-size: 11.5px;
  color: rgba(255,255,255,.70);
  font-weight: 600;
  margin: 0;
}

/* ── FORM CARD ── */
.rxp-form-card {
  background: #fff;
  border: 1.5px solid #edf0f5;
  border-radius: 16px;
  padding: 28px;
}
.rxp-form-title {
  font-family: var(--rxp-font-head);
  font-size: 16.5px;
  font-weight: 900;
  color: var(--rxp-text);
  margin: 0 0 4px;
}
.rxp-form-sub {
  font-size: 12.5px;
  color: var(--rxp-text-light);
  margin-bottom: 18px;
  line-height: 1.6;
}
.rxp-form-section-label {
  font-family: var(--rxp-font-head);
  font-size: 13px;
  font-weight: 900;
  color: var(--rxp-blue);
  text-transform: uppercase;
  letter-spacing: .5px;
  margin: 0 0 14px;
  padding-bottom: 8px;
  border-bottom: 1.5px solid #edf0f5;
}
.rxp-form-section-label.rxp-optional-label {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  gap: 8px;
}
/* Plain text: no pill / badge */
.rxp-form-section-label .rxp-optional-tag {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .3px;
  text-transform: none;
  color: var(--rxp-text-light);
}

.fg { position: relative; margin-bottom: 14px; min-width: 0; }
.fg label {
  display: block;
  font-size: 12px;
  font-weight: 800;
  color: var(--rxp-text-light);
  margin-bottom: 5px;
}
.fg label .req { color: var(--rxp-gold); margin-left: 2px; }
.fg label .opt { font-size: 10.5px; font-weight: 600; opacity: .55; text-transform: none; letter-spacing: 0; }
.fg input, .fg select {
  width: 100%;
  padding: 10px 13px;
  border: 1.5px solid #e0e4ec;
  border-radius: 8px;
  font-size: 13px;
  font-family: var(--rxp-font-body);
  color: var(--rxp-text);
  outline: none;
  transition: border-color .2s, box-shadow .2s;
  background: #fff;
}
.fg input:focus, .fg select:focus {
  border-color: var(--rxp-blue);
  box-shadow: 0 0 0 3px rgba(29,63,143,.10);
}
.fg.invalid input, .fg.invalid select, .fg.invalid .rxp-gender-wrap, .fg.invalid .rxp-file-box {
  border-color: #e53935 !important;
  box-shadow: 0 0 0 3px rgba(229,57,53,.10) !important;
}
.fg .error-msg {
  font-size: 11px;
  color: #e53935;
  font-weight: 700;
  margin-top: 4px;
  display: none;
}
.fg.invalid .error-msg { display: block; }
.fg.valid input, .fg.valid select { border-color: #2eaf6e !important; }

.form-row {
  display: grid;
  grid-template-columns: minmax(0,1fr) minmax(0,1fr);
  gap: 12px;
}

.rxp-gender-wrap {
  display: flex;
  gap: 18px;
  padding: 10px 13px;
  border: 1.5px solid #e0e4ec;
  border-radius: 8px;
}
.rxp-gender-opt {
  display: flex; align-items: center; gap: 7px;
  font-size: 13px; font-weight: 700; color: var(--rxp-text);
  cursor: pointer;
}
.rxp-gender-opt input { width: 16px; height: 16px; accent-color: var(--rxp-blue); cursor: pointer; }

/* ── HEALTH INFO CHOICE GROUPS ── */
.rxp-choice-wrap {
  display: flex;
  flex-wrap: wrap;
  gap: 8px 16px;
  padding: 10px 13px;
  border: 1.5px solid #e0e4ec;
  border-radius: 8px;
  background: #fff;
}
.rxp-choice-opt {
  display: flex; align-items: center; gap: 7px;
  font-size: 12.5px; font-weight: 700; color: var(--rxp-text);
  cursor: pointer;
  white-space: nowrap;
}
.rxp-choice-opt input { width: 15px; height: 15px; accent-color: var(--rxp-blue); cursor: pointer; }

.rxp-health-grid {
  display: grid;
  grid-template-columns: minmax(0,1fr) minmax(0,1fr);
  gap: 12px 16px;
}

.rxp-file-box {
  border: 1.5px dashed #c7d2e8;
  border-radius: 10px;
  padding: 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
  background: var(--rxp-bg-soft);
  transition: border-color .2s, background .2s;
}
.rxp-file-box:hover { border-color: var(--rxp-blue); background: #eef1f8; }
.rxp-file-box input[type="file"] { display: none; }
/* Plain icon: no box / badge behind it */
.rxp-file-icon {
  width: 26px; height: 26px;
  background: none;
  display: flex; align-items: center; justify-content: center;
  color: var(--rxp-blue);
  flex-shrink: 0;
}
.rxp-file-text { min-width: 0; }
.rxp-file-text span {
  display: block;
  font-size: 12.5px;
  font-weight: 700;
  color: var(--rxp-text);
}
.rxp-file-text small {
  display: block;
  font-size: 10.5px;
  color: var(--rxp-text-light);
  margin-top: 2px;
}
#rxpFileName {
  font-size: 11.5px;
  color: var(--rxp-blue);
  font-weight: 800;
  margin-top: 6px;
  word-break: break-word;
}

.rxp-submit-btn {
  width: 100%;
  padding: 12px;
  background: var(--rxp-blue);
  color: #fff;
  border: none;
  border-radius: 6px;
  font-size: 13.5px;
  font-weight: 800;
  font-family: var(--rxp-font-head);
  cursor: pointer;
  margin-top: 6px;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: background .2s, transform .15s;
}
.rxp-submit-btn:hover { background: var(--rxp-blue-dark); transform: translateY(-1px); }
.rxp-submit-btn:disabled { opacity: .65; cursor: default; transform: none; }

.rxp-subnote {
  text-align: center;
  font-size: 11px;
  color: var(--rxp-text-light);
  font-weight: 700;
  margin-top: 10px;
}

.rxp-toast {
  display: flex; align-items: flex-start; gap: 9px;
  border-radius: 10px; font-size: 12.5px; font-weight: 700;
  line-height: 1.5; border: 1.5px solid transparent;
  opacity: 0; max-height: 0; overflow: hidden; padding: 0 16px;
  pointer-events: none;
  transition: opacity .3s ease, max-height .4s ease, padding .4s ease, margin-top .4s ease;
}
.rxp-toast.show { opacity: 1; max-height: 200px; padding: 13px 16px; margin-top: 14px; pointer-events: auto; }
.rxp-toast svg { flex-shrink: 0; margin-top: 1px; }
.rxp-toast span { min-width: 0; word-break: break-word; }
.rxp-toast-success { background: #edfaf3; color: #1a6e44; border-color: #6fcf97; }
.rxp-toast-error   { background: #fff0f0; color: #b71c1c; border-color: #ef9a9a; }

@keyframes rxpSpin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

/* ── SEO CONTENT + FAQ ── */
.rxp-seo { margin-top: 44px; background: var(--rxp-bg-soft); border: 1.5px solid #edf0f5; border-radius: 16px; padding: 28px; }
.rxp-seo h2 { font-family: var(--rxp-font-head); font-size: 19px; font-weight: 900; color: var(--rxp-text); margin: 0 0 10px; }
.rxp-seo p  { font-size: 13.5px; line-height: 1.8; color: var(--rxp-text-light); margin: 0 0 14px; max-width: 900px; }
.rxp-seo h3 { font-family: var(--rxp-font-head); font-size: 14.5px; font-weight: 800; color: var(--rxp-blue); margin: 18px 0 8px; }
.rxp-chip  { display: inline-block; padding: 7px 12px; border: 1.5px solid #e0e4ec; border-radius: 50px; background: #fff; font-size: 12px; font-weight: 700; color: var(--rxp-blue); text-decoration: none; transition: background .2s, border-color .2s; }
.rxp-chip:hover { background: #eef1f8; border-color: var(--rxp-blue); }

/* Category chips — DESKTOP: normal wrapped chips, no movement.
   The second (duplicate) group only exists for the mobile loop, so it is hidden here. */
.rxp-marq-group { display: flex; flex-wrap: wrap; gap: 8px; }
.rxp-marq-group[aria-hidden="true"] { display: none; }

.rxp-ppb { margin-top: 18px; padding: 12px 16px; border: 1.5px solid #e0e4ec; border-radius: 10px; background: #fff; font-size: 13px; font-weight: 700; color: var(--rxp-text); }

.rxp-faq { margin-top: 24px; background: #fff; border: 1.5px solid #edf0f5; border-radius: 16px; padding: 28px; }
.rxp-faq h2 { font-family: var(--rxp-font-head); font-size: 19px; font-weight: 900; color: var(--rxp-text); margin: 0 0 8px; }
.rxp-faq-item { border-bottom: 1px solid #edf0f5; padding: 14px 0; }
.rxp-faq-item summary { font-weight: 700; font-size: 14px; cursor: pointer; color: var(--rxp-text); }
.rxp-faq-item p { font-size: 13.5px; line-height: 1.7; color: var(--rxp-text-light); margin: 10px 0 0; }

/* ── RESPONSIVE ──
   On tablet / mobile the order becomes:
   hero  ->  FORM  ->  image  ->  notice  ->  how it works  ->  info  ->  FAQ */
@media (max-width: 900px) {
  .rxp-hero     { order: 1; }
  .rxp-section  { order: 2; grid-template-columns: minmax(0,1fr); margin-top: 20px; gap: 24px; }
  .rxp-notice   { order: 3; margin-top: 28px; }
  .rxp-how      { order: 4; margin-top: 28px; }
  .rxp-seo      { order: 5; margin-top: 28px; }
  .rxp-faq      { order: 6; }

  .rxp-form-card { order: 1; }
  .rxp-img-col   { order: 2; }

  .rxp-how-grid { grid-template-columns: repeat(2, 1fr); }

  /* ══ CATEGORY CHIPS — MOBILE ONLY: one row, 3 visible, the rest move slowly left ══ */
  @keyframes rxp-marq-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }

  .rxp-marq {
    --gap: 8px;
    --n: 3;
    container-type: inline-size;
    overflow: hidden;
    width: 100%;
  }
  .rxp-marq-track {
    display: flex; width: max-content;
    animation: rxp-marq-scroll 60s linear infinite;
    will-change: transform;
  }
  .rxp-marq:hover .rxp-marq-track,
  .rxp-marq:active .rxp-marq-track,
  .rxp-marq:focus-within .rxp-marq-track { animation-play-state: paused; }
  .rxp-marq-group,
  .rxp-marq-group[aria-hidden="true"] {
    display: flex; flex-wrap: nowrap; gap: var(--gap);
    padding-right: var(--gap); flex-shrink: 0;
  }
  .rxp-marq-item { flex: 0 0 auto; width: calc((100cqw - var(--gap) * (var(--n) - 1)) / var(--n)); }
  .rxp-marq .rxp-chip {
    display: flex; align-items: center; justify-content: center; text-align: center;
    height: 100%; min-height: 54px; padding: 8px 8px;
    border-radius: 12px; font-size: 11px; line-height: 1.3;
  }

  /* Reduced motion: no movement, let people swipe instead */
  @media (prefers-reduced-motion: reduce) {
    .rxp-marq { overflow-x: auto; }
    .rxp-marq-track { animation: none; }
    .rxp-marq-group[aria-hidden="true"] { display: none; }
  }
}
@media (max-width: 640px) {
  .rxp-wrap { margin: 24px auto 40px; padding: 0 16px; }
  .rxp-hero { padding: 32px 20px; border-radius: 16px; }
  .rxp-hero-desc { font-size: 12.5px; }
  .rxp-form-card { padding: 20px; }
  .rxp-seo, .rxp-faq { padding: 20px; }
  .form-row { grid-template-columns: minmax(0,1fr); }
  .rxp-how-grid { grid-template-columns: 1fr 1fr; }
  .rxp-health-grid { grid-template-columns: minmax(0,1fr); }
  .rxp-choice-wrap { gap: 8px 12px; }
}
</style>

<div class="rxp-wrap">

  <!-- HERO (the page's one and only H1) -->
  <div class="rxp-hero">
    <h1 class="rxp-title">Upload Your <span>Prescription</span> Online in Kenya</h1>
    <p class="rxp-hero-desc">Order prescribed drugs from a trusted, PPB licensed pharmacy in Ruaka, Nairobi. Upload your prescription and we'll prepare and deliver your medication, same day within Nairobi, next day to counties outside Nairobi.</p>
  </div>

  <!-- PRESCRIPTION ONLY NOTICE -->
  <div class="rxp-notice">
    <div class="rxp-notice-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
    </div>
    <p><strong>Prescription Medicines Only:</strong> this form is strictly for doctor-prescribed medicines. We cannot process orders without a valid prescription signed by a licensed medical practitioner. For over-the-counter medicines, please visit our <a href="<?php echo esc_url($rxp_shop); ?>">Shop page</a>.</p>
  </div>

  <!-- HOW IT WORKS -->
  <div class="rxp-how">
    <div class="rxp-how-head"><h2>How to Order Prescription Medicine Online in Kenya</h2></div>
    <div class="rxp-how-grid">
      <div class="rxp-how-card">
        <div class="rxp-how-num">1</div>
        <div class="rxp-how-title">Fill the Form</div>
        <div class="rxp-how-desc">Enter your details and attach your prescription file.</div>
      </div>
      <div class="rxp-how-card">
        <div class="rxp-how-num">2</div>
        <div class="rxp-how-title">Submit Securely</div>
        <div class="rxp-how-desc">Your prescription is sent securely to our pharmacy team.</div>
      </div>
      <div class="rxp-how-card">
        <div class="rxp-how-num">3</div>
        <div class="rxp-how-title">We Verify</div>
        <div class="rxp-how-desc">Our licensed pharmacist reviews and verifies your prescription.</div>
      </div>
      <div class="rxp-how-card">
        <div class="rxp-how-num">4</div>
        <div class="rxp-how-title">Fast Delivery</div>
        <div class="rxp-how-desc">Delivered same day in Nairobi or next day to other counties.</div>
      </div>
    </div>
  </div>

  <!-- FORM SECTION -->
  <div class="rxp-section">

    <!-- IMAGE -->
    <div class="rxp-img-col">
      <div class="rxp-img-frame">
        <div class="rxp-img-wrap">
          <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/images/delivery.webp'); ?>" alt="Prescription medicine delivery in Nairobi by Family Drugmart Kenya" loading="lazy" decoding="async">
        </div>
      </div>
      <div class="rxp-img-badge">
        <h3>Fast, Reliable &amp; Secure Cold-Chain Delivery.</h3>
        <p>Same day Nairobi &nbsp;&middot;&nbsp; Next day countrywide</p>
      </div>
    </div>

    <!-- FORM -->
    <div class="rxp-form-card">
      <h2 class="rxp-form-title">Submit Your Prescription</h2>
      <p class="rxp-form-sub">Kindly fill the form with correct details and upload your prescription.</p>

      <form id="rxpForm" enctype="multipart/form-data" novalidate>
        <?php wp_nonce_field('rx_nonce_action', 'rx_nonce'); ?>
        <input type="hidden" name="action" value="carevee_submit_prescription">

        <div class="rxp-form-section-label">Patient Details</div>

        <div class="form-row">
          <div class="fg" id="fg_fname">
            <label>First Name <span class="req">*</span></label>
            <input type="text" name="rx_fname" id="rx_fname" placeholder="e.g. James">
            <div class="error-msg">First name is required.</div>
          </div>
          <div class="fg" id="fg_lname">
            <label>Last Name <span class="req">*</span></label>
            <input type="text" name="rx_lname" id="rx_lname" placeholder="e.g. Kamau">
            <div class="error-msg">Last name is required.</div>
          </div>
        </div>

        <div class="form-row">
          <div class="fg" id="fg_age">
            <label>Age <span class="req">*</span></label>
            <input type="number" name="rx_age" id="rx_age" placeholder="e.g. 35" min="1" max="120">
            <div class="error-msg">Please enter your age.</div>
          </div>
          <div class="fg" id="fg_gender">
            <label>Gender <span class="req">*</span></label>
            <div class="rxp-gender-wrap">
              <label class="rxp-gender-opt"><input type="radio" name="rx_gender" value="Male"> Male</label>
              <label class="rxp-gender-opt"><input type="radio" name="rx_gender" value="Female"> Female</label>
            </div>
            <div class="error-msg">Please select your gender.</div>
          </div>
        </div>

        <div class="form-row">
          <div class="fg" id="fg_phone">
            <label>Phone Number <span class="req">*</span></label>
            <input type="tel" name="rx_phone" id="rx_phone" placeholder="e.g. 0796140021">
            <div class="error-msg">Please enter your phone number.</div>
          </div>
          <div class="fg">
            <label>Email <span class="opt">(optional)</span></label>
            <input type="email" name="rx_email" id="rx_email" placeholder="e.g. james@email.com">
          </div>
        </div>

        <div class="fg" id="fg_location">
          <label>Location <span class="req">*</span></label>
          <input type="text" name="rx_location" id="rx_location" placeholder="e.g. Westlands, Nairobi">
          <div class="error-msg">Please enter your delivery location.</div>
        </div>

        <div class="fg">
          <label>Any food/drug allergies <span class="opt">(optional)</span></label>
          <input type="text" name="rx_allergies" id="rx_allergies" placeholder="e.g. Penicillin, Peanuts">
        </div>

        <!-- HEALTH INFORMATION (OPTIONAL) -->
        <div class="rxp-form-section-label rxp-optional-label">
          <span>Health Information</span>
          <span class="rxp-optional-tag">(Optional)</span>
        </div>

        <div class="rxp-health-grid">
          <div class="fg">
            <label>Pregnant</label>
            <div class="rxp-choice-wrap">
              <label class="rxp-choice-opt"><input type="radio" name="rx_pregnant" value="1st Trimester"> 1st Trimester</label>
              <label class="rxp-choice-opt"><input type="radio" name="rx_pregnant" value="2nd Trimester"> 2nd Trimester</label>
              <label class="rxp-choice-opt"><input type="radio" name="rx_pregnant" value="3rd Trimester"> 3rd Trimester</label>
              <label class="rxp-choice-opt"><input type="radio" name="rx_pregnant" value="No"> No</label>
              <label class="rxp-choice-opt"><input type="radio" name="rx_pregnant" value="N/A"> N/A</label>
            </div>
          </div>

          <div class="fg">
            <label>Breastfeeding</label>
            <div class="rxp-choice-wrap">
              <label class="rxp-choice-opt"><input type="radio" name="rx_breastfeeding" value="Yes"> Yes</label>
              <label class="rxp-choice-opt"><input type="radio" name="rx_breastfeeding" value="No"> No</label>
              <label class="rxp-choice-opt"><input type="radio" name="rx_breastfeeding" value="N/A"> N/A</label>
            </div>
          </div>

          <div class="fg">
            <label>Renal (Kidney) Function</label>
            <div class="rxp-choice-wrap">
              <label class="rxp-choice-opt"><input type="radio" name="rx_renal" value="Normal"> Normal</label>
              <label class="rxp-choice-opt"><input type="radio" name="rx_renal" value="Problem"> Problem</label>
              <label class="rxp-choice-opt"><input type="radio" name="rx_renal" value="N/A"> N/A</label>
            </div>
          </div>

          <div class="fg">
            <label>Liver Function</label>
            <div class="rxp-choice-wrap">
              <label class="rxp-choice-opt"><input type="radio" name="rx_liver" value="Normal"> Normal</label>
              <label class="rxp-choice-opt"><input type="radio" name="rx_liver" value="Problem"> Problem</label>
              <label class="rxp-choice-opt"><input type="radio" name="rx_liver" value="N/A"> N/A</label>
            </div>
          </div>
        </div>

        <div class="rxp-form-section-label">Prescription File</div>

        <div class="fg" id="fg_file">
          <label>Upload Prescription <span class="req">*</span></label>
          <div class="rxp-file-box" id="rxpFileBox" onclick="document.getElementById('rx_file').click()">
            <div class="rxp-file-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            </div>
            <div class="rxp-file-text">
              <span>Click to select your prescription file</span>
              <small>JPG, PNG, PDF or Word &mdash; Max 10MB</small>
            </div>
            <input type="file" id="rx_file" name="rx_file" accept="image/*,.pdf,.doc,.docx,.heic,.heif,.tiff,.tif,.bmp,.webp">
          </div>
          <div id="rxpFileName"></div>
          <div class="error-msg">Please attach your prescription file.</div>
        </div>

        <button type="button" id="rxpSubmitBtn" class="rxp-submit-btn">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          Submit Prescription
        </button>
        <div class="rxp-subnote">Prescription review by licensed Pharmacist</div>

        <div class="rxp-toast rxp-toast-success" id="rxpSuccess" role="alert" aria-live="polite">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Your prescription was received! Our licensed pharmacist will review it and get back to you shortly via WhatsApp or email.</span>
        </div>

        <div class="rxp-toast rxp-toast-error" id="rxpError" role="alert" aria-live="polite">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16"/></svg>
          <span id="rxpErrorText"></span>
        </div>
      </form>
    </div>

  </div>

  <!-- SEO CONTENT -->
  <section class="rxp-seo">
    <h2>Prescribed Drugs Kenya: Trusted Pharmacy in Ruaka &amp; Nairobi</h2>
    <p>Family Drugmart Kenya is a trusted pharmacy in Kenya, based at <?php echo esc_html( $rxp_addr ); ?>. Upload your prescription online and our licensed pharmacist will review it, confirm availability and prices, and arrange delivery of your prescribed drugs in Ruaka, Nairobi and across Kenya. This includes prescriptions for diabetes and weight loss medicines such as Ozempic, Mounjaro, Wegovy and Rybelsus, which are only supplied with a valid prescription.</p>

    <h3>Prescription medicine categories</h3>

    <!-- Desktop: normal wrapped chips (no movement).
         Mobile: ONE row, 3 visible, the rest move slowly to the left. -->
    <div class="rxp-marq" aria-label="Prescription medicine categories">
      <div class="rxp-marq-track">
        <?php for ( $pass = 0; $pass < 2; $pass++ ) : $is_dup = ( $pass === 1 ); ?>
        <div class="rxp-marq-group"<?php echo $is_dup ? ' aria-hidden="true"' : ''; ?>>
          <?php foreach ( $RXP_CHIP_LINKS as $c ) : ?>
            <div class="rxp-marq-item">
              <a class="rxp-chip" href="<?php echo esc_url( $c[1] ); ?>"<?php echo $is_dup ? ' tabindex="-1"' : ''; ?>><?php echo esc_html( $c[0] ); ?></a>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endfor; ?>
      </div>
    </div>

    <div class="rxp-ppb">Pharmacy and Poisons Board (PPB) Kenya License No: <?php echo esc_html( $RXP_PPB ); ?></div>
  </section>

  <!-- FAQ -->
  <section class="rxp-faq">
    <h2>Prescription Upload FAQs Kenya</h2>
    <?php foreach ( $RXP_FAQS as $f ) : ?>
      <details class="rxp-faq-item">
        <summary><?php echo esc_html( $f['q'] ); ?></summary>
        <p><?php echo esc_html( $f['a'] ); ?></p>
      </details>
    <?php endforeach; ?>
  </section>

</div>

<script>
window.addEventListener('load', function () {

  var form = document.getElementById('rxpForm');
  if (!form) return;

  var fileInput = document.getElementById('rx_file');
  var fileNameEl = document.getElementById('rxpFileName');
  var btn = document.getElementById('rxpSubmitBtn');
  var successEl = document.getElementById('rxpSuccess');
  var errorEl = document.getElementById('rxpError');
  var errorText = document.getElementById('rxpErrorText');
  var toastTimer = null, isSending = false;

  var textFields = [
    { id: 'fg_fname',  input: 'rx_fname',  check: function(v){ return v.trim().length > 0; } },
    { id: 'fg_lname',  input: 'rx_lname',  check: function(v){ return v.trim().length > 0; } },
    { id: 'fg_age',    input: 'rx_age',    check: function(v){ return v.trim().length > 0; } },
    { id: 'fg_phone',  input: 'rx_phone',  check: function(v){ return v.trim().replace(/\s/g,'').length >= 9; } },
    { id: 'fg_location', input: 'rx_location', check: function(v){ return v.trim().length > 0; } }
  ];

  fileInput.addEventListener('change', function(){
    var fg = document.getElementById('fg_file');
    if (this.files && this.files[0]) {
      fileNameEl.textContent = 'Selected: ' + this.files[0].name;
      fg.classList.remove('invalid');
    } else {
      fileNameEl.textContent = '';
    }
  });

  textFields.forEach(function(f){
    var el = document.getElementById(f.input), fg = document.getElementById(f.id);
    if (!el || !fg) return;
    el.addEventListener('input', function(){ if (fg.classList.contains('invalid') && f.check(el.value)) fg.classList.remove('invalid'); });
    el.addEventListener('blur', function(){ fg.classList.toggle('valid', f.check(el.value)); });
  });

  document.querySelectorAll('input[name="rx_gender"]').forEach(function(r){
    r.addEventListener('change', function(){ document.getElementById('fg_gender').classList.remove('invalid'); });
  });

  function showToast(el, ms) {
    clearTimeout(toastTimer);
    successEl.classList.remove('show');
    errorEl.classList.remove('show');
    el.classList.add('show');
    toastTimer = setTimeout(function(){ el.classList.remove('show'); }, ms || 7000);
  }
  function btnLoading() {
    btn.disabled = true; isSending = true;
    btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:rxpSpin 1s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Sending...';
  }
  function btnReset() {
    btn.disabled = false; isSending = false;
    btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg> Submit Prescription';
  }
  function resetForm() {
    btnReset();
    form.reset();
    fileNameEl.textContent = '';
    textFields.forEach(function(f){ document.getElementById(f.id).classList.remove('valid','invalid'); });
    document.getElementById('fg_gender').classList.remove('invalid');
    document.getElementById('fg_file').classList.remove('invalid');
  }

  btn.addEventListener('click', function(){
    if (isSending) return;

    var valid = true, firstInvalid = null;

    textFields.forEach(function(f){
      var el = document.getElementById(f.input), fg = document.getElementById(f.id);
      var pass = f.check(el.value);
      fg.classList.toggle('invalid', !pass);
      fg.classList.toggle('valid', pass);
      if (!pass) { valid = false; if (!firstInvalid) firstInvalid = fg; }
    });

    var gender = document.querySelector('input[name="rx_gender"]:checked');
    var fgGender = document.getElementById('fg_gender');
    if (!gender) { fgGender.classList.add('invalid'); valid = false; if (!firstInvalid) firstInvalid = fgGender; }
    else { fgGender.classList.remove('invalid'); }

    var fgFile = document.getElementById('fg_file');
    if (!fileInput.files || !fileInput.files[0]) { fgFile.classList.add('invalid'); valid = false; if (!firstInvalid) firstInvalid = fgFile; }
    else { fgFile.classList.remove('invalid'); }

    if (!valid) {
      if (firstInvalid) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    btnLoading();
    var formData = new FormData(form);

    fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', { method: 'POST', body: formData })
      .then(function(r){ return r.text(); })
      .then(function(raw){
        var clean = raw.trim();
        var s = clean.indexOf('{');
        if (s > 0) clean = clean.substring(s);
        var data;
        try { data = JSON.parse(clean); }
        catch(e){
          btnReset();
          errorText.textContent = 'Server error. Please call us on <?php echo esc_js($rxp_phone); ?>.';
          showToast(errorEl, 8000);
          return;
        }
        if (data.success) {
          resetForm();
          showToast(successEl, 8000);
          btn.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
          btnReset();
          errorText.textContent = (data.data && data.data.msg) ? data.data.msg : 'Failed to send. Please call us on <?php echo esc_js($rxp_phone); ?>.';
          showToast(errorEl, 8000);
        }
      })
      .catch(function(){
        btnReset();
        errorText.textContent = 'Network error. Please check your connection and try again.';
        showToast(errorEl, 8000);
      });
  });

});
</script>

<?php get_footer(); ?>