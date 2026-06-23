<?php
/**
 * Sidebar Template — Family Drugmart Kenya
 */

if ( ! defined('ABSPATH') ) { die(); }

if ( ! defined('FD_THEME_URI') ) {
    define( 'FD_THEME_URI', get_template_directory_uri() );
}

if ( ! function_exists('fd_deal_fallback_svg') ) :
function fd_deal_fallback_svg( $size = 80 ) {
    return sprintf(
        '<img src="%s" alt="Product placeholder" width="%d" height="%d" style="max-width:%dpx;max-height:%dpx;object-fit:contain;" loading="lazy">',
        esc_url( FD_THEME_URI . '/assets/js/images/meds.png' ),
        $size, $size, $size, $size
    );
}
endif;

if ( ! function_exists('fd_shop_url') ) :
function fd_shop_url() {
    if ( function_exists('wc_get_page_id') ) {
        return get_permalink( wc_get_page_id('shop') );
    }
    return home_url('/shop/');
}
endif;
if ( ! function_exists('fd_cart_url') ) :
function fd_cart_url( $product_id ) {
    if ( function_exists('wc_get_cart_url') ) {
        return add_query_arg( ['add-to-cart' => $product_id], wc_get_cart_url() );
    }
    return home_url('/cart/?add-to-cart=' . $product_id);
}
endif;
?>

<style>
.fd-sidebar {
  width: 100%;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.sb-block {
  padding: 14px 16px;
  border-bottom: 1px solid #f0f0f0;
}
.sb-block:last-child { border-bottom: none; }

.sb-cat-title {
  display: flex;
  align-items: center;
  gap: 9px;
  font-family: 'Nunito', sans-serif;
  font-size: 12px;
  font-weight: 900;
  color: #fff;
  background: #0e2358;
  padding: 11px 14px;
  margin: -14px -16px 12px;
  letter-spacing: .4px;
  text-transform: uppercase;
}
.sb-ham { display: flex; flex-direction: column; gap: 3px; }
.sb-ham span { display: block; width: 13px; height: 2px; background: #f5a623; border-radius: 1px; }

.cat-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 8px 4px;
  font-size: 13px;
  font-weight: 600;
  color: #444;
  text-decoration: none;
  font-family: 'Lato', sans-serif;
  border-bottom: 1px solid #f5f5f5;
  transition: color .2s, padding-left .15s;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.cat-item:last-child { border-bottom: none; }
.cat-item:hover { color: #1d3f8f; padding-left: 6px; }
.cat-item::after { content: '›'; color: #ccc; font-size: 15px; flex-shrink: 0; margin-left: 4px; }

/* ── Services ── */
.service-row {
  display: flex; align-items: flex-start; gap: 10px;
  padding: 7px 0; border-bottom: 1px solid #f5f5f5;
}
.service-row:last-child { border-bottom: none; }

/* Icon box: fixed size, no padding, image fills and touches bottom */
.s-icon {
  width: 40px;
  height: 40px;
  border-radius: 9px;
  display: flex;
  align-items: flex-end;       /* image sits at bottom */
  justify-content: center;
  flex-shrink: 0;
  overflow: hidden;
  position: relative;
}
.s-icon img {
  width: 100%;                 /* fill full width of the box */
  height: 100%;                /* fill full height */
  object-fit: cover;           /* cover so it touches all edges */
  object-position: bottom;     /* anchor to bottom */
  display: block;
  border-radius: 9px;
}

.s-label { font-family: 'Nunito', sans-serif; font-size: 12px; font-weight: 700; color: #1b2230; line-height: 1.2; }
.s-sub   { font-size: 10px; color: #999; font-family: 'Lato', sans-serif; margin-top: 2px; }

.sb-section-title {
  font-family: 'Nunito', sans-serif;
  font-size: 13px; font-weight: 900;
  color: #1b2230;
  padding-bottom: 8px;
  margin-bottom: 10px;
  border-bottom: 2px solid #f5a623;
}

.brand-link {
  display: block; font-size: 12px; color: #555;
  padding: 6px 0; text-decoration: none;
  font-family: 'Lato', sans-serif;
  border-bottom: 1px solid #f5f5f5;
  transition: color .2s, padding-left .15s;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.brand-link:last-child { border-bottom: none; }
.brand-link:hover { color: #1d3f8f; padding-left: 5px; }
.brand-link.view-all { color: #1d3f8f; font-weight: 700; }

/* ── Hot Deals (now 3 products) ── */
.hot-deals-grid {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.hot-deal-card {
  position: relative;
  background: #f7f8fa;
  border-radius: 10px;
  padding: 14px 12px;
  text-align: center;
}
.off-badge {
  position: absolute; top: 10px; left: 10px;
  background: #f5a623; color: #0a1228;
  font-size: 9px; font-weight: 800;
  padding: 3px 7px; border-radius: 5px;
  font-family: 'Nunito', sans-serif; letter-spacing: .4px;
}
.wish-btn {
  position: absolute; top: 10px; right: 10px;
  cursor: pointer; padding: 3px; transition: transform .2s;
}
.wish-btn:hover { transform: scale(1.2); }
.deal-img {
  margin: 14px auto 10px;
  display: flex; align-items: center; justify-content: center;
  min-height: 90px;
}
.deal-img img {
  max-width: 90px; max-height: 90px;
  object-fit: contain; border-radius: 5px;
  display: block; margin: 0 auto;
}
.deal-cats {
  font-size: 10px; color: #1d3f8f; font-weight: 700;
  font-family: 'Lato', sans-serif;
  margin-bottom: 4px; text-transform: uppercase; letter-spacing: .4px;
}
.deal-name {
  font-family: 'Nunito', sans-serif;
  font-size: 12px; font-weight: 800; color: #1b2230;
  margin-bottom: 5px; line-height: 1.3;
  display: block; text-decoration: none;
  overflow-wrap: break-word; word-break: break-word;
}
.deal-name:hover { color: #1d3f8f; }
.deal-stars { color: #f5a623; font-size: 12px; margin-bottom: 7px; }
.price-row {
  display: flex; align-items: center;
  justify-content: center; gap: 7px; margin-bottom: 11px;
  flex-wrap: wrap;
}
.old-price { font-size: 11px; color: #bbb; text-decoration: line-through; font-family: 'Lato', sans-serif; }
.new-price { font-size: 16px; font-weight: 900; color: #1d3f8f; font-family: 'Nunito', sans-serif; }
.add-cart-btn {
  display: flex; align-items: center; justify-content: center; gap: 6px;
  width: 100%; background: #1d3f8f; color: #fff;
  border: none; border-radius: 8px; padding: 9px 12px;
  font-size: 11px; font-weight: 800;
  cursor: pointer; text-decoration: none;
  font-family: 'Nunito', sans-serif;
  letter-spacing: .4px; transition: background .2s, transform .15s;
  white-space: nowrap; overflow: hidden;
}
.add-cart-btn:hover { background: #15306e; transform: translateY(-1px); }

.hp-row {
  display: flex; align-items: center; gap: 9px;
  padding: 8px 0; border-bottom: 1px solid #f5f5f5;
  text-decoration: none; cursor: pointer;
  transition: background .15s;
  min-width: 0;
}
.hp-row:last-child { border-bottom: none; }
.hp-row:hover { background: #f7f8fa; border-radius: 6px; padding-left: 4px; }
.hp-img {
  width: 44px; height: 44px; flex-shrink: 0;
  background: #f4f6f8; border-radius: 7px;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
}
.hp-img img { width: 100%; height: 100%; object-fit: cover; }
.hp-info { min-width: 0; flex: 1; }
.hp-stars { color: #f5a623; font-size: 10px; margin-bottom: 2px; }
.hp-name  {
  font-size: 11px; font-weight: 700; color: #1b2230;
  font-family: 'Nunito', sans-serif; line-height: 1.3; margin-bottom: 2px;
  overflow-wrap: break-word; word-break: break-word;
}
.hp-price { font-size: 12px; font-weight: 900; color: #1d3f8f; font-family: 'Nunito', sans-serif; }

/* ── Customer Reviews (now 4 reviews) ── */
.review-item { padding: 4px 0 10px; }
.review-item + .review-item {
  border-top: 1px solid #f0f0f0;
  padding-top: 12px;
  margin-top: 4px;
}
.review-top  { display: flex; align-items: center; gap: 9px; margin-bottom: 7px; }
.review-avatar { width: 34px; height: 34px; border-radius: 50%; overflow: hidden; flex-shrink: 0; }
.review-name  { font-family: 'Nunito', sans-serif; font-size: 12px; font-weight: 800; color: #1b2230; }
.review-stars { color: #f5a623; font-size: 11px; }
.review-quote-icon { font-size: 24px; color: #1d3f8f; line-height: 1; margin-bottom: 3px; }
.review-text  {
  font-size: 11.5px; color: #666; font-family: 'Lato', sans-serif;
  line-height: 1.55; margin-bottom: 7px;
  overflow-wrap: break-word; word-break: break-word;
}
.review-badge {
  font-size: 9px; font-weight: 700; color: #1d3f8f;
  background: #eef1f8; padding: 3px 8px; border-radius: 8px;
  display: inline-block; font-family: 'Lato', sans-serif;
}

@media (max-width: 860px) {
  .fd-sidebar { width: 100%; }
  .sb-block { padding: 12px 14px; }
  .sb-cat-title { margin: -12px -14px 10px; }
  .hot-deal-card { max-width: 100%; }
  .deal-img img { max-width: 70px; max-height: 70px; }
}
</style>

<aside class="fd-sidebar">

  <!-- ① Categories -->
  <div class="sb-block">
    <div class="sb-cat-title">
      <span class="sb-ham"><span></span><span></span><span></span></span>
      <?php esc_html_e('Category', 'familydrugmart'); ?>
    </div>
    <?php
    if ( function_exists('get_terms') ) :
        $cats = get_terms([
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'number'     => 12,
            'exclude'    => get_option('default_product_cat'),
        ]);
        if ( ! empty($cats) && ! is_wp_error($cats) ) :
            foreach ( $cats as $cat ) :
                printf(
                    '<a class="cat-item" href="%s">%s</a>',
                    esc_url( get_term_link($cat) ),
                    esc_html( $cat->name )
                );
            endforeach;
        else :
            foreach (['Prescription Meds','Supplements','Baby Care','Skincare','Equipment','Dental Care'] as $d) :
                echo '<a class="cat-item" href="' . esc_url( fd_shop_url() ) . '">' . esc_html($d) . '</a>';
            endforeach;
        endif;
    endif;
    ?>
  </div>

  <!-- ② Services -->
  <div class="sb-block">
    <?php
    $svcs = [
        ['#1d3f8f', 'Medicine',     'Over 5,000 products',       FD_THEME_URI . '/assets/js/images/meds.png'],
        ['#f5a623', 'Ultrasound',   'Home &amp; in-store scans', FD_THEME_URI . '/assets/js/images/ultrasound.png'],
        ['#15306e', 'Free Consult', 'Talk to a pharmacist',      FD_THEME_URI . '/assets/js/images/doctors.png'],
        ['#0e2358', 'Delivery',     'Nairobi &amp; countrywide', FD_THEME_URI . '/assets/js/images/delivery.png'],
        ['#1aab74', 'WhatsApp',     '7-day support',             FD_THEME_URI . '/assets/js/images/drugmart_logo.png'],
    ];
    foreach ( $svcs as [ $bg, $label, $sub, $icon_url ] ) : ?>
    <div class="service-row">
      <div class="s-icon" style="background:<?php echo esc_attr($bg); ?>">
        <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($label); ?>" loading="lazy">
      </div>
      <div>
        <div class="s-label"><?php echo esc_html($label); ?></div>
        <div class="s-sub"><?php echo $sub; ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- ③ Popular Brands -->
  <div class="sb-block">
    <div class="sb-section-title"><?php esc_html_e('Popular Brands', 'familydrugmart'); ?></div>
    <?php
    $brand_terms  = [];
    $brand_taxons = ['product_brand', 'pwb-brand', 'pa_brand'];

    foreach ( $brand_taxons as $tax ) {
        if ( taxonomy_exists($tax) ) {
            $terms = get_terms([
                'taxonomy'   => $tax,
                'hide_empty' => true,
                'number'     => 50,
                'orderby'    => 'count',
                'order'      => 'DESC',
            ]);
            if ( ! empty($terms) && ! is_wp_error($terms) ) {
                $brand_terms = $terms;
                break;
            }
        }
    }

    if ( ! empty($brand_terms) ) :
        shuffle($brand_terms);
        foreach ( array_slice($brand_terms, 0, 8) as $brand ) :
            printf(
                '<a class="brand-link" href="%s">%s</a>',
                esc_url( get_term_link($brand) ),
                esc_html( $brand->name )
            );
        endforeach;
        echo '<a class="brand-link view-all" href="' . esc_url( fd_shop_url() ) . '">' . esc_html__('View All Brands', 'familydrugmart') . '</a>';
    else :
        global $wpdb;
        $meta_brands = $wpdb->get_col(
            "SELECT DISTINCT meta_value FROM {$wpdb->postmeta}
             WHERE meta_key = '_brand' AND meta_value != ''
             ORDER BY RAND() LIMIT 8"
        );
        if ( ! empty($meta_brands) ) :
            foreach ( $meta_brands as $b ) :
                echo '<a class="brand-link" href="' . esc_url( fd_shop_url() ) . '">' . esc_html($b) . '</a>';
            endforeach;
            echo '<a class="brand-link view-all" href="' . esc_url( fd_shop_url() ) . '">' . esc_html__('View All Brands', 'familydrugmart') . '</a>';
        else :
            echo '<p style="font-size:11px;color:#aaa;font-family:Lato,sans-serif;padding:4px 0;">' . esc_html__('No brands found. Install a WooCommerce brands plugin to populate this section.', 'familydrugmart') . '</p>';
        endif;
    endif;
    ?>
  </div>

  <!-- ④ Hot Deals Day — now shows 3 products -->
  <div class="sb-block">
    <div class="sb-section-title"><?php esc_html_e('Hot Deals Day', 'familydrugmart'); ?></div>
    <div class="hot-deals-grid">
    <?php
    if ( function_exists('wc_get_product') ) :

        $deal_cat_id      = 0;
        $deal_cat_searches = ['diabetic','diabetes','diabetics','diabetes-care','diabetic-care'];

        foreach ( $deal_cat_searches as $slug ) {
            $term = get_term_by('slug', $slug, 'product_cat');
            if ( $term && ! is_wp_error($term) ) {
                $deal_cat_id = $term->term_id;
                break;
            }
        }
        if ( ! $deal_cat_id ) {
            $all_cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'number' => 200]);
            if ( ! is_wp_error($all_cats) ) {
                foreach ( $all_cats as $c ) {
                    if ( stripos($c->name, 'diabet') !== false ) {
                        $deal_cat_id = $c->term_id;
                        break;
                    }
                }
            }
        }

        $deal_args = [
            'post_type'      => 'product',
            'posts_per_page' => 3,
            'orderby'        => 'rand',
            'meta_query'     => [[
                'key'     => '_sale_price',
                'value'   => '',
                'compare' => '!=',
            ]],
        ];
        if ( $deal_cat_id ) {
            $deal_args['tax_query'] = [[
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $deal_cat_id,
            ]];
        }

        $hq = new WP_Query($deal_args);

        if ( $hq->post_count < 3 && $deal_cat_id ) {
            $hq = new WP_Query([
                'post_type'      => 'product',
                'posts_per_page' => 3,
                'orderby'        => 'rand',
                'tax_query'      => [[
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $deal_cat_id,
                ]],
            ]);
        }

        if ( $hq->post_count < 3 ) {
            $hq = new WP_Query([
                'post_type'      => 'product',
                'posts_per_page' => 3,
                'orderby'        => 'rand',
            ]);
        }

        if ( $hq->have_posts() ) :
            while ( $hq->have_posts() ) : $hq->the_post();
                global $product;
                $product     = wc_get_product( get_the_ID() );
                $product_url = get_permalink( get_the_ID() );
                $pct         = 0;
                if ( $product && $product->is_on_sale() && $product->get_regular_price() > 0 )
                    $pct = round( (1 - $product->get_sale_price() / $product->get_regular_price()) * 100 );

                $img_id  = get_post_thumbnail_id( get_the_ID() );
                $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'woocommerce_single') : '';
            ?>
            <div class="hot-deal-card">
                <?php if ($pct > 0) : ?>
                    <span class="off-badge">-<?php echo absint($pct); ?>% OFF</span>
                <?php endif; ?>
                <div class="wish-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" width="14" height="14">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </div>
                <a href="<?php echo esc_url($product_url); ?>" class="deal-img">
                    <?php if ( $img_url ) : ?>
                        <img src="<?php echo esc_url($img_url); ?>"
                             alt="<?php echo esc_attr( get_the_title() ); ?>"
                             width="90" height="90" loading="lazy">
                    <?php else : ?>
                        <?php echo fd_deal_fallback_svg(90); ?>
                    <?php endif; ?>
                </a>
                <div class="deal-cats">
                    <?php
                    $dcats = get_the_terms( get_the_ID(), 'product_cat' );
                    if ( $dcats && ! is_wp_error($dcats) )
                        echo esc_html( implode(', ', array_column( array_slice($dcats, 0, 2), 'name' )) );
                    ?>
                </div>
                <a href="<?php echo esc_url($product_url); ?>" class="deal-name"><?php the_title(); ?></a>
                <div class="deal-stars">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
                <div class="price-row">
                    <?php if ( $product ) : ?>
                        <?php if ( $product->is_on_sale() ) : ?>
                            <span class="old-price"><?php echo wc_price( $product->get_regular_price() ); ?></span>
                        <?php endif; ?>
                        <span class="new-price"><?php echo wc_price( $product->get_sale_price() ?: $product->get_price() ); ?></span>
                    <?php endif; ?>
                </div>
                <a href="<?php echo esc_url( fd_cart_url( get_the_ID() ) ); ?>" class="add-cart-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" width="12" height="12">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    ADD TO CART
                </a>
            </div>
            <?php
            endwhile;
            wp_reset_postdata();

        else :
            $fallback_deals = [
                ['name' => 'Glucose Monitor Complete Kit',  'cat' => 'Diabetic Care',     'old' => 'KSh 4,800', 'new' => 'KSh 3,360', 'pct' => 30],
                ['name' => 'Digital Blood Pressure Monitor', 'cat' => 'Cardiovascular',   'old' => 'KSh 5,200', 'new' => 'KSh 3,900', 'pct' => 25],
                ['name' => 'Multivitamin Gummies 90s',       'cat' => 'Supplements',      'old' => 'KSh 1,800', 'new' => 'KSh 1,350', 'pct' => 25],
            ];
            foreach ( $fallback_deals as $fd ) :
            ?>
            <div class="hot-deal-card">
                <span class="off-badge">-<?php echo esc_html($fd['pct']); ?>% OFF</span>
                <div class="wish-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" width="14" height="14">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </div>
                <div class="deal-img"><?php echo fd_deal_fallback_svg(90); ?></div>
                <div class="deal-cats"><?php echo esc_html($fd['cat']); ?></div>
                <a href="<?php echo esc_url( fd_shop_url() ); ?>" class="deal-name"><?php echo esc_html($fd['name']); ?></a>
                <div class="deal-stars">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
                <div class="price-row">
                    <span class="old-price"><?php echo esc_html($fd['old']); ?></span>
                    <span class="new-price"><?php echo esc_html($fd['new']); ?></span>
                </div>
                <a href="<?php echo esc_url( fd_shop_url() ); ?>" class="add-cart-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" width="12" height="12">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    ADD TO CART
                </a>
            </div>
            <?php endforeach;
        endif;

    else :
    ?>
        <p style="font-size:11px;color:#aaa;font-family:Lato,sans-serif;padding:4px 0;">
            <?php esc_html_e('WooCommerce is required to display deals.', 'familydrugmart'); ?>
        </p>
    <?php endif; ?>
    </div>
  </div>

  <!-- ⑤ Hot Products -->
  <div class="sb-block">
    <div class="sb-section-title"><?php esc_html_e('Hot Products', 'familydrugmart'); ?></div>
    <?php
    if ( function_exists('wc_get_product') ) :
        $hp = new WP_Query([
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'meta_key'       => 'total_sales',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
        ]);
        if ( $hp->have_posts() ) :
            while ( $hp->have_posts() ) : $hp->the_post();
                global $product;
                $product     = wc_get_product( get_the_ID() );
                $product_url = get_permalink( get_the_ID() );
                $hp_img_id   = get_post_thumbnail_id( get_the_ID() );
                $hp_img_url  = $hp_img_id ? wp_get_attachment_image_url($hp_img_id, 'thumbnail') : '';
            ?>
            <a href="<?php echo esc_url($product_url); ?>" class="hp-row" style="text-decoration:none;">
                <div class="hp-img">
                    <?php if ( $hp_img_url ) : ?>
                        <img src="<?php echo esc_url($hp_img_url); ?>"
                             alt="<?php echo esc_attr( get_the_title() ); ?>"
                             width="44" height="44" loading="lazy">
                    <?php else : ?>
                        <?php echo fd_deal_fallback_svg(36); ?>
                    <?php endif; ?>
                </div>
                <div class="hp-info">
                    <div class="hp-stars">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
                    <div class="hp-name"><?php the_title(); ?></div>
                    <div class="hp-price"><?php if ($product) echo $product->get_price_html(); ?></div>
                </div>
            </a>
            <?php
            endwhile;
            wp_reset_postdata();

        else :
            foreach ([
                ['Paracetamol 500mg Tablets', 'KSh 250'],
                ['Multivitamin Capsules 60s',  'KSh 1,200'],
                ['Digital Thermometer',        'KSh 850'],
                ['Hand Sanitizer 500ml',       'KSh 450'],
            ] as [$n, $pr]) : ?>
            <div class="hp-row">
                <div class="hp-img"><?php echo fd_deal_fallback_svg(36); ?></div>
                <div class="hp-info">
                    <div class="hp-stars">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
                    <div class="hp-name"><?php echo esc_html($n); ?></div>
                    <div class="hp-price"><?php echo esc_html($pr); ?></div>
                </div>
            </div>
            <?php endforeach;
        endif;
    endif;
    ?>
  </div>

  <!-- ⑥ Customer Reviews — now shows 4 reviews -->
  <div class="sb-block">
    <div class="sb-section-title"><?php esc_html_e('Customer Reviews', 'familydrugmart'); ?></div>

    <?php
    $reviews = [
        [
            'name'   => 'Sarah M.',
            'stars'  => 5,
            'text'   => 'Family Drugmart has been a lifesaver! Fast delivery and genuine products. I order all my supplements here now.',
            'badge'  => 'Verified Buyer &bull; May 2026',
            'avatar_bg'    => '#eef1f8',
            'avatar_head'  => '#1d3f8f',
            'avatar_body'  => '#1d3f8f',
            'star_color'   => '#f5a623',
            'badge_bg'     => '#eef1f8',
            'badge_color'  => '#1d3f8f',
        ],
        [
            'name'   => 'James K.',
            'stars'  => 4,
            'text'   => 'Great prices and very fast shipping. The pharmacist chat feature helped me choose the right vitamins. Highly recommend!',
            'badge'  => 'Verified Buyer &bull; June 2026',
            'avatar_bg'    => '#fff8e8',
            'avatar_head'  => '#f5a623',
            'avatar_body'  => '#f5a623',
            'star_color'   => '#f5a623',
            'badge_bg'     => '#fff8e8',
            'badge_color'  => '#c47d00',
        ],
        [
            'name'   => 'Wanjiru N.',
            'stars'  => 5,
            'text'   => 'Booked a home-visit ultrasound scan and the sonographer was professional and on time. Results were ready the same day.',
            'badge'  => 'Verified Buyer &bull; June 2026',
            'avatar_bg'    => '#eafaf0',
            'avatar_head'  => '#1aab74',
            'avatar_body'  => '#1aab74',
            'star_color'   => '#f5a623',
            'badge_bg'     => '#eafaf0',
            'badge_color'  => '#1a8a5c',
        ],
        [
            'name'   => 'Brian O.',
            'stars'  => 4,
            'text'   => 'Submitted my prescription online and got my medication delivered within hours. Smooth process from start to finish.',
            'badge'  => 'Verified Buyer &bull; April 2026',
            'avatar_bg'    => '#fef0f0',
            'avatar_head'  => '#e15858',
            'avatar_body'  => '#e15858',
            'star_color'   => '#f5a623',
            'badge_bg'     => '#fef0f0',
            'badge_color'  => '#c0392b',
        ],
    ];

    foreach ( $reviews as $r ) :
        $full_stars  = (int) $r['stars'];
        $empty_stars = 5 - $full_stars;
        $stars_html  = str_repeat('&#9733;', $full_stars) . str_repeat('&#9734;', $empty_stars);
    ?>
    <div class="review-item">
      <div class="review-top">
        <div class="review-avatar">
          <svg viewBox="0 0 40 40" fill="none" width="34" height="34">
            <circle cx="20" cy="20" r="20" fill="<?php echo esc_attr($r['avatar_bg']); ?>"/>
            <circle cx="20" cy="16" r="7" fill="<?php echo esc_attr($r['avatar_head']); ?>" opacity=".35"/>
            <path d="M6 36c0-7.7 6.3-14 14-14s14 6.3 14 14" fill="<?php echo esc_attr($r['avatar_body']); ?>" opacity=".18"/>
          </svg>
        </div>
        <div>
          <div class="review-name"><?php echo esc_html($r['name']); ?></div>
          <div class="review-stars" style="color:<?php echo esc_attr($r['star_color']); ?>;"><?php echo $stars_html; ?></div>
        </div>
      </div>
      <div class="review-quote-icon" style="color:<?php echo esc_attr($r['avatar_head']); ?>;">&#8220;</div>
      <p class="review-text"><?php echo esc_html($r['text']); ?></p>
      <span class="review-badge" style="background:<?php echo esc_attr($r['badge_bg']); ?>;color:<?php echo esc_attr($r['badge_color']); ?>;"><?php echo $r['badge']; ?></span>
    </div>
    <?php endforeach; ?>

  </div>

</aside>