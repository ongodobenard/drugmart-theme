<?php
/**
 * Family Drugmart — header.php
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#1d3f8f">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<style>

/* ═══════════════════════════════════════════
   PAGE LOADER — Family Drugmart
═══════════════════════════════════════════ */
#fd-loader {
  position: fixed;
  inset: 0;
  z-index: 9999999;
  background: #0e2358;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 28px;
  opacity: 1;
  transition: opacity .5s ease;
}
#fd-loader.fd-loader-out {
  opacity: 0;
  pointer-events: none;
}

/* Logo circle */
.fd-ld-logo {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 0 0 0 rgba(245,166,35,0);
  animation: fd-logo-pulse 2s ease-in-out infinite;
  flex-shrink: 0;
  overflow: hidden;
}
.fd-ld-logo img {
  width: 64px;
  height: 64px;
  object-fit: contain;
  display: block;
}
@keyframes fd-logo-pulse {
  0%,100% { box-shadow: 0 0 0 0   rgba(245,166,35,.0), 0 8px 32px rgba(0,0,0,.4); }
  50%      { box-shadow: 0 0 0 14px rgba(245,166,35,.18), 0 8px 32px rgba(0,0,0,.4); }
}

/* Brand name */
.fd-ld-brand {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
}
.fd-ld-name {
  font-family: 'Nunito', system-ui, sans-serif;
  font-size: clamp(1.1rem, 3vw, 1.45rem);
  font-weight: 900;
  color: #fff;
  letter-spacing: .12em;
  text-transform: uppercase;
}
.fd-ld-name span {
  color: #f5a623;
}
.fd-ld-sub {
  font-family: 'Lato', system-ui, sans-serif;
  font-size: .68rem;
  font-weight: 700;
  color: rgba(255,255,255,.40);
  letter-spacing: .3em;
  text-transform: uppercase;
}

/* Progress bar */
.fd-ld-bar-wrap {
  width: clamp(180px, 40vw, 260px);
  height: 3px;
  background: rgba(255,255,255,.10);
  border-radius: 3px;
  overflow: hidden;
}
.fd-ld-bar {
  height: 100%;
  width: 0%;
  background: linear-gradient(90deg, #1d3f8f, #f5a623);
  border-radius: 3px;
  animation: fd-bar-fill 1.8s cubic-bezier(.4,0,.2,1) forwards;
}
@keyframes fd-bar-fill {
  0%   { width: 0%; }
  60%  { width: 75%; }
  100% { width: 100%; }
}

/* Gold bottom border accent */
.fd-ld-foot {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, transparent, #f5a623, #1d3f8f, #f5a623, transparent);
  background-size: 200% 100%;
  animation: fd-foot-slide 2s linear infinite;
}
@keyframes fd-foot-slide {
  0%   { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

@media (prefers-reduced-motion: reduce) {
  .fd-ld-logo, .fd-ld-bar, .fd-ld-foot { animation: none !important; }
  .fd-ld-bar { width: 100% !important; }
}

/* ============================================================
   GOOGLE FONTS
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Lato:wght@400;700&display=swap');

/* ============================================================
   CSS VARS
   ============================================================ */
:root {
  --blue:        #1d3f8f;
  --blue-dark:   #15306e;
  --blue-darker: #0e2358;
  --blue-light:  #eaf0fb;
  --gold:        #f5a623;
  --navy:        #0a1228;
  --gray-bg:     #f4f6f8;
  --white:       #ffffff;
  --text:        #333333;
  --text-light:  #888888;
  --border:      #eeeeee;
  --radius:      8px;
  --shadow:      0 2px 12px rgba(0,0,0,.07);
  --font-head:   'Nunito', sans-serif;
  --font-body:   'Lato', sans-serif;
  --page-px:     48px;
}

/* ============================================================
   TOPBAR
   ============================================================ */
.topbar {
  background: var(--navy); color: #ccc; font-size: 12px;
  display: flex; justify-content: space-between; align-items: center;
  padding: 6px var(--page-px); flex-wrap: wrap; gap: 12px;
}
.topbar-left { display: flex; align-items: center; gap: 20px; flex-wrap: wrap; }
.topbar-left span { display: flex; align-items: center; gap: 5px; white-space: nowrap; }
.topbar-left svg { flex-shrink: 0; color: #ffffff; }
.topbar-left a { color: inherit; text-decoration: none; }
.topbar-socials { display: flex; align-items: center; gap: 8px; }

.t-soc {
  display: inline-flex; align-items: center; justify-content: center;
  width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
  transition: transform .2s, box-shadow .2s; text-decoration: none;
  font-size: 10px; font-weight: 800; color: white;
  font-family: var(--font-head); box-shadow: 0 1px 4px rgba(0,0,0,.25);
}
.t-soc:hover { transform: translateY(-2px) scale(1.13); box-shadow: 0 4px 12px rgba(0,0,0,.35); }
.t-soc-wa { background: #25D366 !important; }
.t-soc-fb { background: #1877F2 !important; }
.t-soc-tw { background: #15202b !important; }
.t-soc-ig { background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%) !important; }

/* ============================================================
   STICKY HEADER
   ============================================================ */
.site-header-sticky-wrap {
  position: sticky; top: 0; z-index: 500;
  box-shadow: 0 2px 14px rgba(0,0,0,0); transition: box-shadow .25s ease;
}
.site-header-sticky-wrap.is-pinned { box-shadow: 0 4px 18px rgba(0,0,0,.18); }

/* ============================================================
   SITE HEADER
   ============================================================ */
.site-header {
  background: var(--blue);
  display: flex; align-items: center;
  gap: 18px; padding: 11px var(--page-px); flex-wrap: wrap;
}

.hamburger-btn {
  display: none; background: rgba(255,255,255,.15); border: none;
  cursor: pointer; flex-direction: column; gap: 5px;
  padding: 8px; border-radius: 5px; transition: background .2s; flex-shrink: 0;
}
.hamburger-btn:hover { background: rgba(255,255,255,.28); }
.hamburger-btn span { display: block; width: 22px; height: 2px; background: white; border-radius: 2px; }

/* ── Logo ── */
.site-logo {
  display: flex; align-items: center; gap: 10px;
  color: white; white-space: nowrap; text-decoration: none;
  transition: opacity .2s; flex-shrink: 0;
}
.site-logo:hover { opacity: .88; }

.site-logo-img-wrap {
  width: clamp(42px, 4.5vw + 18px, 56px);
  height: clamp(42px, 4.5vw + 18px, 56px);
  border-radius: 50%; background: #ffffff;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; overflow: hidden;
  transition: transform .25s ease, box-shadow .25s ease;
  box-shadow: 0 2px 8px rgba(0,0,0,.30);
}
.site-logo:hover .site-logo-img-wrap {
  transform: scale(1.08); box-shadow: 0 4px 16px rgba(0,0,0,.45);
}
.site-logo-img { width: 100%; height: 100%; object-fit: contain; flex-shrink: 0; display: block; }

.mobile-logo-img-wrap {
  width: 40px; height: 40px; border-radius: 50%; background: #ffffff;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,.25);
}
.mobile-logo-img { width: 100%; height: 100%; object-fit: contain; display: block; }

.logo-name { font-family: var(--font-head); font-size: 22px; font-weight: 900; color: white; display: block; line-height: 1.1; }
.logo-sub  { font-size: 9px; font-weight: 600; color: rgba(255,255,255,.75); letter-spacing: 1.3px; text-transform: uppercase; display: block; }

/* ── Search ── */
.header-search { flex: 1; max-width: 620px; margin: 0 auto; }
.header-search form { display: flex; border-radius: 5px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.15); }
.header-search form:focus-within { box-shadow: 0 4px 16px rgba(0,0,0,.25); }
.header-search input[type="search"] { flex: 1; border: none; outline: none; padding: 11px 20px; font-size: 14px; color: var(--text); background: white; min-width: 0; }
.header-search input[type="search"]::placeholder { color: #aaa; }
.header-search button { background: var(--navy); color: white; border: none; padding: 11px 26px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: var(--font-head); white-space: nowrap; transition: background .2s; display: flex; align-items: center; gap: 6px; }
.header-search button:hover { background: #16204a; }

/* ── Header right ── */
.header-right { display: flex; align-items: center; gap: 14px; flex-shrink: 0; }

.hdr-link {
  display: flex; align-items: center; gap: 7px;
  color: white; font-size: 13px; font-weight: 600;
  white-space: nowrap; text-decoration: none;
  padding: 6px 10px; border-radius: 5px;
  transition: background .2s, transform .15s;
}
.hdr-link:hover { background: rgba(255,255,255,.16); transform: translateY(-1px); }
.hdr-link svg { width: 17px; height: 17px; }

.hdr-wish {
  color: white; padding: 7px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  text-decoration: none; position: relative;
  transition: background .2s, transform .15s;
}
.hdr-wish:hover { background: rgba(255,255,255,.2); transform: scale(1.12); }
.hdr-wish svg { stroke: #ffffff; }

/* ════════════════════════════════════════════════
   CART WRAPPER
════════════════════════════════════════════════ */
.hdr-cart-wrap {
  position: relative;
  display: flex;
  align-items: center;
}

.hdr-cart {
  display: flex; align-items: center; gap: 8px;
  color: white; position: relative; text-decoration: none;
  padding: 6px 10px; border-radius: 5px;
  transition: background .2s, transform .15s;
}
.hdr-cart:hover { background: rgba(255,255,255,.16); transform: translateY(-1px); }
.hdr-cart svg { stroke: #ffffff; }
.cart-total-amt { font-size: 14px; font-weight: 700; color: white; }

.badge-dot {
  background: var(--gold); color: var(--navy); font-size: 10px; font-weight: 800;
  min-width: 18px; height: 18px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  position: absolute; top: -5px; right: -3px;
  border: 2px solid var(--blue); padding: 0 3px;
}
.badge-dot.wish-badge { display: none; }
.badge-dot.wish-badge.has-items { display: flex; }

/* ════════════════════════════════════════════════
   CART HOVER DROPDOWN
════════════════════════════════════════════════ */
.fd-cart-dropdown {
  position: absolute;
  top: calc(100% + 14px);
  right: 0;
  width: 340px;
  background: #fff;
  border-radius: 14px;
  border: 1.5px solid #edf0f5;
  box-shadow: 0 16px 48px rgba(29,63,143,.16), 0 2px 10px rgba(0,0,0,.08);
  z-index: 99999;
  opacity: 0;
  visibility: hidden;
  transform: translateY(10px);
  transition: opacity .22s ease, transform .22s ease, visibility .22s;
  pointer-events: none;
  font-family: 'Lato', sans-serif;
}

.fd-cart-dropdown::before {
  content: '';
  position: absolute;
  top: -7px;
  right: 24px;
  width: 13px;
  height: 13px;
  background: #0e2358;
  transform: rotate(45deg);
  border-radius: 2px 0 0 0;
  border-left: 1.5px solid #0e2358;
  border-top: 1.5px solid #0e2358;
}

.fd-cdrop-head {
  background: linear-gradient(135deg, #0e2358, #1d3f8f);
  border-bottom: 3px solid #f5a623;
  padding: 13px 16px;
  border-radius: 12px 12px 0 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.fd-cdrop-head-title {
  font-family: 'Nunito', sans-serif;
  font-size: .88rem;
  font-weight: 800;
  color: #fff;
  display: flex;
  align-items: center;
  gap: 7px;
}
.fd-cdrop-count {
  background: #f5a623;
  color: #0a1228;
  font-size: .65rem;
  font-weight: 900;
  padding: 2px 8px;
  border-radius: 50px;
  font-family: 'Lato', sans-serif;
  white-space: nowrap;
}

.fd-cdrop-items {
  max-height: 256px;
  overflow-y: auto;
  padding: 6px 0;
  scrollbar-width: thin;
  scrollbar-color: #edf0f5 transparent;
}
.fd-cdrop-items::-webkit-scrollbar { width: 4px; }
.fd-cdrop-items::-webkit-scrollbar-track { background: transparent; }
.fd-cdrop-items::-webkit-scrollbar-thumb { background: #dde3f0; border-radius: 4px; }

.fd-cdrop-item {
  display: flex;
  align-items: center;
  gap: 11px;
  padding: 9px 16px;
  border-bottom: 1px solid #f7f8fa;
  transition: background .15s;
}
.fd-cdrop-item:last-child { border-bottom: none; }
.fd-cdrop-item:hover { background: #f7f8fa; }

.fd-cdrop-img {
  width: 48px; height: 48px;
  border-radius: 8px;
  object-fit: contain;
  background: #f4f6f8;
  border: 1px solid #edf0f5;
  flex-shrink: 0;
  padding: 3px;
}
.fd-cdrop-img-ph {
  width: 48px; height: 48px;
  border-radius: 8px;
  background: #eef1f8;
  border: 1px solid #edf0f5;
  flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  color: #1d3f8f; opacity: .45;
}

.fd-cdrop-info { flex: 1; min-width: 0; }
.fd-cdrop-name {
  font-size: .79rem;
  font-weight: 700;
  color: #1b2230;
  line-height: 1.3;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  margin-bottom: 3px;
}
.fd-cdrop-meta {
  font-size: .7rem;
  color: #6b7280;
  display: flex;
  align-items: center;
  gap: 6px;
}
.fd-cdrop-qty {
  background: #eef1f8;
  color: #1d3f8f;
  font-weight: 800;
  padding: 1px 6px;
  border-radius: 4px;
  font-size: .67rem;
}
.fd-cdrop-price {
  font-size: .84rem;
  font-weight: 900;
  color: #1d3f8f;
  font-family: 'Nunito', sans-serif;
  flex-shrink: 0;
  white-space: nowrap;
}

.fd-cdrop-empty {
  padding: 30px 16px;
  text-align: center;
  color: #6b7280;
  font-size: .82rem;
  line-height: 1.6;
}
.fd-cdrop-empty svg { display: block; margin: 0 auto 10px; opacity: .25; }

.fd-cdrop-foot {
  border-top: 2px solid #edf0f5;
  padding: 12px 16px 14px;
  background: #f7f8fa;
  border-radius: 0 0 12px 12px;
}
.fd-cdrop-total-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 11px;
  padding-bottom: 11px;
  border-bottom: 1px solid #edf0f5;
}
.fd-cdrop-total-label {
  font-size: .76rem;
  font-weight: 700;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: .05em;
}
.fd-cdrop-total-amt {
  font-size: 1rem;
  font-weight: 900;
  color: #1d3f8f;
  font-family: 'Nunito', sans-serif;
}
.fd-cdrop-btns { display: flex; gap: 8px; }
.fd-cdrop-btn-view {
  flex: 1;
  display: flex; align-items: center; justify-content: center; gap: 6px;
  padding: 10px 12px; border-radius: 50px;
  font-size: .8rem; font-weight: 800; font-family: 'Nunito', sans-serif;
  text-decoration: none; border: 2px solid #1d3f8f;
  color: #1d3f8f; background: #fff; transition: all .2s; white-space: nowrap;
}
.fd-cdrop-btn-view:hover { background: #eef1f8; color: #0e2358; border-color: #0e2358; }

.fd-cdrop-btn-checkout {
  flex: 1;
  display: flex; align-items: center; justify-content: center; gap: 6px;
  padding: 10px 12px; border-radius: 50px;
  font-size: .8rem; font-weight: 800; font-family: 'Nunito', sans-serif;
  text-decoration: none; background: #1d3f8f; color: #fff;
  border: 2px solid #1d3f8f;
  box-shadow: 0 4px 14px rgba(29,63,143,.28);
  transition: all .2s; white-space: nowrap;
}
.fd-cdrop-btn-checkout:hover {
  background: #0e2358; border-color: #0e2358; color: #fff;
  transform: translateY(-1px); box-shadow: 0 6px 18px rgba(29,63,143,.36);
}

@media (max-width: 960px) {
  .fd-cart-dropdown { display: none !important; }
}

/* ============================================================
   DESKTOP NAVBAR
   ============================================================ */
.site-navbar {
  background: var(--white);
  border-top: 4px solid var(--gold);
  padding: 6px 12px;
}
.navbar-inner { background: var(--blue-darker); border-radius: var(--radius); overflow: hidden; }
.navbar-list {
  display: flex; align-items: stretch; list-style: none;
  margin: 0; padding: 0 var(--page-px); flex-wrap: wrap;
}
.navbar-list > li > a {
  display: flex; align-items: center; gap: 6px;
  padding: 13px 17px; font-size: 13px; font-weight: 700;
  font-family: var(--font-head); color: rgba(255,255,255,.88);
  white-space: nowrap; text-decoration: none;
  border-bottom: 3px solid transparent;
  transition: background .2s, color .15s, border-color .2s;
}
.navbar-list > li > a:hover { background: rgba(0,0,0,.18); color: white; border-bottom-color: var(--gold); }
.navbar-list > li > a.active {
  background: rgba(0,0,0,.18); color: white; border-bottom-color: var(--gold);
}

.nav-spacer { flex: 1; }

.nav-returns > a {
  color: rgba(255,255,255,.85) !important; font-size: 13px !important;
  border-bottom: none !important; padding: 13px 14px !important; background: transparent !important;
}
.nav-returns > a:hover { color: white !important; background: rgba(0,0,0,.1) !important; }
.nav-returns > a.active {
  color: white !important; border-bottom: 3px solid var(--gold) !important; background: rgba(0,0,0,.1) !important;
}

.nav-contact > a {
  background: white !important; color: var(--blue-dark) !important;
  border-radius: 20px !important; border-bottom: none !important;
  margin: 7px 0 7px 6px !important; padding: 6px 20px !important;
  font-weight: 800 !important; transition: background .2s, transform .15s, color .2s !important;
}
.nav-contact > a:hover { background: var(--navy) !important; color: white !important; transform: translateY(-1px) !important; }
.nav-contact > a.active { background: var(--navy) !important; color: white !important; }
.nav-contact > a.active svg { stroke: white !important; }

/* ============================================================
   MOBILE NAV DRAWER
   ============================================================ */
.mobile-nav-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 998; backdrop-filter: blur(2px); }
.mobile-nav-overlay.open { display: block; }
.mobile-nav { position: fixed; top: 0; left: -300px; width: 290px; height: 100%; background: white; z-index: 999; transition: left .3s ease; overflow-y: auto; box-shadow: 4px 0 24px rgba(0,0,0,.18); }
.mobile-nav.open { left: 0; }
.mobile-nav-head {
  background: var(--blue); padding: 14px 18px;
  display: flex; justify-content: space-between; align-items: center; gap: 10px;
}
.mobile-nav-logo { display: flex; align-items: center; gap: 9px; text-decoration: none; }
.mobile-nav-head .logo-name { color: white; font-size: 16px; }
.mobile-nav-close { background: rgba(255,255,255,.15); border: none; color: white; font-size: 18px; cursor: pointer; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: background .2s; flex-shrink: 0; }
.mobile-nav-close:hover { background: rgba(255,255,255,.3); }
.mobile-nav a { display: block; padding: 13px 22px; font-size: 14px; font-weight: 700; font-family: var(--font-head); color: var(--navy); border-bottom: 1px solid #f0f0f0; text-decoration: none; transition: background .15s, color .15s, padding-left .2s; }
.mobile-nav a:hover { background: var(--blue-light); color: var(--blue); padding-left: 30px; }
.mobile-nav a.active { background: var(--blue-light); color: var(--blue); border-left: 4px solid var(--gold); padding-left: 18px; }
.mobile-nav .mob-contact-btn {
  margin: 14px 22px; display: inline-block; background: var(--blue);
  color: white !important; border-radius: 20px; padding: 8px 22px !important;
  font-size: 14px; font-weight: 800; border-bottom: none !important; transition: background .2s !important;
}
.mobile-nav .mob-contact-btn:hover { background: var(--blue-dark) !important; padding-left: 22px !important; }
.mobile-nav .mob-contact-btn.active { background: var(--navy) !important; border-left: none !important; }

/* ============================================================
   BREADCRUMB
   ============================================================ */
.site-breadcrumb { padding: 12px var(--page-px); font-size: 13px; color: var(--text-light); display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
.site-breadcrumb a { color: var(--blue-dark); text-decoration: none; }
.site-breadcrumb a:hover { text-decoration: underline; }

/* ============================================================
   RESPONSIVE — TABLET
   ============================================================ */
@media (max-width: 1024px) {
  .hdr-link span { display: none; }
  .hdr-link { padding: 6px 8px; }
  .site-logo-img-wrap { width: clamp(38px, 4.5vw + 14px, 50px); height: clamp(38px, 4.5vw + 14px, 50px); }
}

/* ============================================================
   RESPONSIVE — MOBILE (≤ 640px)
   ============================================================ */
@media (max-width: 640px) {
  .topbar      { display: none; }
  .site-navbar { display: none; }
  .hamburger-btn { display: flex; }

  .site-header {
    display: grid;
    grid-template-columns: auto 1fr auto;
    grid-template-rows: auto auto;
    align-items: center;
    gap: 0; padding: 0; flex-wrap: unset;
  }

  .hamburger-btn {
    grid-column: 1; grid-row: 1; margin: 0; align-self: stretch;
    padding: 0 12px; border-radius: 0;
    background: rgba(255,255,255,.10);
    border-right: 1px solid rgba(255,255,255,.14);
    display: flex; flex-direction: column; justify-content: center; gap: 5px; min-height: 52px;
  }
  .hamburger-btn:hover { background: rgba(255,255,255,.22); }
  .hamburger-btn span  { width: 19px; }

  .site-logo {
    grid-column: 2; grid-row: 1;
    padding: 7px 6px 7px 9px; gap: 6px;
    min-width: 0; overflow: hidden; white-space: nowrap; flex-shrink: 1; align-items: center;
  }
  .site-logo-img-wrap { width: clamp(26px, 3.5vw + 12px, 38px); height: clamp(26px, 3.5vw + 12px, 38px); flex-shrink: 0; }
  .site-logo > div { min-width: 0; overflow: hidden; display: flex; flex-direction: column; }
  .logo-name { font-size: clamp(9px, 2.8vw, 17px); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 100%; line-height: 1.15; }
  .logo-sub  { font-size: clamp(5px, 1.3vw, 7.5px); letter-spacing: clamp(.3px, .15vw, .9px); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 100%; }

  .header-right {
    grid-column: 3; grid-row: 1; gap: 0; padding: 0 4px; flex-shrink: 0;
    border-left: 1px solid rgba(255,255,255,.14);
    align-self: stretch; align-items: center; display: flex;
  }

  .hdr-wish     { padding: 6px 4px; }
  .hdr-wish svg { width: 18px; height: 18px; }
  .hdr-cart     { padding: 6px 4px; gap: 2px; }
  .hdr-cart svg { width: 18px; height: 18px; }
  .cart-total-amt { font-size: clamp(9px, 2.4vw, 12px); font-weight: 700; }
  .badge-dot { top: -3px; right: -1px; min-width: 15px; height: 15px; font-size: 8px; border-width: 1.5px; }

  .header-search {
    grid-column: 1 / -1; grid-row: 2;
    width: 100%; max-width: 100%; flex: none; margin: 0;
    padding: 8px 11px; box-sizing: border-box;
    border-top: 1px solid rgba(255,255,255,.18);
    background: rgba(0,0,0,.14);
  }
  .header-search form { border-radius: 6px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.22); }
  .header-search input[type="search"] { padding: 9px 12px; font-size: 13px; }
  .header-search button               { padding: 9px 14px; font-size: 12px; }
}

@media (max-width: 380px) {
  .logo-name          { font-size: clamp(8px, 2.5vw, 11px); }
  .logo-sub           { display: none; }
  .site-logo-img-wrap { width: 24px; height: 24px; }
  .hamburger-btn span { width: 17px; }
  .cart-total-amt     { display: none; }
  .header-right       { padding: 0 2px; }
  .hdr-link svg       { width: 14px; height: 14px; }
  .hdr-wish svg       { width: 16px; height: 16px; }
  .hdr-cart svg       { width: 16px; height: 16px; }
}

@media (max-width: 320px) {
  .logo-name          { font-size: 8px; }
  .site-logo-img-wrap { width: 20px; height: 20px; }
  .hdr-link  { padding: 6px 2px; }
  .hdr-wish  { padding: 6px 2px; }
  .hdr-cart  { padding: 6px 2px; }
}
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- ═══════════════════════════════════
     PAGE LOADER — Family Drugmart
═══════════════════════════════════ -->
<div id="fd-loader" aria-hidden="true">

  <div class="fd-ld-logo">
    <img
      src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/images/drugmart_logo.png'); ?>"
      alt="Family Drugmart"
      width="64" height="64"
    />
  </div>

  <div class="fd-ld-brand">
    <div class="fd-ld-name">Family <span>Drugmart</span></div>
    <div class="fd-ld-sub">Online Pharmacy · Kenya</div>
  </div>

  <div class="fd-ld-bar-wrap">
    <div class="fd-ld-bar"></div>
  </div>

  <div class="fd-ld-foot"></div>

</div>

<script>
(function(){
  function fdHideLoader(){
    var l = document.getElementById('fd-loader');
    if(!l || l.dataset.gone) return;
    l.dataset.gone = '1';
    l.classList.add('fd-loader-out');
    setTimeout(function(){ l.style.display = 'none'; }, 520);
  }
  if(document.readyState === 'complete'){
    fdHideLoader();
  } else {
    window.addEventListener('load', fdHideLoader);
  }
  /* Fallback — never block the page longer than 4s */
  setTimeout(fdHideLoader, 4000);
})();
</script>
<!-- END PAGE LOADER -->

<?php wp_body_open(); ?>

<!-- ==================== MOBILE NAV DRAWER ==================== -->
<div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
<nav class="mobile-nav" id="mobileNav" aria-label="Mobile navigation">
  <div class="mobile-nav-head">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-logo">
      <div class="mobile-logo-img-wrap">
        <img
          src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/images/drugmart_logo.png'); ?>"
          alt="<?php bloginfo('name'); ?>"
          class="mobile-logo-img"
          width="40" height="40" loading="eager" decoding="async"
        />
      </div>
      <span class="logo-name">Family Drugmart Kenya</span>
    </a>
    <button class="mobile-nav-close" id="mobileNavClose" aria-label="Close menu">&#x2715;</button>
  </div>

  <?php
  $shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop');
  $mob_nav_items = [
    [home_url('/'),                    'Home',                 is_front_page()],
    [$shop_url,                        'Shop',                 is_shop()],
    [home_url('/about-us'),            'About Us',             is_page('about-us')],
    [home_url('/submit-prescription'), 'Submit Prescription',  is_page('submit-prescription')],
    [home_url('/ultra-sound-service'), 'Ultra Sound Services', is_page('ultrasound-services') || is_page('ultra-sound-service')],
    [home_url('/refund'),              'Returns &amp; Policy', is_page('refund')],
    [home_url('/blog'),                'Blog',                 is_page('blog')],
];
  foreach ($mob_nav_items as [$url, $label, $active]) {
    echo '<a href="' . esc_url($url) . '"' . ($active ? ' class="active"' : '') . '>' . wp_kses_post($label) . '</a>';
  }
  $is_contact_page = is_page('contact');
  ?>
  <a href="<?php echo esc_url(home_url('/contact')); ?>" class="mob-contact-btn<?php echo $is_contact_page ? ' active' : ''; ?>">Contact</a>
</nav>

<!-- ==================== TOPBAR ==================== -->
<div class="topbar">
  <div class="topbar-left">
    <span>
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
      <a href="tel:+254796140021">+254 796140021</a>
    </span>
    <span class="email-info">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      <?php echo function_exists('medicare_email') ? esc_html(medicare_email()) : 'info@familydrugmart.co.ke'; ?>
    </span>
    <span class="address-info">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
      <?php echo function_exists('medicare_address') ? esc_html(medicare_address()) : 'Nairobi, Kenya'; ?> 
  </div>
  <div class="topbar-socials">
    <a href="<?php echo esc_url(get_option('medicare_facebook','#')); ?>" target="_blank" rel="noopener noreferrer" class="t-soc t-soc-fb" aria-label="Facebook">
      <svg width="11" height="11" viewBox="0 0 24 24" fill="white"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
    </a>
    <a href="<?php echo esc_url(get_option('medicare_instagram','#')); ?>" target="_blank" rel="noopener noreferrer" class="t-soc t-soc-ig" aria-label="Instagram">
      <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="white" stroke="none"/></svg>
    </a>
    <a href="<?php echo esc_url(get_option('medicare_twitter','#')); ?>" target="_blank" rel="noopener noreferrer" class="t-soc t-soc-tw" aria-label="X">
      <svg width="11" height="11" viewBox="0 0 24 24" fill="white"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
    </a>
    <a href="https://wa.me/254796140021" target="_blank" rel="noopener noreferrer" class="t-soc t-soc-wa" aria-label="WhatsApp">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
  </div>
</div>

<!-- ==================== STICKY WRAP ==================== -->
<div class="site-header-sticky-wrap" id="stickyHeaderWrap">

<!-- ==================== SITE HEADER ==================== -->
<div class="site-header">
  <button class="hamburger-btn" id="hamburgerBtn" aria-label="Open menu" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>

  <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="Family Drugmart Kenya — Go to homepage">
    <?php if (has_custom_logo()): the_custom_logo(); else: ?>
      <div class="site-logo-img-wrap">
        <img
          src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/images/drugmart_logo.png'); ?>"
          alt="Family Drugmart Kenya Logo"
          class="site-logo-img"
          width="56" height="56"
          loading="eager" decoding="async" fetchpriority="high"
        />
      </div>
      <div>
        <span class="logo-name">Family Drugmart Kenya</span>
        <span class="logo-sub">ONLINE PHARMACY</span>
      </div>
    <?php endif; ?>
  </a>

  <div class="header-search">
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
      <input class="search-input" type="search" name="s" placeholder="Search medicines, products..." value="<?php echo get_search_query(); ?>">
      <input type="hidden" name="post_type" value="product">
      <button type="submit">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Search
      </button>
    </form>
  </div>

  <div class="header-right">

    <?php
    $wishlist_url   = function_exists('YITH_WCWL') ? YITH_WCWL()->get_wishlist_url() : home_url('/wishlist');
    $wishlist_count = function_exists('yith_wcwl_count_products_in_wishlist') ? yith_wcwl_count_products_in_wishlist() : 0;
    ?>
    <a href="<?php echo esc_url($wishlist_url); ?>" class="hdr-wish" aria-label="Wishlist">
      <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
      </svg>
      <span class="badge-dot wish-badge <?php echo $wishlist_count > 0 ? 'has-items' : ''; ?>">
        <?php echo $wishlist_count > 0 ? $wishlist_count : ''; ?>
      </span>
    </a>

    <?php if (function_exists('WC') && WC()->cart):
      $cart_items   = WC()->cart->get_cart();
      $cart_count   = WC()->cart->get_cart_contents_count();
      $cart_total   = WC()->cart->get_cart_total();
      $cart_url     = wc_get_cart_url();
      $checkout_url = wc_get_checkout_url();
    ?>

    <div class="hdr-cart-wrap">

      <a href="<?php echo esc_url($cart_url); ?>" class="hdr-cart" aria-label="View cart">
        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" width="20" height="20">
          <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
        </svg>
        <span class="cart-total-amt"><?php echo $cart_total; ?></span>
        <?php if ($cart_count > 0): ?>
          <span class="badge-dot"><?php echo $cart_count; ?></span>
        <?php endif; ?>
      </a>

      <div class="fd-cart-dropdown" id="fdCartDropdown" role="region" aria-label="Cart preview">

        <div class="fd-cdrop-head">
          <div class="fd-cdrop-head-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" width="15" height="15">
              <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            Your Cart
          </div>
          <span class="fd-cdrop-count" id="fdCdropCount">
            <?php echo $cart_count; ?> item<?php echo $cart_count !== 1 ? 's' : ''; ?>
          </span>
        </div>

        <div class="fd-cdrop-items" id="fdCdropItems">
          <?php if (!empty($cart_items)): ?>
            <?php foreach ($cart_items as $item_key => $item):
              $product  = $item['data'];
              $qty      = $item['quantity'];
              $name     = $product->get_name();
              $price    = wc_price($product->get_price() * $qty);
              $img_id   = $product->get_image_id();
              $img_url  = $img_id ? wp_get_attachment_image_url($img_id, 'thumbnail') : '';
            ?>
            <div class="fd-cdrop-item">
              <?php if ($img_url): ?>
                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($name); ?>" class="fd-cdrop-img">
              <?php else: ?>
                <div class="fd-cdrop-img-ph">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20">
                    <rect x="3" y="3" width="18" height="18" rx="3"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                  </svg>
                </div>
              <?php endif; ?>
              <div class="fd-cdrop-info">
                <div class="fd-cdrop-name" title="<?php echo esc_attr($name); ?>"><?php echo esc_html($name); ?></div>
                <div class="fd-cdrop-meta">
                  <span class="fd-cdrop-qty">&times;<?php echo $qty; ?></span>
                  <span><?php echo esc_html(strip_tags(wc_price($product->get_price()))); ?> each</span>
                </div>
              </div>
              <div class="fd-cdrop-price"><?php echo $price; ?></div>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="fd-cdrop-empty">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" width="40" height="40">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
              </svg>
              Your cart is currently empty
            </div>
          <?php endif; ?>
        </div>

        <?php if (!empty($cart_items)): ?>
        <div class="fd-cdrop-foot">
          <div class="fd-cdrop-total-row">
            <span class="fd-cdrop-total-label">Order Total</span>
            <span class="fd-cdrop-total-amt" id="fdCdropTotal"><?php echo $cart_total; ?></span>
          </div>
          <div class="fd-cdrop-btns">
            <a href="<?php echo esc_url($cart_url); ?>" class="fd-cdrop-btn-view">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="13" height="13">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
              </svg>
              View Cart
            </a>
            <a href="<?php echo esc_url($checkout_url); ?>" class="fd-cdrop-btn-checkout">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="13" height="13">
                <path d="M5 12h14M12 5l7 7-7 7"/>
              </svg>
              Checkout
            </a>
          </div>
        </div>
        <?php endif; ?>

      </div><!-- /.fd-cart-dropdown -->
    </div><!-- /.hdr-cart-wrap -->

    <?php endif; ?>
  </div><!-- /.header-right -->
</div><!-- /.site-header -->

<!-- ==================== DESKTOP NAVBAR ==================== -->
<nav class="site-navbar" aria-label="Primary navigation">
  <div class="navbar-inner">
    <ul class="navbar-list">
      <?php
      $shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop');
      $nav_links = [
        [home_url('/'),                    'Home',                 is_front_page()],
        [$shop_url,                        'Shop',                 is_shop()],
        [home_url('/about-us'),            'About Us',             is_page('about-us')],
        [home_url('/submit-prescription'), 'Submit Prescription',  is_page('submit-prescription')],
        [home_url('/ultra-sound-service'), 'Ultra Sound Services', is_page('ultrasound-services') || is_page('ultra-sound-service')],
      ];
      foreach ($nav_links as [$href, $label, $active]) {
        echo '<li><a href="' . esc_url($href) . '"' . ($active ? ' class="active"' : '') . '>' . esc_html($label) . '</a></li>';
      }
      $is_refund_page  = is_page('refund');
      $is_contact_page = is_page('contact');
      ?>
      <li class="nav-spacer" aria-hidden="true"></li>
      <li class="nav-returns">
        <a href="<?php echo esc_url(home_url('/refund')); ?>"<?php echo $is_refund_page ? ' class="active"' : ''; ?>>Returns &amp; Policy</a>
      </li>
      <li class="nav-contact">
        <a href="<?php echo esc_url(home_url('/contact')); ?>"<?php echo $is_contact_page ? ' class="active"' : ''; ?>>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
          Contact Us
        </a>
      </li>
    </ul>
  </div>
</nav>

</div><!-- /.site-header-sticky-wrap -->

<script>
(function(){
  /* ── Mobile nav ── */
  var btn = document.getElementById('hamburgerBtn');
  var nav = document.getElementById('mobileNav');
  var ovl = document.getElementById('mobileNavOverlay');
  var cls = document.getElementById('mobileNavClose');
  function openNav(){ nav.classList.add('open'); ovl.classList.add('open'); btn.setAttribute('aria-expanded','true'); document.body.style.overflow='hidden'; }
  function closeNav(){ nav.classList.remove('open'); ovl.classList.remove('open'); btn.setAttribute('aria-expanded','false'); document.body.style.overflow=''; }
  if(btn) btn.addEventListener('click', openNav);
  if(cls) cls.addEventListener('click', closeNav);
  if(ovl) ovl.addEventListener('click', closeNav);

  /* ── Sticky shadow ── */
  var stickyWrap = document.getElementById('stickyHeaderWrap');
  if(stickyWrap){
    var onScroll = function(){ stickyWrap.classList.toggle('is-pinned', window.scrollY > 4); };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ── Cart dropdown — stay open while hovering wrap OR dropdown ── */
  var cartWrap = document.querySelector('.hdr-cart-wrap');
  var cartDrop = document.getElementById('fdCartDropdown');
  var hideTimer = null;

  function showDrop(){
    if(hideTimer){ clearTimeout(hideTimer); hideTimer = null; }
    if(cartDrop){
      cartDrop.style.opacity       = '1';
      cartDrop.style.visibility    = 'visible';
      cartDrop.style.transform     = 'translateY(0)';
      cartDrop.style.pointerEvents = 'all';
      cartDrop.style.transitionDelay = '0s';
    }
  }

  function hideDrop(){
    hideTimer = setTimeout(function(){
      if(cartDrop){
        cartDrop.style.opacity       = '0';
        cartDrop.style.visibility    = 'hidden';
        cartDrop.style.transform     = 'translateY(10px)';
        cartDrop.style.pointerEvents = 'none';
      }
    }, 300);
  }

  if(cartWrap && cartDrop){
    cartWrap.addEventListener('mouseenter', showDrop);
    cartWrap.addEventListener('mouseleave', function(){
      if(!cartDrop.matches(':hover')) hideDrop();
    });
    cartDrop.addEventListener('mouseenter', showDrop);
    cartDrop.addEventListener('mouseleave', function(){
      if(!cartWrap.matches(':hover')) hideDrop();
    });
  }

  /* ── Refresh cart dropdown count after add-to-cart ── */
  document.addEventListener('click', function(e){
    var addBtn = e.target.closest('.fp-add-btn, .add_to_cart_button, [data-product_id]');
    if(!addBtn) return;
    setTimeout(function(){
      var xhr = new XMLHttpRequest();
      xhr.open('POST','<?php echo esc_js(home_url("/?wc-ajax=get_refreshed_fragments")); ?>',true);
      xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
      xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
      xhr.onload = function(){
        if(xhr.status !== 200) return;
        try {
          var countSrcs = document.querySelectorAll('.badge-dot:not(.wish-badge)');
          var newCount = 0;
          countSrcs.forEach(function(el){ var n=parseInt(el.textContent); if(!isNaN(n)&&n>newCount) newCount=n; });
          var countEl = document.getElementById('fdCdropCount');
          if(countEl && newCount >= 0) countEl.textContent = newCount + ' item' + (newCount !== 1 ? 's' : '');
        } catch(e){}
      };
      xhr.send('time='+Date.now());
    }, 800);
  });
})();
</script>

<?php if (!is_front_page()): ?>
<div class="site-breadcrumb">
  <a href="<?php echo home_url('/'); ?>">Home</a>
  <?php if (is_shop()): ?>
    <span>&#8250;</span><span>Shop</span>
  <?php elseif (is_singular('product')): ?>
    <span>&#8250;</span>
    <?php if (function_exists('wc_get_page_id')): ?><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Shop</a><?php endif; ?>
    <span>&#8250;</span><span><?php the_title(); ?></span>
  <?php elseif (is_product_category()): ?>
    <span>&#8250;</span>
    <?php if (function_exists('wc_get_page_id')): ?><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Shop</a><?php endif; ?>
    <span>&#8250;</span><span><?php single_cat_title(); ?></span>
  <?php elseif (is_page()): ?>
    <span>&#8250;</span><span><?php the_title(); ?></span>
  <?php endif; ?>
</div>
<?php endif; ?>