<?php
/**
 * Template Name: Delivery, Payment & Returns Policy
 */
get_header();

$rfp_wa    = '254796140021';
$rfp_phone = '+254 796140021';
$rfp_email = function_exists('medicare_email') ? medicare_email() : 'info@familydrugmartkenya.com';
?>

<style>
:root {
  --rfp-blue:        #1d3f8f;
  --rfp-blue-dark:   #15306e;
  --rfp-blue-darker: #0e2358;
  --rfp-blue-navy:   #0a1228;
  --rfp-gold:        #f5a623;
  --rfp-text:        #1b2230;
  --rfp-text-light:  #6b7280;
  --rfp-font-head:   'Nunito', sans-serif;
  --rfp-font-body:   'Lato', sans-serif;
}

.rfp-wrap {
  max-width: 1100px;
  margin: 40px auto 60px;
  padding: 0 24px;
  box-sizing: border-box;
  font-family: var(--rfp-font-body);
}

/* ── BREADCRUMB ── */
.rfp-crumb {
  font-size: 12.5px;
  color: var(--rfp-text-light);
  margin-bottom: 18px;
}
.rfp-crumb a { color: var(--rfp-blue); text-decoration: none; font-weight: 700; }
.rfp-crumb a:hover { color: var(--rfp-gold); }

/* ── HERO ── */
.rfp-hero {
  background: rgba(14,35,88,.92);
  border: 1px solid rgba(245,166,35,.25);
  border-top: 3px solid var(--rfp-gold);
  border-radius: 20px;
  padding: 48px 40px;
  text-align: center;
  box-sizing: border-box;
}

.rfp-tag {
  display: inline-block;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 1.4px;
  text-transform: uppercase;
  color: var(--rfp-gold);
  background: rgba(245,166,35,.10);
  border: 1px solid rgba(245,166,35,.30);
  padding: 6px 16px;
  border-radius: 50px;
  margin-bottom: 16px;
}

.rfp-title {
  font-family: var(--rfp-font-head);
  font-size: clamp(22px, 4vw, 32px);
  font-weight: 900;
  color: #fff;
  margin: 0 0 12px;
  line-height: 1.25;
}
.rfp-title span { color: var(--rfp-gold); }

.rfp-hero-desc {
  font-size: 13.5px;
  color: rgba(255,255,255,.70);
  line-height: 1.7;
  max-width: 560px;
  margin: 0 auto;
}

/* ── SECTION HEADER ── */
.rfp-sec-head {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 44px 0 18px;
}
.rfp-sec-num {
  width: 28px; height: 28px;
  border-radius: 8px;
  background: var(--rfp-blue);
  color: #fff;
  font-size: 13px;
  font-weight: 900;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.rfp-sec-head h2 {
  font-family: var(--rfp-font-head);
  font-size: 18px;
  font-weight: 900;
  color: var(--rfp-text);
  margin: 0;
}

/* ── CARD GRID ── */
.rfp-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.rfp-card {
  background: #fff;
  border: 1.5px solid #edf0f5;
  border-radius: 14px;
  padding: 20px;
  transition: border-color .2s, box-shadow .2s;
}
.rfp-card:hover { border-color: rgba(245,166,35,.35); box-shadow: 0 10px 24px rgba(13,33,79,.06); }

.rfp-card-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: var(--rfp-font-head);
  font-size: 13.5px;
  font-weight: 800;
  color: var(--rfp-text);
  margin-bottom: 10px;
}
.rfp-card-title svg { flex-shrink: 0; }
.rfp-card.no   .rfp-card-title { color: #c0392b; }
.rfp-card.yes  .rfp-card-title { color: #1e8a54; }

.rfp-card ul {
  margin: 0; padding: 0; list-style: none;
}
.rfp-card li {
  font-size: 12.5px;
  line-height: 1.6;
  color: var(--rfp-text-light);
  padding-left: 16px;
  position: relative;
  margin-bottom: 8px;
}
.rfp-card li:last-child { margin-bottom: 0; }
.rfp-card li::before {
  content: '';
  position: absolute;
  left: 0; top: 7px;
  width: 5px; height: 5px;
  border-radius: 50%;
  background: var(--rfp-gold);
}
.rfp-card strong { color: var(--rfp-text); }

/* ── FULL-WIDTH NOTE STRIP ── */
.rfp-note {
  background: #f6f8fc;
  border: 1.5px solid #e9edf5;
  border-radius: 14px;
  padding: 18px 22px;
  font-size: 12.5px;
  color: var(--rfp-text-light);
  line-height: 1.7;
  margin-top: 14px;
}
.rfp-note strong { color: var(--rfp-text); }

/* ── CONTACT STRIP IN NOTE ── */
.rfp-contact-line {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: var(--rfp-blue);
  font-weight: 800;
  text-decoration: none;
}
.rfp-contact-line:hover { color: var(--rfp-gold); }

/* ── CTA BOX ── */
.rfp-cta {
  margin-top: 48px;
  background: var(--rfp-blue-darker);
  border-radius: 18px;
  padding: 34px 28px;
  text-align: center;
}
.rfp-cta h3 {
  font-family: var(--rfp-font-head);
  font-size: 17px;
  font-weight: 900;
  color: #fff;
  margin: 0 0 8px;
}
.rfp-cta p {
  font-size: 13px;
  color: rgba(255,255,255,.65);
  margin: 0 0 22px;
}
.rfp-btn-row {
  display: flex;
  justify-content: center;
  gap: 12px;
  flex-wrap: wrap;
}
.rfp-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  border-radius: 50px;
  font-size: 13px;
  font-weight: 800;
  text-decoration: none;
  white-space: nowrap;
  transition: transform .18s, box-shadow .18s;
}
.rfp-btn-primary { background: var(--rfp-gold); color: var(--rfp-blue-navy); box-shadow: 0 8px 22px rgba(245,166,35,.30); }
.rfp-btn-primary:hover { transform: translateY(-2px); }
.rfp-btn-outline { background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,.30); }
.rfp-btn-outline:hover { border-color: var(--rfp-gold); color: var(--rfp-gold); transform: translateY(-2px); }

/* ── RESPONSIVE ── */
@media (max-width: 720px) {
  .rfp-grid { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
  .rfp-wrap { margin: 24px auto 40px; padding: 0 16px; }
  .rfp-hero { padding: 32px 20px; border-radius: 16px; }
  .rfp-hero-desc { font-size: 12.5px; }
  .rfp-sec-head h2 { font-size: 15.5px; }
  .rfp-card { padding: 16px; }
  .rfp-cta { padding: 26px 18px; }
  .rfp-btn-row { flex-direction: column; align-items: stretch; }
  .rfp-btn { width: 100%; justify-content: center; }
}
</style>

<div class="rfp-wrap">

  <!-- HERO -->
  <div class="rfp-hero">
    <h1 class="rfp-title">Refund, Returns, Delivery <span>&amp; Payment Policy</span></h1>
    <p class="rfp-hero-desc">
      Family Drugmart Kenya is committed to quality pharmaceutical products and reliable service. Please review the policy below before ordering.
    </p>
  </div>

  <!-- SECTION 1: REFUND & RETURNS -->
  <div class="rfp-sec-head">
    <span class="rfp-sec-num">1</span>
    <h2>Refund &amp; Returns Policy</h2>
  </div>

  <div class="rfp-grid">
    <div class="rfp-card no">
      <div class="rfp-card-title">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        Not Accepted
      </div>
      <ul>
        <li>Fridge items needing refrigeration, due to possible integrity loss in transit</li>
        <li>Tampered, opened or altered products</li>
        <li>Change of mind or wrong picking by the customer</li>
        <li>Returns after <strong>7 working days</strong> without prior communication</li>
      </ul>
    </div>

    <div class="rfp-card yes">
      <div class="rfp-card-title">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        Accepted
      </div>
      <ul>
        <li>Returns made within <strong>7 working days</strong> of receipt</li>
        <li>Expired products, contact us immediately for replacement</li>
        <li>Short-expiry items, if flagged before the expiry date</li>
        <li>Wrong item delivered, we collect and dispatch the correct one</li>
      </ul>
    </div>
  </div>

  <div class="rfp-note">
    <strong>Refund process:</strong> returned items are inspected on receipt and approved refunds are processed within <strong>3 working days</strong>, via your original payment method.<br><br>
    <strong>Before returning anything,</strong> please contact us first at
    <a href="mailto:<?php echo esc_attr($rfp_email); ?>" class="rfp-contact-line"><?php echo esc_html($rfp_email); ?></a>
    or
    <a href="tel:+254796140021" class="rfp-contact-line"><?php echo esc_html($rfp_phone); ?></a>
    ,this helps us resolve issues quickly.
  </div>

  <!-- SECTION 2: DELIVERY & PAYMENT -->
  <div class="rfp-sec-head">
    <span class="rfp-sec-num">2</span>
    <h2>Delivery &amp; Payment Policy</h2>
  </div>

  <div class="rfp-grid">
    <div class="rfp-card">
      <div class="rfp-card-title">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--rfp-blue)" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
        Payment Terms
      </div>
      <ul>
        <li>Payable on delivery, strictly within Nairobi and environs</li>
        <li>No credit unless agreed in writing beforehand</li>
        <li>Accepted: M-Pesa, Bank Transfer, Cash, Visa</li>
      </ul>
    </div>

    <div class="rfp-card">
      <div class="rfp-card-title">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--rfp-blue)" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Delivery Time
      </div>
      <ul>
        <li>You'll receive a delivery time window in advance</li>
        <li>Please ensure someone is available to receive and pay</li>
      </ul>
    </div>

    <div class="rfp-card">
      <div class="rfp-card-title">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--rfp-blue)" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        Rider Waiting Time
      </div>
      <ul>
        <li>Riders wait up to <strong>15 minutes</strong> on arrival</li>
        <li>Up to <strong>20 minutes</strong> if you're nearly available and in contact</li>
      </ul>
    </div>

    <div class="rfp-card">
      <div class="rfp-card-title">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--rfp-blue)" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        If You're Unavailable
      </div>
      <ul>
        <li>The rider proceeds to other deliveries and your order is rescheduled</li>
        <li>A re-delivery fee may apply</li>
      </ul>
    </div>
  </div>

  <div class="rfp-note">
    <strong>Rescheduling:</strong> notify us early if you need a different delivery time, and confirm availability before dispatch.<br><br>
    <strong>Repeated failed deliveries:</strong> we reserve the right to decline future cash-on-delivery orders or require advance payment if deliveries repeatedly fail due to unavailability or delayed payment.
  </div>

  <!-- CTA -->
  <div class="rfp-cta">
    <h3>Questions about an order?</h3>
    <p>Our team is happy to help with returns, refunds or delivery queries.</p>
    <div class="rfp-btn-row">
      <a href="https://wa.me/<?php echo esc_attr($rfp_wa); ?>?text=<?php echo urlencode('Hello Family Drugmart Kenya! I have a question about the Refund and Delivery Policy.'); ?>" class="rfp-btn rfp-btn-primary" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
        WhatsApp Us
      </a>
      <a href="<?php echo esc_url(home_url('/terms')); ?>" class="rfp-btn rfp-btn-outline">Terms &amp; Conditions</a>
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="rfp-btn rfp-btn-outline">Contact Page</a>
    </div>
  </div>

</div>

<?php get_footer(); ?>