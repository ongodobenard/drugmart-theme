<?php
/**
 * Template Name: Blog
 */
get_header();

$bg_per_page = 9;
$bg_paged    = isset($_GET['bpage']) ? max(1, intval($_GET['bpage'])) : 1;
$bg_cat      = isset($_GET['blog_cat']) ? sanitize_text_field($_GET['blog_cat']) : '';
$bg_search   = isset($_GET['bsearch']) ? sanitize_text_field($_GET['bsearch']) : '';

$bg_args = [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $bg_per_page,
    'paged'          => $bg_paged,
];
if ($bg_cat) {
    $bg_args['category_name'] = $bg_cat;
}
if ($bg_search) {
    $bg_args['s'] = $bg_search;
}
$bg_query = new WP_Query($bg_args);

$bg_categories = get_categories(['hide_empty' => true]);
$bg_base_url   = function_exists('medicare_page_template') ? home_url('/blog') : home_url('/blog');

/* ── SIDEBAR DATA ── */

// Recent Posts (excludes current loop influence — independent query)
$bg_recent_posts = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'ignore_sticky_posts' => true,
]);

// Tags (top tags by post count)
$bg_tags = get_tags([
    'orderby' => 'count',
    'order'   => 'DESC',
    'number'  => 10,
]);

// Recent Comments
$bg_recent_comments = get_comments([
    'status' => 'approve',
    'number' => 4,
    'order'  => 'DESC',
]);

// What's Trending (most commented posts as a proxy for popularity)
$bg_trending = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'comment_count',
    'order'          => 'DESC',
    'ignore_sticky_posts' => true,
]);
?>

<style>
:root {
  --bg-blue:        #1d3f8f;
  --bg-blue-dark:   #15306e;
  --bg-blue-darker: #0e2358;
  --bg-blue-navy:   #0a1228;
  --bg-gold:        #f5a623;
  --bg-text:        #1b2230;
  --bg-text-light:  #6b7280;
  --bg-border:      #edf0f5;
  --bg-bg-soft:     #f7f8fa;
  --bg-font-head:   'Nunito', sans-serif;
  --bg-font-body:   'Lato', sans-serif;
}

.bg-wrap {
  max-width: 1200px;
  width: 100%;
  margin: 40px auto 60px;
  padding: 0 24px;
  font-family: var(--bg-font-body);
  box-sizing: border-box;
  overflow-x: hidden;
}
.bg-wrap * {
  box-sizing: border-box;
}

/* ── HERO ── */
.bg-hero {
  background: rgba(14,35,88,.92);
  border: 1px solid rgba(245,166,35,.25);
  border-top: 3px solid var(--bg-gold);
  border-radius: 20px;
  padding: 48px 40px;
  text-align: center;
}
.bg-tag {
  display: inline-block;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 1.4px;
  text-transform: uppercase;
  color: var(--bg-gold);
  background: rgba(245,166,35,.10);
  border: 1px solid rgba(245,166,35,.30);
  padding: 6px 16px;
  border-radius: 50px;
  margin-bottom: 16px;
}
.bg-title-main {
  font-family: var(--bg-font-head);
  font-size: clamp(22px, 4vw, 32px);
  font-weight: 900;
  color: #fff;
  margin: 0 0 10px;
  line-height: 1.25;
}
.bg-title-main span { color: var(--bg-gold); }
.bg-hero-desc {
  font-size: 13.5px;
  color: rgba(255,255,255,.70);
  line-height: 1.7;
  max-width: 560px;
  margin: 0 auto;
}

/* ── CATEGORY FILTER ── */
.bg-filter-row {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  justify-content: center;
  margin: 28px 0 8px;
}
.bg-filter-pill {
  display: inline-flex;
  align-items: center;
  padding: 8px 18px;
  border-radius: 50px;
  font-size: 12.5px;
  font-weight: 700;
  text-decoration: none;
  border: 1.5px solid var(--bg-border);
  color: var(--bg-text-light);
  background: #fff;
  transition: background .2s, color .2s, border-color .2s;
  white-space: nowrap;
}
.bg-filter-pill:hover { border-color: var(--bg-blue); color: var(--bg-blue); }
.bg-filter-pill.active {
  background: var(--bg-blue);
  border-color: var(--bg-blue);
  color: #fff;
}

/* ── MAIN LAYOUT (grid + sidebar) ── */
.bg-layout {
  display: grid;
  grid-template-columns: minmax(0, 1fr) 320px;
  gap: 32px;
  margin-top: 32px;
  align-items: start;
  width: 100%;
  max-width: 100%;
}
.bg-layout > div,
.bg-layout > aside {
  min-width: 0;
  max-width: 100%;
}

/* ── POSTS GRID ── */
.bg-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 22px;
}

.bg-card {
  background: #fff;
  border: 1.5px solid var(--bg-border);
  border-radius: 16px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: transform .25s, box-shadow .25s;
}
.bg-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 40px rgba(13,33,79,.12);
  border-color: #c7d4ef;
}
.bg-img-link { display: block; text-decoration: none; }
.bg-img {
  width: 100%;
  height: 190px;
  background: var(--bg-bg-soft);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}
.bg-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .3s;
}
.bg-card:hover .bg-img img { transform: scale(1.05); }

.bg-body {
  padding: 18px 18px 20px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.bg-cat-badge {
  display: inline-block;
  align-self: flex-start;
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .07em;
  padding: 3px 10px;
  border-radius: 50px;
  background: rgba(29,63,143,.08);
  color: var(--bg-blue);
  text-decoration: none;
  margin-bottom: 8px;
}
.bg-date {
  font-size: 11px;
  color: var(--bg-text-light);
  font-weight: 600;
  margin-bottom: 6px;
}
.bg-title {
  font-family: var(--bg-font-head);
  font-size: 15.5px;
  font-weight: 800;
  line-height: 1.4;
  margin: 0 0 8px;
}
.bg-title a {
  color: var(--bg-text);
  text-decoration: none;
  transition: color .15s;
}
.bg-title a:hover { color: var(--bg-blue); }
.bg-excerpt {
  font-size: 12.5px;
  color: var(--bg-text-light);
  line-height: 1.7;
  margin: 0 0 16px;
  flex: 1;
}
.bg-readmore {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12.5px;
  font-weight: 800;
  color: var(--bg-blue);
  text-decoration: none;
  align-self: flex-start;
  transition: gap .2s, color .2s;
}
.bg-readmore:hover { gap: 9px; color: var(--bg-gold-dark, #c47d00); }

/* ── EMPTY STATE ── */
.bg-empty {
  grid-column: 1 / -1;
  text-align: center;
  padding: 60px 20px;
  color: var(--bg-text-light);
  font-size: 13.5px;
}

/* ── PAGINATION ── */
.bg-pagination {
  display: flex;
  gap: 6px;
  justify-content: center;
  align-items: center;
  margin-top: 40px;
  flex-wrap: wrap;
}
.bg-page-btn {
  width: 38px; height: 38px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: .82rem; font-weight: 700;
  text-decoration: none;
  border: 1.5px solid rgba(0,0,0,.12);
  color: var(--bg-text-light);
  transition: background .15s, color .15s, border-color .15s, transform .15s;
}
.bg-page-btn:hover { background: var(--bg-blue); color: #fff; border-color: var(--bg-blue); transform: scale(1.08); }
.bg-page-btn.active { background: var(--bg-blue); color: #fff; border-color: var(--bg-blue); box-shadow: 0 4px 14px rgba(29,63,143,.35); }
.bg-page-btn.dots { border: none; background: none; pointer-events: none; width: auto; letter-spacing: .1em; }
.bg-page-btn.prev, .bg-page-btn.next { width: auto; padding: 0 14px; border-radius: 8px; gap: 5px; font-size: .8rem; }

/* ── SIDEBAR ── */
.bg-sidebar {
  display: flex;
  flex-direction: column;
  gap: 24px;
}
.bg-widget {
  background: #fff;
  border: 1.5px solid var(--bg-border);
  border-radius: 16px;
  padding: 22px 20px;
  min-width: 0;
  max-width: 100%;
  overflow: hidden;
}
.bg-widget-title {
  font-family: var(--bg-font-head);
  font-size: 15px;
  font-weight: 800;
  color: var(--bg-text);
  margin: 0 0 16px;
}

/* Search widget */
.bg-search-form {
  display: flex;
  gap: 8px;
}
.bg-search-input {
  flex: 1 1 0%;
  min-width: 0;
  width: 100%;
  box-sizing: border-box;
  padding: 11px 14px;
  border-radius: 10px;
  border: 1.5px solid var(--bg-border);
  background: var(--bg-bg-soft);
  font-size: 13px;
  font-family: var(--bg-font-body);
  color: var(--bg-text);
}
.bg-search-input:focus { outline: none; border-color: var(--bg-blue); }
.bg-search-btn {
  flex-shrink: 0;
  padding: 0 18px;
  border: none;
  border-radius: 10px;
  background: var(--bg-blue);
  color: #fff;
  font-size: 13px;
  font-weight: 800;
  cursor: pointer;
  transition: background .15s;
}
.bg-search-btn:hover { background: var(--bg-blue-dark); }

/* Recent posts / trending widget (shared list style) */
.bg-side-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.bg-side-item {
  display: flex;
  gap: 12px;
  align-items: flex-start;
  text-decoration: none;
  min-width: 0;
  max-width: 100%;
}
.bg-side-thumb {
  flex: 0 0 56px;
  width: 56px;
  height: 56px;
  border-radius: 10px;
  background: var(--bg-bg-soft);
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}
.bg-side-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.bg-side-thumb svg { opacity: .25; }
.bg-side-content {
  flex: 1 1 0%;
  min-width: 0;
  max-width: 100%;
}
.bg-side-title {
  font-family: var(--bg-font-head);
  font-size: 13px;
  font-weight: 700;
  line-height: 1.4;
  color: var(--bg-text);
  margin: 0 0 4px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  word-break: break-word;
  overflow-wrap: anywhere;
}
.bg-side-item:hover .bg-side-title { color: var(--bg-blue); }
.bg-side-date {
  font-size: 11px;
  color: var(--bg-text-light);
  font-weight: 600;
}

/* Tag cloud widget */
.bg-tag-cloud {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}
.bg-tag-pill {
  display: inline-block;
  padding: 7px 14px;
  border-radius: 8px;
  background: rgba(245,166,35,.10);
  color: var(--bg-blue-dark);
  font-size: 12px;
  font-weight: 700;
  text-decoration: none;
  transition: background .15s, color .15s;
}
.bg-tag-pill:hover { background: var(--bg-blue); color: #fff; }

/* Recent comments widget */
.bg-comment-list {
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.bg-comment-item {
  font-size: 12.5px;
  line-height: 1.6;
  color: var(--bg-text-light);
  padding-bottom: 14px;
  border-bottom: 1px solid var(--bg-border);
}
.bg-comment-item:last-child { border-bottom: none; padding-bottom: 0; }
.bg-comment-author {
  color: var(--bg-text);
  font-weight: 800;
}
.bg-comment-item a { color: var(--bg-blue); font-weight: 700; text-decoration: none; }
.bg-comment-item a:hover { text-decoration: underline; }

.bg-widget-empty {
  font-size: 12.5px;
  color: var(--bg-text-light);
}

/* ── RESPONSIVE ── */
@media (max-width: 980px) {
  .bg-layout { grid-template-columns: 1fr; }
  .bg-sidebar { order: 2; }
  .bg-grid { order: 1; }
}
@media (max-width: 640px) {
  html, body { overflow-x: hidden; max-width: 100%; }
  .bg-wrap { margin: 24px auto 40px; padding: 0 16px; width: 100%; }
  .bg-hero { padding: 32px 20px; border-radius: 16px; }
  .bg-hero-desc { font-size: 12.5px; }
  .bg-layout { gap: 24px; margin-top: 24px; }
  .bg-grid { grid-template-columns: 1fr; gap: 14px; }
  .bg-img { height: 170px; }
  .bg-filter-row { gap: 6px; margin: 22px 0 4px; }
  .bg-filter-pill { font-size: 11.5px; padding: 7px 14px; }
  .bg-search-form { flex-wrap: wrap; }
  .bg-search-btn { flex: 1 1 100%; padding: 11px 18px; }
  .bg-side-item { gap: 10px; }
  .bg-side-thumb { flex-basis: 48px; width: 48px; height: 48px; }
}

</style>

<div class="bg-wrap">

  <!-- HERO -->
  <div class="bg-hero">
    <span class="bg-tag">Our Blog</span>
    <h1 class="bg-title-main">Health Tips &amp; <span>News</span></h1>
    <p class="bg-hero-desc">Stay informed with the latest health advice, product updates and pharmacy news from Family Drugmart Kenya.</p>
  </div>

  <!-- CATEGORY FILTER -->
  <?php if (!empty($bg_categories) && !is_wp_error($bg_categories)): ?>
  <div class="bg-filter-row">
    <a href="<?php echo esc_url($bg_base_url); ?>" class="bg-filter-pill <?php echo $bg_cat === '' ? 'active' : ''; ?>">All Posts</a>
    <?php foreach ($bg_categories as $cat): ?>
      <a href="<?php echo esc_url(add_query_arg('blog_cat', $cat->slug, $bg_base_url)); ?>"
         class="bg-filter-pill <?php echo $bg_cat === $cat->slug ? 'active' : ''; ?>">
        <?php echo esc_html($cat->name); ?>
      </a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <div class="bg-layout">

    <!-- MAIN COLUMN -->
    <div>
      <!-- POSTS GRID -->
      <div class="bg-grid">
        <?php if ($bg_query->have_posts()): while ($bg_query->have_posts()): $bg_query->the_post(); ?>
          <article class="bg-card">
            <a href="<?php the_permalink(); ?>" class="bg-img-link">
              <div class="bg-img">
                <?php if (has_post_thumbnail()): ?>
                  <?php the_post_thumbnail('medium_large'); ?>
                <?php else: ?>
                  <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="opacity:.2;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                <?php endif; ?>
              </div>
            </a>
            <div class="bg-body">
              <?php $bg_cats_here = get_the_category(); if (!empty($bg_cats_here)): ?>
                <a href="<?php echo esc_url(get_category_link($bg_cats_here[0]->term_id)); ?>" class="bg-cat-badge"><?php echo esc_html($bg_cats_here[0]->name); ?></a>
              <?php endif; ?>
              <div class="bg-date"><?php echo esc_html(get_the_date('F j, Y')); ?></div>
              <h2 class="bg-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <p class="bg-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
              <a href="<?php the_permalink(); ?>" class="bg-readmore">
                Read More
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
            </div>
          </article>
        <?php endwhile; else: ?>
          <div class="bg-empty">No blog posts published yet. Check back soon!</div>
        <?php endif; ?>
      </div>

      <!-- PAGINATION -->
      <?php
      $bg_total = $bg_query->max_num_pages;
      if ($bg_total > 1):
        $bg_url_args = array_filter([
          'blog_cat' => $bg_cat,
          'bsearch'  => $bg_search,
        ]);
      ?>
      <div class="bg-pagination">
        <?php if ($bg_paged > 1): ?>
          <a href="<?php echo esc_url(add_query_arg(array_merge($bg_url_args, ['bpage' => $bg_paged - 1]), $bg_base_url)); ?>" class="bg-page-btn prev">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>PREV
          </a>
        <?php endif; ?>
        <?php
        $bg_show = []; $bg_delta = 2;
        for ($i = 1; $i <= $bg_total; $i++) {
          if ($i == 1 || $i == $bg_total || abs($i - $bg_paged) <= $bg_delta) $bg_show[] = $i;
        }
        $bg_show = array_unique($bg_show); sort($bg_show); $bg_prev = 0;
        foreach ($bg_show as $pg):
          if ($bg_prev && $pg - $bg_prev > 1): ?><span class="bg-page-btn dots">…</span><?php endif; ?>
          <a href="<?php echo esc_url(add_query_arg(array_merge($bg_url_args, ['bpage' => $pg]), $bg_base_url)); ?>"
             class="bg-page-btn <?php echo $pg === $bg_paged ? 'active' : ''; ?>"><?php echo $pg; ?></a>
        <?php $bg_prev = $pg; endforeach; ?>
        <?php if ($bg_paged < $bg_total): ?>
          <a href="<?php echo esc_url(add_query_arg(array_merge($bg_url_args, ['bpage' => $bg_paged + 1]), $bg_base_url)); ?>" class="bg-page-btn next">
            NEXT<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
          </a>
        <?php endif; ?>
      </div>
      <?php endif; wp_reset_postdata(); ?>
    </div>

    <!-- SIDEBAR -->
    <aside class="bg-sidebar">

      <!-- Search Widget -->
      <div class="bg-widget">
        <h3 class="bg-widget-title">Search</h3>
        <form class="bg-search-form" action="<?php echo esc_url($bg_base_url); ?>" method="get">
          <input type="text" name="bsearch" class="bg-search-input" placeholder="Search articles…" value="<?php echo esc_attr($bg_search); ?>">
          <button type="submit" class="bg-search-btn">Search</button>
        </form>
      </div>

      <!-- Recent Posts Widget -->
      <div class="bg-widget">
        <h3 class="bg-widget-title">Recent Posts</h3>
        <?php if ($bg_recent_posts->have_posts()): ?>
          <div class="bg-side-list">
            <?php while ($bg_recent_posts->have_posts()): $bg_recent_posts->the_post(); ?>
              <a href="<?php the_permalink(); ?>" class="bg-side-item">
                <div class="bg-side-thumb">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('thumbnail'); ?>
                  <?php else: ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                  <?php endif; ?>
                </div>
                <div class="bg-side-content">
                  <h4 class="bg-side-title"><?php the_title(); ?></h4>
                  <div class="bg-side-date"><?php echo esc_html(get_the_date('F j, Y')); ?></div>
                </div>
              </a>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        <?php else: ?>
          <p class="bg-widget-empty">No recent posts yet.</p>
        <?php endif; ?>
      </div>

      <!-- Tags Widget -->
      <div class="bg-widget">
        <h3 class="bg-widget-title">Tags</h3>
        <?php if (!empty($bg_tags) && !is_wp_error($bg_tags)): ?>
          <div class="bg-tag-cloud">
            <?php foreach ($bg_tags as $tag): ?>
              <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="bg-tag-pill"><?php echo esc_html($tag->name); ?></a>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="bg-widget-empty">No tags yet.</p>
        <?php endif; ?>
      </div>

      <!-- Recent Comments Widget -->
      <div class="bg-widget">
        <h3 class="bg-widget-title">Recent Comments</h3>
        <?php if (!empty($bg_recent_comments)): ?>
          <div class="bg-comment-list">
            <?php foreach ($bg_recent_comments as $comment): ?>
              <div class="bg-comment-item">
                <span class="bg-comment-author"><?php echo esc_html(get_comment_author($comment)); ?></span> on
                <a href="<?php echo esc_url(get_comment_link($comment)); ?>"><?php echo esc_html(get_the_title($comment->comment_post_ID)); ?></a>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="bg-widget-empty">No comments yet.</p>
        <?php endif; ?>
      </div>

      <!-- What's Trending Widget -->
      <div class="bg-widget">
        <h3 class="bg-widget-title">What's Trending</h3>
        <?php if ($bg_trending->have_posts()): ?>
          <div class="bg-side-list">
            <?php while ($bg_trending->have_posts()): $bg_trending->the_post(); ?>
              <a href="<?php the_permalink(); ?>" class="bg-side-item">
                <div class="bg-side-thumb">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('thumbnail'); ?>
                  <?php else: ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                  <?php endif; ?>
                </div>
                <div class="bg-side-content">
                  <h4 class="bg-side-title"><?php the_title(); ?></h4>
                  <div class="bg-side-date"><?php echo esc_html(get_the_date('F j, Y')); ?></div>
                </div>
              </a>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        <?php else: ?>
          <p class="bg-widget-empty">No trending posts yet.</p>
        <?php endif; ?>
      </div>

    </aside>

  </div>

</div>

<?php get_footer(); ?>