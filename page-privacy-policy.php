<?php
/**
 * Template Name: Privacy Policy
 */
get_header();

$pp_wa    = '254796140021';
$pp_phone = '+254 796140021';
$pp_email = function_exists('medicare_email') ? medicare_email() : 'info@familydrugmartkenya.com';
$pp_addr  = 'High Point Plaza, along Ruaka-Banana Road';
?>

<style>
:root {
  --pp-blue:        #1d3f8f;
  --pp-blue-dark:   #15306e;
  --pp-blue-darker: #0e2358;
  --pp-blue-navy:   #0a1228;
  --pp-gold:        #f5a623;
  --pp-text:        #1b2230;
  --pp-text-light:  #6b7280;
  --pp-bg-soft:     #f7f8fa;
  --pp-font-head:   'Nunito', sans-serif;
  --pp-font-body:   'Lato', sans-serif;
}

.pp-wrap {
  max-width: 1100px;
  margin: 40px auto 60px;
  padding: 0 24px;
  box-sizing: border-box;
  font-family: var(--pp-font-body);
}

/* ── HERO ── */
.pp-hero {
  background: rgba(14,35,88,.92);
  border: 1px solid rgba(245,166,35,.25);
  border-top: 3px solid var(--pp-gold);
  border-radius: 20px;
  padding: 48px 40px;
  text-align: center;
  box-sizing: border-box;
}
.pp-tag {
  display: inline-block;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 1.4px;
  text-transform: uppercase;
  color: var(--pp-gold);
  background: rgba(245,166,35,.10);
  border: 1px solid rgba(245,166,35,.30);
  padding: 6px 16px;
  border-radius: 50px;
  margin-bottom: 16px;
}
.pp-title {
  font-family: var(--pp-font-head);
  font-size: clamp(22px, 4vw, 32px);
  font-weight: 900;
  color: #fff;
  margin: 0 0 10px;
  line-height: 1.25;
}
.pp-title span { color: var(--pp-gold); }
.pp-hero-desc {
  font-size: 13.5px;
  color: rgba(255,255,255,.70);
  line-height: 1.7;
  max-width: 560px;
  margin: 0 auto 6px;
}
.pp-updated {
  font-size: 11.5px;
  color: rgba(255,255,255,.45);
  font-style: italic;
}

/* ── SECTION ── */
.pp-sec {
  margin-top: 18px;
  background: var(--pp-bg-soft);
  border: 1.5px solid #edf0f5;
  border-radius: 14px;
  padding: 22px 26px;
}
.pp-sec-head {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}
.pp-sec-num {
  width: 26px; height: 26px;
  border-radius: 7px;
  background: var(--pp-blue);
  color: #fff;
  font-size: 12px;
  font-weight: 900;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.pp-sec-head h2 {
  font-family: var(--pp-font-head);
  font-size: 15.5px;
  font-weight: 900;
  color: var(--pp-text);
  margin: 0;
}
.pp-sec p {
  font-size: 13px;
  line-height: 1.8;
  color: var(--pp-text-light);
  margin: 0 0 10px;
}
.pp-sec p:last-child { margin-bottom: 0; }
.pp-sec p strong { color: var(--pp-text); }
.pp-sec a { color: var(--pp-blue); font-weight: 700; text-decoration: none; }
.pp-sec a:hover { color: var(--pp-gold); }

/* ── CONTACT BOX ── */
.pp-contact-box {
  background: var(--pp-blue-darker);
  border-radius: 16px;
  padding: 26px 28px;
  margin-top: 18px;
}
.pp-contact-row {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 13px;
  color: rgba(255,255,255,.75);
  margin-bottom: 10px;
}
.pp-contact-row:last-child { margin-bottom: 0; }
.pp-contact-row svg { color: var(--pp-gold); flex-shrink: 0; }
.pp-contact-row a { color: #fff; font-weight: 700; text-decoration: none; }
.pp-contact-row a:hover { color: var(--pp-gold); }

/* ── RESPONSIVE ── */
@media (max-width: 640px) {
  .pp-wrap { margin: 24px auto 40px; padding: 0 16px; }
  .pp-hero { padding: 32px 20px; border-radius: 16px; }
  .pp-hero-desc { font-size: 12.5px; }
  .pp-sec { padding: 18px 18px; }
  .pp-sec-head h2 { font-size: 14px; }
  .pp-contact-box { padding: 20px 18px; }
}
</style>

<div class="pp-wrap">

  <!-- HERO -->
  <div class="pp-hero">
    <h1 class="pp-title">Privacy <span>Policy</span></h1>
    <p class="pp-hero-desc">
      Your privacy and the confidentiality of your health information matter to us. This policy explains how we collect, use, and protect your data.
    </p>
    <div class="pp-updated">Last updated: <?php echo date('F Y'); ?></div>
  </div>

  <!-- 1. Information We Collect -->
  <div class="pp-sec">
    <div class="pp-sec-head"><span class="pp-sec-num">1</span><h2>Information We Collect</h2></div>
    <p>We collect your name, phone number, email, and delivery address when you place an order. For prescription orders, we collect prescription and medication details, handled with strict confidentiality. Payment is processed securely through M-Pesa or card providers , we never store full card details.</p>
  </div>

  <!-- 2. How We Use It -->
  <div class="pp-sec">
    <div class="pp-sec-head"><span class="pp-sec-num">2</span><h2>How We Use Your Information</h2></div>
    <p>We use your data to process and deliver your orders, verify prescriptions where required by law, send order and delivery updates, and comply with Pharmacy and Poisons Board of Kenya regulations.</p>
  </div>

  <!-- 3. Confidentiality -->
  <div class="pp-sec">
    <div class="pp-sec-head"><span class="pp-sec-num">3</span><h2>Prescription &amp; Medical Confidentiality</h2></div>
    <p>All health and prescription information is strictly confidential, accessible only to our licensed pharmacists on a need-to-know basis. We never sell or share your medical information for marketing purposes.</p>
  </div>

  <!-- 4. Sharing -->
  <div class="pp-sec">
    <div class="pp-sec-head"><span class="pp-sec-num">4</span><h2>Sharing Your Information</h2></div>
    <p>We share only what's necessary: your name and address with delivery riders to fulfil orders, payment details with secure payment processors, and prescription details with your doctor where required. We disclose information only if legally required to do so.</p>
  </div>

  <!-- 5. Security & Cookies -->
  <div class="pp-sec">
    <div class="pp-sec-head"><span class="pp-sec-num">5</span><h2>Data Security &amp; Cookies</h2></div>
    <p>We use SSL encryption and secure access controls to protect your data. Our website uses cookies to remember your cart and improve your experience , you can manage these through your browser settings.</p>
  </div>

  <!-- 6. Your Rights -->
  <div class="pp-sec">
    <div class="pp-sec-head"><span class="pp-sec-num">6</span><h2>Your Rights</h2></div>
    <p>Under the Kenya Data Protection Act, 2019, you can request access to, correction of, or deletion of your personal data, and withdraw consent for marketing at any time. Contact us using the details below to make a request.</p>
  </div>

  <!-- 7. Other -->
  <div class="pp-sec">
    <div class="pp-sec-head"><span class="pp-sec-num">7</span><h2>Children &amp; Policy Changes</h2></div>
    <p>Our services are not directed at children under 18 , a parent or guardian must place orders on a minor's behalf. We may update this policy from time to time; the latest version will always be shown on this page with the date above.</p>
  </div>

  <!-- CONTACT -->
  <div class="pp-contact-box">
    <div class="pp-contact-row">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
      <span><?php echo esc_html($pp_addr); ?></span>
    </div>
    <div class="pp-contact-row">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 3.07 9.81a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L6.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      <a href="tel:+254796140021"><?php echo esc_html($pp_phone); ?></a>
    </div>
    <div class="pp-contact-row">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
      <a href="https://wa.me/<?php echo esc_attr($pp_wa); ?>" target="_blank" rel="noopener">WhatsApp: <?php echo esc_html($pp_phone); ?></a>
    </div>
    <div class="pp-contact-row">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      <a href="mailto:<?php echo esc_attr($pp_email); ?>"><?php echo esc_html($pp_email); ?></a>
    </div>
  </div>

</div>

<?php get_footer(); ?>