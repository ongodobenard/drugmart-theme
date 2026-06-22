<?php
get_header();

// Get current page slug
$slug   = get_post_field( 'post_name', get_the_ID() );
$custom = get_template_directory() . '/page-' . $slug . '.php';

if ( file_exists( $custom ) ) {
    include( $custom );
} else {
    // No matching template — send the visitor back instead of showing a broken/debug page
    $referer = wp_get_referer();
    $redirect_to = $referer ? $referer : home_url('/');
    wp_safe_redirect( $redirect_to );
    exit;
}

get_footer();