<?php
/**
 * Family Drugmart — footer.php
 */
$wa    = '254796140021';
$phone = '+254 0796140021';
$email = function_exists('medicare_email') ? medicare_email() : 'info@familydrugmart.co.ke';
$addr  = 'High Point Plaza, along Ruaka-Banana Raini Road';
?>

<style>
:root {
  --blue:        #1d3f8f;
  --blue-dark:   #15306e;
  --blue-darker: #0e2358;
  --blue-navy:   #0a1228;
  --gold:        #f5a623;
  --font-head:   'Nunito', sans-serif;
  --font-body:   'Lato', sans-serif;
}

/* ============================================================
   CONTACT BAR
   ============================================================ */
.footer-contact-bar {
  background: #0e2358;
  border-top: 3px solid var(--gold);
  padding: 36px 48px;
  box-sizing: border-box;
  width: 100%;
}

.footer-contact-bar-inner {
  max-width: 1300px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 40px;
  flex-wrap: wrap;
}

.fc-block {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  flex: 1 1 200px;
}

.fc-icon {
  width: 46px;
  height: 46px;
  background: rgba(245,166,35,.10);
  border: 1.5px solid rgba(245,166,35,.30);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: var(--gold);
}

.fc-label {
  font-size: 10px;
  color: rgba(255,255,255,.40);
  font-weight: 700;
  letter-spacing: 1.4px;
  text-transform: uppercase;
  margin-bottom: 4px;
  font-family: var(--font-body);
}

.fc-value {
  font-size: 14px;
  font-weight: 700;
  color: #fff;
  font-family: var(--font-body);
  line-height: 1.3;
}
.fc-value.gold { color: var(--gold); }

.fc-sub {
  font-size: 12px;
  color: rgba(255,255,255,.45);
  font-family: var(--font-body);
  margin-top: 3px;
}

/* App download */
.fc-app {
  margin-left: auto;
  flex: 0 0 auto;
}
.fc-app .fc-label { margin-bottom: 10px; }

.app-btns {
  display: flex;
  gap: clamp(6px, 2vw, 10px);
  flex-wrap: nowrap;
}

.app-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: clamp(4px, 1.5vw, 7px);
  background: #15306e;
  border: 1.5px solid rgba(245,166,35,.35);
  color: white;
  font-size: clamp(10px, 3vw, 12.5px);
  font-weight: 700;
  padding: clamp(6px, 2vw, 10px) clamp(10px, 3.5vw, 20px);
  border-radius: 8px;
  font-family: var(--font-body);
  text-decoration: none;
  transition: background .2s, border-color .2s, transform .15s;
  white-space: nowrap;
}
.app-btn svg { flex-shrink: 0; color: var(--gold); width: clamp(10px, 2.8vw, 14px); height: auto; }
.app-btn:hover {
  background: var(--gold);
  border-color: var(--gold);
  color: #0a1228;
  transform: translateY(-2px);
}
.app-btn:hover svg { color: #0a1228; }

/* ============================================================
   MAIN FOOTER
   ============================================================ */
.site-footer-main {
  background: #0a1228;
  border-top: 1px solid rgba(255,255,255,.06);
  padding: 52px 48px 0;
}

.footer-inner {
  max-width: 1300px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1.3fr;
  gap: 44px;
  padding-bottom: 44px;
  border-bottom: 1px solid rgba(255,255,255,.07);
}

/* Brand col */
.footer-logo-link {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
  text-decoration: none;
}

.footer-logo-img-wrap {
  width: 52px;
  height: 52px;
  background: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  overflow: hidden;
  box-shadow: 0 3px 12px rgba(0,0,0,.35);
  transition: transform .25s, box-shadow .25s;
}
.footer-logo-link:hover .footer-logo-img-wrap {
  transform: scale(1.06);
  box-shadow: 0 6px 20px rgba(245,166,35,.35);
}
.footer-logo-img { width: 100%; height: 100%; object-fit: contain; display: block; }

.footer-logo-name {
  font-family: var(--font-head);
  font-size: 20px;
  font-weight: 900;
  color: #fff;
  display: block;
  line-height: 1.15;
}
.footer-logo-sub {
  font-size: 10px;
  color: rgba(255,255,255,.40);
  text-transform: uppercase;
  letter-spacing: .8px;
  font-family: var(--font-body);
}

.footer-brand-col > p {
  font-size: 13.5px;
  color: rgba(255,255,255,.52);
  line-height: 1.8;
  margin-bottom: 22px;
  max-width: 260px;
  font-family: var(--font-body);
}

.footer-socials { display: flex; gap: 9px; }

.fsoc {
  width: 36px; height: 36px;
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  text-decoration: none;
  border: 1px solid rgba(255,255,255,.10);
  transition: transform .2s, box-shadow .2s, opacity .2s;
}
.fsoc:hover { opacity: .88; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,.3); }
.fsoc-fb { background: #1877f2; }
.fsoc-tw { background: #15202b; }
.fsoc-ig { background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); }
.fsoc-wa { background: #25d366; }

/* Footer columns */
.footer-col h4 {
  font-family: var(--font-head);
  font-size: 15px;
  font-weight: 900;
  color: #fff;
  margin-bottom: 18px;
  padding-bottom: 11px;
  border-bottom: 1px solid rgba(255,255,255,.08);
  position: relative;
}
.footer-col h4::after {
  content: '';
  position: absolute;
  left: 0; bottom: -1px;
  width: 32px; height: 2px;
  background: var(--gold);
  border-radius: 2px;
}
.footer-col a {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: rgba(255,255,255,.50);
  margin-bottom: 11px;
  text-decoration: none;
  font-family: var(--font-body);
  transition: color .2s, padding-left .2s;
}
.footer-col a:hover { color: var(--gold); padding-left: 4px; }

/* Contact col items */
.contact-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  margin-bottom: 13px;
  font-family: var(--font-body);
  font-size: 13px;
  color: rgba(255,255,255,.50);
  text-decoration: none;
  transition: color .2s;
  line-height: 1.5;
  padding-left: 0 !important;
}
.contact-item:hover { color: var(--gold); }

.contact-item-icon {
  width: 28px; height: 28px;
  border-radius: 7px;
  background: rgba(245,166,35,.10);
  border: 1px solid rgba(245,166,35,.20);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  margin-top: 1px;
  color: var(--gold);
}

/* ============================================================
   PAYMENT BAR
   ============================================================ */
.payment-bar {
  max-width: 1300px;
  margin: 0 auto;
  padding: 22px 0;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  flex-wrap: wrap;
  border-bottom: 1px solid rgba(255,255,255,.06);
  box-sizing: border-box;
}

.payment-bar-label {
  font-size: 11px;
  font-weight: 700;
  color: rgba(255,255,255,.35);
  font-family: var(--font-body);
  text-transform: uppercase;
  letter-spacing: 1px;
  white-space: nowrap;
  flex-shrink: 0;
}

.pay-pill {
  display: inline-flex;
  align-items: center;
  gap: clamp(4px, 1.5vw, 7px);
  border: 1.5px solid rgba(255,255,255,.12);
  border-radius: 8px;
  padding: clamp(5px, 1.8vw, 7px) clamp(8px, 3vw, 16px);
  font-size: clamp(10px, 3vw, 12px);
  font-weight: 700;
  color: rgba(255,255,255,.65);
  font-family: var(--font-body);
  background: rgba(255,255,255,.05);
  transition: border-color .2s, background .2s, color .2s, transform .15s;
  white-space: nowrap;
}
.pay-pill:hover {
  border-color: rgba(245,166,35,.45);
  background: rgba(245,166,35,.08);
  color: var(--gold);
  transform: translateY(-1px);
}
.pay-pill svg {
  flex-shrink: 0;
  display: block;
  width: clamp(20px, 6vw, 32px);
  height: auto;
}

/* ============================================================
   BOTTOM BAR
   ============================================================ */
.footer-bottom-bar {
  background: #0a1228;
  border-top: 1px solid rgba(255,255,255,.07);
  padding: 18px 48px;
}

.footer-bottom-inner {
  max-width: 1300px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
}

.footer-copy {
  font-size: 12.5px;
  color: rgba(255,255,255,.32);
  font-family: var(--font-body);
}

.footer-bottom-links {
  display: flex;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}

.footer-bottom-links a {
  font-size: 12.5px;
  color: rgba(255,255,255,.45);
  font-family: var(--font-body);
  text-decoration: none;
  transition: color .2s;
  white-space: nowrap;
}
.footer-bottom-links a:hover { color: var(--gold); }

/* ============================================================
   FLOATING ACTION BUTTON
   ============================================================ */
.fab-container {
  position: fixed;
  bottom: 32px;
  right: 28px;
  z-index: 9999;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 12px;
}

@keyframes fab-pulse {
  0%   { box-shadow: 0 0 0 0    rgba(245,166,35,.70), 0 6px 24px rgba(14,35,88,.60); }
  70%  { box-shadow: 0 0 0 16px rgba(245,166,35, 0),  0 6px 24px rgba(14,35,88,.60); }
  100% { box-shadow: 0 0 0 0    rgba(245,166,35, 0),  0 6px 24px rgba(14,35,88,.60); }
}

.fab-main {
  width: 58px; height: 58px;
  border-radius: 50%;
  background: #1d3f8f;
  border: 2px solid var(--gold);
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  outline: none;
  animation: fab-pulse 2.2s ease-out infinite;
  transition: transform .2s, background .2s;
  position: relative;
  z-index: 2;
}
.fab-main:hover { transform: scale(1.08); background: #15306e; }

.fab-actions {
  display: none;
  flex-direction: column;
  align-items: flex-end;
  gap: 10px;
  opacity: 0;
  transform: translateY(14px) scale(.94);
  pointer-events: none;
  transition: opacity .25s, transform .25s;
}
.fab-actions.open {
  display: flex;
  opacity: 1;
  transform: translateY(0) scale(1);
  pointer-events: all;
}

.fab-action-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: #0e2358;
  border: 1px solid rgba(245,166,35,.25);
  color: rgba(255,255,255,.85);
  font-family: var(--font-body);
  font-size: 13px;
  font-weight: 700;
  padding: 10px 18px 10px 12px;
  border-radius: 50px;
  box-shadow: 0 4px 20px rgba(0,0,0,.35);
  text-decoration: none;
  transition: background .18s, color .18s, border-color .18s, transform .15s;
  white-space: nowrap;
}
.fab-action-btn:hover {
  background: #1d3f8f;
  color: var(--gold);
  border-color: var(--gold);
  transform: translateX(-3px);
}

.fab-icon {
  width: 32px; height: 32px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.fab-wa   { background: #25d366; }
.fab-call { background: #1d3f8f; border: 1.5px solid rgba(245,166,35,.4); }
.fab-sms  { background: #0e2358; border: 1.5px solid rgba(245,166,35,.4); }

/* ============================================================
   RESPONSIVE — TABLET
   ============================================================ */
@media (max-width: 1024px) {
  .footer-inner { grid-template-columns: 1.6fr 1fr 1fr; }
  .footer-contact-col { display: none; }
}

@media (max-width: 860px) {
  .footer-inner { grid-template-columns: 1fr 1fr; }
  .footer-contact-col { display: none; }
}

/* ============================================================
   RESPONSIVE — MOBILE (≤ 640px)
   ============================================================ */
@media (max-width: 640px) {

  /* ── Contact bar ── */
  .footer-contact-bar {
    padding: 28px 20px;
  }
  .footer-contact-bar-inner {
    flex-direction: column;
    gap: 0;
  }

  .fc-block {
    flex: 1 1 100%;
    width: 100%;
    padding: 16px 0;
    border-bottom: 1px solid rgba(255,255,255,.07);
    gap: 14px;
    align-items: center;
  }
  .fc-block:last-child { border-bottom: none; padding-bottom: 0; }
  .fc-block:first-child { padding-top: 0; }

  .fc-icon { width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0; }
  .fc-label { font-size: 9px; letter-spacing: 1.2px; margin-bottom: 2px; }
  .fc-value { font-size: 13.5px; }
  .fc-sub   { font-size: 11.5px; }

  .fc-app {
    margin-left: 0;
    width: 100%;
    padding: 18px 0 0;
    border-bottom: none !important;
  }
  .fc-app .fc-label {
    font-size: 9px;
    letter-spacing: 1.2px;
    margin-bottom: 10px;
    text-align: center;
    width: 100%;
    display: block;
  }
  .app-btns {
    display: flex;
    flex-direction: row;
    width: 100%;
  }
  .app-btn {
    flex: 1 1 0;
    min-width: 0;
    justify-content: center;
  }

  /* ── Main footer ── */
  .site-footer-main {
    padding: 36px 20px 0;
  }
  .footer-inner {
    grid-template-columns: 1fr;
    gap: 0;
    padding-bottom: 32px;
  }

  .footer-col { display: none; }
  .footer-brand-col { display: block; }

  .footer-logo-link { margin-bottom: 14px; }
  .footer-logo-img-wrap { width: 46px; height: 46px; }
  .footer-logo-name { font-size: 17px; }
  .footer-logo-sub  { font-size: 9px; }

  .footer-brand-col > p {
    font-size: 13px;
    max-width: 100%;
    margin-bottom: 18px;
    line-height: 1.7;
  }

  .footer-socials { gap: 8px; }
  .fsoc { width: 34px; height: 34px; border-radius: 8px; }

  /* ── Payment bar ── */
  .payment-bar {
    padding: 20px 20px;
    gap: 8px;
    justify-content: center;
  }
  .payment-bar-label {
    width: 100%;
    text-align: center;
    margin-bottom: 6px;
    font-size: 10px;
  }

  .pay-pill {
    flex: 1 1 calc(50% - 6px);
    max-width: calc(50% - 6px);
    justify-content: center;
    box-sizing: border-box;
  }

  /* ── Bottom bar ── */
  .footer-bottom-bar { padding: 16px 20px; }
  .footer-bottom-inner {
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 8px;
  }
  .footer-copy { font-size: 12px; }
  .footer-bottom-links { justify-content: center; gap: 16px; }
  .footer-bottom-links a { font-size: 12px; }

  /* ── FAB ── */
  .fab-container { bottom: 20px; right: 16px; gap: 10px; }
  .fab-main { width: 52px; height: 52px; }
  .fab-action-btn { font-size: 12.5px; padding: 9px 16px 9px 10px; }
  .fab-icon { width: 28px; height: 28px; }
}

@media (max-width: 380px) {
  .pay-pill {
    flex: 1 1 calc(50% - 5px);
    max-width: calc(50% - 5px);
  }
  .footer-contact-bar { padding: 24px 16px; }
  .site-footer-main   { padding: 28px 16px 0; }
  .footer-bottom-bar  { padding: 14px 16px; }
  .payment-bar        { padding: 18px 16px; }
}
</style>

<!-- ==================== CONTACT BAR ==================== -->
<div class="footer-contact-bar">
  <div class="footer-contact-bar-inner">

    <div class="fc-block">
      <div class="fc-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
      </div>
      <div>
        <div class="fc-label">Our Address</div>
        <div class="fc-value"><?php echo esc_html($addr); ?></div>
      </div>
    </div>

    <div class="fc-block">
      <div class="fc-icon">
        <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" color="#f5a623"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
      </div>
      <div>
        <div class="fc-label">WhatsApp Us</div>
        <div class="fc-value gold"><?php echo esc_html($phone); ?></div>
        <div class="fc-sub"><?php echo esc_html($email); ?></div>
      </div>
    </div>

    <div class="fc-block">
      <div class="fc-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 3.07 9.81a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L6.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      </div>
      <div>
        <div class="fc-label">Call Directly</div>
        <div class="fc-value"><?php echo esc_html($phone); ?></div>
        <div class="fc-sub">Mon–Fri 8.30am–6pm | Sat 9:00am–1pm</div>
      </div>
    </div>

    <div class="fc-block fc-app">
      <div class="fc-label">Download Our App</div>
      <div class="app-btns">
        <a href="#" class="app-btn">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3.18 23.76a2 2 0 0 0 2.28-.22l.08-.07 9.58-5.53-2.76-2.76-9.18 8.58zM.46 1.26A2 2 0 0 0 0 2.54v18.92a2 2 0 0 0 .46 1.28l.07.07 10.6-10.6v-.25L.53 1.19l-.07.07zM20.06 10.46l-2.84-1.64-3.07 3.07 3.07 3.07 2.87-1.66a2 2 0 0 0 0-2.84zM5.46.46l.08.07 9.18 8.58-2.76 2.76L2.38.35A2 2 0 0 1 5.46.46z"/></svg>
          Google Play
        </a>
        <a href="#" class="app-btn">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98l-.09.06c-.22.15-2.18 1.27-2.16 3.8.03 3.02 2.65 4.03 2.68 4.04l-.07.28zM13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
          App Store
        </a>
      </div>
    </div>

  </div>
</div>

<!-- ==================== MAIN FOOTER ==================== -->
<footer class="site-footer-main">

  <div class="footer-inner">

    <!-- Brand -->
    <div class="footer-brand-col">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo-link">
        <div class="footer-logo-img-wrap">
          <img
            src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/images/drugmart_logo.png'); ?>"
            alt="Family Drugmart Kenya"
            class="footer-logo-img"
            width="52" height="52"
            loading="lazy" decoding="async"
          />
        </div>
        <div>
          <span class="footer-logo-name">Family Drugmart Kenya</span>
          <span class="footer-logo-sub">Online Pharmacy · Kenya</span>
        </div>
      </a>
      <p>Kenya's trusted online pharmacy. Quality medicines, supplements and healthcare products delivered with care across Nairobi and beyond.</p>
      <div class="footer-socials">
        <a href="<?php echo esc_url(get_option('medicare_facebook','#')); ?>" class="fsoc fsoc-fb" target="_blank" rel="noopener" aria-label="Facebook">
          <svg viewBox="0 0 24 24" fill="white" width="14" height="14"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
        </a>
        <a href="<?php echo esc_url(get_option('medicare_twitter','#')); ?>" class="fsoc fsoc-tw" target="_blank" rel="noopener" aria-label="X">
          <svg viewBox="0 0 24 24" fill="white" width="14" height="14"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <a href="<?php echo esc_url(get_option('medicare_instagram','#')); ?>" class="fsoc fsoc-ig" target="_blank" rel="noopener" aria-label="Instagram">
          <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" width="14" height="14"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </a>
        <a href="https://wa.me/<?php echo esc_attr($wa); ?>" class="fsoc fsoc-wa" target="_blank" rel="noopener" aria-label="WhatsApp">
          <svg viewBox="0 0 24 24" fill="white" width="14" height="14"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
        </a>
      </div>
    </div>

    <!-- Quick Links -->
    <div class="footer-col">
      <h4>Quick Links</h4>
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      <a href="<?php echo esc_url(function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop')); ?>">Shop</a>
      <a href="<?php echo esc_url(home_url('/about-us')); ?>">About Us</a>
      <a href="<?php echo esc_url(home_url('/submit-prescription')); ?>">Submit Prescription</a>
      <a href="<?php echo esc_url(home_url('/ultrasound-services')); ?>">Ultrasound Services</a>
      <a href="<?php echo esc_url(home_url('/blog')); ?>">Blog</a>
      <a href="<?php echo esc_url(home_url('/contact')); ?>">Contact Us</a>
    </div>

    <!-- Categories -->
    <div class="footer-col">
      <h4>Categories</h4>
      <?php
      $cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0,'number'=>6]);
      if (!empty($cats) && !is_wp_error($cats)) {
        foreach ($cats as $c) echo '<a href="' . esc_url(get_term_link($c)) . '">' . esc_html($c->name) . '</a>';
      } else {
        $su = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop');
        foreach (['Prescription Meds','Supplements','Baby Care','Skincare','Equipment','Dental Care'] as $n)
          echo '<a href="' . esc_url($su) . '">' . esc_html($n) . '</a>';
      }
      ?>
    </div>

    <!-- Contact -->
    <div class="footer-col footer-contact-col">
      <h4>Contact Us</h4>
      <a href="https://wa.me/<?php echo esc_attr($wa); ?>?text=<?php echo urlencode('Hello Family Drugmart Kenya! I would like to place an order.'); ?>" class="contact-item" target="_blank" rel="noopener">
        <span class="contact-item-icon"><svg viewBox="0 0 24 24" fill="#25d366" width="14" height="14"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg></span>
        WhatsApp Us
      </a>
      <a href="tel:+254796140021" class="contact-item">
        <span class="contact-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 3.07 9.81a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L6.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span>
        <?php echo esc_html($phone); ?>
      </a>
      <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-item">
        <span class="contact-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
        <?php echo esc_html($email); ?>
      </a>
      <a href="#" class="contact-item">
        <span class="contact-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
        <?php echo esc_html($addr); ?>
      </a>
      <a href="<?php echo esc_url(home_url('/refund')); ?>" class="contact-item">
        <span class="contact-item-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4"/></svg></span>
        Return &amp; Refund Policy
      </a>
    </div>

  </div>

  <!-- Payment Partners -->
  <div class="payment-bar">
    <span class="payment-bar-label">Payment Partners:</span>
    <span class="pay-pill">
      <svg viewBox="0 0 32 14" fill="none"><rect width="32" height="14" rx="3" fill="#00a651"/><text x="50%" y="10.5" font-size="6" font-weight="900" fill="white" text-anchor="middle" font-family="Lato,sans-serif" letter-spacing=".5">M-PESA</text></svg>
      M-Pesa
    </span>
    <span class="pay-pill">
      <svg viewBox="0 0 38 24"><circle cx="15" cy="12" r="9" fill="#eb001b" opacity=".9"/><circle cx="23" cy="12" r="9" fill="#f79e1b" opacity=".9"/></svg>
      Mastercard
    </span>
    <span class="pay-pill">
      <svg viewBox="0 0 52 20"><rect width="52" height="20" rx="3" fill="rgba(255,255,255,.08)"/><text x="50%" y="14" font-size="13" font-weight="900" fill="rgba(255,255,255,.80)" text-anchor="middle" font-family="serif" letter-spacing="1">VISA</text></svg>
      VISA
    </span>
    <span class="pay-pill">
      <svg viewBox="0 0 44 18" fill="none"><rect width="44" height="18" rx="3" fill="rgba(255,60,60,.15)"/><text x="50%" y="13" font-size="8" font-weight="900" fill="rgba(255,80,80,.90)" text-anchor="middle" font-family="Lato,sans-serif" letter-spacing=".5">AIRTEL</text></svg>
      Airtel Money
    </span>
  </div>

</footer>

<!-- ==================== BOTTOM BAR ==================== -->
<div class="footer-bottom-bar">
  <div class="footer-bottom-inner">
    <p class="footer-copy">&copy; <?php echo date('Y'); ?> Family Drugmart Kenya. All rights reserved.</p>
    <div class="footer-bottom-links">
      <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>
      <a href="<?php echo esc_url(home_url('/terms')); ?>">Terms &amp; Conditions</a>
    </div>
  </div>
</div>

<!-- ==================== FAB ==================== -->
<div class="fab-container" id="fabContainer">

  <div class="fab-actions" id="fabActions">

    <a href="https://wa.me/<?php echo esc_attr($wa); ?>?text=<?php echo urlencode('Hello Family Drugmart Kenya! I would like to place an order.'); ?>"
       class="fab-action-btn" target="_blank" rel="noopener">
      <span class="fab-icon fab-wa">
        <svg viewBox="0 0 24 24" fill="white" width="15" height="15"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
      </span>
      WhatsApp Us
    </a>

    <a href="tel:+254796140021" class="fab-action-btn">
      <span class="fab-icon fab-call">
        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" width="15" height="15"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 3.07 9.81a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L6.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      </span>
      Call Us
    </a>

    <a href="sms:+254796140021" class="fab-action-btn">
      <span class="fab-icon fab-sms">
        <svg viewBox="0 0 24 24" width="20" height="20">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" fill="none" stroke="white" stroke-width="1.6"/>
          <text x="12" y="11.8" text-anchor="middle" font-family="'Nunito', sans-serif" font-size="6.3" font-weight="900" fill="white" letter-spacing=".3">SMS</text>
        </svg>
      </span>
      SMS Us
    </a>

  </div>

  <button class="fab-main" id="fabMain" aria-label="Contact us" aria-expanded="false">
    <span id="fabIconChat" style="display:flex;align-items:center;justify-content:center;">
      <svg viewBox="0 0 24 24" width="26" height="26">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" fill="none" stroke="white" stroke-width="1.6"/>
        <text x="12" y="11.8" text-anchor="middle" font-family="'Nunito', sans-serif" font-size="6.3" font-weight="900" fill="white" letter-spacing=".3">SMS</text>
      </svg>
    </span>
    <svg id="fabIconClose" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" width="24" height="24" style="display:none;">
      <line x1="18" y1="6" x2="6" y2="18"/>
      <line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
  </button>

</div>

<script>
(function(){
  var btn      = document.getElementById('fabMain');
  var actions  = document.getElementById('fabActions');
  var iconChat = document.getElementById('fabIconChat');
  var iconX    = document.getElementById('fabIconClose');
  var open     = false;
  if (!btn) return;
  btn.addEventListener('click', function(){
    open = !open;
    actions.classList.toggle('open', open);
    btn.setAttribute('aria-expanded', open);
    iconChat.style.display = open ? 'none' : 'flex';
    iconX.style.display    = open ? 'block' : 'none';
    btn.style.animation    = open ? 'none' : 'fab-pulse 2.2s ease-out infinite';
  });
  document.addEventListener('click', function(e){
    if (open && !document.getElementById('fabContainer').contains(e.target)){
      open = false;
      actions.classList.remove('open');
      btn.setAttribute('aria-expanded','false');
      iconChat.style.display = 'flex';
      iconX.style.display    = 'none';
      btn.style.animation    = 'fab-pulse 2.2s ease-out infinite';
    }
  });
})();
</script>

<?php wp_footer(); ?>
</body>
</html>