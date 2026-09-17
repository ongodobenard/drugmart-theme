<?php
/**
 * 404 Template — Family Drugmart Kenya
 *
 * WordPress loads this file automatically for any URL that doesn't
 * match a real page/post/product (broken links, deleted products,
 * mistyped URLs, etc). Instead of showing a blank "Nothing found"
 * message, we redirect straight to the homepage so visitors always
 * land on the front-page design.
 */

if ( ! defined('ABSPATH') ) { die(); }

wp_safe_redirect( home_url('/') );
exit;