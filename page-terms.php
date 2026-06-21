<?php
/**
 * Template Name: Terms & Conditions
 */
get_header();

$tc_wa    = '254796140021';
$tc_phone = '+254 796140021';
$tc_email = function_exists('medicare_email') ? medicare_email() : 'info@familydrugmartkenya.com';
$tc_addr  = 'High Point Plaza, along Ruaka-Banana Road';
?>

<style>
:root {
  --tc-blue:        #1d3f8f;
  --tc-blue-dark:   #15306e;
  --tc-blue-darker: #0e2358;
  --tc-blue-navy:   #0a1228;
  --tc-gold:        #f5a623;
  --tc-text:        #1b2230;
  --tc-text-light:  #6b7280;
  --tc-font-head:   'Nunito', sans-serif;
  --tc-font-body:   'Lato', sans-serif;
}

.tc-wrap {
  max-width: 1100px;
  margin: 40px auto 60px;
  padding: 0 24px;
  box-sizing: border-box;
  font-family: var(--tc-font-body);
}

/* ── HERO ── */
.tc-hero {
  background: rgba(14,35,88,.92);
  border: 1px solid rgba(245,166,35,.25);
  border-top: 3px solid var(--tc-gold);
  border-radius: 20px;
  padding: 48px 40px;
  text-align: center;
  box-sizing: border-box;
}
.tc-tag {
  display: inline-block;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 1.4px;
  text-transform: uppercase;
  color: var(--tc-gold);
  background: rgba(245,166,35,.10);
  border: 1px solid rgba(245,166,35,.30);
  padding: 6px 16px;
  border-radius: 50px;
  margin-bottom: 16px;
}
.tc-title {
  font-family: var(--tc-font-head);
  font-size: clamp(22px, 4vw, 32px);
  font-weight: 900;
  color: #fff;
  margin: 0 0 10px;
  line-height: 1.25;
}
.tc-title span { color: var(--tc-gold); }
.tc-hero-desc {
  font-size: 13.5px;
  color: rgba(255,255,255,.70);
  line-height: 1.7;
  max-width: 560px;
  margin: 0 auto 6px;
}
.tc-updated {
  font-size: 11.5px;
  color: rgba(255,255,255,.45);
  font-style: italic;
}

/* ── SECTION ── */
.tc-sec { margin-top: 36px; }
.tc-sec-head {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 12px;
}
.tc-sec-num {
  width: 26px; height: 26px;
  border-radius: 7px;
  background: var(--tc-blue);
  color: #fff;
  font-size: 12px;
  font-weight: 900;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.tc-sec-head h2 {
  font-family: var(--tc-font-head);
  font-size: 16.5px;
  font-weight: 900;
  color: var(--tc-text);
  margin: 0;
}
.tc-sec p {
  font-size: 13px;
  line-height: 1.8;
  color: var(--tc-text-light);
  margin: 0 0 10px;
}
.tc-sec p strong { color: var(--tc-text); }
.tc-sec a { color: var(--tc-blue); font-weight: 700; text-decoration: none; }
.tc-sec a:hover { color: var(--tc-gold); }

.tc-list { margin: 8px 0 4px; padding: 0; list-style: none; }
.tc-list li {
  font-size: 12.5px;
  line-height: 1.7;
  color: var(--tc-text-light);
  padding-left: 16px;
  position: relative;
  margin-bottom: 6px;
}
.tc-list li::before {
  content: '';
  position: absolute;
  left: 0; top: 7px;
  width: 5px; height: 5px;
  border-radius: 50%;
  background: var(--tc-gold);
}
.tc-list li strong { color: var(--tc-text); }

/* ── NOTE / WARNING STRIP ── */
.tc-note {
  display: flex;
  gap: 10px;
  background: #f6f8fc;
  border-left: 3px solid var(--tc-blue);
  border-radius: 0 10px 10px 0;
  padding: 14px 18px;
  font-size: 12.5px;
  color: var(--tc-text-light);
  line-height: 1.7;
  margin: 10px 0;
}
.tc-note.warn { border-left-color: #e0581f; background: #fff6f0; }
.tc-note strong { color: var(--tc-text); }
.tc-note svg { flex-shrink: 0; margin-top: 2px; }

/* ── ZONE CARDS (payment) ── */
.tc-zone-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
  margin: 12px 0;
}
.tc-zone-card {
  border-radius: 14px;
  padding: 18px 20px;
  border: 1.5px solid #edf0f5;
  background: #fff;
}
.tc-zone-badge {
  display: inline-block;
  font-size: 10.5px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .5px;
  padding: 4px 10px;
  border-radius: 50px;
  margin-bottom: 10px;
}
.tc-zone-card.nairobi .tc-zone-badge { background: rgba(29,63,143,.10); color: var(--tc-blue); }
.tc-zone-card.county  .tc-zone-badge { background: rgba(245,166,35,.12); color: #c47d00; }
.tc-zone-title { font-family: var(--tc-font-head); font-size: 14px; font-weight: 900; color: var(--tc-text); margin-bottom: 4px; }
.tc-zone-sub { font-size: 12px; color: var(--tc-text-light); line-height: 1.6; }

/* ── PAYMENT METHOD PILLS ── */
.tc-methods { display: flex; flex-wrap: wrap; gap: 8px; margin: 10px 0 4px; }
.tc-method-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #f6f8fc;
  border: 1.5px solid #e9edf5;
  border-radius: 50px;
  padding: 6px 14px;
  font-size: 12px;
  font-weight: 700;
  color: var(--tc-text);
}

/* ── CONTACT BOX ── */
.tc-contact-box {
  background: var(--tc-blue-darker);
  border-radius: 16px;
  padding: 26px 28px;
  margin-top: 6px;
}
.tc-contact-row {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 13px;
  color: rgba(255,255,255,.75);
  margin-bottom: 10px;
}
.tc-contact-row:last-child { margin-bottom: 0; }
.tc-contact-row svg { color: var(--tc-gold); flex-shrink: 0; }
.tc-contact-row a { color: #fff; font-weight: 700; text-decoration: none; }
.tc-contact-row a:hover { color: var(--tc-gold); }

/* ── RESPONSIVE ── */
@media (max-width: 720px) {
  .tc-zone-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
  .tc-wrap { margin: 24px auto 40px; padding: 0 16px; }
  .tc-hero { padding: 32px 20px; border-radius: 16px; }
  .tc-hero-desc { font-size: 12.5px; }
  .tc-sec-head h2 { font-size: 14.5px; }
  .tc-contact-box { padding: 20px 18px; }
}
</style>

<div class="tc-wrap">

  <!-- HERO -->
  <div class="tc-hero">
  
    <h1 class="tc-title">Terms <span>&amp; Conditions</span></h1>
    <p class="tc-hero-desc">
      By using this website or ordering from Family Drugmart Kenya, you agree to the terms below. Please read them carefully.
    </p>
    <div class="tc-updated">Last updated: <?php echo date('F Y'); ?></div>
  </div>

  <!-- 1. About Us -->
  <div class="tc-sec">
    <div class="tc-sec-head"><span class="tc-sec-num">1</span><h2>About Family Drugmart Kenya</h2></div>
    <p>We are a licensed pharmacy operating under the Pharmacy and Poisons Board of Kenya, offering prescription and over-the-counter medicines, healthcare products, and ultrasound scanning services, with delivery available across Kenya. By using our services you confirm you are at least 18 years old, or acting under a parent or guardian's supervision.</p>
  </div>

  <!-- 2. Orders & Prescriptions -->
  <div class="tc-sec">
    <div class="tc-sec-head"><span class="tc-sec-num">2</span><h2>Orders &amp; Prescriptions</h2></div>
    <p>Prescription medicines require a valid prescription from a licensed Kenyan healthcare provider. By ordering, you confirm the prescription is genuine, issued to you, and not already dispensed elsewhere.</p>
    <div class="tc-note warn">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e0581f" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      <span>Submitting a forged or altered prescription is a criminal offence under Kenyan law and will be reported to the relevant authorities.</span>
    </div>
  </div>

  <!-- 3. Payment -->
  <div class="tc-sec">
    <div class="tc-sec-head"><span class="tc-sec-num">3</span><h2>Payment Terms</h2></div>
    <p>Payment terms depend on your delivery location:</p>
    <div class="tc-zone-grid">
      <div class="tc-zone-card nairobi">
        <span class="tc-zone-badge">Nairobi &amp; environs</span>
        <div class="tc-zone-title">Pay on Delivery</div>
        <div class="tc-zone-sub">Pay our rider in cash or via M-Pesa when your order arrives.</div>
      </div>
      <div class="tc-zone-card county">
        <span class="tc-zone-badge">Other counties</span>
        <div class="tc-zone-title">Full Payment Upfront</div>
        <div class="tc-zone-sub">Orders are dispatched only after full payment is confirmed.</div>
      </div>
    </div>
    <div class="tc-methods">
      <span class="tc-method-pill">M-Pesa</span>
      <span class="tc-method-pill">Bank Transfer</span>
      <span class="tc-method-pill">Cash</span>
      <span class="tc-method-pill">Visa</span>
    </div>
  </div>

  <!-- 4. Delivery -->
  <div class="tc-sec">
    <div class="tc-sec-head"><span class="tc-sec-num">4</span><h2>Delivery</h2></div>
    <p><strong>Nairobi:</strong> same-day or next-day delivery for orders confirmed before 3:00 PM. <strong>Other counties:</strong> typically 1–2 business days after dispatch. Delivery times are estimates and may vary due to courier availability or circumstances beyond our control.</p>
    <p>Please see our full <a href="<?php echo esc_url(home_url('/refund')); ?>">Delivery, Payment &amp; Returns Policy</a> for rider waiting times and rescheduling.</p>
  </div>

  <!-- 5. Cancellations & Refunds -->
  <div class="tc-sec">
    <div class="tc-sec-head"><span class="tc-sec-num">5</span><h2>Cancellations &amp; Refunds</h2></div>
    <p>You may cancel an order any time before dispatch for a full refund. Once dispatched, orders cannot be cancelled, though you may refuse delivery.</p>
    <ul class="tc-list">
      <li><strong>Full refund:</strong> wrong, damaged, or expired item, or non-delivery.</li>
      <li><strong>Partial refund:</strong> missing items from an order.</li>
      <li><strong>No refund:</strong> dispensed prescriptions, opened products, or orders cancelled after dispatch.</li>
    </ul>
    <p>Refund requests must be made within 48 hours of delivery, see our <a href="<?php echo esc_url(home_url('/refund')); ?>">Returns Policy</a> for full details.</p>
  </div>

  <!-- 6. Pricing -->
  <div class="tc-sec">
    <div class="tc-sec-head"><span class="tc-sec-num">6</span><h2>Pricing &amp; Availability</h2></div>
    <p>Prices are listed in Kenyan Shillings and may change without notice. If a product is unavailable after ordering, we'll offer a suitable alternative or a full refund.</p>
  </div>

  <!-- 7. Liability -->
  <div class="tc-sec">
    <div class="tc-sec-head"><span class="tc-sec-num">7</span><h2>Limitation of Liability</h2></div>
    <p>We are not liable for indirect or consequential damages arising from use of our website or services. Health information on this site is general guidance only and not a substitute for professional medical advice, always consult a qualified healthcare provider.</p>
  </div>

  <!-- 8. Privacy & Governing Law -->
  <div class="tc-sec">
    <div class="tc-sec-head"><span class="tc-sec-num">8</span><h2>Privacy &amp; Governing Law</h2></div>
    <p>Your use of our services is also governed by our <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>. These Terms are governed by the laws of Kenya, including regulations of the Pharmacy and Poisons Board and the Data Protection Act, 2019. We may update these Terms from time to time; continued use of our site means you accept the changes.</p>
  </div>

  <!-- CONTACT -->
  <div class="tc-sec">
    <div class="tc-sec-head"><span class="tc-sec-num">9</span><h2>Contact Us</h2></div>
    <div class="tc-contact-box">
      <div class="tc-contact-row">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <span><?php echo esc_html($tc_addr); ?></span>
      </div>
      <div class="tc-contact-row">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 3.07 9.81a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L6.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <a href="tel:+254796140021"><?php echo esc_html($tc_phone); ?></a>
      </div>
      <div class="tc-contact-row">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
        <a href="https://wa.me/<?php echo esc_attr($tc_wa); ?>" target="_blank" rel="noopener">WhatsApp: <?php echo esc_html($tc_phone); ?></a>
      </div>
      <div class="tc-contact-row">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        <a href="mailto:<?php echo esc_attr($tc_email); ?>"><?php echo esc_html($tc_email); ?></a>
      </div>
    </div>
  </div>

</div>

<?php get_footer(); ?>