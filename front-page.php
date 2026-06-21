<?php
/**
 * Front Page Template — Family Drugmart Kenya
 */

if ( ! defined('ABSPATH') ) { die(); }

get_header();

if ( ! defined('FD_THEME_URI') ) {
    define( 'FD_THEME_URI', get_template_directory_uri() );
}

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

$vitamins_url = fd_cat_url(['vitamins-supplements','vitamins','supplements','vitamin']);
$diabetic_url = fd_cat_url(['diabetic','diabetes','diabetic-care','diabetes-care','diabetic-weight']);
$infant_url   = fd_cat_url(['infant-baby','infant','baby','baby-formula','infant-formula']);
$skincare_url = fd_cat_url(['skincare','skin-care','skin','beauty-skincare','beauty']);
$shop_url     = function_exists('wc_get_page_id')
    ? esc_url( get_permalink( wc_get_page_id('shop') ) )
    : home_url('/shop/');

$fd_wa_number = function_exists('medicare_wa') ? medicare_wa() : '254796140021';

/**
 * Builds a WhatsApp enquiry link that now includes the product price.
 *
 * @param string $product_title
 * @param string $product_url
 * @param string $price_text  Pre-formatted price string, e.g. "KES 1,200.00"
 */
if ( ! function_exists('fd_whatsapp_url') ) :
function fd_whatsapp_url( $product_title = '', $product_url = '', $price_text = '' ) {
    global $fd_wa_number;
    $msg = 'Hi! I\'m interested in purchasing: ' . $product_title;
    if ( $price_text )   $msg .= ' : ' . $price_text;
    if ( $product_url )  $msg .= ' - ' . $product_url;
    return 'https://wa.me/' . $fd_wa_number . '?text=' . rawurlencode( $msg );
}
endif;

if ( ! function_exists('fd_render_product_card') ) :
function fd_render_product_card() {
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
    $is_simple   = $product->is_type('simple');
    $is_rx       = medicare_is_prescription_product( get_the_ID() );
    $title_short = mb_strlen($title) > 30 ? mb_substr($title, 0, 30) . '…' : $title;

    /* Current effective price (sale price if on sale, else regular price),
       formatted plainly for use inside the WhatsApp message text */
    $current_price = (float) $product->get_price();
    $price_text    = 'KES ' . number_format( $current_price, 2 );

    $wa_url     = fd_whatsapp_url( $title, $url, $price_text );
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
                    <rect x="20" y="10" width="40" height="60" rx="8" fill="#1d3f8f" opacity=".12"/>
                    <circle cx="40" cy="38" r="10" fill="#1d3f8f" opacity=".30"/>
                    <path d="M40 32v12M34 38h12" stroke="#1d3f8f" stroke-width="2.5" stroke-linecap="round"/>
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
                    <span class="fp-sale-price"><?php echo wc_price($sale); ?></span>
                <?php else : ?>
                    <span class="fp-sale-price"><?php echo $price_html; ?></span>
                <?php endif; ?>
            </div>
            <?php if ( $is_rx ) : ?>
                <a href="<?php echo esc_url( medicare_prescription_url( get_the_ID() ) ); ?>" class="fp-add-btn fp-rx-btn">
                    <svg class="fp-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13" aria-hidden="true">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    Submit Prescription
                </a>
            <?php elseif ( $is_simple ) : ?>
                <!-- Silent AJAX-style ATC — reloads in place, shows toast, never navigates to cart -->
                <button type="button"
                    class="fp-add-btn carevee-atc-btn"
                    data-pid="<?php echo esc_attr( get_the_ID() ); ?>"
                    data-name="<?php echo esc_attr( $title_short ); ?>">
                    <svg class="fp-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13" aria-hidden="true">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span class="fp-atc-txt">Add to Cart</span>
                </button>
            <?php else : ?>
                <a href="<?php echo esc_url($url); ?>" class="fp-add-btn">
                    <svg class="fp-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13" aria-hidden="true">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    Select Options
                </a>
            <?php endif; ?>
            <a href="<?php echo esc_url($wa_url); ?>" class="fp-wa-btn" target="_blank" rel="noopener noreferrer">
                <svg class="fp-btn-icon" viewBox="0 0 24 24" fill="currentColor" width="13" height="13" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
                </svg>
                Medicine Enquiry
            </a>
        </div>
    </div>
    <?php
}
endif;

if ( ! function_exists('fd_get_products') ) :
function fd_get_products( string $type, int $limit = 6 ) : WP_Query {
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

<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Lato:wght@400;600;700&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }

:root {
    --fd-blue:        #1d3f8f;
    --fd-blue-dark:   #15306e;
    --fd-blue-darker: #0e2358;
    --fd-blue-navy:   #0a1228;
    --fd-gold:        #f5a623;
    --fd-gold-dark:   #c47d00;
    --fd-green:       #1aab74;
    --fd-text:        #1b2230;
    --fd-text-light:  #6b7280;
    --fd-bg-soft:     #f7f8fa;
    --fd-border:      #edf0f5;
    --fd-font-head:   'Nunito', sans-serif;
    --fd-font-body:   'Lato', sans-serif;
}

.page-body {
    display: flex; align-items: flex-start; gap: 20px;
    max-width: 1380px; width: 100%;
    margin: 0 auto; padding: 14px 20px; overflow-x: hidden;
    font-family: var(--fd-font-body);
}
.sidebar-wrapper {
    width: 270px; min-width: 270px; flex-shrink: 0;
    border-radius: 12px; overflow: visible;
    border: 1.5px solid var(--fd-border); background: #fff;
    position: sticky; top: 12px; align-self: flex-start; max-width: 270px;
}
.sidebar-wrapper:empty::after { content:''; display:block; min-height:200px; }
.sidebar-wrapper > * { max-width:100%; overflow-x:hidden; }

.site-main {
    flex: 1; min-width: 0; min-height: 400px;
    display: flex; flex-direction: column; gap: 16px; overflow: visible;
}
.fp-card { width:100%; background:#fff; border-radius:14px; border:1.5px solid var(--fd-border); overflow:visible; }
.fp-card.gray { background:var(--fd-bg-soft); }
.fp-pad { padding:20px; }

.mobile-sidebar-toggle-wrap { display:none; max-width:1380px; margin:0 auto; padding:10px 10px 0; }
.mobile-sidebar-toggle {
    display:flex; width:100%; align-items:center; gap:8px;
    background:var(--fd-blue-darker); color:#fff; border:none;
    padding:11px 14px; font-size:13px; font-weight:700;
    font-family:var(--fd-font-body); cursor:pointer; border-radius:8px;
}
.tog-label { flex:1; text-align:center; }
.tog-arrow { flex-shrink:0; transition:transform .3s; }
.mobile-sidebar-toggle.open .tog-arrow { transform:rotate(180deg); }

/* ══════════════════════════════════════════════════════
   HERO — centered text, lighter overlay, 3-slide carousel
   ══════════════════════════════════════════════════════ */
@keyframes fd-fade-up {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes fd-hero-zoom {
    from { transform: scale(1.04); }
    to   { transform: scale(1.00); }
}

.fd-hero {
    position: relative;
    width: 100%;
    border-radius: 16px;
    overflow: hidden;
    height: 460px;
    background-color: var(--fd-blue-navy);
}

/* ── Slides ── each slide carries its own background image and content ── */
.fd-hero-slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center 18%;
    background-repeat: no-repeat;
    border-radius: 16px;
    opacity: 0;
    visibility: hidden;
    z-index: 0;
    transition: opacity 1s ease;
}
.fd-hero-slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 1;
}
.fd-hero-slide.active .fd-hero-slide-bg {
    animation: fd-hero-zoom 7s ease-out forwards;
}
.fd-hero-slide-bg {
    position: absolute;
    inset: 0;
    background-image: inherit;
    background-size: cover;
    background-position: inherit;
    background-repeat: no-repeat;
    border-radius: 16px;
}

/* LIGHTER overlay — image is clearly visible */
.fd-hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(10, 18, 40, .18);
    z-index: 1;
    border-radius: 16px;
}

/* Lighter centre-to-edge gradient so image shows through */
.fd-hero-overlay::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(10, 18, 40, .55) 0%,
        rgba(10, 18, 40, .30) 40%,
        rgba(10, 18, 40, .40) 100%
    );
    pointer-events: none;
    border-radius: 16px;
}

/* Soft bottom fade so trust strip stays readable */
.fd-hero-overlay::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 28%;
    background: linear-gradient(to top, rgba(10,18,40,.50) 0%, transparent 100%);
    pointer-events: none;
}

/* Gold top border + small blue bottom accent — ties in the brand's primary blue */
.fd-hero-frame-border {
    position: absolute;
    inset: 0;
    z-index: 2;
    border-radius: 16px;
    border-top: 4px solid var(--fd-gold);
    border-bottom: 3px solid var(--fd-blue);
    pointer-events: none;
}

/* ── Hero content — top group pinned to top, bottom group pinned to bottom,
   nav arrows stay separate/untouched ── */
.fd-hero-content {
    position: absolute;
    inset: 0;
    z-index: 5;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    text-align: center;
    padding: 32px 40px;
    width: 100%;
    max-width: 100%;
}
.fd-hero-content-top {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.fd-hero-content-bottom {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.fd-hero-tag {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(245,166,35,.18); border: 1px solid rgba(245,166,35,.50);
    color: var(--fd-gold); font-size: 11px; font-weight: 800;
    padding: 7px 18px; border-radius: 50px;
    margin-bottom: 18px; font-family: var(--fd-font-body);
    letter-spacing: 1.3px; text-transform: uppercase;
    backdrop-filter: blur(6px);
    opacity: 0; animation: fd-fade-up .55s ease forwards; animation-delay: .1s;
}

.fd-hero-heading {
    font-family: var(--fd-font-head);
    font-weight: 900;
    font-size: clamp(28px, 3.6vw, 48px);
    color: #fff; line-height: 1.18;
    margin: 0;
    text-shadow: 0 2px 12px rgba(0,0,0,.55);
    max-width: 780px;
    opacity: 0; animation: fd-fade-up .6s ease forwards; animation-delay: .22s;
}
.fd-hero-heading-highlight { color: var(--fd-gold); }
.fd-hero-cursor {
    display: inline-block;
    color: var(--fd-gold);
    margin-left: 2px;
    animation: fd-blink 1s steps(1) infinite;
}
@keyframes fd-blink { 0%, 49% { opacity: 1; } 50%, 100% { opacity: 0; } }

.fd-hero-desc {
    font-family: var(--fd-font-body); font-size: 15px;
    line-height: 1.75; color: rgba(255,255,255,.95);
    margin: 0 0 20px; max-width: 560px;
    text-shadow: 0 1px 8px rgba(0,0,0,.55);
    opacity: 0; animation: fd-fade-up .6s ease forwards; animation-delay: .34s;
}

.fd-hero-actions {
    display: flex; gap: 14px; align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    opacity: 0; animation: fd-fade-up .6s ease forwards; animation-delay: .46s;
}
.fd-hero-btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--fd-gold); color: var(--fd-blue-navy);
    font-size: 13.5px; font-weight: 800; padding: 13px 30px; border-radius: 50px;
    text-decoration: none; font-family: var(--fd-font-body);
    box-shadow: 0 8px 22px rgba(0,0,0,.30);
    white-space: nowrap; transition: transform .18s, box-shadow .2s;
}
.fd-hero-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,.38); }

/* Solid blue button — second hero CTA, uses theme's primary blue */
.fd-hero-btn-blue {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--fd-blue); color: #fff;
    font-size: 13.5px; font-weight: 800; padding: 13px 30px; border-radius: 50px;
    text-decoration: none; font-family: var(--fd-font-body);
    box-shadow: 0 8px 22px rgba(13,33,79,.35);
    white-space: nowrap; transition: transform .18s, box-shadow .2s, background .2s;
}
.fd-hero-btn-blue:hover { background: var(--fd-blue-dark); transform: translateY(-2px); box-shadow: 0 12px 28px rgba(13,33,79,.45); }

/* Trust badges — centered at the bottom (pharmacy slide only) */
.fd-hero-trust-row {
    position: absolute;
    bottom: 46px; left: 0; right: 0;
    z-index: 6;
    display: flex; gap: 18px; align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    padding: 0 30px;
    opacity: 0; animation: fd-fade-up .6s ease forwards; animation-delay: .6s;
}
.fd-hero-trust-item {
    display: flex; align-items: center; gap: 7px;
    font-family: var(--fd-font-body); font-size: 11px; font-weight: 700;
    color: rgba(255,255,255,.90); white-space: nowrap;
}
.fd-hero-trust-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--fd-gold); flex-shrink: 0;
}
.fd-hero-trust-sep {
    width: 1px; height: 14px; background: rgba(255,255,255,.30); flex-shrink: 0;
}

/* ── Carousel nav arrows (circular) — independent of hero-content ── */
.fd-hero-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 8;
    width: 42px; height: 42px;
    border-radius: 50%;
    background: rgba(255,255,255,.16);
    border: 1.5px solid rgba(255,255,255,.45);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    backdrop-filter: blur(6px);
    transition: background .2s, transform .2s, border-color .2s;
    padding: 0;
}
.fd-hero-nav:hover { background: rgba(255,255,255,.30); border-color: rgba(255,255,255,.7); transform: translateY(-50%) scale(1.08); }
.fd-hero-nav-prev { left: 16px; }
.fd-hero-nav-next { right: 16px; }

/* ── Carousel dots ── */
.fd-hero-dots {
    position: absolute;
    bottom: 16px; left: 0; right: 0;
    z-index: 7;
    display: flex; gap: 8px; align-items: center; justify-content: center;
}
.fd-hero-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: rgba(255,255,255,.45);
    border: none; padding: 0; cursor: pointer;
    transition: background .25s, width .25s, border-radius .25s;
}
.fd-hero-dot.active { background: var(--fd-gold); width: 22px; border-radius: 5px; }

/* ── Hero responsive ── */
@media (max-width: 1100px) {
    .fd-hero { height: 420px; }
    .fd-hero-content { padding: 28px; }
}
@media (max-width: 768px) {
    .fd-hero { height: 360px !important; border-radius: 14px; }
    .fd-hero-slide { background-position: center 12% !important; }
    .fd-hero-content { padding: 20px 18px !important; }
    .fd-hero-tag { font-size: 9px !important; margin-bottom: 12px !important; }
    .fd-hero-heading { font-size: clamp(22px, 5.5vw, 30px) !important; }
    .fd-hero-desc { display: none !important; }
    .fd-hero-btn-blue { display: none; }
    .fd-hero-trust-row { display: none !important; }
    .fd-hero-nav { width: 34px; height: 34px; }
    .fd-hero-nav-prev { left: 10px; }
    .fd-hero-nav-next { right: 10px; }
}
@media (max-width: 480px) {
    .fd-hero { height: 300px !important; }
    .fd-hero-heading { font-size: clamp(19px, 5.2vw, 24px) !important; }
    .fd-hero-btn-primary { font-size: 13px; padding: 11px 22px; }
    .fd-hero-nav { width: 30px; height: 30px; }
    .fd-hero-dots { bottom: 10px; }
}
@media (max-width: 360px) {
    .fd-hero { height: 260px !important; }
    .fd-hero-heading { font-size: 17px !important; }
}

/* ── Promo cards ── */
.promo-cards-row { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; width:100%; }
.promo-card-h    { border-radius:12px; padding:18px 20px; display:flex; align-items:center; justify-content:space-between; min-height:90px; overflow:hidden; gap:10px; }
.promo-left      { min-width:0; flex:1; }
.promo-card-h h3 { font-family:var(--fd-font-body); font-size:14px; font-weight:800; margin:0 0 3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.promo-upto      { font-size:9px; font-weight:700; letter-spacing:1px; text-transform:uppercase; }
.promo-pct       { font-size:20px; font-weight:900; font-family:var(--fd-font-body); }
.promo-shop-btn  { flex-shrink:0; font-size:10px; font-weight:800; text-decoration:none; padding:7px 12px; border-radius:50px; white-space:nowrap; transition:background .2s; font-family:var(--fd-font-body); }

.promo-vitamins { background:linear-gradient(135deg,#1d3f8f,#15306e); }
.promo-vitamins h3, .promo-vitamins .promo-upto, .promo-vitamins .promo-pct { color:#fff; }
.promo-vitamins .promo-shop-btn { background:rgba(255,255,255,.16); color:#fff; }
.promo-vitamins .promo-shop-btn:hover { background:rgba(255,255,255,.28); }

.promo-diabetic { background:linear-gradient(135deg,#f5a623,#e0931a); }
.promo-diabetic h3, .promo-diabetic .promo-upto, .promo-diabetic .promo-pct { color:var(--fd-blue-navy); }
.promo-diabetic .promo-shop-btn { background:rgba(10,18,40,.16); color:var(--fd-blue-navy); }
.promo-diabetic .promo-shop-btn:hover { background:rgba(10,18,40,.28); }

.promo-infant { background:linear-gradient(135deg,#0e2358,#0a1228); }
.promo-infant h3, .promo-infant .promo-upto, .promo-infant .promo-pct { color:#fff; }
.promo-infant .promo-shop-btn { background:rgba(245,166,35,.20); color:var(--fd-gold); }
.promo-infant .promo-shop-btn:hover { background:rgba(245,166,35,.32); }

/* ── Section header ── */
.fp-section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
.fp-section-title  { font-family:var(--fd-font-head); font-size:16px; font-weight:900; color:var(--fd-text); padding-left:10px; border-left:3px solid var(--fd-gold); }
.fp-arrows         { display:flex; gap:7px; }
.fp-arr            { width:30px; height:30px; border-radius:50%; border:1.5px solid #ddd; background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:border-color .2s,background .2s; color: var(--fd-text); }
.fp-arr:hover      { border-color:var(--fd-blue); background:#eef1f8; color: var(--fd-blue); }

/* ── Product grids ── */
.fp-prod-grid   { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; }
.fp-prod-grid-6 { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; }

/* ── Product card ── */
.fp-prod-card       { position:relative; background:#fff; border:1.5px solid var(--fd-border); border-radius:12px; overflow:hidden; display:flex; flex-direction:column; transition:box-shadow .2s,transform .2s; min-width:0; width:100%; }
.fp-prod-card:hover { box-shadow:0 8px 26px rgba(13,33,79,.10); transform:translateY(-2px); }
.fp-badge           { position:absolute; top:10px; left:10px; z-index:2; background:var(--fd-gold); color:var(--fd-blue-navy); font-size:10px; font-weight:800; padding:3px 8px; border-radius:6px; font-family:var(--fd-font-body); }
.fp-img-wrap        { display:flex; align-items:center; justify-content:center; height:160px; background:var(--fd-bg-soft); padding:12px; text-decoration:none; overflow:hidden; }
.fp-img-wrap img    { max-height:136px; max-width:100%; object-fit:contain; transition:transform .25s; }
.fp-prod-card:hover .fp-img-wrap img { transform:scale(1.05); }
.fp-card-body       { padding:12px 14px 14px; display:flex; flex-direction:column; gap:6px; flex:1; }
.fp-cat-label       { font-size:10px; font-weight:700; color:var(--fd-blue); text-transform:uppercase; letter-spacing:.5px; }
.fp-prod-name       { font-size:13px; font-weight:700; color:var(--fd-text); font-family:var(--fd-font-body); line-height:1.35; text-decoration:none; display:-webkit-box; -webkit-line-clamp:2; line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.fp-prod-name:hover { color:var(--fd-blue); }
.fp-price-row       { display:flex; align-items:center; gap:7px; flex-wrap:wrap; margin-top:2px; }
.fp-reg-price       { font-size:11px; color:#bbb; text-decoration:line-through; }
.fp-sale-price      { font-size:15px; font-weight:900; color:var(--fd-blue); font-family:var(--fd-font-body); }
.fp-sale-price ins  { text-decoration:none; }
.fp-add-btn         { display:flex; align-items:center; justify-content:center; gap:7px; margin-top:auto; background:var(--fd-blue); color:#fff; font-size:12px; font-weight:800; padding:10px 14px; border-radius:8px; text-decoration:none; font-family:var(--fd-font-body); transition:background .2s; white-space:nowrap; overflow:hidden; min-width:0; width:100%; border: none; cursor: pointer; }
.fp-add-btn:hover   { background:var(--fd-blue-dark); }
.fp-add-btn.fp-rx-btn { background:#e53935; }
.fp-add-btn.fp-rx-btn:hover { background:#c62828; }
.fp-add-btn.atc-loading { pointer-events: none; opacity: .7; }
.fp-wa-btn          { display:flex; align-items:center; justify-content:center; gap:7px; background:#25d366; color:#fff; font-size:12px; font-weight:800; padding:10px 14px; border-radius:8px; text-decoration:none; font-family:var(--fd-font-body); transition:background .2s; white-space:nowrap; overflow:hidden; min-width:0; width:100%; }
.fp-wa-btn:hover    { background:#1ebe5a; color:#fff; }
.fp-no-products     { color:#888; font-size:13px; grid-column:1/-1; padding:20px 0; text-align:center; }

/* Hide default WooCommerce notices — we use our own toast */
.woocommerce-notices-wrapper,
.woocommerce-message,
.woocommerce-info,
ul.woocommerce-error,
.wc-forward { display: none !important; }

/* ══════════════════════════════════════════════════════
   FIXED TOAST NOTIFICATION
   ══════════════════════════════════════════════════════ */
#carevee-toast {
  position: fixed;
  bottom: 100px;
  right: 24px;
  z-index: 999999;
  min-width: 280px;
  max-width: 340px;
  background: var(--fd-blue-navy);
  color: #fff;
  border-radius: 14px;
  padding: 14px 16px;
  box-shadow: 0 12px 40px rgba(0,0,0,.3);
  display: flex;
  align-items: flex-start;
  gap: 12px;
  font-family: var(--fd-font-body);
  opacity: 0;
  transform: translateY(20px) scale(0.95);
  transition: opacity .4s cubic-bezier(.34,1.56,.64,1),
              transform .4s cubic-bezier(.34,1.56,.64,1);
  pointer-events: none;
}
#carevee-toast.cv-show {
  opacity: 1;
  transform: translateY(0) scale(1);
  pointer-events: all;
}
.cv-toast-icon-wrap {
  width: 36px; height: 36px; border-radius: 50%;
  background: var(--fd-blue);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; margin-top: 1px;
}
.cv-toast-body { flex: 1; min-width: 0; }
.cv-toast-title {
  font-size: .72rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: .08em; color: var(--fd-gold); margin-bottom: 3px;
}
.cv-toast-name {
  font-size: .85rem; font-weight: 700; color: #fff;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  margin-bottom: 10px;
}
.cv-toast-actions { display: flex; gap: 8px; }
.cv-toast-btn-cart {
  display: inline-flex; align-items: center; gap: 5px;
  background: var(--fd-blue); color: #fff;
  padding: 6px 12px; border-radius: 8px;
  font-size: .72rem; font-weight: 800;
  text-decoration: none; transition: background .2s;
  white-space: nowrap;
}
.cv-toast-btn-cart:hover { background: var(--fd-blue-dark); color: #fff; }
.cv-toast-btn-close {
  display: inline-flex; align-items: center;
  background: rgba(255,255,255,.1); color: rgba(255,255,255,.7);
  padding: 6px 10px; border-radius: 8px; border: none; cursor: pointer;
  font-size: .72rem; font-weight: 700; transition: background .2s;
  font-family: var(--fd-font-body);
}
.cv-toast-btn-close:hover { background: rgba(255,255,255,.2); color: #fff; }
.cv-toast-progress {
  position: absolute; bottom: 0; left: 0; right: 0; height: 4px;
  background: rgba(255,255,255,.15); border-radius: 0 0 14px 14px; overflow: hidden;
}
.cv-toast-progress-bar {
  height: 100%; width: 100%;
  background: var(--fd-blue);
  transform-origin: left;
  animation: none;
}
#carevee-toast.cv-show .cv-toast-progress-bar {
  animation: cvCountdown 5s linear forwards;
}
@keyframes cvCountdown {
  from { transform: scaleX(1); }
  to   { transform: scaleX(0); }
}
@media(max-width:600px) {
  #carevee-toast { bottom: 80px; right: 12px; left: 12px; min-width: unset; max-width: unset; }
}

/* ── Newsletter ── */
.fp-newsletter      { background:linear-gradient(135deg,#eef1f8 0%,#dde3f2 50%,#eef1f8 100%); border-radius:14px; padding:44px 28px; text-align:center; }
.fp-newsletter-wrap { max-width:1380px; width:100%; margin:0 auto; padding:0 20px 20px; }
.fp-newsletter h2   { font-family:var(--fd-font-head); font-size:24px; font-weight:900; color:var(--fd-text); margin:0 0 7px; }
.fp-newsletter p    { color:var(--fd-text-light); font-size:13px; margin:0 0 20px; }
.fp-nl-form         { display:flex; max-width:520px; width:100%; margin:0 auto; border-radius:50px; overflow:hidden; box-shadow:0 6px 20px rgba(13,33,79,.10); background:#fff; }
.fp-nl-form input[type="email"]              { flex:1; border:none; outline:none; padding:12px 20px; font-size:13px; color:#333; min-width:0; font-family:var(--fd-font-body); }
.fp-nl-form input[type="email"]::placeholder { color:#aaa; }
.fp-nl-form button  { background:var(--fd-blue); color:#fff; border:none; padding:12px 22px; font-size:11px; font-weight:800; cursor:pointer; font-family:var(--fd-font-body); display:flex; align-items:center; gap:6px; white-space:nowrap; transition:background .2s; flex-shrink:0; }
.fp-nl-form button:hover { background:var(--fd-blue-dark); }
.nl-success { color:var(--fd-blue); font-weight:700; font-size:13px; margin-top:12px; }

/* ══════════════════════════════════════════════════════
   RESPONSIVE
   ══════════════════════════════════════════════════════ */
@media (max-width:860px) {
    .page-body { flex-direction:column; padding:10px; gap:0; }
    .sidebar-wrapper { width:100% !important; min-width:0 !important; max-width:100% !important; position:static !important; max-height:0; overflow:hidden; transition:max-height .4s ease; margin-bottom:0; border-radius:0; }
    .sidebar-wrapper.open { max-height:3000px; margin-bottom:10px; overflow:visible; }
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

<!-- FIXED TOAST HTML -->
<div id="carevee-toast" role="alert" aria-live="assertive">
  <div class="cv-toast-icon-wrap">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
  </div>
  <div class="cv-toast-body">
    <div class="cv-toast-title">✓ Added to Cart</div>
    <div class="cv-toast-name" id="cv-toast-name"></div>
    <div class="cv-toast-actions">
      <a href="<?php echo esc_url( function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#' ); ?>" class="cv-toast-btn-cart">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>
        View Cart
      </a>
      <button class="cv-toast-btn-close" id="cv-toast-close" type="button">Dismiss</button>
    </div>
  </div>
  <div class="cv-toast-progress">
    <div class="cv-toast-progress-bar" id="cv-toast-bar"></div>
  </div>
</div>

<!-- MOBILE SIDEBAR TOGGLE -->
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

    <!-- SIDEBAR -->
    <aside class="sidebar-wrapper" id="sidebarWrapper">
        <?php get_sidebar(); ?>
    </aside>

    <!-- MAIN -->
    <main class="site-main" id="mainContent">

        <!-- HERO -->
        <div class="fp-card" style="padding:0;overflow:hidden;border-radius:16px;">
            <div class="fd-hero" id="fdHero" role="banner" aria-roledescription="carousel" aria-label="Family Drugmart Kenya — Trusted Online Pharmacy">

                <!-- SLIDE 1 — PHARMACY -->
                <div class="fd-hero-slide active" data-slide-index="0" style="background-image:url('<?php echo esc_url( FD_THEME_URI . '/assets/js/images/doctors2.png' ); ?>');">
                    <div class="fd-hero-slide-bg" aria-hidden="true"></div>
                    <div class="fd-hero-overlay" aria-hidden="true"></div>
                    <div class="fd-hero-frame-border" aria-hidden="true"></div>
                    <div class="fd-hero-content">
                        <div class="fd-hero-content-top">
                            <span class="fd-hero-tag">Kenya's Trusted Pharmacy</span>
                            <h1 class="fd-hero-heading" data-main="Expert Advice, " data-highlight="Right When You Need It"><span class="fd-hero-heading-main"></span><span class="fd-hero-heading-highlight"></span><span class="fd-hero-cursor">|</span></h1>
                        </div>
                        <div class="fd-hero-content-bottom">
                            <p class="fd-hero-desc">Chat live with our qualified pharmacists every day. Trusted guidance on medications, supplements &amp; health questions, all in one place.</p>
                            <div class="fd-hero-actions">
                                <a href="<?php echo esc_url($shop_url); ?>" class="fd-hero-btn-primary">
                                    Shop Now
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="13" height="13" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                                <a href="https://wa.me/<?php echo esc_attr( $fd_wa_number ); ?>?text=<?php echo rawurlencode("Hi! I'd like to speak with a pharmacist."); ?>"
                                   class="fd-hero-btn-blue" target="_blank" rel="noopener noreferrer">
                                    Talk to a Pharmacist &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                  
                </div>

                <!-- SLIDE 2 — SKINCARE -->
                <div class="fd-hero-slide" data-slide-index="1" style="background-image:url('<?php echo esc_url( FD_THEME_URI . '/assets/js/images/skincare.png' ); ?>');">
                    <div class="fd-hero-slide-bg" aria-hidden="true"></div>
                    <div class="fd-hero-overlay" aria-hidden="true"></div>
                    <div class="fd-hero-frame-border" aria-hidden="true"></div>
                    <div class="fd-hero-content">
                        <div class="fd-hero-content-top">
                            <span class="fd-hero-tag">Glow Naturally</span>
                            <h1 class="fd-hero-heading" data-main="Skincare That " data-highlight="Loves You Back"><span class="fd-hero-heading-main"></span><span class="fd-hero-heading-highlight"></span><span class="fd-hero-cursor">|</span></h1>
                        </div>
                        <div class="fd-hero-content-bottom">
                            <p class="fd-hero-desc">Dermatologist-trusted skincare for every skin type, sourced and stocked with care.</p>
                            <div class="fd-hero-actions">
                                <a href="<?php echo esc_url($skincare_url); ?>" class="fd-hero-btn-primary">
                                    Shop Skincare
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="13" height="13" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 3 — BABY CARE -->
                <div class="fd-hero-slide" data-slide-index="2" style="background-image:url('<?php echo esc_url( FD_THEME_URI . '/assets/js/images/babycare.png' ); ?>');">
                    <div class="fd-hero-slide-bg" aria-hidden="true"></div>
                    <div class="fd-hero-overlay" aria-hidden="true"></div>
                    <div class="fd-hero-frame-border" aria-hidden="true"></div>
                    <div class="fd-hero-content">
                        <div class="fd-hero-content-top">
                            <span class="fd-hero-tag">Gentle Care, Trusted Brands</span>
                            <h1 class="fd-hero-heading" data-main="Everything Your " data-highlight="Baby Needs"><span class="fd-hero-heading-main"></span><span class="fd-hero-heading-highlight"></span><span class="fd-hero-cursor">|</span></h1>
                        </div>
                        <div class="fd-hero-content-bottom">
                            <p class="fd-hero-desc">From formula to baby skincare, shop trusted essentials for your little one.</p>
                            <div class="fd-hero-actions">
                                <a href="<?php echo esc_url($infant_url); ?>" class="fd-hero-btn-primary">
                                    Shop Baby Care
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="13" height="13" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NAV ARROWS -->
                <button type="button" class="fd-hero-nav fd-hero-nav-prev" id="fdHeroPrev" aria-label="Previous slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button type="button" class="fd-hero-nav fd-hero-nav-next" id="fdHeroNext" aria-label="Next slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                </button>

                <!-- DOTS -->
                <div class="fd-hero-dots" id="fdHeroDots">
                    <button type="button" class="fd-hero-dot active" data-go-to="0" aria-label="Go to slide 1"></button>
                    <button type="button" class="fd-hero-dot" data-go-to="1" aria-label="Go to slide 2"></button>
                    <button type="button" class="fd-hero-dot" data-go-to="2" aria-label="Go to slide 3"></button>
                </div>

            </div>
        </div>

        <!-- PROMO CARDS -->
        <div class="promo-cards-row">
            <div class="promo-card-h promo-vitamins">
                <div class="promo-left">
                    <h3>Vitamins &amp; Supplements</h3>
                    <div class="promo-upto">UP TO</div>
                    <div class="promo-pct">30% off</div>
                </div>
                <a href="<?php echo esc_url($vitamins_url); ?>" class="promo-shop-btn">&rarr; SHOP NOW</a>
            </div>
            <div class="promo-card-h promo-diabetic">
                <div class="promo-left">
                    <h3>Diabetic &amp; Wellness</h3>
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

            <!-- HEALTH PRODUCTS -->
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
                        $q1 = fd_get_products('featured', 3);
                        if ( $q1->have_posts() ) :
                            while ( $q1->have_posts() ) : $q1->the_post(); fd_render_product_card(); endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="fp-no-products">No products found.</p>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- SALE PRODUCTS -->
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
                                while ( $q2->have_posts() && $count < 6 ) : $q2->the_post(); $count++; fd_render_product_card(); endwhile;
                                wp_reset_postdata();
                            else :
                                $q2b = new WP_Query(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>6,'orderby'=>'date','order'=>'DESC']);
                                if ( $q2b->have_posts() ) :
                                    while ( $q2b->have_posts() ) : $q2b->the_post(); fd_render_product_card(); endwhile;
                                    wp_reset_postdata();
                                endif;
                            endif;
                        else :
                            $q2b = new WP_Query(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>6,'orderby'=>'date','order'=>'DESC']);
                            if ( $q2b->have_posts() ) :
                                while ( $q2b->have_posts() ) : $q2b->the_post(); fd_render_product_card(); endwhile;
                                wp_reset_postdata();
                            else :
                                echo '<p class="fp-no-products">No products found.</p>';
                            endif;
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- TRENDING PRODUCTS -->
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
                        $q3 = fd_get_products('trending', 3);
                        if ( $q3->have_posts() ) :
                            while ( $q3->have_posts() ) : $q3->the_post(); fd_render_product_card(); endwhile;
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

<!-- NEWSLETTER -->
<div class="fp-newsletter-wrap">
    <div class="fp-newsletter">
        <h2>Sign Up For Our Newsletter</h2>
        <p>Get health tips, new arrivals and discount codes straight to your inbox.</p>
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

    function initHeroCarousel() {
        var hero = document.getElementById('fdHero');
        if (!hero) return;

        var slides  = Array.prototype.slice.call(hero.querySelectorAll('.fd-hero-slide'));
        var dots    = Array.prototype.slice.call(hero.querySelectorAll('.fd-hero-dot'));
        var prevBtn = document.getElementById('fdHeroPrev');
        var nextBtn = document.getElementById('fdHeroNext');
        var total   = slides.length;
        if (!total) return;

        var current      = 0;
        var autoTimer     = null;
        var AUTOPLAY_MS   = 6000;
        var TYPE_SPEED_MS = 35;

        function typeHeading(slideEl) {
            var heading = slideEl.querySelector('.fd-hero-heading');
            if (!heading) return;
            var main = heading.getAttribute('data-main') || '';
            var hi   = heading.getAttribute('data-highlight') || '';
            var full = main + hi;
            var mainSpan = heading.querySelector('.fd-hero-heading-main');
            var hiSpan   = heading.querySelector('.fd-hero-heading-highlight');
            if (!mainSpan || !hiSpan) return;

            clearInterval(heading._typeTimer);
            mainSpan.textContent = '';
            hiSpan.textContent   = '';

            var i = 0;
            heading._typeTimer = setInterval(function () {
                i++;
                var typed = full.slice(0, i);
                if (typed.length <= main.length) {
                    mainSpan.textContent = typed;
                    hiSpan.textContent   = '';
                } else {
                    mainSpan.textContent = main;
                    hiSpan.textContent   = typed.slice(main.length);
                }
                if (i >= full.length) {
                    clearInterval(heading._typeTimer);
                }
            }, TYPE_SPEED_MS);
        }

        function goTo(index) {
            index = ((index % total) + total) % total;
            if (index === current) return;
            slides[current].classList.remove('active');
            if (dots[current]) dots[current].classList.remove('active');
            current = index;
            slides[current].classList.add('active');
            if (dots[current]) dots[current].classList.add('active');
            setTimeout(function () { typeHeading(slides[current]); }, 260);
        }

        function next() { goTo(current + 1); }
        function prev() { goTo(current - 1); }

        function startAuto() {
            stopAuto();
            autoTimer = setInterval(next, AUTOPLAY_MS);
        }
        function stopAuto() {
            if (autoTimer) clearInterval(autoTimer);
        }

        if (nextBtn) nextBtn.addEventListener('click', function () { next(); startAuto(); });
        if (prevBtn) prevBtn.addEventListener('click', function () { prev(); startAuto(); });
        dots.forEach(function (dot, i) {
            dot.addEventListener('click', function () { goTo(i); startAuto(); });
        });

        hero.addEventListener('mouseenter', stopAuto);
        hero.addEventListener('mouseleave', startAuto);

        setTimeout(function () { typeHeading(slides[0]); }, 450);
        startAuto();
    }

    function init() {
        initSidebar();
        initHeroCarousel();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
}());
</script>

<!-- ATC + Scroll-restore + Toast JS -->
<script>
(function(){

  /* ══════════════════════════════════════════
     TOAST
  ══════════════════════════════════════════ */
  var toast       = document.getElementById('carevee-toast');
  var toastNameEl = document.getElementById('cv-toast-name');
  var toastBar    = document.getElementById('cv-toast-bar');
  var closeBtn    = document.getElementById('cv-toast-close');
  var hideTimer   = null;

  function showToast(name) {
    if (!toast) return;
    if (toastNameEl) toastNameEl.textContent = name || '';
    if (toastBar) {
      toastBar.style.animation = 'none';
      void toastBar.offsetWidth;
      toastBar.style.animation = '';
    }
    toast.classList.add('cv-show');
    if (hideTimer) clearTimeout(hideTimer);
    hideTimer = setTimeout(function(){ toast.classList.remove('cv-show'); }, 5000);
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', function(){
      toast.classList.remove('cv-show');
      if (hideTimer) clearTimeout(hideTimer);
    });
  }

  /* ══════════════════════════════════════════
     ON PAGE LOAD — restore scroll + show toast
     if we came back from an add-to-cart reload
  ══════════════════════════════════════════ */
  var params      = new URLSearchParams(window.location.search);
  var toastName   = params.get('cv_added_name');
  var savedScroll = sessionStorage.getItem('cv_scroll_pos');

  if (toastName) {
    /* Restore scroll immediately — before any paint */
    if (savedScroll !== null) {
      var scrollY = parseInt(savedScroll, 10);
      window.scrollTo(0, scrollY);
    }

    /* Restore again after full load (browser sometimes overrides) */
    window.addEventListener('load', function() {
      if (savedScroll !== null) window.scrollTo(0, parseInt(savedScroll, 10));
      sessionStorage.removeItem('cv_scroll_pos');
    });

    /* Show toast once DOM is ready */
    document.addEventListener('DOMContentLoaded', function() {
      if (savedScroll !== null) window.scrollTo(0, parseInt(savedScroll, 10));
      showToast(decodeURIComponent(toastName));
    });

    /* Clean the URL — remove our params so refresh doesn't re-toast */
    var cleanUrl = new URL(window.location.href);
    cleanUrl.searchParams.delete('cv_added_name');
    cleanUrl.searchParams.delete('added-to-cart');
    cleanUrl.searchParams.delete('add-to-cart');
    window.history.replaceState(null, '', cleanUrl.toString());
  }

  /* ══════════════════════════════════════════
     ADD TO CART — save scroll → reload
     WC processes the add natively on reload.
     Page comes back to exact same Y position.
     Toast appears. Cart count updates.
  ══════════════════════════════════════════ */
  document.querySelectorAll('.carevee-atc-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();

      var pid  = btn.getAttribute('data-pid');
      var name = btn.getAttribute('data-name');

      /* Save scroll position to sessionStorage before navigating */
      var scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
      sessionStorage.setItem('cv_scroll_pos', scrollY);

      /* Loading feedback */
      btn.classList.add('atc-loading');
      var txtEl = btn.querySelector('.fp-atc-txt');
      if (txtEl) txtEl.textContent = 'Adding…';

      /* Build URL: WC ?add-to-cart=X processes the add on load */
      var url = new URL(window.location.href);
      url.searchParams.set('add-to-cart',   pid);
      url.searchParams.set('quantity',      '1');
      url.searchParams.set('cv_added_name', encodeURIComponent(name));

      window.location.href = url.toString();
    });
  });

})();
</script>

<?php get_footer(); ?>