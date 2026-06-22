<?php
/**
 * Template Name: About Us
 */
get_header();

$ab_wa    = function_exists('medicare_wa')    ? medicare_wa()    : '254796140021';
$ab_phone = function_exists('medicare_phone') ? medicare_phone() : '+254 0796140021';
?>

<style>
:root {
  --ab-blue:        #1d3f8f;
  --ab-blue-dark:   #15306e;
  --ab-blue-darker: #0e2358;
  --ab-blue-navy:   #0a1228;
  --ab-gold:        #f5a623;
  --ab-text:        #1b2230;
  --ab-text-light:  #6b7280;
  --ab-bg-soft:     #f7f8fa;
  --ab-border:      #edf0f5;
  --ab-font-head:   'Nunito', sans-serif;
  --ab-font-body:   'Lato', sans-serif;
}
*, *::before, *::after { box-sizing: border-box; }

.ab-wrap {
  max-width: 1100px;
  margin: 40px auto 60px;
  padding: 0 24px;
  font-family: var(--ab-font-body);
  overflow-x: hidden;
}

/* HERO */
.ab-hero {
  background: rgba(14,35,88,.92);
  border: 1px solid rgba(245,166,35,.25);
  border-top: 3px solid var(--ab-gold);
  border-radius: 20px;
  padding: 40px;
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: 36px;
  align-items: center;
}
.ab-hero-img-frame {
  position: relative;
  background: rgba(255,255,255,.04);
  border-radius: 18px;
  padding: 12px;
}
.ab-hero-img-frame::before,
.ab-hero-img-frame::after {
  content: '';
  position: absolute;
  width: 26px; height: 26px;
  border-color: var(--ab-gold);
  border-style: solid;
}
.ab-hero-img-frame::before {
  top: -1px; left: -1px;
  border-width: 3px 0 0 3px;
  border-top-left-radius: 12px;
}
.ab-hero-img-frame::after {
  bottom: -1px; right: -1px;
  border-width: 0 3px 3px 0;
  border-bottom-right-radius: 12px;
}
.ab-hero-img-wrap { border-radius: 12px; overflow: hidden; }
.ab-hero-img-wrap img {
  width: 100%; height: 260px;
  object-fit: cover; object-position: top center; display: block;
}
.ab-tag {
  display: inline-block;
  font-size: 11px; font-weight: 800; letter-spacing: 1.4px;
  text-transform: uppercase; color: var(--ab-gold);
  background: rgba(245,166,35,.10);
  border: 1px solid rgba(245,166,35,.30);
  padding: 6px 16px; border-radius: 50px; margin-bottom: 16px;
}
.ab-title {
  font-family: var(--ab-font-head);
  font-size: clamp(20px, 4vw, 32px);
  font-weight: 900; color: #fff; margin: 0 0 10px; line-height: 1.25;
}
.ab-title span { color: var(--ab-gold); }
.ab-hero-desc {
  font-size: 13.5px; color: rgba(255,255,255,.70); line-height: 1.7; margin: 0;
}

/* VALUES */
.ab-values { margin-top: 36px; }
.ab-values-grid {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px;
}
.ab-value-card {
  background: var(--ab-bg-soft); border: 1.5px solid var(--ab-border);
  border-radius: 14px; padding: 20px 16px; text-align: center;
}
.ab-value-icon {
  width: 38px; height: 38px; margin: 0 auto 12px; border-radius: 10px;
  background: rgba(29,63,143,.08);
  display: flex; align-items: center; justify-content: center;
  color: var(--ab-blue);
}
.ab-value-title {
  font-family: var(--ab-font-head); font-size: 13px;
  font-weight: 800; color: var(--ab-text); margin-bottom: 5px;
}
.ab-value-desc { font-size: 11.5px; color: var(--ab-text-light); line-height: 1.6; }

/* STATS */
.ab-stats {
  margin-top: 36px; background: var(--ab-blue-darker);
  border-radius: 18px; padding: 30px 24px;
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 16px; text-align: center;
}
.ab-stat-num {
  font-family: var(--ab-font-head); font-size: 26px;
  font-weight: 900; color: var(--ab-gold);
}
.ab-stat-label {
  font-size: 11.5px; color: rgba(255,255,255,.65);
  font-weight: 700; margin-top: 4px;
}

/* SERVICES */
.ab-services { margin-top: 44px; text-align: center; }
.ab-services h2 {
  font-family: var(--ab-font-head); font-size: 19px;
  font-weight: 900; color: var(--ab-text); margin: 0 0 18px;
}
.ab-services-grid {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; text-align: left;
}
.ab-service-card {
  display: flex; align-items: center; gap: 12px;
  background: var(--ab-bg-soft); border: 1.5px solid var(--ab-border);
  border-radius: 12px; padding: 14px 16px;
}
.ab-service-icon {
  width: 34px; height: 34px; border-radius: 9px;
  background: rgba(29,63,143,.08);
  display: flex; align-items: center; justify-content: center;
  color: var(--ab-blue); flex-shrink: 0;
}
.ab-service-name { font-size: 12.5px; font-weight: 800; color: var(--ab-text); line-height: 1.4; }

/* ULTRASOUND */
.ab-ultrasound { margin-top: 44px; }
.ab-ultrasound-head { text-align: center; margin-bottom: 18px; }
.ab-ultrasound-head h2 {
  font-family: var(--ab-font-head); font-size: 19px;
  font-weight: 900; color: var(--ab-text); margin: 0 0 6px;
}
.ab-ultrasound-head p { font-size: 12.5px; color: var(--ab-text-light); margin: 0; }
.ab-ultrasound-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
}
.ab-us-card { border-radius: 14px; padding: 24px; min-width: 0; }
.ab-us-card-dark { background: var(--ab-blue-darker); }
.ab-us-card-light { background: var(--ab-bg-soft); border: 1.5px solid var(--ab-border); }
.ab-us-eyebrow {
  font-size: 10px; font-weight: 800; letter-spacing: 1.4px;
  text-transform: uppercase; margin-bottom: 10px;
}
.ab-us-card-dark .ab-us-eyebrow { color: var(--ab-gold); }
.ab-us-card-light .ab-us-eyebrow { color: var(--ab-blue); }
.ab-us-card h3 {
  font-family: var(--ab-font-head); font-size: 15px;
  font-weight: 900; margin: 0 0 10px;
}
.ab-us-card-dark h3 { color: #fff; }
.ab-us-card-light h3 { color: var(--ab-text); }
.ab-us-card p { font-size: 12.5px; line-height: 1.7; margin: 0 0 16px; }
.ab-us-card-dark p { color: rgba(255,255,255,.75); }
.ab-us-card-light p { color: var(--ab-text-light); }
.ab-us-tags {
  list-style: none; margin: 0 0 18px; padding: 0;
  display: flex; flex-wrap: wrap; gap: 7px;
}
.ab-us-tags li { font-size: 11px; font-weight: 700; padding: 5px 10px; border-radius: 6px; }
.ab-us-card-dark .ab-us-tags li {
  background: rgba(245,166,35,.15);
  border: 1px solid rgba(245,166,35,.30); color: var(--ab-gold);
}
.ab-us-card-light .ab-us-tags li {
  background: rgba(29,63,143,.07); color: var(--ab-blue);
}

/* DELIVERY */
.ab-delivery { margin-top: 44px; }
.ab-delivery-head { text-align: center; margin-bottom: 6px; }
.ab-delivery-head h2 {
  font-family: var(--ab-font-head); font-size: 19px;
  font-weight: 900; color: var(--ab-text); margin: 0;
}
.ab-delivery-sub {
  text-align: center; font-size: 12.5px;
  color: var(--ab-text-light); margin: 6px 0 22px;
}
.ab-delivery-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.ab-delivery-card {
  background: var(--ab-bg-soft); border: 1.5px solid var(--ab-border);
  border-radius: 14px; padding: 20px;
}
.ab-delivery-title {
  display: flex; align-items: center; gap: 8px;
  font-family: var(--ab-font-head); font-size: 13px; font-weight: 800;
  color: var(--ab-blue); margin-bottom: 12px; padding-bottom: 10px;
  border-bottom: 1.5px solid #e0e4ec;
}
.ab-delivery-row {
  font-size: 12px; color: var(--ab-text-light);
  line-height: 1.7; margin-bottom: 7px;
}
.ab-delivery-row:last-child { margin-bottom: 0; }
.ab-delivery-row strong { color: var(--ab-text); }

/* WHATSAPP STRIP */
.ab-wa-strip {
  margin-top: 24px; text-align: center; background: #fff;
  border: 1.5px solid var(--ab-border); border-radius: 14px; padding: 22px;
}
.ab-wa-strip p {
  font-size: 12.5px; color: var(--ab-text-light);
  font-weight: 600; margin: 0 0 14px;
}

/* BUTTONS */
.ab-btn {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 24px; border-radius: 50px;
  font-size: 13px; font-weight: 800; font-family: var(--ab-font-body);
  text-decoration: none; white-space: nowrap;
  transition: transform .18s, box-shadow .18s;
}
.ab-btn-gold {
  background: var(--ab-gold); color: var(--ab-blue-navy);
  box-shadow: 0 8px 22px rgba(245,166,35,.30);
}
.ab-btn-gold:hover { transform: translateY(-2px); }
.ab-btn-sm { font-size: 12px; padding: 10px 20px; }
.ab-btn-white { background: #fff; color: var(--ab-blue); box-shadow: 0 6px 16px rgba(0,0,0,.08); }
.ab-btn-white:hover { transform: translateY(-2px); }
.ab-btn-outline { background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,.35); }
.ab-btn-outline:hover { border-color: var(--ab-gold); color: var(--ab-gold); transform: translateY(-2px); }

/* FINAL CTA */
.ab-cta {
  margin-top: 44px; background: var(--ab-blue-darker);
  border-radius: 18px; padding: 36px 28px; text-align: center;
}
.ab-cta h2 {
  font-family: var(--ab-font-head); font-size: 19px;
  font-weight: 900; color: #fff; margin: 0 0 8px;
}
.ab-cta h2 span { color: var(--ab-gold); }
.ab-cta p { font-size: 12.5px; color: rgba(255,255,255,.65); margin: 0 0 22px; }
.ab-btn-row { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

/* RESPONSIVE */
@media (max-width: 860px) {
  .ab-hero { grid-template-columns: 1fr; padding: 28px; gap: 24px; }
  .ab-hero-img-wrap img { height: 200px; }
  .ab-values-grid { grid-template-columns: repeat(2, 1fr); }
  .ab-stats { grid-template-columns: repeat(2, 1fr); }
  .ab-services-grid { grid-template-columns: repeat(2, 1fr); }
  .ab-delivery-grid { grid-template-columns: 1fr; }
  .ab-ultrasound-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
  .ab-wrap { margin: 20px auto 40px; padding: 0 14px; }
  .ab-hero { padding: 18px; border-radius: 14px; gap: 18px; }
  .ab-hero-img-wrap img { height: 170px; }
  .ab-hero-desc { font-size: 12.5px; }
  .ab-values-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .ab-value-card { padding: 14px 10px; }
  .ab-value-title { font-size: 12px; }
  .ab-value-desc { font-size: 11px; }
  .ab-stats { grid-template-columns: repeat(2, 1fr); padding: 20px 14px; gap: 12px; }
  .ab-stat-num { font-size: 22px; }
  .ab-stat-label { font-size: 11px; }
  .ab-services-grid { grid-template-columns: 1fr; gap: 8px; }
  .ab-service-card { padding: 12px; }
  .ab-service-name { font-size: 12px; }
  .ab-ultrasound-grid { grid-template-columns: 1fr; }
  .ab-us-card { padding: 16px; }
  .ab-us-card h3 { font-size: 14px; }
  .ab-us-card p { font-size: 12px; }
  .ab-us-tags li { font-size: 10.5px; padding: 4px 8px; }
  .ab-delivery-grid { grid-template-columns: 1fr; }
  .ab-delivery-card { padding: 16px; }
  .ab-btn-row { flex-direction: column; align-items: stretch; }
  .ab-btn { justify-content: center; font-size: 12px; padding: 11px 18px; }
  .ab-cta { padding: 26px 16px; }
  .ab-cta h2 { font-size: 16px; }

  /* fix: shrink font so button text stays on one line */
  .ab-us-card .ab-btn {
    font-size: 11px;
    padding: 10px 14px;
    gap: 6px;
  }
  .ab-us-card .ab-btn svg { flex-shrink: 0; }
}
@media (max-width: 400px) {
  .ab-values-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
  .ab-stats { grid-template-columns: 1fr 1fr; }

  /* tighten further for very small screens */
  .ab-us-card .ab-btn {
    font-size: 10.5px;
    padding: 9px 12px;
  }
}
</style>

<div class="ab-wrap">

  <!-- HERO -->
  <div class="ab-hero">
    <div class="ab-hero-img-frame">
      <div class="ab-hero-img-wrap">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/js/images/doctors.png'); ?>" alt="Family Drugmart Pharmacists">
      </div>
    </div>
    <div>
      <span class="ab-tag">About Us</span>
      <h1 class="ab-title">About <span>Family Drugmart</span></h1>
      <p class="ab-hero-desc">Kenya's trusted online pharmacy, serving families with quality, affordable, certified medicines, including in-store and home visit ultrasound scanning services. Licensed by the Pharmacy and Poisons Board of Kenya.</p>
    </div>
  </div>

  <!-- MISSION / VISION / VALUES / AWARD -->
  <div class="ab-values">
    <div class="ab-values-grid">
      <div class="ab-value-card">
        <div class="ab-value-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
        <div class="ab-value-title">Our Mission</div>
        <div class="ab-value-desc">Quality, affordable healthcare for every Kenyan family.</div>
      </div>
      <div class="ab-value-card">
        <div class="ab-value-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
        <div class="ab-value-title">Our Vision</div>
        <div class="ab-value-desc">Kenya's most trusted pharmacy, online and in-store.</div>
      </div>
      <div class="ab-value-card">
        <div class="ab-value-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div>
        <div class="ab-value-title">Our Values</div>
        <div class="ab-value-desc">Integrity, care and excellence in everything we do.</div>
      </div>
      <div class="ab-value-card">
        <div class="ab-value-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></div>
        <div class="ab-value-title">Award Winning</div>
        <div class="ab-value-desc">Recognized for excellence in healthcare delivery.</div>
      </div>
    </div>
  </div>

  <!-- STATS -->
  <div class="ab-stats">
    <div>
      <div class="ab-stat-num" data-target="12" data-suffix="+">0+</div>
      <div class="ab-stat-label">Years of Service</div>
    </div>
    <div>
      <div class="ab-stat-num" data-target="8" data-suffix="K+">0K+</div>
      <div class="ab-stat-label">Happy Customers</div>
    </div>
    <div>
      <div class="ab-stat-num" data-target="6" data-suffix="K+">0K+</div>
      <div class="ab-stat-label">Products Available</div>
    </div>
    <div>
      <div class="ab-stat-num" data-target="24" data-suffix="/7">0/7</div>
      <div class="ab-stat-label">WhatsApp Support</div>
    </div>
  </div>

  <!-- SERVICES -->
  <div class="ab-services">
    <h2>What We Do</h2>
    <div class="ab-services-grid">
      <div class="ab-service-card">
        <div class="ab-service-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
        <div class="ab-service-name">Prescription Medicines</div>
      </div>
      <div class="ab-service-card">
        <div class="ab-service-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div class="ab-service-name">24/7 Emergency Services</div>
      </div>
      <div class="ab-service-card">
        <div class="ab-service-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
        <div class="ab-service-name">Free Consultation</div>
      </div>
      <div class="ab-service-card">
        <div class="ab-service-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/></svg></div>
        <div class="ab-service-name">Excellence Rewards</div>
      </div>
      <div class="ab-service-card">
        <div class="ab-service-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
        <div class="ab-service-name">Countrywide Delivery</div>
      </div>
      <div class="ab-service-card">
        <div class="ab-service-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        <div class="ab-service-name">Professional Pharmacists</div>
      </div>
    </div>
  </div>

  <!-- ULTRASOUND -->
  <div class="ab-ultrasound">
    <div class="ab-ultrasound-head">
      <h2>In-Store &amp; Home Ultrasound Services</h2>
      <p>Professional diagnostic imaging at our pharmacy or in the comfort of your home.</p>
    </div>
    <div class="ab-ultrasound-grid">
      <div class="ab-us-card ab-us-card-dark">
        <div class="ab-us-eyebrow">In-Store</div>
        <h3>Visit Us at the Pharmacy</h3>
        <p>Walk in or book an appointment with our certified sonographers at High Point Plaza, Ruaka-Banana Road. Fast results, no referral needed.</p>
        <ul class="ab-us-tags">
          <li>Thyroid Scan</li><li>Obs Scan</li><li>Breast Ultrasound</li>
          <li>Abdominal Scan</li><li>Pelvic Scan</li><li>Scrotal Scan</li>
          <li>KUBP</li><li>Doppler Scan</li><li>Echocardiography</li>
        </ul>
        <a href="<?php echo esc_url(home_url('/ultra-sound-service/')); ?>" class="ab-btn ab-btn-gold ab-btn-sm">
          Book In-Store Scan
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="ab-us-card ab-us-card-light">
        <div class="ab-us-eyebrow">Home Visit</div>
        <h3>We Come to You</h3>
        <p>Can't make it to the pharmacy? Our mobile ultrasound service brings certified sonographers directly to your home across Nairobi. Affordable, private and convenient.</p>
        <ul class="ab-us-tags">
          <li>Nairobi Coverage</li><li>All Scan Types</li>
          <li>Certified Sonographers</li><li>Fast Results</li>
        </ul>
        <a href="https://wa.me/<?php echo esc_attr($ab_wa); ?>?text=<?php echo urlencode('Hi! I would like to book a home visit ultrasound scan.'); ?>" class="ab-btn ab-btn-gold ab-btn-sm" target="_blank" rel="noopener">
          Book Home Visit via WhatsApp
          <svg viewBox="0 0 24 24" fill="currentColor" width="13" height="13"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
        </a>
      </div>
    </div>
  </div>

  <!-- DELIVERY -->
  <div class="ab-delivery">
    <div class="ab-delivery-head"><h2>Delivery Schedule</h2></div>
    <div class="ab-delivery-sub">Same day across Nairobi, 1–2 days countrywide.</div>
    <div class="ab-delivery-grid">
      <div class="ab-delivery-card">
        <div class="ab-delivery-title">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Nairobi: Same Day
        </div>
        <div class="ab-delivery-row"><strong>Before 3:00 PM</strong> — dispatched same day, delivered by evening.</div>
        <div class="ab-delivery-row"><strong>3–6 PM</strong> — possible same day, confirmed via WhatsApp.</div>
        <div class="ab-delivery-row"><strong>After 6:00 PM</strong> — delivered the next morning.</div>
      </div>
      <div class="ab-delivery-card">
        <div class="ab-delivery-title">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          Outside Nairobi
        </div>
        <div class="ab-delivery-row"><strong>Nearby counties</strong> — Kiambu, Machakos, Kajiado, Murang'a: next day.</div>
        <div class="ab-delivery-row"><strong>Distant counties</strong> — Mombasa, Kisumu, Nakuru, Eldoret: 1–2 days.</div>
        <div class="ab-delivery-row">We always confirm your delivery time via WhatsApp before dispatch.</div>
      </div>
    </div>
    <div class="ab-wa-strip">
      <p>Have delivery questions? Chat with us directly!</p>
      <a href="https://wa.me/<?php echo esc_attr($ab_wa); ?>?text=<?php echo urlencode('Hello Family Drugmart! I have a delivery enquiry.'); ?>" class="ab-btn ab-btn-gold" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
        Chat on WhatsApp
      </a>
    </div>
  </div>

  <!-- FINAL CTA -->
  <div class="ab-cta">
    <h2>Have Questions? <span>We're Here</span></h2>
    <p>Reach out via WhatsApp or visit us at High Point Plaza, Ruaka-Banana Road.</p>
    <div class="ab-btn-row">
      <a href="https://wa.me/<?php echo esc_attr($ab_wa); ?>?text=<?php echo urlencode('Hello Family Drugmart! I have an enquiry.'); ?>" class="ab-btn ab-btn-white" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
        Chat on WhatsApp
      </a>
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="ab-btn ab-btn-outline">Contact Us</a>
    </div>
  </div>

</div>

<script>
(function(){
  function animateCounter(el) {
    var target = parseInt(el.getAttribute('data-target'));
    var suffix = el.getAttribute('data-suffix');
    var duration = 1500, start = null;
    function step(ts) {
      if (!start) start = ts;
      var progress = Math.min((ts - start) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.floor(eased * target) + suffix;
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = target + suffix;
    }
    requestAnimationFrame(step);
  }
  var counters = document.querySelectorAll('.ab-stat-num');
  if ('IntersectionObserver' in window) {
    var obs = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if (e.isIntersecting) { animateCounter(e.target); obs.unobserve(e.target); }
      });
    }, { threshold: 0.3 });
    counters.forEach(function(c){ obs.observe(c); });
  } else {
    counters.forEach(animateCounter);
  }
})();
</script>

<?php get_footer(); ?>