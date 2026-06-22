<?php
/**
 * Family Drugmart Kenya — functions.php
 * Updated: June 2026
 */

if ( defined('WP_DEBUG') && WP_DEBUG ) {
    @set_time_limit(300);
}

// ─── THEME SETUP ──────────────────────────────
function medicare_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'custom-logo', [ 'width' => 46, 'height' => 46, 'flex-square' => true ] );
    register_nav_menus( [ 'primary' => 'Primary Menu' ] );
}
add_action( 'after_setup_theme', 'medicare_setup' );

// ─── ENQUEUE ──────────────────────────────────
function medicare_enqueue() {
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800;900&family=Lato:wght@400;700;900&display=swap', [], null );
    wp_enqueue_style( 'medicare-style', get_stylesheet_uri(), [], '1.0.2' );
    wp_enqueue_script( 'medicare-main', get_template_directory_uri() . '/assets/js/main.js', [ 'jquery' ], '1.0.2', true );

    $shop_url = home_url( '/shop' );
    if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_get_page_id' ) ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id > 0 ) {
            $shop_url = get_permalink( $shop_page_id );
        }
    }

    wp_localize_script( 'medicare-main', 'medicareData', [
        'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
        'nonce'      => wp_create_nonce( 'medicare_nonce' ),
        'orderNonce' => wp_create_nonce( 'carevee_order_nonce' ),
        'waNumber'   => esc_js( medicare_wa() ),
        'shopUrl'    => esc_url( $shop_url ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'medicare_enqueue' );

// ─── HELPERS ──────────────────────────────────
function medicare_wa()      { return get_option( 'medicare_wa',      '254796140021' ); }
function medicare_phone()   { return get_option( 'medicare_phone',   '+254 0796140021' ); }
function medicare_address() { return get_option( 'medicare_address', 'High Point Plaza, along Ruaka-Banana Road' ); }
function medicare_tagline() { return get_option( 'medicare_tagline', 'Your Health, Our Priority' ); }
function medicare_email()   { return get_option( 'medicare_email',   'info@familydrugmartkenya.com' ); }

// ─── FORCE PAGE TEMPLATES BY SLUG ─────────────
function medicare_page_template( $template ) {
    if ( is_page() ) {
        $slug   = get_post_field( 'post_name', get_queried_object_id() );
        $custom = get_template_directory() . '/page-' . $slug . '.php';
        if ( file_exists( $custom ) ) return $custom;
    }
    return $template;
}
add_filter( 'template_include', 'medicare_page_template', 99 );

// ─── WA URL HELPER ────────────────────────────
function medicare_get_wa_url( $product_id ) {
    $product = wc_get_product( $product_id );
    if ( ! $product ) return '';
    $wa    = medicare_wa();
    $name  = $product->get_name();
    $price = strip_tags( $product->get_price_html() );
    $url   = get_permalink( $product_id );
    $msg   = urlencode( "Hello " . get_bloginfo( 'name' ) . "! I'd like to order: *{$name}* Price: {$price} Link: {$url} Please confirm availability. Thank you!" );
    return "https://wa.me/" . esc_attr( $wa ) . "?text=" . $msg;
}

// ════════════════════════════════════════════════════════════════════════════
// ─── PRESCRIPTION-ONLY CATEGORIES ────────────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════
function medicare_prescription_categories() {
    return array(
        'oncology',
        'anti-infective',
        'brain-and-nervous-system-disorder',
        'diabetes',
        'hormonal-and-steroids',
        'hypertension',
        'vaccins-and-immunization',
        'weight-management',
        'cardiovascular-and-cerebrovascular',
        'anti-hypertension',
        'prescription',
    );
}

function medicare_is_prescription_product( $product_id ) {
    return has_term( medicare_prescription_categories(), 'product_cat', $product_id );
}

function medicare_prescription_url( $product_id = 0 ) {
    $url = home_url( '/submit-prescription' );
    if ( $product_id ) {
        $url = add_query_arg( 'product_id', $product_id, $url );
    }
    return $url;
}

add_filter('woocommerce_add_to_cart_validation', function( $passed, $product_id ) {
    if ( medicare_is_prescription_product( $product_id ) ) {
        wc_add_notice( 'This product requires a valid prescription. Please submit your prescription before ordering.', 'error' );
        return false;
    }
    return $passed;
}, 10, 2);

add_filter('woocommerce_loop_add_to_cart_link', function( $button, $product ) {
    if ( medicare_is_prescription_product( $product->get_id() ) ) {
        return '<a href="' . esc_url( medicare_prescription_url( $product->get_id() ) ) . '" class="p-btn-cart rx-btn">Submit Prescription</a>';
    }
    return $button;
}, 10, 2);

// ─── WC WRAPPERS ──────────────────────────────
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'woocommerce_before_main_content', function () { echo '<div class="wc-outer">'; }, 10 );
add_action( 'woocommerce_after_main_content',  function () { echo '</div>'; }, 10 );

// ─── DISABLE WC NATIVE EMAILS (custom rich HTML used instead) ─────────────
add_filter( 'woocommerce_email_enabled_new_order',        '__return_false' );
add_filter( 'woocommerce_email_enabled_customer_processing_order', '__return_false' );

// ─── WHATSAPP ORDER BUTTON (Single Product Page) ──────────────────────────
function medicare_wa_button() {
    if ( ! class_exists( 'WooCommerce' ) ) return;
    global $product;
    if ( ! $product || ! is_a( $product, 'WC_Product' ) ) return;

    $product_id = $product->get_id();
    $wa_url     = medicare_get_wa_url( $product_id );
    ?>
    
        href="<?php echo esc_url( $wa_url ); ?>"
        target="_blank"
        rel="noopener noreferrer"
        class="wc-wa-btn carevee-wa-order-btn"
        data-product-id="<?php echo esc_attr( $product_id ); ?>"
        data-wa-url="<?php echo esc_url( $wa_url ); ?>"
    >
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        Medicine Enquiry
    </a>
    <?php
}
add_action( 'woocommerce_single_product_summary', 'medicare_wa_button', 35 );

// ─── CASH ON DELIVERY ONLY ────────────────────
add_filter( 'woocommerce_payment_gateways', function ( $gateways ) {
    if ( isset( $gateways['cod'] ) ) {
        return [ 'cod' => $gateways['cod'] ];
    }
    return $gateways;
} );

// ─── PRICE RANGE FILTER ───────────────────────
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) return;
    if ( ! function_exists( 'is_shop' ) ) return;
    if ( ! is_shop() && ! is_product_category() && ! is_search() ) return;
    if ( ! isset( $_GET['min_price'] ) && ! isset( $_GET['max_price'] ) ) return;

    $min = isset( $_GET['min_price'] ) ? floatval( $_GET['min_price'] ) : 0;
    $max = isset( $_GET['max_price'] ) ? floatval( $_GET['max_price'] ) : 999999999;

    $existing   = (array) $query->get( 'meta_query' );
    $existing[] = [
        'key'     => '_price',
        'value'   => [ $min, $max ],
        'compare' => 'BETWEEN',
        'type'    => 'NUMERIC',
    ];
    $query->set( 'meta_query', $existing );
    $query->set( 'post_type', 'product' );
} );

// ─── AJAX: FILTER PRODUCTS BY CATEGORY ───────
function medicare_filter_products() {
    if ( ! class_exists( 'WooCommerce' ) ) wp_send_json_error( 'WooCommerce not active' );

    $cat  = sanitize_text_field( $_POST['cat'] ?? '' );
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => 8,
        'post_status'    => 'publish',
    ];
    if ( $cat ) {
        $args['tax_query'] = [
            [ 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $cat ]
        ];
    }

    $q = new WP_Query( $args );
    ob_start();

    if ( $q->have_posts() ) {
        while ( $q->have_posts() ) {
            $q->the_post();
            $product_id = get_the_ID();
            $product    = wc_get_product( $product_id );
            if ( ! $product ) continue;

            $sale      = $product->is_on_sale();
            $is_new    = ( time() - strtotime( $product->get_date_created() ) ) < ( 30 * DAY_IN_SECONDS );
            $price_cur = number_format( (float) $product->get_price(), 2 );
            $price_reg = $product->get_regular_price();
            $img       = get_the_post_thumbnail_url( $product_id, 'woocommerce_thumbnail' );
            $cart_url  = $product->is_type( 'simple' ) ? '?add-to-cart=' . $product_id : get_permalink( $product_id );

            $cats    = get_the_terms( $product_id, 'product_cat' );
            $cat_n   = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
            $cat_lnk = ( $cats && ! is_wp_error( $cats ) ) ? get_term_link( $cats[0] ) : '#';
            $brands  = get_the_terms( $product_id, 'product_brand' );
            if ( ! $brands || is_wp_error( $brands ) ) $brands = get_the_terms( $product_id, 'pa_brand' );
            $brand_n = ( $brands && ! is_wp_error( $brands ) ) ? $brands[0]->name : '';

            $wa_product_url = medicare_get_wa_url( $product_id );
            $is_rx          = medicare_is_prescription_product( $product_id );
            ?>
            <div class="p-card">
              <a href="<?php the_permalink(); ?>" class="p-img-link">
                <div class="p-img">
                  <?php if ( $img ) : ?>
                    <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                  <?php else : ?>
                    <svg style="width:48px;height:48px;opacity:.2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M10.5 3.5a6 6 0 018 8l-8.5 8.5a6 6 0 01-8-8l8.5-8.5z"/></svg>
                  <?php endif; ?>
                  <button class="p-wish" aria-label="Wishlist" onclick="event.preventDefault();event.stopPropagation();">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                  </button>
                  <?php if ( $sale && $price_reg ) : ?>
                    <div class="p-badge-sale"><?php echo round( ( ( $price_reg - $product->get_price() ) / $price_reg ) * 100 ); ?>% OFF</div>
                  <?php elseif ( $is_new ) : ?>
                    <div class="p-badge-new">NEW</div>
                  <?php endif; ?>
                </div>
              </a>
              <div class="p-body">
                <?php if ( $cat_n || $brand_n ) : ?>
                  <div class="p-card-meta">
                    <?php if ( $cat_n ) : ?><a href="<?php echo esc_url( $cat_lnk ); ?>" class="p-card-cat"><?php echo esc_html( $cat_n ); ?></a><?php endif; ?>
                    <?php if ( $brand_n ) : ?><span class="p-card-brand"><?php echo esc_html( $brand_n ); ?></span><?php endif; ?>
                  </div>
                <?php endif; ?>
                <div class="p-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                <div class="p-price-wrap">
                  <?php if ( $sale && $price_reg ) : ?>
                    <div class="p-price-old">KES <?php echo number_format( $price_reg, 2 ); ?></div>
                  <?php endif; ?>
                  <div class="p-price-cur">KES <?php echo $price_cur; ?></div>
                </div>
                <div class="p-btns">
                  <?php if ( $is_rx ) : ?>
                    <a href="<?php echo esc_url( medicare_prescription_url( $product_id ) ); ?>" class="p-btn-cart p-btn-rx">
                      <span class="p-btn-ico p-btn-rx-ico">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                      </span>
                      Submit Prescription
                    </a>
                  <?php else : ?>
                    <a href="<?php echo esc_url( $cart_url ); ?>" class="p-btn-cart"
                       <?php if ( $product->is_type( 'simple' ) ) : ?>data-product_id="<?php echo $product_id; ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow"<?php endif; ?>>
                      <span class="p-btn-ico">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.97 1.61h9.72a2 2 0 001.97-1.67L23 6H6"/></svg>
                      </span>
                      Add to Cart
                    </a>
                  <?php endif; ?>
                  
                    href="<?php echo esc_url( $wa_product_url ); ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="p-btn-wa carevee-wa-order-btn"
                    data-product-id="<?php echo esc_attr( $product_id ); ?>"
                    data-wa-url="<?php echo esc_url( $wa_product_url ); ?>"
                  >
                    <span class="p-btn-ico">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </span>
                    Medicine Enquiry
                  </a>
                </div>
              </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    }

    wp_send_json_success( ob_get_clean() );
}
add_action( 'wp_ajax_medicare_filter_products',        'medicare_filter_products' );
add_action( 'wp_ajax_nopriv_medicare_filter_products', 'medicare_filter_products' );

// ════════════════════════════════════════════════════════════════════════════
// ─── GLOBAL JS — WA ENQUIRY BUTTON (no cart touch, pure redirect) ─────────
// ════════════════════════════════════════════════════════════════════════════
add_action( 'wp_footer', function () {
    ?>
    <script>
    (function($){
        if (typeof careveeWaBound !== 'undefined') return;
        window.careveeWaBound = true;

        $(document).on('click', '.carevee-wa-order-btn', function(e){
            e.preventDefault();
            var waUrl = $(this).data('wa-url') || $(this).attr('href');
            if (waUrl) {
                window.open(waUrl, '_blank');
            }
            // Cart is NEVER touched here — enquiry is WhatsApp only
        });
    })(jQuery);
    </script>
    <?php
} );

// ─── CONTACT FORM AJAX ────────────────────────
function medicare_contact() {
    ob_clean();

    if ( ! wp_verify_nonce( $_POST['nonce'] ?? '', 'medicare_nonce' ) ) {
        wp_send_json_error( [ 'msg' => 'Security check failed. Please refresh and try again.' ] );
    }

    $name  = sanitize_text_field( $_POST['contact_name']    ?? '' );
    $email = sanitize_email( $_POST['contact_email']        ?? '' );
    $phone = sanitize_text_field( $_POST['contact_phone']   ?? '' );
    $dept  = sanitize_text_field( $_POST['contact_dept']    ?? '' );
    $msg   = sanitize_textarea_field( $_POST['contact_msg'] ?? '' );

    if ( empty( $name ) || strlen( $name ) < 2 )
        wp_send_json_error( [ 'msg' => 'Please enter your full name.' ] );
    if ( empty( $email ) || ! is_email( $email ) )
        wp_send_json_error( [ 'msg' => 'Please enter a valid email address.' ] );
    if ( empty( $phone ) || strlen( preg_replace( '/\s/', '', $phone ) ) < 9 )
        wp_send_json_error( [ 'msg' => 'Please enter a valid phone number.' ] );
    if ( empty( $dept ) )
        wp_send_json_error( [ 'msg' => 'Please select a department.' ] );
    if ( empty( $msg ) || strlen( trim( $msg ) ) < 5 )
        wp_send_json_error( [ 'msg' => 'Please enter your message (at least 5 characters).' ] );

    $to      = medicare_email();
    $subject = "[Family Drugmart Contact] {$dept} - {$name}";
    $body    = "New contact form submission from " . home_url( '/' ) . "\n\n";
    $body   .= "Name:        {$name}\n";
    $body   .= "Email:       {$email}\n";
    $body   .= "Phone:       {$phone}\n";
    $body   .= "Department:  {$dept}\n\n";
    $body   .= "Message:\n{$msg}\n\n";
    $body   .= "Sent via Family Drugmart Kenya website contact form.\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$name} <{$email}>",
    ];

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( [ 'msg' => 'Message sent successfully!' ] );
    } else {
        global $phpmailer;
        $smtp_err = ( isset( $phpmailer ) && ! empty( $phpmailer->ErrorInfo ) )
            ? $phpmailer->ErrorInfo
            : 'Unknown mail error.';
        wp_send_json_error( [ 'msg' => 'Mail failed: ' . $smtp_err ] );
    }
}
add_action( 'wp_ajax_medicare_contact',        'medicare_contact' );
add_action( 'wp_ajax_nopriv_medicare_contact', 'medicare_contact' );

// ─── PRESCRIPTION FORM AJAX ───────────────────
function carevee_submit_prescription() {
    ob_clean();

    if ( ! wp_verify_nonce( $_POST['rx_nonce'] ?? '', 'rx_nonce_action' ) ) {
        wp_send_json_error( [ 'msg' => 'Security check failed. Please refresh and try again.' ] );
    }

    $fname     = sanitize_text_field( $_POST['rx_fname']     ?? '' );
    $lname     = sanitize_text_field( $_POST['rx_lname']     ?? '' );
    $age       = sanitize_text_field( $_POST['rx_age']       ?? '' );
    $gender    = sanitize_text_field( $_POST['rx_gender']    ?? '' );
    $phone     = sanitize_text_field( $_POST['rx_phone']     ?? '' );
    $email     = sanitize_email( $_POST['rx_email']          ?? '' );
    $location  = sanitize_text_field( $_POST['rx_location']  ?? '' );
    $allergies = sanitize_text_field( $_POST['rx_allergies'] ?? '' );
    $notes     = sanitize_textarea_field( $_POST['rx_notes'] ?? '' );

    if ( empty( $fname ) )    wp_send_json_error( [ 'msg' => 'First name is required.' ] );
    if ( empty( $lname ) )    wp_send_json_error( [ 'msg' => 'Last name is required.' ] );
    if ( empty( $age ) )      wp_send_json_error( [ 'msg' => 'Age is required.' ] );
    if ( empty( $gender ) )   wp_send_json_error( [ 'msg' => 'Please select your gender.' ] );
    if ( empty( $phone ) )    wp_send_json_error( [ 'msg' => 'Phone number is required.' ] );
    if ( empty( $location ) ) wp_send_json_error( [ 'msg' => 'Delivery address is required.' ] );

    $attachment = [];
    if ( ! empty( $_FILES['rx_file']['name'] ) ) {
        $allowed_types = [
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        if ( ! in_array( $_FILES['rx_file']['type'], $allowed_types ) ) {
            wp_send_json_error( [ 'msg' => 'Invalid file type. Please upload an image, PDF or Word document.' ] );
        }
        if ( $_FILES['rx_file']['size'] > 10 * 1024 * 1024 ) {
            wp_send_json_error( [ 'msg' => 'File too large. Maximum size is 10MB.' ] );
        }
        $upload = wp_upload_bits( $_FILES['rx_file']['name'], null, file_get_contents( $_FILES['rx_file']['tmp_name'] ) );
        if ( $upload['error'] ) {
            wp_send_json_error( [ 'msg' => 'File upload failed: ' . $upload['error'] ] );
        }
        $attachment[] = $upload['file'];
    } else {
        wp_send_json_error( [ 'msg' => 'Please attach your prescription file.' ] );
    }

    $to      = medicare_email();
    $subject = '[Family Drugmart Prescription] ' . $fname . ' ' . $lname . ' - ' . $phone;
    $body    = "New Prescription Submission from " . home_url( '/' ) . "\n\n";
    $body   .= "================================\n";
    $body   .= "PATIENT DETAILS\n";
    $body   .= "================================\n";
    $body   .= "Name:             " . $fname . ' ' . $lname . "\n";
    $body   .= "Age:              " . $age . "\n";
    $body   .= "Gender:           " . $gender . "\n";
    $body   .= "Phone:            " . $phone . "\n";
    $body   .= "Email:            " . ( $email ?: 'Not provided' ) . "\n";
    $body   .= "Delivery Address: " . $location . "\n";
    $body   .= "Allergies:        " . ( $allergies ?: 'None mentioned' ) . "\n";
    $body   .= "Notes:            " . ( $notes ?: 'None' ) . "\n";
    $body   .= "================================\n";
    $body   .= "Prescription file is attached.\n";
    $body   .= "Please review and contact the patient via phone or WhatsApp.\n\n";
    $body   .= "Submitted: " . current_time( 'mysql' ) . "\n";

    $headers = [ 'Content-Type: text/plain; charset=UTF-8' ];
    if ( $email ) {
        $headers[] = "Reply-To: {$fname} {$lname} <{$email}>";
    }

    $sent = wp_mail( $to, $subject, $body, $headers, $attachment );

    if ( ! empty( $attachment[0] ) && file_exists( $attachment[0] ) ) {
        @unlink( $attachment[0] );
    }

    if ( $sent ) {
        wp_send_json_success( [ 'msg' => 'Your prescription was successfully received! Our professional pharmacist will review it and get back to you soon.' ] );
    } else {
        global $phpmailer;
        $err = ( isset( $phpmailer ) && ! empty( $phpmailer->ErrorInfo ) ) ? $phpmailer->ErrorInfo : 'Unknown error.';
        wp_send_json_error( [ 'msg' => 'Failed to send: ' . $err ] );
    }
}
add_action( 'wp_ajax_carevee_submit_prescription',        'carevee_submit_prescription' );
add_action( 'wp_ajax_nopriv_carevee_submit_prescription', 'carevee_submit_prescription' );

// ════════════════════════════════════════════════════════════════════════════
// ─── ORDER ATTRIBUTION ───────────────────────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════
function medicare_apply_order_attribution( $order ) {
    if ( ! $order instanceof WC_Order ) return;

    $current_raw = isset( $_COOKIE['sbjs_current'] ) ? $_COOKIE['sbjs_current'] : '';
    $first_raw   = isset( $_COOKIE['sbjs_first'] )   ? $_COOKIE['sbjs_first']   : '';

    $parse_sbjs = function ( $raw ) {
        $out = [];
        if ( empty( $raw ) ) return $out;
        $decoded = urldecode( $raw );
        $pairs   = explode( '||', $decoded );
        foreach ( $pairs as $pair ) {
            $kv = explode( '|', $pair, 2 );
            if ( count( $kv ) === 2 ) {
                $out[ trim( $kv[0] ) ] = trim( $kv[1] );
            }
        }
        return $out;
    };

    $current_data = $parse_sbjs( $current_raw );
    $first_data   = $parse_sbjs( $first_raw );

    $source_type = $current_data['typ'] ?? $first_data['typ'] ?? '';
    $source      = $current_data['src'] ?? $first_data['src'] ?? '';
    $medium      = $current_data['mdm'] ?? $first_data['mdm'] ?? '';
    $campaign    = $current_data['cmp'] ?? $first_data['cmp'] ?? '';
    $referrer    = $current_data['rf']  ?? $first_data['rf']  ?? '';

    if ( empty( $source_type ) ) {
        if ( ! empty( $campaign ) )     $source_type = 'utm';
        elseif ( ! empty( $referrer ) ) $source_type = 'referral';
        else                             $source_type = 'typein';
    }

    if ( empty( $source ) && $source_type === 'typein' ) {
        $source = '(direct)';
    }

    if ( $source_type ) $order->update_meta_data( '_wc_order_attribution_source_type', sanitize_text_field( $source_type ) );
    if ( $source )      $order->update_meta_data( '_wc_order_attribution_utm_source',  sanitize_text_field( $source ) );
    if ( $medium )      $order->update_meta_data( '_wc_order_attribution_utm_medium',  sanitize_text_field( $medium ) );
    if ( $campaign )    $order->update_meta_data( '_wc_order_attribution_utm_campaign', sanitize_text_field( $campaign ) );
    if ( $referrer )    $order->update_meta_data( '_wc_order_attribution_referrer',    esc_url_raw( $referrer ) );

    $order->update_meta_data( '_wc_order_attribution_device_type', wp_is_mobile() ? 'Mobile' : 'Desktop' );
}

// ════════════════════════════════════════════════════════════════════════════
// ─── SHARED ORDER HELPER ─────────────────────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════
function carevee_build_and_send_order( $args ) {

    $fname      = $args['fname']      ?? '';
    $lname      = $args['lname']      ?? '';
    $company    = $args['company']    ?? '';
    $phone      = $args['phone']      ?? '';
    $email      = $args['email']      ?? '';
    $addr1      = $args['addr1']      ?? '';
    $addr2      = $args['addr2']      ?? '';
    $city       = $args['city']       ?? '';
    $state      = $args['state']      ?? '';
    $postcode   = $args['postcode']   ?? '';
    $country    = $args['country']    ?: 'KE';
    $notes      = $args['notes']      ?? '';
    $payment    = $args['payment']    ?: 'cod';
    $via        = $args['via']        ?: 'website';
    $cart_lines = $args['cart_lines'] ?? [];
    $wc_items   = $args['wc_items']   ?? [];

    $total = array_sum( array_column( $cart_lines, 'sub' ) );

    $order_id    = 0;
    $order_url   = '';
    $order_error = '';

    if ( function_exists( 'wc_create_order' ) && ! empty( $wc_items ) ) {
        try {
            $order = wc_create_order( [
                'status'      => 'processing',
                'customer_id' => get_current_user_id(),
            ] );

            if ( is_wp_error( $order ) ) throw new Exception( $order->get_error_message() );

            $order->set_billing_first_name( $fname );
            $order->set_billing_last_name(  $lname );
            $order->set_billing_company(    $company );
            $order->set_billing_phone(      $phone );
            $order->set_billing_email(      is_email( $email ) ? $email : get_option( 'admin_email' ) );
            $order->set_billing_address_1(  $addr1 );
            $order->set_billing_address_2(  $addr2 );
            $order->set_billing_city(       $city );
            $order->set_billing_state(      $state );
            $order->set_billing_postcode(   $postcode );
            $order->set_billing_country(    $country );
            $order->set_payment_method(     $payment );
            $order->set_payment_method_title( ucwords( str_replace( [ '_', '-' ], ' ', $payment ) ) );

            foreach ( $wc_items as $item ) {
                $order->add_product( $item['product'], $item['qty'] );
            }

            if ( $notes ) $order->add_order_note( 'Customer note: ' . $notes, 1 );
            $order->add_order_note(
                'Order placed via Family Drugmart ' . ( $via === 'whatsapp' ? 'WhatsApp button' : 'website checkout' ) . '.',
                0
            );

            medicare_apply_order_attribution( $order );

            $order->calculate_totals();
            $order->save();

            $order_id  = $order->get_id();
            $order_url = admin_url( 'admin.php?page=wc-orders&action=edit&id=' . $order_id );

        } catch ( Exception $e ) {
            $order_error = $e->getMessage();
        }
    }

    $store_name   = 'Online Pharmacy & Ultrasound';
    $store_phone  = medicare_phone();
    $store_wa_raw = preg_replace( '/[^0-9]/', '', medicare_wa() );
    $notify_email = medicare_email();
    $order_label  = $order_id ? '#' . $order_id : 'N/A';
    $via_label    = $via === 'whatsapp' ? 'WhatsApp Order' : 'Website Checkout';
    $total_fmt    = 'KES ' . number_format( $total, 2 );

    $items_html = '';
    foreach ( $cart_lines as $item ) {
        $items_html .= '<tr>
            <td style="padding:10px 14px;border-bottom:1px solid #e9edf5;font-family:Arial,sans-serif;font-size:14px;color:#1b2230;">' . esc_html( $item['name'] ) . '</td>
            <td style="padding:10px 14px;border-bottom:1px solid #e9edf5;text-align:center;font-family:Arial,sans-serif;font-size:14px;color:#6b7280;">' . intval( $item['qty'] ) . '</td>
            <td style="padding:10px 14px;border-bottom:1px solid #e9edf5;text-align:right;font-family:Arial,sans-serif;font-size:14px;color:#c47d00;font-weight:700;">KES ' . number_format( $item['sub'], 2 ) . '</td>
        </tr>';
    }

    $wc_block = $order_id
        ? '<tr><td style="padding:12px 32px 0;"><div style="background:#eef1f8;border:1.5px solid #c7d2e8;border-radius:8px;padding:10px 16px;font-size:12px;color:#15306e;">Order #' . $order_id . ' saved to WooCommerce, Status: <strong>Processing</strong></div></td></tr>'
        : ( $order_error ? '<tr><td style="padding:12px 32px 0;"><div style="background:#fff0f0;border:1.5px solid #f0b8b8;border-radius:8px;padding:10px 16px;font-size:12px;color:#c0392b;">WC order creation failed: ' . esc_html( $order_error ) . '</div></td></tr>' : '' );

    $view_btn = $order_id
        ? '<a href="' . esc_url( $order_url ) . '" style="display:inline-block;background:#1d3f8f;color:#fff;padding:12px 28px;border-radius:50px;font-size:14px;font-weight:800;text-decoration:none;">View Order #' . $order_id . ' in WooCommerce</a>'
        : '<a href="' . esc_url( admin_url( 'admin.php?page=wc-orders' ) ) . '" style="display:inline-block;background:#1d3f8f;color:#fff;padding:12px 28px;border-radius:50px;font-size:14px;font-weight:800;text-decoration:none;">View WooCommerce Orders</a>';

    $customer_rows = '
        <tr><td style="padding:5px 0;font-size:13px;color:#93a0b3;font-weight:700;width:130px;">Name</td><td style="padding:5px 0;font-size:13px;color:#1b2230;font-weight:700;">' . esc_html( trim( $fname . ' ' . $lname ) ) . '</td></tr>'
        . ( $company ? '<tr><td style="padding:5px 0;font-size:13px;color:#93a0b3;font-weight:700;">Company</td><td style="padding:5px 0;font-size:13px;color:#1b2230;">' . esc_html( $company ) . '</td></tr>' : '' )
        . ( $phone   ? '<tr><td style="padding:5px 0;font-size:13px;color:#93a0b3;font-weight:700;">Phone</td><td style="padding:5px 0;font-size:13px;color:#1b2230;font-weight:700;"><a href="tel:' . esc_attr( $phone ) . '" style="color:#1d3f8f;">' . esc_html( $phone ) . '</a></td></tr>' : '' )
        . ( is_email( $email ) ? '<tr><td style="padding:5px 0;font-size:13px;color:#93a0b3;font-weight:700;">Email</td><td style="padding:5px 0;font-size:13px;color:#1b2230;"><a href="mailto:' . esc_attr( $email ) . '" style="color:#1d3f8f;">' . esc_html( $email ) . '</a></td></tr>' : '' )
        . '<tr><td style="padding:5px 0;font-size:13px;color:#93a0b3;font-weight:700;">Address</td><td style="padding:5px 0;font-size:13px;color:#1b2230;">' . esc_html( implode( ', ', array_filter( [ $addr1, $addr2, $city, $state, $postcode, $country ] ) ) ) . '</td></tr>'
        . '<tr><td style="padding:5px 0;font-size:13px;color:#93a0b3;font-weight:700;">Payment</td><td style="padding:5px 0;font-size:13px;color:#1b2230;">' . esc_html( ucwords( str_replace( [ '_', '-' ], ' ', $payment ) ) ) . '</td></tr>';

    $wa_phone = preg_replace( '/[^0-9]/', '', $phone );

    $html_sales = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#f4f6fb;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb;padding:30px 0;">
      <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;max-width:600px;width:100%;">
          <tr><td style="background:#0e2358;border-top:4px solid #f5a623;padding:28px 32px;text-align:center;">
            <div style="font-size:26px;font-weight:900;color:#fff;">' . esc_html( $store_name ) . '</div>
            <div style="font-size:13px;color:rgba(255,255,255,.7);margin-top:4px;">New Order Notification</div>
          </td></tr>
          <tr><td style="padding:24px 32px 0;text-align:center;">
            <div style="display:inline-block;background:#eef1f8;border:1.5px solid #c7d2e8;border-radius:50px;padding:7px 20px;font-size:13px;font-weight:800;color:#15306e;">' . esc_html( $via_label ) . ' &nbsp;|&nbsp; Order ' . esc_html( $order_label ) . '</div>
          </td></tr>
          ' . $wc_block . '
          <tr><td style="padding:24px 32px 0;">
            <div style="font-size:15px;font-weight:800;color:#1b2230;margin-bottom:12px;border-bottom:2px solid #eef1f8;padding-bottom:8px;">Customer Details</div>
            <table width="100%" cellpadding="0" cellspacing="0">' . $customer_rows . '</table>
          </td></tr>
          <tr><td style="padding:24px 32px 0;">
            <div style="font-size:15px;font-weight:800;color:#1b2230;margin-bottom:12px;border-bottom:2px solid #eef1f8;padding-bottom:8px;">Order Items</div>
            <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #eef1f8;border-radius:8px;overflow:hidden;">
              <thead><tr style="background:#f7f8fa;">
                <th style="padding:9px 14px;text-align:left;font-size:11px;font-weight:800;color:#93a0b3;text-transform:uppercase;">Product</th>
                <th style="padding:9px 14px;text-align:center;font-size:11px;font-weight:800;color:#93a0b3;text-transform:uppercase;">Qty</th>
                <th style="padding:9px 14px;text-align:right;font-size:11px;font-weight:800;color:#93a0b3;text-transform:uppercase;">Total</th>
              </tr></thead>
              <tbody>' . $items_html . '</tbody>
              <tfoot><tr style="background:#f7f8fa;">
                <td colspan="2" style="padding:12px 14px;font-size:15px;font-weight:900;color:#1b2230;">ORDER TOTAL</td>
                <td style="padding:12px 14px;text-align:right;font-size:17px;font-weight:900;color:#c47d00;">' . $total_fmt . '</td>
              </tfoot>
            </table>
          </td></tr>
          ' . ( $notes ? '<tr><td style="padding:20px 32px 0;"><div style="background:#fff8e8;border:1.5px solid #f0d080;border-radius:8px;padding:12px 16px;"><div style="font-size:12px;font-weight:800;color:#b8860b;margin-bottom:5px;text-transform:uppercase;">Customer Notes</div><div style="font-size:13px;color:#6b7280;line-height:1.6;">' . esc_html( $notes ) . '</div></div></td></tr>' : '' ) . '
          <tr><td style="padding:20px 32px 0;">
            <div style="background:#eef1f8;border:1.5px solid #c7d2e8;border-radius:8px;padding:14px 16px;">
              <div style="font-size:12px;font-weight:800;color:#1d3f8f;text-transform:uppercase;margin-bottom:8px;">Payment Reminder</div>
              <div style="font-size:12px;color:#6b7280;line-height:1.8;">
                Nairobi &amp; environs: Collect Cash or M-Pesa on delivery<br>
                Other Counties: Full payment before dispatch
              </div>
            </div>
          </td></tr>
          <tr><td style="padding:24px 32px;text-align:center;">
            ' . $view_btn . '
            ' . ( $wa_phone ? '<div style="margin-top:14px;"><a href="https://wa.me/' . esc_attr( $wa_phone ) . '" style="font-size:12px;color:#25d366;text-decoration:none;font-weight:700;">WhatsApp Customer</a></div>' : '' ) . '
          </td></tr>
          <tr><td style="background:#f7f8fa;border-top:2px solid #eef1f8;padding:16px 32px;text-align:center;">
            <div style="font-size:11px;color:#93a0b3;">Automated notification from ' . esc_html( $store_name ) . '</div>
            <div style="font-size:11px;color:#93a0b3;margin-top:3px;">' . esc_html( $store_phone ) . ' &nbsp;|&nbsp; ' . esc_html( home_url( '/' ) ) . '</div>
          </td></tr>
        </table>
      </td></tr>
    </table>
    </body></html>';

    $subject_sales = 'New Order ' . $order_label . ' - ' . trim( $fname . ' ' . $lname ) . ' | ' . $store_name;
    $headers_sales = [ 'Content-Type: text/html; charset=UTF-8' ];
    if ( is_email( $email ) ) {
        $headers_sales[] = 'Reply-To: ' . trim( $fname . ' ' . $lname ) . ' <' . $email . '>';
    }

    $sent_sales = wp_mail( [ $notify_email, 'ongodobenard72@gmail.com' ], $subject_sales, $html_sales, $headers_sales );

    $sent_customer = false;
    if ( is_email( $email ) && $via !== 'whatsapp' ) {
        $sent_customer = carevee_send_customer_confirmation( $email, $fname, $lname, $phone, $order_id, $order_label, $cart_lines, $total_fmt, $notes, $payment, $store_name );
    }

    return [
        'order_id'            => $order_id,
        'order_error'         => $order_error,
        'email_sent'          => $sent_sales,
        'customer_email_sent' => $sent_customer,
    ];
}

// ════════════════════════════════════════════════════════════════════════════
// ─── CUSTOMER CONFIRMATION EMAIL ─────────────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════
function carevee_send_customer_confirmation( $email, $fname, $lname, $phone, $order_id, $order_label, $cart_lines, $total_fmt, $notes, $payment, $store_name ) {

    $items_html = '';
    foreach ( $cart_lines as $item ) {
        $items_html .= '<tr>
            <td style="padding:10px 14px;border-bottom:1px solid #e9edf5;font-family:Arial,sans-serif;font-size:14px;color:#1b2230;">' . esc_html( $item['name'] ) . '</td>
            <td style="padding:10px 14px;border-bottom:1px solid #e9edf5;text-align:center;font-family:Arial,sans-serif;font-size:14px;color:#6b7280;">' . intval( $item['qty'] ) . '</td>
            <td style="padding:10px 14px;border-bottom:1px solid #e9edf5;text-align:right;font-family:Arial,sans-serif;font-size:14px;color:#c47d00;font-weight:700;">KES ' . number_format( $item['sub'], 2 ) . '</td>
        </tr>';
    }

    $store_wa    = preg_replace( '/[^0-9]/', '', medicare_wa() );
    $store_phone = medicare_phone();
    $store_email = medicare_email();
    $tagline     = medicare_tagline();
    $tel_href    = 'tel:+' . $store_wa;

    $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#f4f6fb;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb;padding:30px 0;">
      <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;max-width:600px;width:100%;">
          <tr><td style="background:#0e2358;border-top:4px solid #f5a623;padding:30px 32px;text-align:center;">
            <div style="font-size:28px;font-weight:900;color:#fff;letter-spacing:-0.5px;">' . esc_html( $store_name ) . '</div>
            <div style="font-size:13px;color:rgba(255,255,255,.7);margin-top:4px;font-style:italic;">' . esc_html( $tagline ) . '</div>
          </td></tr>
          <tr><td style="padding:28px 32px 10px;text-align:center;">
            <div style="font-family:Arial,sans-serif;font-size:22px;font-weight:900;color:#1b2230;margin-bottom:6px;">Order Confirmed</div>
            <div style="font-family:Arial,sans-serif;font-size:14px;color:#6b7280;line-height:1.6;">
              Thank you, <strong>' . esc_html( $fname ) . '</strong>! Your order has been received and our team will contact you shortly to confirm delivery.
            </div>
            <div style="display:inline-block;background:#eef1f8;border:1.5px solid #c7d2e8;border-radius:50px;padding:7px 20px;font-size:13px;font-weight:800;color:#15306e;margin-top:14px;">
              Order ' . esc_html( $order_label ) . '
            </div>
          </td></tr>
          <tr><td style="padding:20px 32px 0;">
            <div style="font-size:15px;font-weight:800;color:#1b2230;margin-bottom:12px;border-bottom:2px solid #eef1f8;padding-bottom:8px;">Your Order</div>
            <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #eef1f8;border-radius:8px;overflow:hidden;">
              <thead><tr style="background:#f7f8fa;">
                <th style="padding:9px 14px;text-align:left;font-size:11px;font-weight:800;color:#93a0b3;text-transform:uppercase;">Product</th>
                <th style="padding:9px 14px;text-align:center;font-size:11px;font-weight:800;color:#93a0b3;text-transform:uppercase;">Qty</th>
                <th style="padding:9px 14px;text-align:right;font-size:11px;font-weight:800;color:#93a0b3;text-transform:uppercase;">Total</th>
              </tr></thead>
              <tbody>' . $items_html . '</tbody>
              <tfoot><tr style="background:#f7f8fa;">
                <td colspan="2" style="padding:12px 14px;font-size:15px;font-weight:900;color:#1b2230;">ORDER TOTAL</td>
                <td style="padding:12px 14px;text-align:right;font-size:17px;font-weight:900;color:#c47d00;">' . $total_fmt . '</td>
              </tr></tfoot>
            </table>
          </td></tr>
          ' . ( $notes ? '<tr><td style="padding:16px 32px 0;"><div style="background:#fff8e8;border:1.5px solid #f0d080;border-radius:8px;padding:12px 16px;"><div style="font-size:12px;font-weight:800;color:#b8860b;margin-bottom:5px;text-transform:uppercase;">Your Notes</div><div style="font-size:13px;color:#6b7280;line-height:1.6;">' . esc_html( $notes ) . '</div></div></td></tr>' : '' ) . '
          <tr><td style="padding:16px 32px 0;">
            <div style="background:#eef1f8;border:1.5px solid #c7d2e8;border-radius:8px;padding:14px 16px;">
              <div style="font-size:12px;font-weight:800;color:#1d3f8f;text-transform:uppercase;margin-bottom:8px;">Payment: ' . esc_html( ucwords( str_replace( [ '_', '-' ], ' ', $payment ) ) ) . '</div>
              <div style="font-size:12px;color:#6b7280;line-height:1.9;">
                Nairobi &amp; environs: Pay Cash or M-Pesa on delivery<br>
                Other Counties: Full payment before dispatch<br>
                Total to pay: <span style="color:#c47d00;font-weight:800;">' . $total_fmt . '</span>
              </div>
            </div>
          </td></tr>
          <tr><td style="padding:16px 32px 0;">
            <div style="font-size:15px;font-weight:800;color:#1b2230;margin-bottom:10px;border-bottom:2px solid #eef1f8;padding-bottom:8px;">What Happens Next</div>
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td style="width:32px;vertical-align:top;padding:4px 0;"><div style="width:22px;height:22px;background:#1d3f8f;border-radius:50%;text-align:center;color:#fff;font-size:11px;font-weight:900;line-height:22px;">1</div></td>
                <td style="padding:4px 0 4px 8px;font-size:13px;color:#6b7280;font-family:Arial,sans-serif;line-height:1.5;">Our pharmacist reviews your order and verifies stock availability.</td>
              </tr>
              <tr>
                <td style="width:32px;vertical-align:top;padding:4px 0;"><div style="width:22px;height:22px;background:#1d3f8f;border-radius:50%;text-align:center;color:#fff;font-size:11px;font-weight:900;line-height:22px;">2</div></td>
                <td style="padding:4px 0 4px 8px;font-size:13px;color:#6b7280;font-family:Arial,sans-serif;line-height:1.5;">We call or WhatsApp you on <strong>' . esc_html( $phone ) . '</strong> to confirm delivery details.</td>
              </tr>
              <tr>
                <td style="width:32px;vertical-align:top;padding:4px 0;"><div style="width:22px;height:22px;background:#1d3f8f;border-radius:50%;text-align:center;color:#fff;font-size:11px;font-weight:900;line-height:22px;">3</div></td>
                <td style="padding:4px 0 4px 8px;font-size:13px;color:#6b7280;font-family:Arial,sans-serif;line-height:1.5;">Your order is dispatched and delivered to your address.</td>
              </tr>
            </table>
          </td></tr>
          <tr><td style="padding:24px 32px;text-align:center;">
            <a href="https://wa.me/' . esc_attr( $store_wa ) . '" style="display:inline-block;background:#25d366;color:#fff;padding:12px 24px;border-radius:50px;font-size:14px;font-weight:800;text-decoration:none;margin:0 6px 10px;">Chat on WhatsApp</a>
            <a href="' . esc_attr( $tel_href ) . '" style="display:inline-block;background:#1d3f8f;color:#fff;padding:12px 24px;border-radius:50px;font-size:14px;font-weight:800;text-decoration:none;margin:0 6px 10px;">Call Us</a>
          </td></tr>
          <tr><td style="background:#f7f8fa;border-top:2px solid #eef1f8;padding:16px 32px;text-align:center;">
            <div style="font-size:12px;color:#6b7280;font-weight:700;">' . esc_html( $store_name ) . ' : ' . esc_html( $tagline ) . '</div>
            <div style="font-size:11px;color:#93a0b3;margin-top:4px;">' . esc_html( $store_phone ) . ' &nbsp;|&nbsp; ' . esc_html( $store_email ) . '</div>
            <div style="font-size:11px;color:#93a0b3;margin-top:2px;">' . esc_html( home_url( '/' ) ) . '</div>
            <div style="font-size:10px;color:#b0bccb;margin-top:8px;">This is an automated order confirmation email. Please do not reply directly.</div>
          </td></tr>
        </table>
      </td></tr>
    </table>
    </body></html>';

    $subject = 'Order ' . $order_label . ' Confirmed - ' . $store_name;
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $store_name . ' <' . $store_email . '>',
    ];

    return wp_mail( $email, $subject, $html, $headers );
}

// ─── AJAX: CHECKOUT PLACE ORDER ───────────────
add_action( 'wp_ajax_carevee_send_order_email',        'carevee_send_order_email_handler' );
add_action( 'wp_ajax_nopriv_carevee_send_order_email', 'carevee_send_order_email_handler' );

function carevee_send_order_email_handler() {
    if ( ! isset( $_POST['carevee_order_nonce'] ) ||
         ! wp_verify_nonce( sanitize_text_field( $_POST['carevee_order_nonce'] ), 'carevee_order_nonce' ) ) {
        wp_send_json_error( [ 'msg' => 'Security check failed.' ] );
        return;
    }

    $fname    = sanitize_text_field( $_POST['billing_first_name'] ?? '' );
    $lname    = sanitize_text_field( $_POST['billing_last_name']  ?? '' );
    $company  = sanitize_text_field( $_POST['billing_company']    ?? '' );
    $phone    = sanitize_text_field( $_POST['billing_phone']      ?? '' );
    $email    = sanitize_email( $_POST['billing_email']           ?? '' );
    $addr1    = sanitize_text_field( $_POST['billing_address_1']  ?? '' );
    $addr2    = sanitize_text_field( $_POST['billing_address_2']  ?? '' );
    $city     = sanitize_text_field( $_POST['billing_city']       ?? '' );
    $state    = sanitize_text_field( $_POST['billing_state']      ?? '' );
    $postcode = sanitize_text_field( $_POST['billing_postcode']   ?? '' );
    $country  = sanitize_text_field( $_POST['billing_country']    ?? 'KE' );
    $notes    = sanitize_textarea_field( $_POST['order_comments'] ?? '' );
    $payment  = sanitize_text_field( $_POST['payment_method']     ?? 'cod' );
    $via      = sanitize_text_field( $_POST['order_via']          ?? 'website' );

    if ( empty( $fname ) || empty( $lname ) )
        wp_send_json_error( [ 'msg' => 'Please enter your first and last name.', 'field' => 'name' ] );
    if ( empty( $phone ) )
        wp_send_json_error( [ 'msg' => 'Please enter your phone number.', 'field' => 'billing_phone' ] );
    if ( $via !== 'whatsapp' && ( empty( $email ) || ! is_email( $email ) ) )
        wp_send_json_error( [ 'msg' => 'A valid email address is required to receive your order confirmation.', 'field' => 'billing_email' ] );

    $cart_lines = [];
    $wc_items   = [];

    if ( function_exists( 'WC' ) && WC()->cart && ! WC()->cart->is_empty() ) {
        foreach ( WC()->cart->get_cart() as $ci ) {
            $p     = $ci['data'];
            $q     = $ci['quantity'];
            $price = (float) $p->get_price();
            $sub   = $price * $q;
            $cart_lines[] = [ 'name' => $p->get_name(), 'qty' => $q, 'price' => $price, 'sub' => $sub ];
            $wc_items[]   = [ 'product' => $p, 'qty' => $q ];
        }
    }

    if ( empty( $cart_lines ) )
        wp_send_json_error( [ 'msg' => 'Your cart is empty. Please add items before placing an order.' ] );

    $result   = carevee_build_and_send_order( compact( 'fname','lname','company','phone','email','addr1','addr2','city','state','postcode','country','notes','payment','via','cart_lines','wc_items' ) );
    $order_id = $result['order_id'];
    $sent     = $result['email_sent'];
    $err      = $result['order_error'];

    if ( $order_id && function_exists( 'WC' ) && WC()->cart ) {
        WC()->cart->empty_cart();
        if ( WC()->session ) {
            WC()->session->set( 'cart', [] );
            WC()->session->set( 'cart_totals', null );
        }
    }

    if ( $sent && $order_id ) {
        wp_send_json_success( [ 'msg' => 'Order #' . $order_id . ' placed successfully.', 'order_id' => $order_id, 'email_sent' => true, 'customer_email_sent' => $result['customer_email_sent'] ] );
    } elseif ( $order_id && ! $sent ) {
        wp_send_json_error( [ 'msg' => 'Order #' . $order_id . ' saved but confirmation email failed. Please check SMTP settings.', 'order_id' => $order_id ] );
    } elseif ( $sent && ! $order_id ) {
        wp_send_json_error( [ 'msg' => 'Email sent but WooCommerce order could not be saved. Error: ' . esc_html( $err ), 'order_id' => 0 ] );
    } else {
        wp_send_json_error( [ 'msg' => 'Something went wrong. Please contact us on WhatsApp or call ' . medicare_phone() . '.', 'order_id' => 0 ] );
    }
}

// ════════════════════════════════════════════════════════════════════════════
// ─── WOOCOMMERCE ADMIN ORDER BADGE ───────────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════
add_action( 'admin_menu', 'carevee_wc_order_badge', 999 );

function carevee_wc_order_badge() {
    global $submenu;

    $current_page   = $_GET['page']      ?? '';
    $current_post   = $_GET['post_type'] ?? '';
    $is_orders_page = ( $current_page === 'wc-orders' || $current_post === 'shop_order' );
    $admin_user_id  = get_current_user_id();

    if ( $is_orders_page ) {
        update_user_meta( $admin_user_id, 'carevee_orders_last_viewed', time() );
        return;
    }

    $last_viewed = (int) get_user_meta( $admin_user_id, 'carevee_orders_last_viewed', true );
    $new_count   = 0;

    if ( function_exists( 'wc_get_orders' ) ) {
        $new_orders = wc_get_orders( [ 'status' => [ 'wc-pending', 'wc-processing' ], 'limit' => -1, 'return' => 'ids', 'date_created' => '>' . $last_viewed ] );
        $new_count  = count( $new_orders );
    } else {
        global $wpdb;
        $dt = date( 'Y-m-d H:i:s', $last_viewed );
        $new_count = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'shop_order' AND post_status IN ('wc-pending','wc-processing') AND post_date_gmt > %s", $dt ) );
    }

    if ( $new_count < 1 ) return;

    $badge   = ' <span class="awaiting-mod count-' . $new_count . '" id="carevee-order-badge"><span class="pending-count">' . number_format_i18n( $new_count ) . '</span></span>';
    $parents = [ 'woocommerce', 'edit.php?post_type=shop_order' ];

    foreach ( $parents as $parent ) {
        if ( ! isset( $submenu[ $parent ] ) ) continue;
        foreach ( $submenu[ $parent ] as $k => $sub ) {
            if ( isset( $sub[2] ) && ( $sub[2] === 'wc-orders' || $sub[2] === 'edit.php?post_type=shop_order' ) ) {
                $submenu[ $parent ][ $k ][0] .= $badge;
                break 2;
            }
        }
    }

    add_action( 'admin_footer', function() { ?>
        <script>
        (function(){
            var badge = document.getElementById('carevee-order-badge');
            if (!badge) return;
            var ordersPatterns = ['page=wc-orders', 'post_type=shop_order'];
            document.querySelectorAll('#adminmenu a').forEach(function(link){
                var href = link.getAttribute('href') || '';
                var isOrders = ordersPatterns.some(function(p){ return href.indexOf(p) !== -1; });
                if (!isOrders) return;
                link.addEventListener('click', function(){
                    var b = document.getElementById('carevee-order-badge');
                    if (b) b.style.display = 'none';
                });
            });
        })();
        </script>
    <?php } );
}

// ─── ADMIN SETTINGS PAGE ──────────────────────
function medicare_admin_menu() {
    add_menu_page( 'Family Drugmart Settings', 'Family Drugmart Settings', 'manage_options', 'medicare-settings', 'medicare_settings_page', 'dashicons-heart', 60 );
}
add_action( 'admin_menu', 'medicare_admin_menu' );

function medicare_settings_page() {
    if ( isset( $_POST['medicare_save'] ) ) {
        check_admin_referer( 'medicare_settings_save' );
        foreach ( [ 'medicare_wa', 'medicare_phone', 'medicare_address', 'medicare_tagline', 'medicare_email' ] as $k ) {
            update_option( $k, sanitize_text_field( $_POST[ $k ] ?? '' ) );
        }
        echo '<div class="updated"><p>Settings saved successfully.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Family Drugmart Settings</h1>
        <form method="post">
            <?php wp_nonce_field( 'medicare_settings_save' ); ?>
            <table class="form-table">
                <tr>
                    <th>WhatsApp Number</th>
                    <td><input type="text" name="medicare_wa" value="<?php echo esc_attr( medicare_wa() ); ?>" class="regular-text"><p class="description">Numbers only, no spaces or + e.g. <strong>254796140021</strong></p></td>
                </tr>
                <tr>
                    <th>Display Phone</th>
                    <td><input type="text" name="medicare_phone" value="<?php echo esc_attr( medicare_phone() ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><input type="text" name="medicare_address" value="<?php echo esc_attr( medicare_address() ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th>Tagline</th>
                    <td><input type="text" name="medicare_tagline" value="<?php echo esc_attr( medicare_tagline() ); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th>Display Email</th>
                    <td><input type="text" name="medicare_email" value="<?php echo esc_attr( medicare_email() ); ?>" class="regular-text"><p class="description">No trailing period e.g. <strong>info@familydrugmartkenya.com</strong></p></td>
                </tr>
            </table>
            <?php submit_button( 'Save Settings', 'primary', 'medicare_save' ); ?>
        </form>
    </div>
    <?php
}

// ─── SCHEMA MARKUP ────────────────────────────
function medicare_schema() {
    if ( is_admin() ) return;
    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Pharmacy',
        'name'        => get_bloginfo( 'name' ),
        'description' => get_bloginfo( 'description' ),
        'url'         => home_url( '/' ),
        'telephone'   => medicare_phone(),
        'address'     => [ '@type' => 'PostalAddress', 'addressLocality' => medicare_address(), 'addressCountry' => 'KE' ],
        'contactPoint' => [ '@type' => 'ContactPoint', 'contactType' => 'customer service', 'telephone' => medicare_phone() ],
    ];
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'medicare_schema' );

// ─── MISC ─────────────────────────────────────
add_filter( 'excerpt_length', function () { return 18; }, 999 );
add_filter( 'excerpt_more',   function () { return '...'; } );
add_action( 'init', function () { remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 ); } );

// ════════════════════════════════════════════════════════════════════════════
// ─── YOAST SEO: AUTO-FILL FOCUS KEYPHRASE ────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════
add_action( 'save_post_product', 'carevee_auto_yoast_keyphrase', 10, 2 );
function carevee_auto_yoast_keyphrase( $post_id, $post ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( wp_is_post_revision( $post_id ) ) return;
    if ( ! defined( 'WPSEO_VERSION' ) ) return;
    $existing = get_post_meta( $post_id, '_yoast_wpseo_focuskw', true );
    if ( ! empty( $existing ) ) return;
    update_post_meta( $post_id, '_yoast_wpseo_focuskw', $post->post_title );
}

add_action( 'init', 'carevee_bulk_yoast_keyphrase_once' );
function carevee_bulk_yoast_keyphrase_once() {
    if ( ! defined( 'WPSEO_VERSION' ) ) return;
    if ( get_option( 'carevee_yoast_kw_filled' ) ) return;
    $products = get_posts( [ 'post_type' => 'product', 'post_status' => 'any', 'posts_per_page' => -1, 'fields' => 'ids' ] );
    foreach ( $products as $id ) {
        $existing = get_post_meta( $id, '_yoast_wpseo_focuskw', true );
        if ( empty( $existing ) ) update_post_meta( $id, '_yoast_wpseo_focuskw', get_the_title( $id ) );
    }
    update_option( 'carevee_yoast_kw_filled', true );
}

add_filter( 'woocommerce_product_get_price',                    'drugmart_safe_price', 10, 2 );
add_filter( 'woocommerce_product_get_regular_price',            'drugmart_safe_price', 10, 2 );
add_filter( 'woocommerce_product_variation_get_price',          'drugmart_safe_price', 10, 2 );
add_filter( 'woocommerce_product_variation_get_regular_price',  'drugmart_safe_price', 10, 2 );

function drugmart_safe_price( $price, $product ) {
    return ( $price === '' || $price === null ) ? 0 : $price;
}

// ════════════════════════════════════════════════════════════════════════════
// ─── CART SESSION FIX ────────────────────────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════

/**
 * Only destroy a session when: no cookie exists AND no active session data
 * AND we are NOT in an AJAX request (add-to-cart, fragments, etc).
 */
add_action( 'woocommerce_load_cart_from_session', function () {

    if ( ! function_exists( 'WC' ) || ! WC()->session ) {
        return;
    }

    // Never touch the session during any AJAX call
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return;
    }

    $cookie_name = 'woocommerce_session_' . COOKIEHASH;

    if ( empty( $_COOKIE[ $cookie_name ] ) && ! WC()->session->has_session() ) {
        WC()->session->destroy_session();
        WC()->cart->empty_cart( false );
    }

}, 1 );

/**
 * Prevent caching plugins from caching the cart-fragments AJAX endpoint.
 */
add_action( 'init', function () {
    if ( isset( $_GET['wc-ajax'] ) && $_GET['wc-ajax'] === 'get_refreshed_fragments' ) {
        nocache_headers();
        header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
        header( 'Pragma: no-cache' );
        header( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
    }
} );

/**
 * Force wc-cart-fragments to load on all front-end pages.
 */
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_admin() ) {
        wp_enqueue_script( 'wc-cart-fragments' );
    }
}, 5 );

// ════════════════════════════════════════════════════════════════════════════
// ─── WOOCOMMERCE CART FRAGMENTS ───────────────────────────────────────────
// ════════════════════════════════════════════════════════════════════════════
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {

    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        return $fragments;
    }

    WC()->cart->calculate_totals();

    $cart_count   = WC()->cart->get_cart_contents_count();
    $cart_total   = WC()->cart->get_cart_total();
    $cart_items   = WC()->cart->get_cart();
    $cart_url     = wc_get_cart_url();
    $checkout_url = wc_get_checkout_url();

    ob_start();
    ?>
    <span class="badge-dot fd-frag-cart-badge<?php echo $cart_count < 1 ? ' hidden' : ''; ?>">
        <?php echo $cart_count > 0 ? $cart_count : ''; ?>
    </span>
    <?php
    $fragments['span.fd-frag-cart-badge'] = ob_get_clean();

    ob_start();
    ?>
    <span class="cart-total-amt fd-frag-cart-total"><?php echo $cart_total; ?></span>
    <?php
    $fragments['span.fd-frag-cart-total'] = ob_get_clean();

    $label = $cart_count . ' item' . ( $cart_count !== 1 ? 's' : '' );
    $fragments['#fdCdropCount'] = '<span class="fd-cdrop-count" id="fdCdropCount">' . esc_html( $label ) . '</span>';

    ob_start();
    ?>
    <div class="fd-cart-dropdown" id="fdCartDropdown" role="region" aria-label="Cart preview">
        <div class="fd-cdrop-head">
            <div class="fd-cdrop-head-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" width="15" height="15">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                Your Cart
            </div>
            <span class="fd-cdrop-count" id="fdCdropCount"><?php echo esc_html( $label ); ?></span>
        </div>
        <div class="fd-cdrop-items" id="fdCdropItems">
            <?php if ( ! empty( $cart_items ) ) : ?>
                <?php foreach ( $cart_items as $item_key => $item ) :
                    $product = $item['data'];
                    $qty     = $item['quantity'];
                    $name    = $product->get_name();
                    $price   = wc_price( $product->get_price() * $qty );
                    $img_id  = $product->get_image_id();
                    $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'thumbnail' ) : '';
                ?>
                <div class="fd-cdrop-item">
                    <?php if ( $img_url ) : ?>
                        <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="fd-cdrop-img">
                    <?php else : ?>
                        <div class="fd-cdrop-img-ph">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
                                <rect x="3" y="3" width="18" height="18" rx="3"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <div class="fd-cdrop-info">
                        <div class="fd-cdrop-name" title="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $name ); ?></div>
                        <div class="fd-cdrop-meta">
                            <span class="fd-cdrop-qty">&times;<?php echo $qty; ?></span>
                            <span><?php echo esc_html( strip_tags( wc_price( $product->get_price() ) ) ); ?> each</span>
                        </div>
                    </div>
                    <div class="fd-cdrop-price"><?php echo $price; ?></div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="fd-cdrop-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" width="40" height="40">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    Your cart is currently empty
                </div>
            <?php endif; ?>
        </div>
        <?php if ( ! empty( $cart_items ) ) : ?>
        <div class="fd-cdrop-foot">
            <div class="fd-cdrop-total-row">
                <span class="fd-cdrop-total-label">Order Total</span>
                <span class="fd-cdrop-total-amt" id="fdCdropTotal"><?php echo $cart_total; ?></span>
            </div>
            <div class="fd-cdrop-btns">
                <a href="<?php echo esc_url( $cart_url ); ?>" class="fd-cdrop-btn-view">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="13" height="13">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    View Cart
                </a>
                <a href="<?php echo esc_url( $checkout_url ); ?>" class="fd-cdrop-btn-checkout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="13" height="13">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                    Checkout
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php
    $fragments['#fdCartDropdown'] = ob_get_clean();

    return $fragments;

}, 10, 1 );
