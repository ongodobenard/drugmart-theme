<?php
/**
 * single.php — Individual Blog Post
 * Family Drugmart Kenya
 * Matches page-blog.php's visual style and sidebar widgets.
 */
get_header();

/* ── SIDEBAR DATA (same as page-blog.php) ── */

$sg_recent_posts = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'ignore_sticky_posts' => true,
    'post__not_in'   => [ get_the_ID() ],
]);

$sg_tags = get_tags([
    'orderby' => 'count',
    'order'   => 'DESC',
    'number'  => 10,
]);

$sg_recent_comments = get_comments([
    'status' => 'approve',
    'number' => 4,
    'order'  => 'DESC',
]);

$sg_trending = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'comment_count',
    'order'          => 'DESC',
    'ignore_sticky_posts' => true,
    'post__not_in'   => [ get_the_ID() ],
]);

$sg_blog_url = home_url('/blog');
?>

<style>
:root {
  --sg-blue:        #1d3f8f;
  --sg-blue-dark:   #15306e;
  --sg-blue-darker: #0e2358;
  --sg-blue-navy:   #0a1228;
  --sg-gold:        #f5a623;
  --sg-text:        #1b2230;
  --sg-text-light:  #6b7280;
  --sg-border:      #edf0f5;
  --sg-bg-soft:     #f7f8fa;
  --sg-font-head:   'Nunito', sans-serif;
  --sg-font-body:   'Lato', sans-serif;
}

.sg-wrap {
  max-width: 1200px;
  width: 100%;
  margin: 40px auto 60px;
  padding: 0 24px;
  font-family: var(--sg-font-body);
  box-sizing: border-box;
  overflow-x: hidden;
}
.sg-wrap * { box-sizing: border-box; }

/* ── BREADCRUMB ── */
.sg-breadcrumb {
  font-size: 12.5px;
  color: var(--sg-text-light);
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 6px;
  flex-wrap: wrap;
}
.sg-breadcrumb a { color: var(--sg-blue); text-decoration: none; font-weight: 700; }
.sg-breadcrumb a:hover { text-decoration: underline; }
.sg-breadcrumb span.sep { color: #c7d0dc; }

/* ── LAYOUT ── */
.sg-layout {
  display: grid;
  grid-template-columns: minmax(0, 1fr) 320px;
  gap: 32px;
  align-items: start;
  width: 100%;
  max-width: 100%;
}
.sg-layout > div,
.sg-layout > aside {
  min-width: 0;
  max-width: 100%;
}

/* ── ARTICLE ── */
.sg-article {
  background: #fff;
  border: 1.5px solid var(--sg-border);
  border-radius: 16px;
  overflow: hidden;
}
.sg-feat-img {
  width: 100%;
  height: 380px;
  background: var(--sg-bg-soft);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}
.sg-feat-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.sg-article-body {
  padding: 32px;
}
.sg-cat-badge {
  display: inline-block;
  font-size: 10.5px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .07em;
  padding: 4px 12px;
  border-radius: 50px;
  background: rgba(29,63,143,.08);
  color: var(--sg-blue);
  text-decoration: none;
  margin-bottom: 14px;
}
.sg-title {
  font-family: var(--sg-font-head);
  font-size: clamp(22px, 3.2vw, 32px);
  font-weight: 900;
  color: var(--sg-text);
  line-height: 1.3;
  margin: 0 0 14px;
}
.sg-meta {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
  font-size: 12.5px;
  color: var(--sg-text-light);
  font-weight: 600;
  margin-bottom: 28px;
  padding-bottom: 24px;
  border-bottom: 1.5px solid var(--sg-border);
}
.sg-meta-item { display: flex; align-items: center; gap: 6px; }

.sg-content {
  font-size: 15px;
  line-height: 1.85;
  color: var(--sg-text);
}
.sg-content p { margin: 0 0 20px; }
.sg-content h2 {
  font-family: var(--sg-font-head);
  font-size: 21px;
  font-weight: 800;
  color: var(--sg-text);
  margin: 32px 0 14px;
}
.sg-content h3 {
  font-family: var(--sg-font-head);
  font-size: 18px;
  font-weight: 800;
  color: var(--sg-text);
  margin: 26px 0 12px;
}
.sg-content img {
  max-width: 100%;
  height: auto;
  border-radius: 12px;
  margin: 20px 0;
}
.sg-content ul, .sg-content ol { margin: 0 0 20px; padding-left: 22px; }
.sg-content li { margin-bottom: 8px; }
.sg-content a { color: var(--sg-blue); font-weight: 700; }
.sg-content blockquote {
  border-left: 4px solid var(--sg-gold);
  background: var(--sg-bg-soft);
  padding: 16px 20px;
  margin: 24px 0;
  border-radius: 0 10px 10px 0;
  font-style: italic;
  color: var(--sg-text-light);
}

/* ── TAGS ON POST ── */
.sg-post-tags {
  margin-top: 32px;
  padding-top: 24px;
  border-top: 1.5px solid var(--sg-border);
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  align-items: center;
}
.sg-post-tags-label {
  font-size: 12.5px;
  font-weight: 800;
  color: var(--sg-text-light);
  margin-right: 4px;
}
.sg-post-tag-pill {
  display: inline-block;
  padding: 6px 14px;
  border-radius: 8px;
  background: rgba(245,166,35,.10);
  color: var(--sg-blue-dark);
  font-size: 11.5px;
  font-weight: 700;
  text-decoration: none;
  transition: background .15s, color .15s;
}
.sg-post-tag-pill:hover { background: var(--sg-blue); color: #fff; }

/* ── BACK TO BLOG ── */
.sg-back-row {
  margin-top: 28px;
}
.sg-back-link {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 13px;
  font-weight: 800;
  color: var(--sg-blue);
  text-decoration: none;
}
.sg-back-link:hover { gap: 10px; }

/* ── SIDEBAR (shared styling with page-blog.php) ── */
.sg-sidebar {
  display: flex;
  flex-direction: column;
  gap: 24px;
}
.sg-widget {
  background: #fff;
  border: 1.5px solid var(--sg-border);
  border-radius: 16px;
  padding: 22px 20px;
  min-width: 0;
  max-width: 100%;
  overflow: hidden;
}
.sg-widget-title {
  font-family: var(--sg-font-head);
  font-size: 15px;
  font-weight: 800;
  color: var(--sg-text);
  margin: 0 0 16px;
}

.sg-search-form { display: flex; gap: 8px; }
.sg-search-input {
  flex: 1 1 0%;
  min-width: 0;
  width: 100%;
  box-sizing: border-box;
  padding: 11px 14px;
  border-radius: 10px;
  border: 1.5px solid var(--sg-border);
  background: var(--sg-bg-soft);
  font-size: 13px;
  font-family: var(--sg-font-body);
  color: var(--sg-text);
}
.sg-search-input:focus { outline: none; border-color: var(--sg-blue); }
.sg-search-btn {
  flex-shrink: 0;
  padding: 0 18px;
  border: none;
  border-radius: 10px;
  background: var(--sg-blue);
  color: #fff;
  font-size: 13px;
  font-weight: 800;
  cursor: pointer;
  transition: background .15s;
}
.sg-search-btn:hover { background: var(--sg-blue-dark); }

.sg-side-list { display: flex; flex-direction: column; gap: 16px; }
.sg-side-item {
  display: flex;
  gap: 12px;
  align-items: flex-start;
  text-decoration: none;
  min-width: 0;
  max-width: 100%;
}
.sg-side-thumb {
  flex: 0 0 56px;
  width: 56px;
  height: 56px;
  border-radius: 10px;
  background: var(--sg-bg-soft);
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}
.sg-side-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.sg-side-thumb svg { opacity: .25; }
.sg-side-content { flex: 1 1 0%; min-width: 0; max-width: 100%; }
.sg-side-title {
  font-family: var(--sg-font-head);
  font-size: 13px;
  font-weight: 700;
  line-height: 1.4;
  color: var(--sg-text);
  margin: 0 0 4px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  word-break: break-word;
  overflow-wrap: anywhere;
}
.sg-side-item:hover .sg-side-title { color: var(--sg-blue); }
.sg-side-date { font-size: 11px; color: var(--sg-text-light); font-weight: 600; }

.sg-tag-cloud { display: flex; flex-wrap: wrap; gap: 8px; }
.sg-tag-pill {
  display: inline-block;
  padding: 7px 14px;
  border-radius: 8px;
  background: rgba(245,166,35,.10);
  color: var(--sg-blue-dark);
  font-size: 12px;
  font-weight: 700;
  text-decoration: none;
  transition: background .15s, color .15s;
}
.sg-tag-pill:hover { background: var(--sg-blue); color: #fff; }

.sg-comment-list { display: flex; flex-direction: column; gap: 14px; }
.sg-comment-item {
  font-size: 12.5px;
  line-height: 1.6;
  color: var(--sg-text-light);
  padding-bottom: 14px;
  border-bottom: 1px solid var(--sg-border);
}
.sg-comment-item:last-child { border-bottom: none; padding-bottom: 0; }
.sg-comment-author { color: var(--sg-text); font-weight: 800; }
.sg-comment-item a { color: var(--sg-blue); font-weight: 700; text-decoration: none; }
.sg-comment-item a:hover { text-decoration: underline; }

.sg-widget-empty { font-size: 12.5px; color: var(--sg-text-light); }

/* ── RESPONSIVE ── */
@media (max-width: 980px) {
  .sg-layout { grid-template-columns: 1fr; }
  .sg-sidebar { order: 2; }
  .sg-article { order: 1; }
}
@media (max-width: 640px) {
  .sg-wrap { margin: 24px auto 40px; padding: 0 16px; }
  .sg-feat-img { height: 220px; }
  .sg-article-body { padding: 20px; }
  .sg-title { font-size: 22px; }
  .sg-content { font-size: 14px; }
  .sg-search-form { flex-wrap: wrap; }
  .sg-search-btn { flex: 1 1 100%; padding: 11px 18px; }
  .sg-side-item { gap: 10px; }
  .sg-side-thumb { flex-basis: 48px; width: 48px; height: 48px; }
}
</style>

<div class="sg-wrap">

  <?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>

  <!-- BREADCRUMB -->
  <nav class="sg-breadcrumb">
    <a href="<?php echo esc_url( home_url('/') ); ?>">Home</a>
    <span class="sep">&rsaquo;</span>
    <a href="<?php echo esc_url( $sg_blog_url ); ?>">Blog</a>
    <span class="sep">&rsaquo;</span>
    <span><?php the_title(); ?></span>
  </nav>

  <div class="sg-layout">

    <!-- ARTICLE -->
    <article class="sg-article">

      <?php if ( has_post_thumbnail() ): ?>
        <div class="sg-feat-img">
          <?php the_post_thumbnail('large'); ?>
        </div>
      <?php endif; ?>

      <div class="sg-article-body">

        <?php
        $sg_cats = get_the_category();
        if ( ! empty( $sg_cats ) ): ?>
          <a href="<?php echo esc_url( get_category_link( $sg_cats[0]->term_id ) ); ?>" class="sg-cat-badge"><?php echo esc_html( $sg_cats[0]->name ); ?></a>
        <?php endif; ?>

        <h1 class="sg-title"><?php the_title(); ?></h1>

        <div class="sg-meta">
          <span class="sg-meta-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <?php echo esc_html( get_the_date('F j, Y') ); ?>
          </span>
          <span class="sg-meta-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <?php the_author(); ?>
          </span>
        </div>

        <div class="sg-content">
          <?php the_content(); ?>
        </div>

        <?php
        $sg_post_tags = get_the_tags();
        if ( ! empty( $sg_post_tags ) && ! is_wp_error( $sg_post_tags ) ): ?>
          <div class="sg-post-tags">
            <span class="sg-post-tags-label">Tags:</span>
            <?php foreach ( $sg_post_tags as $tag ): ?>
              <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="sg-post-tag-pill"><?php echo esc_html( $tag->name ); ?></a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="sg-back-row">
          <a href="<?php echo esc_url( $sg_blog_url ); ?>" class="sg-back-link">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Blog
          </a>
        </div>

      </div>
    </article>

    <!-- SIDEBAR -->
    <aside class="sg-sidebar">

      <!-- Search -->
      <div class="sg-widget">
        <h3 class="sg-widget-title">Search</h3>
        <form class="sg-search-form" action="<?php echo esc_url( $sg_blog_url ); ?>" method="get">
          <input type="text" name="bsearch" class="sg-search-input" placeholder="Search articles…">
          <button type="submit" class="sg-search-btn">Search</button>
        </form>
      </div>

      <!-- Recent Posts -->
      <div class="sg-widget">
        <h3 class="sg-widget-title">Recent Posts</h3>
        <?php if ( $sg_recent_posts->have_posts() ): ?>
          <div class="sg-side-list">
            <?php while ( $sg_recent_posts->have_posts() ): $sg_recent_posts->the_post(); ?>
              <a href="<?php the_permalink(); ?>" class="sg-side-item">
                <div class="sg-side-thumb">
                  <?php if ( has_post_thumbnail() ): ?>
                    <?php the_post_thumbnail('thumbnail'); ?>
                  <?php else: ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                  <?php endif; ?>
                </div>
                <div class="sg-side-content">
                  <h4 class="sg-side-title"><?php the_title(); ?></h4>
                  <div class="sg-side-date"><?php echo esc_html( get_the_date('F j, Y') ); ?></div>
                </div>
              </a>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        <?php else: ?>
          <p class="sg-widget-empty">No recent posts yet.</p>
        <?php endif; ?>
      </div>

      <!-- Tags -->
      <div class="sg-widget">
        <h3 class="sg-widget-title">Tags</h3>
        <?php if ( ! empty( $sg_tags ) && ! is_wp_error( $sg_tags ) ): ?>
          <div class="sg-tag-cloud">
            <?php foreach ( $sg_tags as $tag ): ?>
              <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="sg-tag-pill"><?php echo esc_html( $tag->name ); ?></a>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="sg-widget-empty">No tags yet.</p>
        <?php endif; ?>
      </div>

      <!-- Recent Comments -->
      <div class="sg-widget">
        <h3 class="sg-widget-title">Recent Comments</h3>
        <?php if ( ! empty( $sg_recent_comments ) ): ?>
          <div class="sg-comment-list">
            <?php foreach ( $sg_recent_comments as $comment ): ?>
              <div class="sg-comment-item">
                <span class="sg-comment-author"><?php echo esc_html( get_comment_author( $comment ) ); ?></span> on
                <a href="<?php echo esc_url( get_comment_link( $comment ) ); ?>"><?php echo esc_html( get_the_title( $comment->comment_post_ID ) ); ?></a>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="sg-widget-empty">No comments yet.</p>
        <?php endif; ?>
      </div>

      <!-- What's Trending -->
      <div class="sg-widget">
        <h3 class="sg-widget-title">What's Trending</h3>
        <?php if ( $sg_trending->have_posts() ): ?>
          <div class="sg-side-list">
            <?php while ( $sg_trending->have_posts() ): $sg_trending->the_post(); ?>
              <a href="<?php the_permalink(); ?>" class="sg-side-item">
                <div class="sg-side-thumb">
                  <?php if ( has_post_thumbnail() ): ?>
                    <?php the_post_thumbnail('thumbnail'); ?>
                  <?php else: ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                  <?php endif; ?>
                </div>
                <div class="sg-side-content">
                  <h4 class="sg-side-title"><?php the_title(); ?></h4>
                  <div class="sg-side-date"><?php echo esc_html( get_the_date('F j, Y') ); ?></div>
                </div>
              </a>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        <?php else: ?>
          <p class="sg-widget-empty">No trending posts yet.</p>
        <?php endif; ?>
      </div>

    </aside>

  </div>

  <?php endwhile; endif; ?>

</div>

<?php get_footer(); ?>