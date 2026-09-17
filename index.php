<?php
/**
 * Main Index Template — Nozaltah / Pharmacare
 *
 * WordPress falls back to this file when no more specific template matches.
 * On the homepage, we defer to front-page.php so both files always show
 * the same design. For anything else (blog listing, search, archives),
 * we show a safe minimal loop instead of theme-mismatched markup.
 */

if ( ! defined('ABSPATH') ) { die(); }

// If this is the site's homepage, just load the front-page template.
if ( is_front_page() && file_exists( get_template_directory() . '/front-page.php' ) ) {
    include get_template_directory() . '/front-page.php';
    return;
}

get_header();
?>

<div class="page-body" style="display:block; max-width:1000px; margin:0 auto; padding:24px 20px;">
    <main id="mainContent">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class(); ?> style="margin-bottom:32px;">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-summary"><?php the_excerpt(); ?></div>
                </article>
            <?php endwhile; ?>

            <?php the_posts_pagination(); ?>

        <?php else : ?>
            <p><?php esc_html_e( 'Nothing found.', 'pharmacare' ); ?></p>
        <?php endif; ?>
    </main>
</div>

<?php get_footer(); ?>