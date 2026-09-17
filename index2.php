<?php
/**
 * Front Page Template — Nozaltah / Pharmacare
 */

if ( ! defined('ABSPATH') ) { die(); }

get_header();

if ( ! defined('PHARMACARE_URI') ) {
    define( 'PHARMACARE_URI', get_template_directory_uri() );
}

/* ══════════════════════════════════════════════════════
   HELPERS
   ══════════════════════════════════════════════════════ */
if ( ! function_exists('pharmacare_cat_url') ) :
function pharmacare_cat_url( array $frags ) {
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

$vitamins_url = pharmacare_cat_url(['vitamins-supplements','vitamins','supplements','vitamin']);
$diabetic_url = pharmacare_cat_url(['diabetic','diabetes','diabetic-care','diabetes-care','diabetic-weight']);
$infant_url   = pharmacare_cat_url(['infant-baby','infant','baby','baby-formula','infant-formula']);
$skincare_url = pharmacare_cat_url(['skin-care','skincare','beauty','beauty-personal-care','personal-care']);
$shop_url     = function_exists('wc_get_page_id')
    ? esc_url( get_permalink( wc_get_page_id('shop') ) )
    : home_url('/shop/');

define( 'PHARMACARE_WA_NUMBER', '254796038686' );

if ( ! function_exists('fp_whatsapp_url') ) :
function fp_whatsapp_url( $product_title = '', $product_url = '' ) {
    $msg = 'Hi! I\'m interested in purchasing: ' . $product_title;
    if ( $product_url ) $msg .= ' - ' . $product_url;
    return 'https://wa.me/' . PHARMACARE_WA_NUMBER . '?text=' . rawurlencode( $msg );
}
endif;

/* ══════════════════════════════════════════════════════
   PRODUCT CARD RENDERER
   ══════════════════════════════════════════════════════ */
if ( ! function_exists('fp_render_product_card') ) :
function fp_render_product_card() {
    if ( ! function_exists('wc_get_product') ) return;
    global $product;
    $product = wc_get_product( get_the_ID() );
    if ( ! $product ) return;

    $url        = get_permalink();
    $title      = get_the_title();
    $img_id     = get_post_thumbnail_id();
    $img_url    = $img_id ? wp_get_attachment_image_url( $img_id, 'woocommerce_thumbnail' ) : '';
    $price_html = $product->get_price_html();
    $on_sale    = $product->is_on_sale();
    $reg        = (float) $product->get_regular_price();
    $sale       = (float) $product->get_sale_price();
    $pct        = ( $on_sale && $reg > 0 ) ? round( (1 - $sale / $reg) * 100 ) : 0;
    $cart_url   = function_exists('wc_get_cart_url')
        ? add_query_arg(['add-to-cart' => get_the_ID()], wc_get_cart_url())
        : '#';
    $wa_url     = fp_whatsapp_url( $title, $url );
    $cats       = get_the_terms( get_the_ID(), 'product_cat' );
    $cat_name   = ( $cats && ! is_wp_error($cats) ) ? esc_html( $cats[0]->name ) : '';
    ?>
    <div class="fp-prod-card">
        <?php if ( $pct > 0 ) : ?>
            <span class="fp-badge">-<?php echo absint($pct); ?>%</span>
        <?php endif; ?>
        <a href="<?php echo esc_url($url); ?>" class="fp-img-wrap">
            <?php if ( $img_url ) : ?>
                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
            <?php else : ?>
                <svg viewBox="0 0 80 80" fill="none" width="60" height="60">
                    <rect x="20" y="10" width="40" height="60" rx="8" fill="#1aaa8f" opacity=".15"/>
                    <circle cx="40" cy="38" r="10" fill="#1aaa8f" opacity=".35"/>
                    <path d="M40 32v12M34 38h12" stroke="#1aaa8f" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            <?php endif; ?>
        </a>
        <div class="fp-card-body">
            <?php if ( $cat_name ) : ?>
                <div class="fp-cat-label"><?php echo $cat_name; ?></div>
            <?php endif; ?>
            <a href="<?php echo esc_url($url); ?>" class="fp-prod-name"><?php echo esc_html($title); ?></a>
            <div class="fp-price-row">
                <?php if ( $on_sale && $reg ) : ?>
                    <span class="fp-reg-price"><?php echo wc_price($reg); ?></span>
                <?php endif; ?>
                <span class="fp-sale-price"><?php echo $price_html; ?></span>
            </div>
            <a href="<?php echo esc_url($cart_url); ?>" class="fp-add-btn">
                <svg class="fp-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13" aria-hidden="true">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                Add to Cart
            </a>
            <a href="<?php echo esc_url($wa_url); ?>" class="fp-wa-btn" target="_blank" rel="noopener noreferrer">
                <svg class="fp-btn-icon" viewBox="0 0 24 24" fill="currentColor" width="13" height="13" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
                </svg>
                Buy via WhatsApp
            </a>
        </div>
    </div>
    <?php
}
endif;

/* ══════════════════════════════════════════════════════
   SMART PRODUCT QUERY HELPER
   ══════════════════════════════════════════════════════ */
if ( ! function_exists('fp_get_products') ) :
function fp_get_products( string $type, int $limit = 6 ) : WP_Query {
    $base = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
    ];
    switch ( $type ) {
        case 'featured':
            $q = new WP_Query( array_merge($base, [
                'tax_query' => [[
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                ]],
            ]));
            break;
        case 'sale':
            $sale_ids = function_exists('wc_get_product_ids_on_sale') ? wc_get_product_ids_on_sale() : [];
            if ( ! empty($sale_ids) ) {
                $q = new WP_Query([
                    'post_type'      => 'product',
                    'post_status'    => 'publish',
                    'posts_per_page' => $limit,
                    'post__in'       => array_slice($sale_ids, 0, $limit * 3),
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ]);
            } else {
                $q = new WP_Query(['post_type' => 'product', 'posts_per_page' => 0]);
            }
            break;
        case 'trending':
            $q = new WP_Query( array_merge($base, [
                'meta_key' => 'total_sales',
                'orderby'  => 'meta_value_num',
                'order'    => 'DESC',
            ]));
            break;
        default:
            $q = new WP_Query(['post_type' => 'product', 'posts_per_page' => 0]);
    }
    if ( ! $q->have_posts() ) {
        $q = new WP_Query( array_merge($base, [
            'orderby'        => 'date',
            'order'          => 'DESC',
            'posts_per_page' => $limit,
        ]));
    }
    return $q;
}
endif;

/* ══════════════════════════════════════════════════════
   NEWSLETTER HANDLER
   ══════════════════════════════════════════════════════ */
$nl_message = '';
if (
    isset( $_POST['fp_nl_nonce'] ) &&
    wp_verify_nonce( $_POST['fp_nl_nonce'], 'fp_newsletter_subscribe' ) &&
    ! empty( $_POST['nl_email'] ) &&
    is_email( sanitize_email( $_POST['nl_email'] ) )
) {
    $nl_message = '<p class="nl-success">&#10003; You\'re subscribed! Check your inbox.</p>';
}
?>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600;1,700;1,800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

<style>
/* ── Reset ── */
*, *::before, *::after { box-sizing: border-box; }

:root {
    --pk:        #8B1A4A;
    --pk-fade:   #8B1A4A;
    --pk-accent: #f9c5d6;
    --teal:      #1aaa8f;
    --teal-dk:   #138a74;
    --navy:      #1a1a2e;
    --border:    #eef0f3;
    --font-head: 'Cormorant Garamond', serif;
    --font-body: 'DM Sans', sans-serif;
}

/* ── Page layout ── */
.page-body {
    display: flex; align-items: flex-start; gap: 20px;
    max-width: 1380px; width: 100%;
    margin: 0 auto; padding: 14px 20px; overflow-x: hidden;
}
.sidebar-wrapper {
    width: 270px; min-width: 270px; flex-shrink: 0;
    border-radius: 5px; overflow: visible;
    border: 1px solid var(--border); background: #fff;
    position: sticky; top: 12px; align-self: flex-start; max-width: 270px;
}
.sidebar-wrapper:empty::after { content:''; display:block; min-height:200px; }
.sidebar-wrapper > * { max-width:100%; overflow-x:hidden; }

.site-main {
    flex: 1; min-width: 0; min-height: 400px;
    display: flex; flex-direction: column; gap: 16px; overflow: visible;
}
.fp-card { width:100%; background:#fff; border-radius:10px; border:1px solid var(--border); overflow:visible; }
.fp-card.gray { background:#f4f6f8; }
.fp-pad { padding:20px; }

/* ── Mobile sidebar toggle ── */
.mobile-sidebar-toggle-wrap { display:none; max-width:1380px; margin:0 auto; padding:10px 10px 0; }
.mobile-sidebar-toggle {
    display:flex; width:100%; align-items:center; gap:8px;
    background:var(--pk); color:#fff; border:none;
    padding:10px 14px; font-size:13px; font-weight:700;
    font-family:var(--font-body); cursor:pointer; border-radius:6px;
}
.tog-label { flex:1; text-align:center; }
.tog-arrow { flex-shrink:0; transition:transform .3s; }
.mobile-sidebar-toggle.open .tog-arrow { transform:rotate(180deg); }

/* ══════════════════════════════════════════════════════
   HERO BANNER — full-bleed background image
   ══════════════════════════════════════════════════════ */
@keyframes cur-blink {
    0%,100% { opacity:1; }
    50%      { opacity:0; }
}
@keyframes fade-up {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}

.hero-banner {
    position: relative;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    height: 480px;
    background-color: var(--pk);
}

/* ── Full-bleed background image ── */
.hero-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: var(--hero-bg-url);
    background-size: cover;
    background-position: center 15%;
    background-repeat: no-repeat;
    z-index: 0;
    border-radius: 12px;
    /* subtle scale on load for depth */
    animation: hero-zoom 12s ease-out forwards;
}
@keyframes hero-zoom {
    from { transform: scale(1.04); }
    to   { transform: scale(1.00); }
}

/* ── Very light pink tint over full image ── */
.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(139, 26, 74, 0.12);
    z-index: 1;
    border-radius: 12px;
}

/* ── Strong dark gradient on LEFT where text lives ── */
.hero-overlay::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to right,
        rgba(20, 6, 14, 0.90) 0%,
        rgba(20, 6, 14, 0.68) 36%,
        rgba(20, 6, 14, 0.18) 62%,
        transparent 100%
    );
    pointer-events: none;
    border-radius: 12px;
}

/* ── Bottom gradient for trust strip ── */
.hero-overlay::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 26%;
    background: linear-gradient(to top, rgba(20,6,14,.55) 0%, transparent 100%);
    pointer-events: none;
}

/* ── Text content ── */
.hero-content {
    position: absolute;
    inset: 0;
    z-index: 5;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0 64px;
    max-width: 680px;
}

.hero-tag {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(139,26,74,.55); border: 1px solid rgba(249,197,214,.45);
    color: #fff; font-size: 10px; font-weight: 700;
    padding: 6px 16px 6px 10px; border-radius: 30px;
    margin-bottom: 18px; font-family: var(--font-body);
    letter-spacing: 1.4px; text-transform: uppercase;
    backdrop-filter: blur(8px); width: fit-content; white-space: nowrap;
    opacity: 0; animation: fade-up .55s ease forwards; animation-delay: .25s;
}
.hero-tag-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--pk-accent); flex-shrink: 0;
}

.hero-heading {
    font-family: var(--font-head);
    font-style: italic; font-weight: 700;
    font-size: clamp(30px, 3.4vw, 56px);
    color: #fff; line-height: 1.13;
    margin: 0 0 20px;
    text-shadow: 0 2px 8px rgba(0,0,0,.55), 0 4px 32px rgba(0,0,0,.35);
    white-space: pre-line;
}
.hero-cursor {
    display: inline-block; width: 2px; height: .82em;
    background: var(--pk-accent); margin-left: 3px;
    vertical-align: middle; border-radius: 1px;
    animation: cur-blink .72s step-end infinite;
}

.hero-desc {
    font-family: var(--font-body); font-size: 15px;
    line-height: 1.72; color: rgba(255,255,255,.95);
    margin: 0 0 30px; max-width: 440px;
    text-shadow: 0 1px 6px rgba(0,0,0,.50);
    opacity: 0; animation: fade-up .6s ease forwards; animation-delay: 3.0s;
}

.hero-actions {
    display: flex; gap: 14px; align-items: center; flex-wrap: wrap;
    opacity: 0; animation: fade-up .6s ease forwards; animation-delay: 3.3s;
}

.hero-btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: #fff; color: var(--pk);
    font-size: 14px; font-weight: 800; padding: 13px 28px; border-radius: 8px;
    text-decoration: none; font-family: var(--font-body);
    box-shadow: 0 6px 22px rgba(0,0,0,.22);
    white-space: nowrap; flex-shrink: 0;
    transition: transform .18s, box-shadow .2s;
}
.hero-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,0,0,.30); }

.hero-btn-ghost {
    display: inline-flex; align-items: center; gap: 6px;
    color: rgba(255,255,255,.90); font-size: 14px; font-weight: 600;
    text-decoration: none; font-family: var(--font-body);
    border-bottom: 2px solid rgba(255,255,255,.38); padding-bottom: 2px;
    white-space: nowrap; flex-shrink: 0;
    transition: color .18s, border-color .18s;
}
.hero-btn-ghost:hover { color: #fff; border-color: #fff; }

/* ── Trust badges row inside hero ── */
.hero-trust-row {
    position: absolute;
    bottom: 24px; left: 64px; right: 64px;
    z-index: 6;
    display: flex; gap: 20px; align-items: center;
    opacity: 0; animation: fade-up .6s ease forwards; animation-delay: 3.6s;
}
.hero-trust-item {
    display: flex; align-items: center; gap: 7px;
    font-family: var(--font-body); font-size: 11px; font-weight: 700;
    color: rgba(255,255,255,.82); white-space: nowrap;
}
.hero-trust-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--pk-accent); flex-shrink: 0;
}
.hero-trust-sep {
    width: 1px; height: 16px; background: rgba(255,255,255,.25); flex-shrink: 0;
}

/* ══════════════════════════════════════════════════════
   HERO RESPONSIVE
   ══════════════════════════════════════════════════════ */
@media (max-width: 1100px) {
    .hero-banner  { height: 420px; }
    .hero-content { padding: 0 36px; max-width: 580px; }
    .hero-trust-row { left: 36px; right: 36px; }
}

@media (max-width: 768px) {
    .hero-banner {
        height: 360px !important;
        border-radius: 10px;
    }
    /* On mobile, anchor image to top so heads are visible */
    .hero-banner::before {
        background-position: center 10% !important;
    }
    .hero-content {
        padding: 0 22px !important;
        max-width: 100% !important;
        justify-content: center !important;
        align-items: flex-start !important;
    }
    .hero-tag     { font-size: 9px !important; margin-bottom: 12px !important; }
    .hero-heading { font-size: clamp(22px, 5.5vw, 30px) !important; margin-bottom: 14px !important; }
    .hero-desc    { display: none !important; }
    .hero-btn-ghost { display: none; }
    .hero-trust-row { display: none !important; }
}

@media (max-width: 480px) {
    .hero-banner { height: 300px !important; }
    .hero-heading { font-size: clamp(19px, 5.2vw, 24px) !important; }
    .hero-btn-primary { font-size: 13px; padding: 11px 22px; }
}

@media (max-width: 360px) {
    .hero-banner  { height: 260px !important; }
    .hero-heading { font-size: 17px !important; }
}

/* ── Promo cards ── */
.promo-cards-row { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; width:100%; }
.promo-card-h    { border-radius:8px; padding:18px 20px; display:flex; align-items:center; justify-content:space-between; min-height:90px; overflow:hidden; gap:10px; }
.promo-left      { min-width:0; flex:1; }
.promo-card-h h3 { font-family:var(--font-body); font-size:14px; font-weight:800; color:#fff; margin:0 0 3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.promo-upto      { font-size:9px; color:rgba(255,255,255,.8); font-weight:700; letter-spacing:1px; text-transform:uppercase; }
.promo-pct       { font-size:20px; font-weight:900; color:#fff; font-family:var(--font-body); }
.promo-shop-btn  { flex-shrink:0; font-size:10px; font-weight:800; color:#fff; text-decoration:none; background:rgba(0,0,0,.22); padding:7px 12px; border-radius:5px; white-space:nowrap; transition:background .2s; font-family:var(--font-body); }
.promo-shop-btn:hover { background:rgba(0,0,0,.38); }
.promo-vitamins  { background:linear-gradient(135deg,#e84891,#c02070); }
.promo-diabetic  { background:linear-gradient(135deg,#1aaa8f,#0f7a65); }
.promo-infant    { background:linear-gradient(135deg,#3b82f6,#1d4ed8); }

/* ── Section header ── */
.fp-section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
.fp-section-title  { font-family:var(--font-body); font-size:16px; font-weight:900; color:var(--navy); padding-left:9px; border-left:3px solid var(--teal); }
.fp-arrows         { display:flex; gap:7px; }
.fp-arr            { width:30px; height:30px; border-radius:50%; border:1.5px solid #ddd; background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:border-color .2s,background .2s; }
.fp-arr:hover      { border-color:var(--teal); background:#e8f5f2; }

/* ── Product grids ── */
.fp-prod-grid   { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; }
.fp-prod-grid-6 { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; }

/* ── Product card ── */
.fp-prod-card       { position:relative; background:#fff; border:1px solid var(--border); border-radius:8px; overflow:hidden; display:flex; flex-direction:column; transition:box-shadow .2s,transform .2s; min-width:0; width:100%; }
.fp-prod-card:hover { box-shadow:0 6px 24px rgba(0,0,0,.1); transform:translateY(-2px); }
.fp-badge           { position:absolute; top:10px; left:10px; z-index:2; background:#e84891; color:#fff; font-size:10px; font-weight:800; padding:3px 8px; border-radius:4px; font-family:var(--font-body); }
.fp-img-wrap        { display:flex; align-items:center; justify-content:center; height:160px; background:#f8f9fb; padding:12px; text-decoration:none; overflow:hidden; }
.fp-img-wrap img    { max-height:136px; max-width:100%; object-fit:contain; transition:transform .25s; }
.fp-prod-card:hover .fp-img-wrap img { transform:scale(1.05); }
.fp-card-body       { padding:12px 14px 14px; display:flex; flex-direction:column; gap:6px; flex:1; }
.fp-cat-label       { font-size:10px; font-weight:700; color:var(--teal); text-transform:uppercase; letter-spacing:.5px; }
.fp-prod-name       { font-size:13px; font-weight:700; color:var(--navy); font-family:var(--font-body); line-height:1.35; text-decoration:none; display:-webkit-box; -webkit-line-clamp:2; line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.fp-prod-name:hover { color:var(--teal); }
.fp-price-row       { display:flex; align-items:center; gap:7px; flex-wrap:wrap; margin-top:2px; }
.fp-reg-price       { font-size:11px; color:#bbb; text-decoration:line-through; }
.fp-sale-price      { font-size:15px; font-weight:900; color:#e84891; font-family:var(--font-body); }
.fp-sale-price ins  { text-decoration:none; }
.fp-add-btn         { display:flex; align-items:center; justify-content:center; gap:7px; margin-top:auto; background:var(--teal); color:#fff; font-size:12px; font-weight:800; padding:10px 14px; border-radius:6px; text-decoration:none; font-family:var(--font-body); transition:background .2s; white-space:nowrap; overflow:hidden; min-width:0; width:100%; }
.fp-add-btn:hover   { background:var(--teal-dk); }
.fp-wa-btn          { display:flex; align-items:center; justify-content:center; gap:7px; background:#25d366; color:#fff; font-size:12px; font-weight:800; padding:10px 14px; border-radius:6px; text-decoration:none; font-family:var(--font-body); transition:background .2s; white-space:nowrap; overflow:hidden; min-width:0; width:100%; }
.fp-wa-btn:hover    { background:#1ebe5a; color:#fff; }
.fp-no-products     { color:#888; font-size:13px; grid-column:1/-1; padding:20px 0; text-align:center; }

/* ── Newsletter ── */
.fp-newsletter      { background:linear-gradient(135deg,#e8f5f2 0%,#cde9e4 50%,#e8f5f2 100%); border-radius:8px; padding:44px 28px; text-align:center; }
.fp-newsletter-wrap { max-width:1380px; width:100%; margin:0 auto; padding:0 20px 20px; }
.fp-newsletter h2   { font-family:var(--font-body); font-size:24px; font-weight:900; color:var(--navy); margin:0 0 7px; }
.fp-newsletter p    { color:#666; font-size:13px; margin:0 0 20px; }
.fp-nl-form         { display:flex; max-width:520px; width:100%; margin:0 auto; border-radius:50px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,.1); background:#fff; }
.fp-nl-form input[type="email"]              { flex:1; border:none; outline:none; padding:12px 20px; font-size:13px; color:#333; min-width:0; font-family:var(--font-body); }
.fp-nl-form input[type="email"]::placeholder { color:#aaa; }
.fp-nl-form button  { background:var(--teal); color:#fff; border:none; padding:12px 22px; font-size:11px; font-weight:800; cursor:pointer; font-family:var(--font-body); display:flex; align-items:center; gap:6px; white-space:nowrap; transition:background .2s; flex-shrink:0; }
.fp-nl-form button:hover { background:var(--teal-dk); }
.nl-success { color:var(--teal); font-weight:700; font-size:13px; margin-top:12px; }

/* ══════════════════════════════════════════════════════
   REMAINING RESPONSIVE
   ══════════════════════════════════════════════════════ */
@media (max-width:860px) {
    .page-body { flex-direction:column; padding:10px; gap:0; }
    .sidebar-wrapper { width:100% !important; min-width:0 !important; max-width:100% !important; position:static !important; max-height:0; overflow:hidden; transition:max-height .4s ease; margin-bottom:0; border-radius:0; }
    .sidebar-wrapper.open { max-height:2000px; margin-bottom:10px; overflow:visible; }
    .mobile-sidebar-toggle-wrap { display:block; }
    .site-main  { gap:10px; }
    .fp-pad     { padding:14px 12px; }
    .promo-cards-row  { grid-template-columns:1fr; gap:8px; }
    .fp-prod-grid     { grid-template-columns:repeat(2,minmax(0,1fr)); gap:8px; }
    .fp-prod-grid-6   { grid-template-columns:repeat(2,minmax(0,1fr)); gap:8px; }
    .fp-newsletter    { padding:28px 14px; }
    .fp-newsletter h2 { font-size:19px; }
    .fp-newsletter-wrap { padding:0 10px 10px; }
    .fp-add-btn,.fp-wa-btn { font-size:10px; padding:8px 6px; gap:3px; }
    .fp-btn-icon  { display:none; }
    .fp-card-body { padding:10px 8px 10px; gap:5px; }
}
@media (max-width:480px) {
    .page-body  { padding:8px; }
    .fp-prod-grid { grid-template-columns:repeat(2,minmax(0,1fr)) !important; gap:8px; }
    .fp-prod-name   { font-size:12px; }
    .fp-sale-price  { font-size:13px; }
    .fp-img-wrap    { height:110px; }
    .fp-img-wrap img { max-height:90px; }
    .fp-add-btn,.fp-wa-btn { font-size:9px; padding:7px 5px; gap:2px; }
    .fp-newsletter-wrap { padding:0 8px 8px; }
    .fp-nl-form { flex-direction:column; border-radius:8px; }
    .fp-nl-form input[type="email"] { padding:12px 16px; border-radius:8px 8px 0 0; }
    .fp-nl-form button { justify-content:center; border-radius:0 0 8px 8px; }
}
@media (max-width:320px) {
    .fp-prod-grid,.fp-prod-grid-6 { grid-template-columns:1fr !important; gap:8px; }
    .fp-add-btn,.fp-wa-btn { font-size:12px; padding:10px 14px; gap:7px; }
}
</style>

<!-- ══════════════════════════════════════════════════════
     MOBILE SIDEBAR TOGGLE
     ══════════════════════════════════════════════════════ -->
<div class="mobile-sidebar-toggle-wrap">
    <button class="mobile-sidebar-toggle" id="mobileSidebarToggle" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16" aria-hidden="true">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
        <span class="tog-label">Browse Categories &amp; Brands</span>
        <svg class="tog-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14" aria-hidden="true">
            <path d="M6 9l6 6 6-6"/>
        </svg>
    </button>
</div>

<div class="page-body">

    <!-- ══ SIDEBAR ══ -->
    <aside class="sidebar-wrapper" id="sidebarWrapper">
        <?php get_sidebar(); ?>
    </aside>

    <!-- ══ MAIN ══ -->
    <main class="site-main" id="mainContent">

        <!-- ▸ HERO BANNER -->
        <div class="fp-card" style="padding:0;overflow:hidden;border-radius:12px;">
            <div class="hero-banner"
                 role="banner"
                 aria-label="Expert Pharmacy Care — Nozaltah Pharmacare"
                 style="--hero-bg-url: url('<?php echo esc_url( PHARMACARE_URI . '/assets/images/slides/homepagebg.png' ); ?>');">

                <!-- Pink tint overlay -->
                <div class="hero-overlay" aria-hidden="true"></div>

                <!-- Text content -->
                <div class="hero-content">
                    <span class="hero-tag">
                        <span class="hero-tag-dot" aria-hidden="true"></span>Kenya's Trusted Pharmacy
                    </span>
                    <h2 class="hero-heading"
                        id="heroHeading"
                        aria-label="Expert Advice, Right When You Need It"></h2>
                    <p class="hero-desc">Chat live with our qualified pharmacists 7 days a week. Trusted guidance on medications, supplements &amp; health questions — all in one place.</p>
                    <div class="hero-actions">
                        <a href="<?php echo esc_url($shop_url); ?>" class="hero-btn-primary">
                            Shop Now
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="13" height="13" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="https://wa.me/<?php echo esc_attr( PHARMACARE_WA_NUMBER ); ?>?text=<?php echo rawurlencode("Hi! I'd like to speak with a pharmacist."); ?>"
                           class="hero-btn-ghost" target="_blank" rel="noopener noreferrer">
                            Talk to a Pharmacist &rarr;
                        </a>
                    </div>
                </div>

                <!-- Trust badges — bottom strip -->
                <div class="hero-trust-row" aria-hidden="true">
                    <div class="hero-trust-item">
                        <span class="hero-trust-dot"></span>60,000+ Happy Customers
                    </div>
                    <div class="hero-trust-sep"></div>
                    <div class="hero-trust-item">
                        <span class="hero-trust-dot"></span>5,000+ Genuine Products
                    </div>
                    <div class="hero-trust-sep"></div>
                    <div class="hero-trust-item">
                        <span class="hero-trust-dot"></span>Licensed by PPB Kenya
                    </div>
                    <div class="hero-trust-sep"></div>
                    <div class="hero-trust-item">
                        <span class="hero-trust-dot"></span>7-Day Pharmacist Support
                    </div>
                </div>

            </div>
        </div>

        <!-- ▸ PROMO CARDS -->
        <div class="promo-cards-row">
            <div class="promo-card-h promo-vitamins">
                <div class="promo-left">
                    <h3>Vitamins &amp; Supplement</h3>
                    <div class="promo-upto">UP TO</div>
                    <div class="promo-pct">30% off</div>
                </div>
                <a href="<?php echo esc_url($vitamins_url); ?>" class="promo-shop-btn">&rarr; SHOP NOW</a>
            </div>
            <div class="promo-card-h promo-diabetic">
                <div class="promo-left">
                    <h3>Diabetic &amp; Weight</h3>
                    <div class="promo-upto">UP TO</div>
                    <div class="promo-pct">25% off</div>
                </div>
                <a href="<?php echo esc_url($diabetic_url); ?>" class="promo-shop-btn">&rarr; SHOP NOW</a>
            </div>
            <div class="promo-card-h promo-infant">
                <div class="promo-left">
                    <h3>Infant &amp; Baby Formula</h3>
                    <div class="promo-upto">UP TO</div>
                    <div class="promo-pct">25% off</div>
                </div>
                <a href="<?php echo esc_url($infant_url); ?>" class="promo-shop-btn">&rarr; SHOP NOW</a>
            </div>
        </div>

        <?php if ( function_exists('wc_get_page_id') ) : ?>

            <!-- ▸ HEALTH PRODUCTS -->
            <div class="fp-card">
                <div class="fp-pad">
                    <div class="fp-section-header">
                        <div class="fp-section-title">Health Products</div>
                        <div class="fp-arrows">
                            <button class="fp-arr" aria-label="Previous"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
                            <button class="fp-arr" aria-label="Next"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                        </div>
                    </div>
                    <div class="fp-prod-grid">
                        <?php
                        $q1 = fp_get_products('featured', 3);
                        if ( $q1->have_posts() ) :
                            while ( $q1->have_posts() ) : $q1->the_post(); fp_render_product_card(); endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="fp-no-products">No products found.</p>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- ▸ SALE PRODUCTS -->
            <div class="fp-card gray">
                <div class="fp-pad">
                    <div class="fp-section-header">
                        <div class="fp-section-title">Sale Products</div>
                        <div class="fp-arrows">
                            <button class="fp-arr" aria-label="Previous"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
                            <button class="fp-arr" aria-label="Next"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                        </div>
                    </div>
                    <div class="fp-prod-grid-6">
                        <?php
                        $sale_ids = function_exists('wc_get_product_ids_on_sale') ? wc_get_product_ids_on_sale() : [];
                        if ( ! empty($sale_ids) ) :
                            $q2 = new WP_Query([
                                'post_type'      => 'product',
                                'post_status'    => 'publish',
                                'posts_per_page' => 6,
                                'post__in'       => $sale_ids,
                                'orderby'        => 'date',
                                'order'          => 'DESC',
                            ]);
                            if ( $q2->have_posts() ) :
                                $count = 0;
                                while ( $q2->have_posts() && $count < 6 ) : $q2->the_post(); $count++; fp_render_product_card(); endwhile;
                                wp_reset_postdata();
                            else :
                                $q2b = new WP_Query(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>6,'orderby'=>'date','order'=>'DESC']);
                                if ( $q2b->have_posts() ) :
                                    while ( $q2b->have_posts() ) : $q2b->the_post(); fp_render_product_card(); endwhile;
                                    wp_reset_postdata();
                                endif;
                            endif;
                        else :
                            $q2b = new WP_Query(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>6,'orderby'=>'date','order'=>'DESC']);
                            if ( $q2b->have_posts() ) :
                                while ( $q2b->have_posts() ) : $q2b->the_post(); fp_render_product_card(); endwhile;
                                wp_reset_postdata();
                            else :
                                echo '<p class="fp-no-products">No products found.</p>';
                            endif;
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- ▸ TRENDING PRODUCTS -->
            <div class="fp-card">
                <div class="fp-pad">
                    <div class="fp-section-header">
                        <div class="fp-section-title">Trending Products</div>
                        <div class="fp-arrows">
                            <button class="fp-arr" aria-label="Previous"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M19 12H5M12 19l-7-7 7-7"/></svg></button>
                            <button class="fp-arr" aria-label="Next"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                        </div>
                    </div>
                    <div class="fp-prod-grid">
                        <?php
                        $q3 = fp_get_products('trending', 3);
                        if ( $q3->have_posts() ) :
                            while ( $q3->have_posts() ) : $q3->the_post(); fp_render_product_card(); endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="fp-no-products">No products found.</p>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </main>
</div><!-- /.page-body -->

<!-- ▸ NEWSLETTER -->
<div class="fp-newsletter-wrap">
    <div class="fp-newsletter">
        <h2>Sign Up For Newsletter</h2>
        <p>Join 60,000+ subscribers and get a new discount coupon every Saturday.</p>
        <form class="fp-nl-form" method="post" action="<?php echo esc_url( get_permalink() ); ?>">
            <?php wp_nonce_field('fp_newsletter_subscribe', 'fp_nl_nonce'); ?>
            <input type="email" name="nl_email" placeholder="Your email address" required autocomplete="email">
            <button type="submit">
                SUBSCRIBE
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" width="11" height="11" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </form>
        <?php echo $nl_message; ?>
    </div>
</div>

<script>
(function () {
    'use strict';

    /* ── Sidebar toggle ── */
    function initSidebar() {
        var btn = document.getElementById('mobileSidebarToggle');
        var sb  = document.getElementById('sidebarWrapper');
        if (!btn || !sb) return;
        btn.addEventListener('click', function () {
            var open = sb.classList.toggle('open');
            btn.classList.toggle('open', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    /* ── Hero typewriter ── */
    function initTypewriter() {
        var el = document.getElementById('heroHeading');
        if (!el) return;

        var lines     = ['Expert Advice,', 'Right When', 'You Need It.'];
        var lineIdx   = 0;
        var charIdx   = 0;
        var charSpeed = 55;
        var lineGap   = 280;

        var cursor = document.createElement('span');
        cursor.className = 'hero-cursor';
        cursor.setAttribute('aria-hidden', 'true');

        function buildText() {
            var out = '';
            for (var i = 0; i < lineIdx; i++) out += lines[i] + '\n';
            out += lines[lineIdx].substring(0, charIdx);
            return out;
        }

        function tick() {
            el.textContent = buildText();
            el.appendChild(cursor);
            if (charIdx < lines[lineIdx].length) {
                charIdx++;
                setTimeout(tick, charSpeed);
            } else {
                lineIdx++;
                charIdx = 0;
                if (lineIdx < lines.length) setTimeout(tick, lineGap);
            }
        }

        setTimeout(tick, 950);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { initSidebar(); initTypewriter(); });
    } else {
        initSidebar();
        initTypewriter();
    }
}());
</script>

<?php get_footer(); ?>
