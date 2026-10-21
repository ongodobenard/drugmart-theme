<?php
/**
 * Front Page Template — Family Drugmart Kenya
 * SEO: Family Drugmart | Affordable Online Pharmacy Kenya
 */

if ( ! defined('ABSPATH') ) { die(); }

/* ══════════════════════════════════════════════════════════════
   SEO — must run BEFORE get_header() so wp_head can output it.
   If you use Yoast or Rank Math, delete this whole SEO block
   (title, description, canonical, schema) and set them in the plugin.
   ══════════════════════════════════════════════════════════════ */
$FD_SEO_TITLE = 'Family Drugmart | Affordable Online Pharmacy Kenya';
$FD_SEO_DESC  = 'Trusted, affordable online pharmacy Kenya in Ruaka, Nairobi. Best prices on prescribed drugs, baby formula, vitamins, skin care and scans. PPB licensed.';
$FD_SEO_KEYWORDS = 'trusted pharmacy in Kenya, best pharmacy in Nairobi, top pharmacy in Nairobi, affordable online pharmacy Kenya, licensed pharmacy Kenya, PPB licensed pharmacy, genuine medicines Kenya, reliable pharmacy Nairobi, cheap pharmacy Nairobi, pharmacy near me Ruaka, prescribed drugs Kenya, baby formula Kenya, best skin care products in Kenya, top vitamins and supplements Kenya, ultrasound Nairobi';
$FD_PPB_LICENSE = 'PPB/F/3208';

/* Opening hours — keep ONE copy here so text, FAQ and schema never drift apart. */
$FD_HOURS_TEXT = 'Mon to Fri 8:30am to 6pm, Sat 9am to 1pm';

/* functions.php already prints a Pharmacy schema on every page (medicare_schema).
   This page prints its own fuller one below, so remove the duplicate here. */
remove_action( 'wp_head', 'medicare_schema' );

$fd_has_seo_plugin = defined( 'WPSEO_VERSION' )
    || defined( 'RANK_MATH_VERSION' )
    || defined( 'AIOSEO_VERSION' )
    || defined( 'SEOPRESS_VERSION' )
    || defined( 'THE_SEO_FRAMEWORK_VERSION' );

if ( ! $fd_has_seo_plugin ) {

    add_filter( 'pre_get_document_title', function ( $title ) use ( $FD_SEO_TITLE ) {
        return is_front_page() ? $FD_SEO_TITLE : $title;
    }, 99 );

    add_action( 'wp_head', function () use ( $FD_SEO_DESC, $FD_SEO_TITLE, $FD_SEO_KEYWORDS ) {
        if ( ! is_front_page() ) return;
        echo '<meta name="description" content="' . esc_attr( $FD_SEO_DESC ) . '">' . "\n";
        echo '<meta name="keywords" content="' . esc_attr( $FD_SEO_KEYWORDS ) . '">' . "\n";
        echo '<link rel="canonical" href="' . esc_url( home_url( '/' ) ) . '">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr( $FD_SEO_TITLE ) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr( $FD_SEO_DESC ) . '">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:url" content="' . esc_url( home_url( '/' ) ) . '">' . "\n";
    }, 1 );

}

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

$vitamins_url   = fd_cat_url(['vitamins-supplements','vitamins','supplements','vitamin']);
$diabetic_url   = fd_cat_url(['diabetic','diabetes','diabetic-care','diabetes-care','diabetic-weight']);
$infant_url     = fd_cat_url(['infant-baby','infant','baby','baby-formula','infant-formula']);
$skincare_url   = fd_cat_url(['skincare','skin-care','skin','beauty-skincare','beauty']);
$ultrasound_url = home_url('/ultra-sound-service/');

/* Prescription promo card link */
$prescription_url = home_url('/submit-prescription/');

$shop_url       = function_exists('wc_get_page_id')
    ? esc_url( get_permalink( wc_get_page_id('shop') ) )
    : home_url('/shop/');

$fd_wa_number = function_exists('medicare_wa') ? medicare_wa() : '254796140021';

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
    $is_simple  = $product->is_type('simple');
    $is_rx      = medicare_is_prescription_product( get_the_ID() );
    $in_stock   = $product->is_in_stock();
    $title_short = mb_strlen($title) > 30 ? mb_substr($title, 0, 30) . '…' : $title;

    $current_price = (float) $product->get_price();
    $price_text    = 'KES ' . number_format( $current_price, 2 );

    $wa_url   = fd_whatsapp_url( $title, $url, $price_text );
    $cats     = get_the_terms( get_the_ID(), 'product_cat' );
    $cat_name = ( $cats && ! is_wp_error($cats) ) ? esc_html( $cats[0]->name ) : '';

    /* Ultrasound Services is a booked service, not a stocked product. */
    $is_service_cat = false;
    if ( $cats && ! is_wp_error($cats) ) {
        foreach ( $cats as $__c ) {
            if ( stripos($__c->slug, 'ultrasound') !== false || stripos($__c->name, 'ultrasound') !== false ) {
                $is_service_cat = true;
                break;
            }
        }
    }

    /* WhatsApp button label — mirrors single-product.php logic. */
    if ( $is_service_cat ) {
        $wa_btn_label = 'Service Enquiry';
    } elseif ( $is_rx ) {
        $wa_btn_label = 'Medicine Enquiry';
    } else {
        $wa_btn_label = 'Order Via WhatsApp';
    }

    $atc_btn_label = $in_stock ? 'Add to Cart' : 'Out of Stock';
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
                <?php if ( $in_stock ) : ?>
                <a href="<?php echo esc_url( medicare_prescription_url( get_the_ID() ) ); ?>" class="fp-add-btn fp-rx-btn">
                    <svg class="fp-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13" aria-hidden="true">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    Submit Prescription
                </a>
                <?php else : ?>
                <span class="fp-add-btn fp-rx-btn atc-outofstock" aria-disabled="true">
                    <svg class="fp-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13" aria-hidden="true">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    Out of Stock
                </span>
                <?php endif; ?>
            <?php elseif ( $is_simple ) : ?>
                <button type="button"
                    class="fp-add-btn carevee-atc-btn<?php echo $in_stock ? '' : ' atc-outofstock'; ?>"
                    data-pid="<?php echo esc_attr( get_the_ID() ); ?>"
                    data-name="<?php echo esc_attr( $title_short ); ?>"
                    <?php echo $in_stock ? '' : 'disabled aria-disabled="true"'; ?>>
                    <svg class="fp-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13" height="13" aria-hidden="true">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span class="fp-atc-txt"><?php echo esc_html( $atc_btn_label ); ?></span>
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
                <?php echo esc_html( $wa_btn_label ); ?>
            </a>
        </div>
    </div>
    <?php
}
endif;

if ( ! function_exists('fd_get_products') ) :
function fd_get_products( string $type, int $limit = 6, string $cat_slug = '' ) : WP_Query {
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
        case 'category':
            $q = new WP_Query( array_merge($base, [
                'orderby'   => 'date',
                'order'     => 'DESC',
                'tax_query' => [[
                    'taxonomy'         => 'product_cat',
                    'field'            => 'slug',
                    'terms'            => $cat_slug,
                    'include_children' => true,
                ]],
            ]));
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

/* ══ SEO content data ══ */
$FD_FAQS = [
    [ 'q' => 'Is Family Drugmart Kenya a licensed pharmacy?',
      'a' => 'Yes. Family Drugmart Kenya is a Pharmacy and Poisons Board (PPB) licensed pharmacy in Kenya, License No: ' . $FD_PPB_LICENSE . '.' ],
    [ 'q' => 'Where is Family Drugmart Kenya located?',
      'a' => 'We are at ' . medicare_address() . ', serving Ruaka, Banana, Kiambu and Nairobi. You can also order online and have your items delivered.' ],
    [ 'q' => 'What are your opening hours?',
      'a' => 'We are open Monday to Friday from 8:30am to 6pm and on Saturday from 9am to 1pm. You can place orders on the website at any time. Messages sent on WhatsApp outside these hours are answered when we reopen.' ],
    [ 'q' => 'Which is the best pharmacy in Nairobi?',
      'a' => 'Family Drugmart Kenya aims to be the best pharmacy in Nairobi for our customers. We are a PPB licensed, trusted pharmacy in Ruaka offering genuine medicines, affordable prices, friendly pharmacy professionals, pay on delivery and delivery across Nairobi.' ],
    [ 'q' => 'Is Family Drugmart a trusted and affordable pharmacy in Kenya?',
      'a' => 'Yes. We are a PPB licensed pharmacy (License No: ' . $FD_PPB_LICENSE . ') and we stock genuine, quality products at affordable prices, with regular offers on vitamins, diabetic care and baby formula.' ],
    [ 'q' => 'Can I buy medicine online in Kenya from Family Drugmart?',
      'a' => 'Yes. Browse our affordable online pharmacy and place your order on the website or on WhatsApp. In Nairobi and environs you pay cash or M-Pesa on delivery. Prescription medicines need a valid prescription, which you can upload on our Submit Prescription page.' ],
    [ 'q' => 'How much is delivery in Nairobi?',
      'a' => 'Delivery in Nairobi is KES 300, and it is free for orders of KES 2,500 and above. For other counties, contact us on WhatsApp for your county rate; full payment is made before dispatch.' ],
    [ 'q' => 'Do you deliver temperature-sensitive medicines?',
      'a' => 'Yes. Temperature-sensitive medicines, such as insulin, are packed in insulated packaging with ice packs to keep them cool during delivery. Chat with us on WhatsApp to confirm availability and delivery for your area.' ],
    [ 'q' => 'Do I need a prescription for Ozempic, Mounjaro, Wegovy or Rybelsus?',
      'a' => 'Yes. These are prescription-only medicines in Kenya. Upload your prescription and a pharmacy professional will review it, or chat with us on WhatsApp for availability and current prices.' ],
    [ 'q' => 'Do you sell baby formula in Nairobi?',
      'a' => 'Yes. Our infant and baby section includes the best baby formula, baby care and baby skincare products. Ask our pharmacy professional if you need help choosing a formula for your baby.' ],
    [ 'q' => 'Do you stock Jamieson vitamins and supplements?',
      'a' => 'Yes. Shop Jamieson and other top, trusted vitamins and supplements, including multivitamins, vitamin D and omega 3.' ],
    [ 'q' => 'Where can I get an ultrasound or obs scan near Ruaka and Nairobi?',
      'a' => 'We offer in-store and home visit ultrasound scans, including obs, breast, abdominal, pelvic, testicular and scrotal scans, as well as mobile ultrasound. Book on our ultrasound page or enquire on WhatsApp.' ],
];

/* Info boxes (one row, 3 visible on desktop, the rest slide slowly left).
   Each topic appears ONCE only. */
$FD_BOXES = [
    [ 'Best Pharmacy in Nairobi',
      'Family Drugmart is a trusted, top pharmacy in Nairobi for genuine medicines, affordable prices and friendly pharmacy professionals. PPB licensed, with pay on delivery.' ],
    [ 'Trusted Prescribed Drugs Kenya',
      'Order genuine prescription medicine in Nairobi from a trusted, licensed pharmacy. <a href="' . esc_url( $prescription_url ) . '">Upload your prescription online</a> and our pharmacy professional reviews it before your order is processed.' ],
    [ 'Affordable Diabetes &amp; Weight Management',
      'Shop <a href="' . esc_url( $diabetic_url ) . '">diabetic care products in Kenya</a> such as glucometers and test strips. Injectables like Ozempic or Mounjaro are prescription-only; chat with our pharmacy professionals for availability and prices.' ],
    [ 'Best Baby Formula Kenya',
      'Buy the best baby formula online in Kenya, plus baby milk, baby care products and <a href="' . esc_url( $infant_url ) . '">baby skincare</a>.' ],
    [ 'Top Vitamins &amp; Supplements',
      'Jamieson vitamins and other trusted supplements, from multivitamins and vitamin D to omega 3. <a href="' . esc_url( $vitamins_url ) . '">Buy vitamins online in Kenya</a>.' ],
    [ 'Best Skin Care Products in Kenya',
      'Find the best skin care products in Nairobi for acne, moisturising and sun protection. <a href="' . esc_url( $skincare_url ) . '">Shop skin care Kenya</a>.' ],
    [ 'Affordable Ultrasound &amp; Obs Scans',
      'Book an <a href="' . esc_url( $ultrasound_url ) . '">affordable ultrasound in Ruaka and Nairobi</a>: obs, breast, abdominal, pelvic and scrotal scans, in-store or at home.' ],
    [ 'Affordable Delivery &amp; Payment',
      'Delivery in Nairobi is KES 300, free for orders from KES 2,500. Pay cash or M-Pesa on delivery. Other counties: contact us on WhatsApp for your rate.' ],
];

/* Category chips (one row, 5 visible on desktop, 3 on mobile, the rest slide slowly left) */
$FD_LOCAL_CATS = [
    [ 'Trusted prescription medicines Ruaka',                  ['prescription'] ],
    [ 'Affordable blood pressure medicine Nairobi',               ['blood-pressure-medicine','hypertension'] ],
    [ 'Heart and cardiovascular medicines Kenya',      ['cardiovascular-and-cerebrovascular'] ],
    [ 'Diabetes and weight loss medicines Nairobi',    ['diabetes','weight-management'] ],
    [ 'Vaccines and immunization Nairobi',             ['vaccins-and-immunization'] ],
    [ 'Antibiotics and anti-infectives Kenya',         ['anti-infective'] ],
    [ 'Brain and nervous system medicines Kenya',      ['brain-and-nervous-system-disorder'] ],
    [ 'Hormonal and steroid medicines Kenya',          ['hormonal-and-steroids'] ],
    [ 'Kidney (renal) care Kenya',                     ['renal-wellbeing'] ],
    [ 'Digestive health medicines Nairobi',            ['digestive-system'] ],
    [ 'Reproductive health and sexual wellness Nairobi', ['reproductive-health-and-sexual-wellness'] ],
    [ 'Oncology (cancer care) medicines Kenya',        ['oncology'] ],
    [ 'Top vitamins and supplements Ruaka',                ['vitamins-supplements','vitamins','supplements','vitamin'] ],
    [ 'Best baby formula and baby care Ruaka',              ['infant-baby','infant','baby','baby-formula','infant-formula'] ],
    [ 'Best skin care products in Kenya',              ['skincare','skin-care','skin','beauty-skincare','beauty'] ],
];

/* Resolve chip URLs once (not twice) */
$FD_CHIP_LINKS = [];
foreach ( $FD_LOCAL_CATS as $c ) {
    $FD_CHIP_LINKS[] = [ $c[0], fd_cat_url( $c[1] ) ];
}

$fd_pharmacy_schema = [
    '@context'     => 'https://schema.org',
    '@type'        => 'Pharmacy',
    'name'         => 'Family Drugmart Kenya',
    'alternateName'=> 'Family Drugmart',
    'description'  => $FD_SEO_DESC,
    'url'          => home_url( '/' ),
    'telephone'    => '+' . $fd_wa_number,
    'email'        => medicare_email(),
    'areaServed'   => [
        [ '@type' => 'City',    'name' => 'Nairobi' ],
        [ '@type' => 'Country', 'name' => 'Kenya' ],
    ],
    'address'      => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => medicare_address(),
        'addressLocality' => 'Ruaka',
        'addressRegion'   => 'Kiambu',
        'addressCountry'  => 'KE',
    ],
    'identifier'   => [ '@type' => 'PropertyValue', 'name' => 'Pharmacy and Poisons Board (PPB) Kenya License No', 'value' => $FD_PPB_LICENSE ],
    'paymentAccepted' => 'Cash on delivery, M-Pesa on delivery',
    'openingHoursSpecification' => [
        [ '@type'     => 'OpeningHoursSpecification',
          'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'],
          'opens'     => '08:30',
          'closes'    => '18:00' ],
        [ '@type'     => 'OpeningHoursSpecification',
          'dayOfWeek' => 'Saturday',
          'opens'     => '09:00',
          'closes'    => '13:00' ],
    ],
];
$fd_faq_schema = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map( function ( $f ) {
        return [ '@type' => 'Question', 'name' => $f['q'], 'acceptedAnswer' => [ '@type' => 'Answer', 'text' => $f['a'] ] ];
    }, $FD_FAQS ),
];
?>

<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Lato:wght@400;600;700&display=swap" rel="stylesheet">

<?php
$fd_has_yoast_local = defined( 'WPSEO_LOCAL_VERSION' ) || class_exists( 'WPSEO_Local_Core' );
if ( ! $fd_has_yoast_local ) : ?>
<script type="application/ld+json"><?php echo wp_json_encode( $fd_pharmacy_schema, JSON_UNESCAPED_SLASHES ); ?></script>
<?php endif; ?>
<script type="application/ld+json"><?php echo wp_json_encode( $fd_faq_schema, JSON_UNESCAPED_SLASHES ); ?></script>

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
    --fd-btn-radius:  6px;
}

.page-body {
    display: block;
    max-width: 1380px; width: 100%;
    margin: 0 auto; padding: 14px 20px; overflow-x: hidden;
    font-family: var(--fd-font-body);
}

.site-main {
    width: 100%; min-width: 0; min-height: 400px;
    display: flex; flex-direction: column; gap: 22px; overflow: visible;
}
.fp-card { width:100%; background:#fff; border-radius:14px; border:1.5px solid var(--fd-border); overflow:visible; }
.fp-card.gray { background:var(--fd-bg-soft); }
.fp-pad { padding:22px; }

/* ══ HERO ══ */
@keyframes fd-fade-up {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes fd-hero-zoom {
    from { transform: scale(1.04); }
    to   { transform: scale(1.00); }
}

.fd-hero {
    position: relative; width: 100%; border-radius: 16px;
    overflow: hidden; height: 460px; background-color: var(--fd-blue-navy);
}
.fd-hero-slide {
    position: absolute; inset: 0; background-size: cover;
    background-position: center 18%; background-repeat: no-repeat;
    border-radius: 16px; opacity: 0; visibility: hidden; z-index: 0;
    transition: opacity 1s ease;
}
.fd-hero-slide.active { opacity: 1; visibility: visible; z-index: 1; }
.fd-hero-slide.active .fd-hero-slide-bg { animation: fd-hero-zoom 7s ease-out forwards; }
.fd-hero-slide-bg {
    position: absolute; inset: 0; background-image: inherit;
    background-size: cover; background-position: inherit;
    background-repeat: no-repeat; border-radius: 16px;
}
.fd-hero-overlay {
    position: absolute; inset: 0; background: rgba(10,18,40,.18);
    z-index: 1; border-radius: 16px;
}
.fd-hero-overlay::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(to bottom, rgba(10,18,40,.55) 0%, rgba(10,18,40,.30) 40%, rgba(10,18,40,.40) 100%);
    pointer-events: none; border-radius: 16px;
}
.fd-hero-overlay::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 28%;
    background: linear-gradient(to top, rgba(10,18,40,.50) 0%, transparent 100%);
    pointer-events: none;
}
.fd-hero-frame-border {
    position: absolute; inset: 0; z-index: 2; border-radius: 16px;
    border-top: 4px solid var(--fd-gold); border-bottom: 3px solid var(--fd-blue);
    pointer-events: none;
}
.fd-hero-content {
    position: absolute; inset: 0; z-index: 5;
    display: flex; flex-direction: column; justify-content: space-between;
    align-items: center; text-align: center; padding: 32px 40px;
    width: 100%; max-width: 100%;
}
.fd-hero-content-top { display: flex; flex-direction: column; align-items: center; }
.fd-hero-content-bottom { display: flex; flex-direction: column; align-items: center; width: 100%; }

/* Headings are plain static text: no typing effect, no cursor, visible immediately. */
.fd-hero-heading {
    font-family: var(--fd-font-head); font-weight: 900;
    font-size: clamp(28px, 3.6vw, 48px); color: #fff; line-height: 1.18; margin: 0;
    text-shadow: 0 2px 12px rgba(0,0,0,.55); max-width: 780px;
}
.fd-hero-heading-highlight { color: var(--fd-gold); }

.fd-hero-desc {
    font-family: var(--fd-font-body); font-size: 15px; line-height: 1.75;
    color: rgba(255,255,255,.95); margin: 0 0 20px; max-width: 560px;
    text-shadow: 0 1px 8px rgba(0,0,0,.55);
    opacity: 0; animation: fd-fade-up .6s ease forwards; animation-delay: .34s;
}
.fd-hero-actions {
    display: flex; gap: 14px; align-items: center; justify-content: center;
    flex-wrap: wrap;
    opacity: 0; animation: fd-fade-up .6s ease forwards; animation-delay: .46s;
}
.fd-hero-btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--fd-gold); color: var(--fd-blue-navy);
    font-size: 13.5px; font-weight: 800; padding: 13px 30px; border-radius: var(--fd-btn-radius);
    text-decoration: none; font-family: var(--fd-font-body);
    box-shadow: 0 8px 22px rgba(0,0,0,.30); white-space: nowrap;
    transition: transform .18s, box-shadow .2s;
}
.fd-hero-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,.38); }
.fd-hero-btn-blue {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--fd-blue); color: #fff;
    font-size: 13.5px; font-weight: 800; padding: 13px 30px; border-radius: var(--fd-btn-radius);
    text-decoration: none; font-family: var(--fd-font-body);
    box-shadow: 0 8px 22px rgba(13,33,79,.35); white-space: nowrap;
    transition: transform .18s, box-shadow .2s, background .2s;
}
.fd-hero-btn-blue:hover { background: var(--fd-blue-dark); transform: translateY(-2px); box-shadow: 0 12px 28px rgba(13,33,79,.45); }

.fd-hero-nav {
    position: absolute; top: 50%; transform: translateY(-50%); z-index: 8;
    width: 42px; height: 42px; border-radius: var(--fd-btn-radius);
    background: rgba(255,255,255,.16); border: 1.5px solid rgba(255,255,255,.45);
    color: #fff; display: flex; align-items: center; justify-content: center;
    cursor: pointer; backdrop-filter: blur(6px);
    transition: background .2s, transform .2s, border-color .2s; padding: 0;
}
.fd-hero-nav:hover { background: rgba(255,255,255,.30); border-color: rgba(255,255,255,.7); transform: translateY(-50%) scale(1.08); }
.fd-hero-nav-prev { left: 16px; }
.fd-hero-nav-next { right: 16px; }

.fd-hero-dots {
    position: absolute; bottom: 16px; left: 0; right: 0; z-index: 7;
    display: flex; gap: 8px; align-items: center; justify-content: center;
}
.fd-hero-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: rgba(255,255,255,.45); border: none; padding: 0; cursor: pointer;
    transition: background .25s, width .25s, border-radius .25s;
}
.fd-hero-dot.active { background: var(--fd-gold); width: 22px; border-radius: 5px; }

@media (max-width: 1100px) { .fd-hero { height: 420px; } .fd-hero-content { padding: 28px; } }
@media (max-width: 768px) {
    .fd-hero { height: 360px !important; border-radius: 14px; }
    .fd-hero-slide { background-position: center 12% !important; }
    .fd-hero-content { padding: 20px 18px !important; }
    .fd-hero-heading { font-size: clamp(22px, 5.5vw, 30px) !important; }
    .fd-hero-desc { display: none !important; }
    .fd-hero-btn-blue { display: none; }
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
@media (max-width: 360px) { .fd-hero { height: 260px !important; } .fd-hero-heading { font-size: 17px !important; } }

/* ══ PROMO CARDS ══ */
.promo-cards-row {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px; width: 100%;
}
.promo-card-h {
    position: relative; overflow: hidden;
    display: flex; flex-direction: column; justify-content: flex-end;
    min-height: 260px; padding: 12px;
    border-radius: 12px;
    background-color: var(--fd-bg-soft);
    background-size: cover; background-position: center; background-repeat: no-repeat;
}
.promo-panel {
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
    width: 100%;
    background: rgba(255,255,255,.95);
    border-radius: 10px;
    padding: 10px 12px;
    box-shadow: 0 4px 16px rgba(10,18,40,.18);
}
.promo-left { min-width: 0; flex: 1; }
.promo-card-h h3 {
    font-family: var(--fd-font-body); font-size: 14px; font-weight: 800;
    margin: 0 0 2px; line-height: 1.25; color: var(--fd-blue-navy);
}
.promo-upto {
    font-size: 9px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
    color: var(--fd-text-light);
}
.promo-pct {
    font-size: 20px; font-weight: 900; font-family: var(--fd-font-body); line-height: 1.15;
    color: var(--fd-blue);
}
.promo-shop-btn {
    flex-shrink: 0; font-size: 10px; font-weight: 800; text-decoration: none;
    padding: 8px 12px; border-radius: var(--fd-btn-radius); white-space: nowrap;
    background: var(--fd-blue); color: #fff;
    transition: background .2s;
    font-family: var(--fd-font-body);
}
.promo-shop-btn:hover { background: var(--fd-blue-dark); color: #fff; }

/* ══ SECTION HEADER ══ */
.fp-section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; gap:10px; }
.fp-section-title  { font-family:var(--fd-font-head); font-size:17px; font-weight:900; color:var(--fd-text); padding-left:10px; border-left:3px solid var(--fd-gold); margin:0; }
.fp-view-all       { font-family:var(--fd-font-body); font-size:12px; font-weight:800; color:var(--fd-blue); text-decoration:none; white-space:nowrap; padding:7px 12px; border:1.5px solid var(--fd-border); border-radius:var(--fd-btn-radius); background:#fff; transition:background .2s,border-color .2s; }
.fp-view-all:hover { background:#eef1f8; border-color:var(--fd-blue); color:var(--fd-blue); }

/* ══ PRODUCT GRIDS ══ */
.fp-prod-grid-6      { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:14px; }
.fp-prod-grid-health { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:14px; }

@media (min-width:861px) {
    .fp-prod-grid-6 > .fp-prod-card:nth-child(n+6) { display:none; }
}
@media (max-width:860px) {
    .fp-prod-grid-health > .fp-prod-card:nth-child(n+5) { display:none; }
}

/* ══ PRODUCT CARD ══ */
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
.fp-add-btn         { display:flex; align-items:center; justify-content:center; gap:7px; margin-top:auto; background:var(--fd-blue); color:#fff; font-size:12px; font-weight:800; padding:10px 14px; border-radius:var(--fd-btn-radius); text-decoration:none; font-family:var(--fd-font-body); transition:background .2s; white-space:nowrap; overflow:hidden; min-width:0; width:100%; border:none; cursor:pointer; }
.fp-add-btn:hover   { background:var(--fd-blue-dark); }
.fp-add-btn.fp-rx-btn { background:#e53935; }
.fp-add-btn.fp-rx-btn:hover { background:#c62828; }
.fp-add-btn.atc-loading { pointer-events:none; opacity:.7; }
.fp-add-btn.atc-outofstock { pointer-events:none; opacity:.5; cursor:not-allowed !important; background:#c7cbd1 !important; color:#6b7280 !important; }
.fp-wa-btn          { display:flex; align-items:center; justify-content:center; gap:7px; background:#25d366; color:#fff; font-size:12px; font-weight:800; padding:10px 14px; border-radius:var(--fd-btn-radius); text-decoration:none; font-family:var(--fd-font-body); transition:background .2s; white-space:nowrap; overflow:hidden; min-width:0; width:100%; }
.fp-wa-btn:hover    { background:#1ebe5a; color:#fff; }
.fp-no-products     { color:#888; font-size:13px; grid-column:1/-1; padding:20px 0; text-align:center; }

@media (min-width:861px) {
    .fp-card-body { padding:10px 10px 12px; }
    .fp-img-wrap  { height:140px; }
    .fp-img-wrap img { max-height:116px; }
    .fp-add-btn, .fp-wa-btn { font-size:11px; padding:9px 8px; gap:5px; }
    .fp-sale-price { font-size:14px; }
}

.woocommerce-notices-wrapper, .woocommerce-message, .woocommerce-info,
ul.woocommerce-error, .wc-forward { display:none !important; }

/* ══ TOAST ══ */
#carevee-toast {
    position:fixed; bottom:100px; right:24px; z-index:999999;
    min-width:280px; max-width:340px;
    background:var(--fd-blue-navy); color:#fff; border-radius:14px;
    padding:14px 16px; box-shadow:0 12px 40px rgba(0,0,0,.3);
    display:flex; align-items:flex-start; gap:12px;
    font-family:var(--fd-font-body); opacity:0;
    transform:translateY(20px) scale(0.95);
    transition:opacity .4s cubic-bezier(.34,1.56,.64,1), transform .4s cubic-bezier(.34,1.56,.64,1);
    pointer-events:none;
}
#carevee-toast.cv-show { opacity:1; transform:translateY(0) scale(1); pointer-events:all; }
.cv-toast-icon-wrap { width:36px; height:36px; border-radius:50%; background:var(--fd-blue); display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
.cv-toast-body { flex:1; min-width:0; }
.cv-toast-title { font-size:.72rem; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:var(--fd-gold); margin-bottom:3px; }
.cv-toast-name { font-size:.85rem; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:10px; }
.cv-toast-actions { display:flex; gap:8px; }
.cv-toast-btn-cart { display:inline-flex; align-items:center; gap:5px; background:var(--fd-blue); color:#fff; padding:6px 12px; border-radius:var(--fd-btn-radius); font-size:.72rem; font-weight:800; text-decoration:none; transition:background .2s; white-space:nowrap; }
.cv-toast-btn-cart:hover { background:var(--fd-blue-dark); color:#fff; }
.cv-toast-btn-close { display:inline-flex; align-items:center; background:rgba(255,255,255,.1); color:rgba(255,255,255,.7); padding:6px 10px; border-radius:var(--fd-btn-radius); border:none; cursor:pointer; font-size:.72rem; font-weight:700; transition:background .2s; font-family:var(--fd-font-body); }
.cv-toast-btn-close:hover { background:rgba(255,255,255,.2); color:#fff; }
.cv-toast-progress { position:absolute; bottom:0; left:0; right:0; height:4px; background:rgba(255,255,255,.15); border-radius:0 0 14px 14px; overflow:hidden; }
.cv-toast-progress-bar { height:100%; width:100%; background:var(--fd-blue); transform-origin:left; animation:none; }
#carevee-toast.cv-show .cv-toast-progress-bar { animation:cvCountdown 5s linear forwards; }
@keyframes cvCountdown { from { transform:scaleX(1); } to { transform:scaleX(0); } }
@media(max-width:600px) { #carevee-toast { bottom:80px; right:12px; left:12px; min-width:unset; max-width:unset; } }

/* ══ SLOW MOVING ROWS (info boxes + category chips)
   One row only. The track holds two identical groups and slides left by
   exactly one group width, so the loop is seamless.
   --n = how many items are visible at once. ══ */
@keyframes fp-marq-scroll { from { transform:translateX(0); } to { transform:translateX(-50%); } }

.fp-marq {
    --gap: 14px;
    --n: 3;
    container-type: inline-size;
    overflow: hidden;
    width: 100%;
}
.fp-marq-track {
    display: flex; width: max-content;
    animation: fp-marq-scroll var(--dur, 70s) linear infinite;
    will-change: transform;
}
.fp-marq:hover .fp-marq-track,
.fp-marq:active .fp-marq-track,
.fp-marq:focus-within .fp-marq-track { animation-play-state: paused; }
.fp-marq-group { display: flex; gap: var(--gap); padding-right: var(--gap); flex-shrink: 0; }
.fp-marq-item  { flex: 0 0 auto; width: calc((100cqw - var(--gap) * (var(--n) - 1)) / var(--n)); }

/* Info boxes: 3 visible */
.fp-marq-boxes { --n: 3; --dur: 75s; }
.fp-seo-box {
    height: 100%;
    background: #fff; border: 1.5px solid var(--fd-border); border-radius: 14px;
    padding: 18px 18px 20px;
}
.fp-seo-box h3 { font-family:var(--fd-font-head); font-size:15px; font-weight:800; color:var(--fd-blue); margin:0 0 8px; }
.fp-seo-box p  { font-size:13px; line-height:1.7; color:var(--fd-text-light); margin:0; }
.fp-seo-box a  { color:var(--fd-blue); font-weight:700; text-decoration:none; }
.fp-seo-box a:hover { text-decoration:underline; }

/* Category chips: 5 visible */
.fp-marq-chips { --n: 5; --gap: 10px; --dur: 90s; }
.fp-chip {
    display: flex; align-items: center; justify-content: center; text-align: center;
    height: 100%; min-height: 56px; padding: 10px 14px;
    border: 1.5px solid var(--fd-border); border-radius: 12px; background: #fff;
    font-size: 12.5px; font-weight: 700; line-height: 1.3; color: var(--fd-blue);
    text-decoration: none; transition: background .2s, border-color .2s;
}
.fp-chip:hover { background:#eef1f8; border-color:var(--fd-blue); }

.fp-sub-title { font-family:var(--fd-font-head); font-size:15px; font-weight:800; color:var(--fd-text); margin:26px 0 12px; }

/* Plain info strip */
.fp-info-strip { display:flex; flex-wrap:wrap; gap:10px 28px; margin-top:22px; padding:14px 18px; border:1.5px solid var(--fd-border); border-radius:12px; background:#fff; font-size:13px; color:var(--fd-text); }
.fp-info-strip strong { color:var(--fd-blue); font-weight:800; }

/* ══ SEO TEXT ══ */
.fp-seo-intro { font-size:14px; line-height:1.8; color:var(--fd-text-light); margin:0 0 20px; max-width:900px; }
.fp-seo-title { font-family:var(--fd-font-head); font-size:20px; font-weight:900; color:var(--fd-text); margin:0 0 10px; padding-left:10px; border-left:3px solid var(--fd-gold); }
/* Two-column SEO intro: side by side on desktop, stacked on mobile */
.fp-seo-split { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; margin:0 0 22px; }
.fp-seo-col { background:#fff; border:1.5px solid var(--fd-border); border-radius:14px; padding:20px 22px; min-width:0; }
.fp-seo-col-title { font-family:var(--fd-font-head); font-size:17px; font-weight:800; line-height:1.3; color:var(--fd-blue); margin:0 0 10px; }
.fp-seo-col .fp-seo-intro { margin:0; max-width:none; }
@media (max-width:860px) {
    .fp-seo-split { grid-template-columns:1fr; gap:12px; margin-bottom:16px; }
    .fp-seo-col { padding:16px 14px; }
    .fp-seo-col-title { font-size:15px; }
}

/* FAQ: two columns on desktop (shorter page), single column on mobile */
.fp-faq-split { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:0 36px; align-items:start; }
.fp-faq-col { min-width:0; }
@media (max-width:860px) {
    .fp-faq-split { grid-template-columns:1fr; gap:0; }
}

.fp-faq-item  { border-bottom:1px solid var(--fd-border); padding:14px 0; }
.fp-faq-item summary { font-weight:700; font-size:14px; cursor:pointer; color:var(--fd-text); font-family:var(--fd-font-body); }
.fp-faq-item p { font-size:13.5px; line-height:1.7; color:var(--fd-text-light); margin:10px 0 0; }

/* Respect reduced-motion: stop the movement and let people swipe instead */
@media (prefers-reduced-motion: reduce) {
    .fp-marq { overflow-x: auto; }
    .fp-marq-track { animation: none; }
    .fp-marq-group[aria-hidden="true"] { display: none; }
}

/* ══ NEWSLETTER ══ */
.fp-newsletter      { background:linear-gradient(135deg,#eef1f8 0%,#dde3f2 50%,#eef1f8 100%); border-radius:14px; padding:44px 28px; text-align:center; }
.fp-newsletter-wrap { max-width:1380px; width:100%; margin:0 auto; padding:0 20px 20px; }
.fp-newsletter h2   { font-family:var(--fd-font-head); font-size:24px; font-weight:900; color:var(--fd-text); margin:0 0 7px; }
.fp-newsletter p    { color:var(--fd-text-light); font-size:13px; margin:0 0 20px; }
.fp-nl-form         { display:flex; gap:6px; max-width:520px; width:100%; margin:0 auto; padding:5px; border-radius:10px; overflow:hidden; box-shadow:0 6px 20px rgba(13,33,79,.10); background:#fff; }
.fp-nl-form input[type="email"]              { flex:1; border:none; outline:none; padding:12px 16px; font-size:13px; color:#333; min-width:0; font-family:var(--fd-font-body); }
.fp-nl-form input[type="email"]::placeholder { color:#aaa; }
.fp-nl-form button  { background:var(--fd-blue); color:#fff; border:none; padding:12px 22px; border-radius:var(--fd-btn-radius); font-size:11px; font-weight:800; cursor:pointer; font-family:var(--fd-font-body); display:flex; align-items:center; gap:6px; white-space:nowrap; transition:background .2s; flex-shrink:0; }
.fp-nl-form button:hover { background:var(--fd-blue-dark); }
.nl-success { color:var(--fd-blue); font-weight:700; font-size:13px; margin-top:12px; }

/* ══ RESPONSIVE ══ */
@media (max-width:860px) {
    .page-body { padding:10px; }
    .site-main  { gap:16px; }
    .fp-pad     { padding:16px 12px; }

    .promo-cards-row  { grid-template-columns:repeat(2,minmax(0,1fr)); gap:8px; }
    .promo-card-h     { min-height:200px; padding:8px; border-radius:10px; }
    .promo-panel      { flex-direction:column; align-items:flex-start; gap:6px; padding:8px 9px; border-radius:8px; }
    .promo-card-h h3  { font-size:11.5px; }
    .promo-upto       { font-size:8px; }
    .promo-pct        { font-size:15px; }
    .promo-shop-btn   { font-size:9px; padding:6px 10px; width:100%; text-align:center; }

    .fp-prod-grid-6   { grid-template-columns:repeat(2,minmax(0,1fr)); gap:8px; }
    .fp-prod-grid-health { grid-template-columns:repeat(2,minmax(0,1fr)); gap:8px; }
    .fp-section-title { font-size:15px; }
    .fp-seo-title     { font-size:17px; }
    .fp-newsletter    { padding:28px 14px; }
    .fp-newsletter h2 { font-size:19px; }
    .fp-newsletter-wrap { padding:0 10px 10px; }
    .fp-add-btn,.fp-wa-btn { font-size:10px; padding:8px 6px; gap:3px; }
    .fp-btn-icon  { display:none; }
    .fp-card-body { padding:10px 8px 10px; gap:5px; }

    /* Moving rows on tablet / mobile */
    .fp-marq-boxes { --n: 2.2; --gap: 10px; }
    .fp-marq-chips { --n: 3; --gap: 8px; }
    .fp-chip       { font-size:11px; padding:8px 8px; min-height:54px; }
}
@media (max-width:560px) {
    .fp-marq-boxes { --n: 1.15; }
}
@media (max-width:480px) {
    .page-body  { padding:8px; }
    .promo-card-h   { min-height:180px; }
    .promo-card-h h3 { font-size:11px; }
    .promo-pct      { font-size:14px; }
    .fp-prod-grid-6 { grid-template-columns:repeat(2,minmax(0,1fr)) !important; gap:8px; }
    .fp-prod-grid-health { grid-template-columns:repeat(2,minmax(0,1fr)) !important; gap:8px; }
    .fp-prod-name   { font-size:12px; }
    .fp-sale-price  { font-size:13px; }
    .fp-img-wrap    { height:110px; }
    .fp-img-wrap img { max-height:90px; }
    .fp-add-btn,.fp-wa-btn { font-size:9px; padding:7px 5px; gap:2px; }
    .fp-view-all    { font-size:11px; padding:6px 10px; }
    .fp-newsletter-wrap { padding:0 8px 8px; }
    .fp-nl-form { flex-direction:column; border-radius:10px; }
    .fp-nl-form input[type="email"] { padding:12px 14px; border-radius:var(--fd-btn-radius); }
    .fp-nl-form button { justify-content:center; border-radius:var(--fd-btn-radius); }
}
</style>

<!-- TOAST -->
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
  <div class="cv-toast-progress"><div class="cv-toast-progress-bar" id="cv-toast-bar"></div></div>
</div>

<div class="page-body">

    <main class="site-main" id="mainContent">

        <!-- HERO -->
        <div class="fp-card" style="padding:0;overflow:hidden;border-radius:16px;">
            <div class="fd-hero" id="fdHero" role="banner" aria-roledescription="carousel" aria-label="Family Drugmart Kenya — Affordable Online Pharmacy Kenya">

                <!-- SLIDE 1 — PHARMACY (the page's ONE and only H1) -->
                <div class="fd-hero-slide active" data-slide-index="0" style="background-image:url('<?php echo esc_url( FD_THEME_URI . '/assets/js/images/doctors2.webp' ); ?>');">
                    <div class="fd-hero-slide-bg" aria-hidden="true"></div>
                    <div class="fd-hero-overlay" aria-hidden="true"></div>
                    <div class="fd-hero-frame-border" aria-hidden="true"></div>
                    <div class="fd-hero-content">
                        <div class="fd-hero-content-top">
                            <h1 class="fd-hero-heading"><span class="fd-hero-heading-main">Affordable Online Pharmacy Kenya: </span><span class="fd-hero-heading-highlight">Expert Advice When You Need It</span></h1>
                        </div>
                        <div class="fd-hero-content-bottom">
                            <p class="fd-hero-desc">Family Drugmart Kenya is a trusted, affordable, PPB licensed pharmacy in Ruaka, Nairobi, a top choice for genuine medicines. Chat live with our qualified pharmacy professionals during opening hours (<?php echo esc_html( $FD_HOURS_TEXT ); ?>) about medications, supplements &amp; health questions.</p>
                            <div class="fd-hero-actions">
                                <a href="<?php echo esc_url($shop_url); ?>" class="fd-hero-btn-primary">
                                    Shop Now
                                </a>
                                <a href="https://wa.me/<?php echo esc_attr( $fd_wa_number ); ?>?text=<?php echo rawurlencode("Hi! I'd like to speak with a pharmacy professional."); ?>"
                                   class="fd-hero-btn-blue" target="_blank" rel="noopener noreferrer">
                                    Talk to a Pharmacy Professional
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 2 — SKIN CARE -->
                <div class="fd-hero-slide" data-slide-index="1" data-bg="<?php echo esc_url( FD_THEME_URI . '/assets/js/images/skincare.webp' ); ?>">
                    <div class="fd-hero-slide-bg" aria-hidden="true"></div>
                    <div class="fd-hero-overlay" aria-hidden="true"></div>
                    <div class="fd-hero-frame-border" aria-hidden="true"></div>
                    <div class="fd-hero-content">
                        <div class="fd-hero-content-top">
                            <h2 class="fd-hero-heading"><span class="fd-hero-heading-main">Best Skin Care Products in Kenya: </span><span class="fd-hero-heading-highlight">Healthy, Glowing Skin</span></h2>
                        </div>
                        <div class="fd-hero-content-bottom">
                            <p class="fd-hero-desc">Dermatologist-trusted, affordable skin care for every skin type, from the best skin care brands in Nairobi.</p>
                            <div class="fd-hero-actions">
                                <a href="<?php echo esc_url($skincare_url); ?>" class="fd-hero-btn-primary">
                                    Shop Skin Care
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 3 — BABY CARE -->
                <div class="fd-hero-slide" data-slide-index="2" data-bg="<?php echo esc_url( FD_THEME_URI . '/assets/js/images/babycare.webp' ); ?>">
                    <div class="fd-hero-slide-bg" aria-hidden="true"></div>
                    <div class="fd-hero-overlay" aria-hidden="true"></div>
                    <div class="fd-hero-frame-border" aria-hidden="true"></div>
                    <div class="fd-hero-content">
                        <div class="fd-hero-content-top">
                            <h2 class="fd-hero-heading"><span class="fd-hero-heading-main">Best Baby Formula Kenya: </span><span class="fd-hero-heading-highlight">Gentle Care for Your Little One</span></h2>
                        </div>
                        <div class="fd-hero-content-bottom">
                            <p class="fd-hero-desc">From the best baby formula to gentle baby skincare, shop trusted, affordable baby care products for your little one.</p>
                            <div class="fd-hero-actions">
                                <a href="<?php echo esc_url($infant_url); ?>" class="fd-hero-btn-primary">
                                    Shop Baby Care
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 4 — ULTRASOUND -->
                <div class="fd-hero-slide" data-slide-index="3" data-bg="<?php echo esc_url( FD_THEME_URI . '/assets/js/images/ultrasound2.webp' ); ?>">
                    <div class="fd-hero-slide-bg" aria-hidden="true"></div>
                    <div class="fd-hero-overlay" aria-hidden="true"></div>
                    <div class="fd-hero-frame-border" aria-hidden="true"></div>
                    <div class="fd-hero-content">
                        <div class="fd-hero-content-top">
                            <h2 class="fd-hero-heading"><span class="fd-hero-heading-main">Affordable Ultrasound Nairobi: </span><span class="fd-hero-heading-highlight">In-Store &amp; At Home</span></h2>
                        </div>
                        <div class="fd-hero-content-bottom">
                            <p class="fd-hero-desc">Get a top quality obs scan or other professional ultrasound at our pharmacy, or book a certified sonographer to come to you. Fast results, affordable pricing, no referral needed.</p>
                            <div class="fd-hero-actions">
                                <a href="<?php echo esc_url($ultrasound_url); ?>" class="fd-hero-btn-primary">
                                    Book a Scan
                                </a>
                                <a href="https://wa.me/<?php echo esc_attr( $fd_wa_number ); ?>?text=<?php echo rawurlencode("Hi! I'd like to book an ultrasound scan."); ?>"
                                   class="fd-hero-btn-blue" target="_blank" rel="noopener noreferrer">
                                    Enquire on WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="fd-hero-nav fd-hero-nav-prev" id="fdHeroPrev" aria-label="Previous slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button type="button" class="fd-hero-nav fd-hero-nav-next" id="fdHeroNext" aria-label="Next slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                </button>

                <div class="fd-hero-dots" id="fdHeroDots">
                    <button type="button" class="fd-hero-dot active" data-go-to="0" aria-label="Go to slide 1"></button>
                    <button type="button" class="fd-hero-dot" data-go-to="1" aria-label="Go to slide 2"></button>
                    <button type="button" class="fd-hero-dot" data-go-to="2" aria-label="Go to slide 3"></button>
                    <button type="button" class="fd-hero-dot" data-go-to="3" aria-label="Go to slide 4"></button>
                </div>

            </div>
        </div>

        <!-- PROMO CARDS -->
        <div class="promo-cards-row">

            <div class="promo-card-h promo-vitamins" role="img" aria-label="Vitamins and supplements Kenya" style="background-image:url('<?php echo esc_url( FD_THEME_URI . '/assets/js/images/vitaminsbg.webp' ); ?>');">
                <div class="promo-panel">
                    <div class="promo-left">
                        <h3>Vitamins &amp; Supplements</h3>
                        <div class="promo-upto">UP TO</div>
                        <div class="promo-pct">30% off</div>
                    </div>
                    <a href="<?php echo esc_url($vitamins_url); ?>" class="promo-shop-btn">&rarr; SHOP NOW</a>
                </div>
            </div>

            <div class="promo-card-h promo-diabetic" role="img" aria-label="Diabetic care and weight management products Kenya" style="background-image:url('<?php echo esc_url( FD_THEME_URI . '/assets/js/images/diabeticbg.webp' ); ?>');">
                <div class="promo-panel">
                    <div class="promo-left">
                        <h3>Diabetic &amp; Wellness</h3>
                        <div class="promo-upto">UP TO</div>
                        <div class="promo-pct">25% off</div>
                    </div>
                    <a href="<?php echo esc_url($diabetic_url); ?>" class="promo-shop-btn">&rarr; SHOP NOW</a>
                </div>
            </div>

            <div class="promo-card-h promo-infant" role="img" aria-label="Baby formula Kenya" style="background-image:url('<?php echo esc_url( FD_THEME_URI . '/assets/js/images/infantbg.webp' ); ?>');">
                <div class="promo-panel">
                    <div class="promo-left">
                        <h3>Baby Formula</h3>
                        <div class="promo-upto">UP TO</div>
                        <div class="promo-pct">25% off</div>
                    </div>
                    <a href="<?php echo esc_url($infant_url); ?>" class="promo-shop-btn">&rarr; SHOP NOW</a>
                </div>
            </div>

            <div class="promo-card-h promo-prescription" role="img" aria-label="Prescribed drugs Kenya, upload your prescription" style="background-image:url('<?php echo esc_url( FD_THEME_URI . '/assets/js/images/prescriptionbg.webp' ); ?>');">
                <div class="promo-panel">
                    <div class="promo-left">
                        <h3>Prescription Medicines</h3>
                        <div class="promo-upto">UPLOAD &amp; ORDER</div>
                        <div class="promo-pct">Rx Made Easy</div>
                    </div>
                    <a href="<?php echo esc_url($prescription_url); ?>" class="promo-shop-btn">&rarr; SUBMIT NOW</a>
                </div>
            </div>

        </div>

        <?php if ( function_exists('wc_get_page_id') ) :

            $fd_sale_ids = function_exists('wc_get_product_ids_on_sale') ? wc_get_product_ids_on_sale() : [];
        ?>

            <!-- HEALTH PRODUCTS — pulls the 5 newest from Vitamins & Health Supplements
                 (the Featured flag only matched 1 product). Change the slug below to use another category. -->
            <div class="fp-card">
                <div class="fp-pad">
                    <div class="fp-section-header">
                        <h2 class="fp-section-title">Trusted Health Products Kenya</h2>
                        <a class="fp-view-all" href="<?php echo esc_url($shop_url); ?>">View all &rarr;</a>
                    </div>
                    <div class="fp-prod-grid-health">
                        <?php
                        $q1 = fd_get_products('category', 5, 'vitamins-and-health-supplements');
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

            <!-- DEALS (6 fetched: desktop shows 5, mobile shows all 6) -->
            <div class="fp-card gray">
                <div class="fp-pad">
                    <div class="fp-section-header">
                        <h2 class="fp-section-title">Best Affordable Pharmacy Deals Nairobi</h2>
                        <a class="fp-view-all" href="<?php echo esc_url($shop_url); ?>">View all &rarr;</a>
                    </div>
                    <div class="fp-prod-grid-6">
                        <?php
                        $q2 = null;
                        if ( ! empty($fd_sale_ids) ) {
                            $q2 = new WP_Query([
                                'post_type'      => 'product',
                                'post_status'    => 'publish',
                                'posts_per_page' => 6,
                                'post__in'       => array_slice($fd_sale_ids, 0, 6),
                                'orderby'        => 'post__in',
                            ]);
                        }
                        if ( ! $q2 || ! $q2->have_posts() ) {
                            $q2 = new WP_Query(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>6,'orderby'=>'date','order'=>'DESC']);
                        }
                        if ( $q2->have_posts() ) :
                            while ( $q2->have_posts() ) : $q2->the_post(); fd_render_product_card(); endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="fp-no-products">No products found.</p>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- TRENDING -->
            <div class="fp-card">
                <div class="fp-pad">
                    <div class="fp-section-header">
                        <h2 class="fp-section-title">Top Trending Pharmacy Products</h2>
                        <a class="fp-view-all" href="<?php echo esc_url($shop_url); ?>">View all &rarr;</a>
                    </div>
                    <div class="fp-prod-grid-health">
                        <?php
                        $q3 = fd_get_products('trending', 5);
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

        <!-- ═══════════ SEO CONTENT ═══════════ -->
        <div class="fp-card gray">
            <div class="fp-pad">
                <h2 class="fp-seo-title">Family Drugmart: Trusted Pharmacy in Kenya and Best Pharmacy in Nairobi</h2>
                <div class="fp-seo-split">
                    <div class="fp-seo-col">
                        <h3 class="fp-seo-col-title">Trusted, Affordable &amp; PPB Licensed Pharmacy in Kenya</h3>
                        <p class="fp-seo-intro">
                            Family Drugmart Kenya is a trusted, affordable and PPB licensed pharmacy in Kenya, based at <?php echo esc_html( rtrim( medicare_address(), ". \t\n\r" ) ); ?>, serving Ruaka, Banana, Kiambu and Nairobi. Buy medicine online in Kenya, order prescribed drugs, and get reliable pharmacy delivery in Nairobi. Pay cash or M-Pesa on delivery, upload your prescription, or chat with a pharmacy professional on WhatsApp.
                        </p>
                    </div>
                    <div class="fp-seo-col">
                        <h3 class="fp-seo-col-title">Best Pharmacy in Nairobi: Top Medicines, Baby Care, Skin Care &amp; Scans</h3>
                        <p class="fp-seo-intro">
                            Whether you are looking for the best pharmacy in Nairobi or a top pharmacy near you, we stock genuine, quality medicines at fair prices. As a top pharmacy in Nairobi, we offer the best baby formula, top vitamins and supplements such as Jamieson, the best skin care products in Kenya, affordable diabetic care, trusted prescription medicines and professional ultrasound scans, in-store or at home. Our friendly pharmacy professionals help you choose safe, genuine products at affordable prices.
                        </p>
                    </div>
                </div>

                <!-- Info boxes: ONE row, 3 visible, the rest move slowly to the left -->
                <div class="fp-marq fp-marq-boxes" aria-label="What we offer">
                    <div class="fp-marq-track">
                        <?php for ( $pass = 0; $pass < 2; $pass++ ) : $is_dup = ( $pass === 1 ); ?>
                        <div class="fp-marq-group"<?php echo $is_dup ? ' aria-hidden="true"' : ''; ?>>
                            <?php foreach ( $FD_BOXES as $b ) :
                                $body = $b[1];
                                if ( $is_dup ) { $body = str_replace( '<a ', '<a tabindex="-1" ', $body ); }
                            ?>
                                <div class="fp-marq-item">
                                    <div class="fp-seo-box">
                                        <h3><?php echo $b[0]; ?></h3>
                                        <p><?php echo $body; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <h3 class="fp-sub-title">Shop Pharmacy Categories in Ruaka &amp; Nairobi</h3>

                <!-- Category chips: ONE row, 5 visible (3 on mobile), the rest move slowly to the left -->
                <div class="fp-marq fp-marq-chips" aria-label="Pharmacy categories">
                    <div class="fp-marq-track">
                        <?php for ( $pass = 0; $pass < 2; $pass++ ) : $is_dup = ( $pass === 1 ); ?>
                        <div class="fp-marq-group"<?php echo $is_dup ? ' aria-hidden="true"' : ''; ?>>
                            <?php foreach ( $FD_CHIP_LINKS as $c ) : ?>
                                <div class="fp-marq-item">
                                    <a class="fp-chip" href="<?php echo esc_url( $c[1] ); ?>"<?php echo $is_dup ? ' tabindex="-1"' : ''; ?>><?php echo esc_html( $c[0] ); ?></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="fp-info-strip">
                    <span><strong>Address:</strong> <?php echo esc_html( medicare_address() ); ?></span>
                    <span><strong>PPB License No:</strong> <?php echo esc_html( $FD_PPB_LICENSE ); ?></span>
                    <span><strong>Opening hours:</strong> <?php echo esc_html( $FD_HOURS_TEXT ); ?></span>
                </div>
            </div>
        </div>

        <!-- FAQ -->
        <div class="fp-card">
            <div class="fp-pad">
                <h2 class="fp-seo-title">Online Pharmacy Kenya FAQs</h2>
                <?php $fd_faq_cols = array_chunk( $FD_FAQS, (int) ceil( count( $FD_FAQS ) / 2 ) ); ?>
                <div class="fp-faq-split">
                    <?php foreach ( $fd_faq_cols as $fd_col ) : ?>
                    <div class="fp-faq-col">
                        <?php foreach ( $fd_col as $f ) : ?>
                            <details class="fp-faq-item">
                                <summary><?php echo esc_html( $f['q'] ); ?></summary>
                                <p><?php echo esc_html( $f['a'] ); ?></p>
                            </details>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

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

    function initHeroCarousel() {
        var hero = document.getElementById('fdHero');
        if (!hero) return;

        var slides  = Array.prototype.slice.call(hero.querySelectorAll('.fd-hero-slide'));
        var dots    = Array.prototype.slice.call(hero.querySelectorAll('.fd-hero-dot'));
        var prevBtn = document.getElementById('fdHeroPrev');
        var nextBtn = document.getElementById('fdHeroNext');
        var total   = slides.length;
        if (!total) return;

        function loadSlide(i) {
            var sl = slides[i];
            if (!sl) return;
            var bg = sl.getAttribute('data-bg');
            if (bg) {
                sl.style.backgroundImage = "url('" + bg + "')";
                sl.removeAttribute('data-bg');
            }
        }
        function loadAllSlides() { for (var k = 1; k < slides.length; k++) loadSlide(k); }
        if (document.readyState === 'complete') {
            setTimeout(loadAllSlides, 300);
        } else {
            window.addEventListener('load', function () { setTimeout(loadAllSlides, 300); });
        }

        var current     = 0;
        var autoTimer   = null;
        var AUTOPLAY_MS = 6000;

        function goTo(index) {
            index = ((index % total) + total) % total;
            if (index === current) return;
            loadSlide(index);
            slides[current].classList.remove('active');
            if (dots[current]) dots[current].classList.remove('active');
            current = index;
            slides[current].classList.add('active');
            if (dots[current]) dots[current].classList.add('active');
        }

        function next() { goTo(current + 1); }
        function prev() { goTo(current - 1); }
        function startAuto() { stopAuto(); autoTimer = setInterval(next, AUTOPLAY_MS); }
        function stopAuto()  { if (autoTimer) clearInterval(autoTimer); }

        if (nextBtn) nextBtn.addEventListener('click', function () { next(); startAuto(); });
        if (prevBtn) prevBtn.addEventListener('click', function () { prev(); startAuto(); });
        dots.forEach(function (dot, i) {
            dot.addEventListener('click', function () { goTo(i); startAuto(); });
        });

        hero.addEventListener('mouseenter', stopAuto);
        hero.addEventListener('mouseleave', startAuto);

        startAuto();
    }

    function init() { initHeroCarousel(); }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
}());
</script>

<script>
(function(){

  var toast       = document.getElementById('carevee-toast');
  var toastNameEl = document.getElementById('cv-toast-name');
  var toastBar    = document.getElementById('cv-toast-bar');
  var closeBtn    = document.getElementById('cv-toast-close');
  var hideTimer   = null;

  function showToast(name) {
    if (!toast) return;
    if (toastNameEl) toastNameEl.textContent = name || '';
    if (toastBar) { toastBar.style.animation = 'none'; void toastBar.offsetWidth; toastBar.style.animation = ''; }
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

  var params      = new URLSearchParams(window.location.search);
  var toastName   = params.get('cv_added_name');
  var savedScroll = sessionStorage.getItem('cv_scroll_pos');

  if (toastName) {
    if (savedScroll !== null) window.scrollTo(0, parseInt(savedScroll, 10));
    window.addEventListener('load', function() {
      if (savedScroll !== null) window.scrollTo(0, parseInt(savedScroll, 10));
      sessionStorage.removeItem('cv_scroll_pos');
    });
    document.addEventListener('DOMContentLoaded', function() {
      if (savedScroll !== null) window.scrollTo(0, parseInt(savedScroll, 10));
      showToast(decodeURIComponent(toastName));
    });
    var cleanUrl = new URL(window.location.href);
    cleanUrl.searchParams.delete('cv_added_name');
    cleanUrl.searchParams.delete('added-to-cart');
    cleanUrl.searchParams.delete('add-to-cart');
    window.history.replaceState(null, '', cleanUrl.toString());
  }

  document.querySelectorAll('.carevee-atc-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault(); e.stopPropagation();
      var pid  = btn.getAttribute('data-pid');
      var name = btn.getAttribute('data-name');
      var scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
      sessionStorage.setItem('cv_scroll_pos', scrollY);
      btn.classList.add('atc-loading');
      var txtEl = btn.querySelector('.fp-atc-txt');
      if (txtEl) txtEl.textContent = 'Adding…';
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