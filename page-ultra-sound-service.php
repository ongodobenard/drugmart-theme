<?php
/**
 * Template Name: Ultrasound Services
 */
get_header();

$us_wa    = '254796140021';
$us_phone = '+254 0796140021';
$us_form  = 'https://docs.google.com/forms/d/e/1FAIpQLSex9caqdh6Gjjiibm-mMZlGXUmmUYqh1T7i3uqrSCkHNiMIDg/viewform?pli=1';
?>

<style>
:root {
  --usp-blue:        #1d3f8f;
  --usp-blue-dark:   #15306e;
  --usp-blue-darker: #0e2358;
  --usp-blue-navy:   #0a1228;
  --usp-gold:        #f5a623;
  --usp-text:        #1b2230;
  --usp-text-light:  #6b7280;
  --usp-font-head:   'Nunito', sans-serif;
  --usp-font-body:   'Lato', sans-serif;
}

.usp-wrap {
  max-width: 1100px;
  margin: 40px auto 60px;
  padding: 0 24px;
  box-sizing: border-box;
  font-family: var(--usp-font-body);
}

/* ── HERO ── */
.usp-hero {
  background: var(--usp-blue-darker);
  border: 1px solid rgba(245,166,35,.25);
  border-top: 3px solid var(--usp-gold);
  border-radius: 20px;
  padding: 52px 40px;
  text-align: center;
  box-sizing: border-box;
}
.usp-tag {
  display: inline-block;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 1.4px;
  text-transform: uppercase;
  color: var(--usp-gold);
  background: rgba(245,166,35,.10);
  border: 1px solid rgba(245,166,35,.30);
  padding: 6px 16px;
  border-radius: 50px;
  margin-bottom: 18px;
  font-family: var(--usp-font-body);
}

.usp-title {
  font-family: var(--usp-font-head);
  font-size: clamp(24px, 4vw, 36px);
  font-weight: 900;
  color: #fff;
  margin: 0 0 14px;
  line-height: 1.25;
}
.usp-title span { color: var(--usp-gold); }

.usp-hero-desc {
  font-size: clamp(13.5px, 2vw, 15px);
  color: rgba(255,255,255,.70);
  line-height: 1.75;
  max-width: 620px;
  margin: 0 auto 28px;
}

.usp-btn-row {
  display: flex;
  justify-content: center;
  gap: 12px;
  flex-wrap: wrap;
}

.usp-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 13px 26px;
  border-radius: 50px;
  font-size: 13.5px;
  font-weight: 800;
  font-family: var(--usp-font-body);
  text-decoration: none;
  white-space: nowrap;
  transition: transform .18s, box-shadow .18s, background .18s;
}
.usp-btn-primary {
  background: var(--usp-gold);
  color: var(--usp-blue-navy);
  box-shadow: 0 8px 22px rgba(245,166,35,.30);
}
.usp-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 26px rgba(245,166,35,.40); }
.usp-btn-outline {
  background: transparent;
  color: #fff;
  border: 1.5px solid rgba(255,255,255,.30);
}
.usp-btn-outline:hover { border-color: var(--usp-gold); color: var(--usp-gold); transform: translateY(-2px); }
.usp-btn svg { flex-shrink: 0; }

/* ── INTRO ── */
.usp-intro {
  max-width: 720px;
  margin: 40px auto 0;
  text-align: center;
}
.usp-intro p {
  font-size: 14.5px;
  line-height: 1.85;
  color: var(--usp-text-light);
  margin: 0;
}
.usp-intro strong { color: var(--usp-text); }

/* ── FEATURE GRID ── */
.usp-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 18px;
  margin-top: 40px;
}

.usp-card {
  background: #fff;
  border: 1.5px solid #edf0f5;
  border-radius: 14px;
  padding: 24px 18px;
  text-align: center;
  transition: transform .2s, box-shadow .2s, border-color .2s;
}
.usp-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 28px rgba(13,33,79,.08);
  border-color: rgba(245,166,35,.35);
}

.usp-card-icon {
  width: 46px;
  height: 46px;
  margin: 0 auto 14px;
  border-radius: 12px;
  background: rgba(29,63,143,.08);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--usp-blue);
}

.usp-card-title {
  font-family: var(--usp-font-head);
  font-size: 14px;
  font-weight: 800;
  color: var(--usp-text);
  margin-bottom: 6px;
}

.usp-card-desc {
  font-size: 12px;
  color: var(--usp-text-light);
  line-height: 1.6;
}

/* ── BOOKING STRIP ── */
.usp-booking {
  margin-top: 44px;
  background: #f6f8fc;
  border: 1.5px solid #e9edf5;
  border-radius: 16px;
  padding: 32px 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 24px;
  flex-wrap: wrap;
}

.usp-booking-text h3 {
  font-family: var(--usp-font-head);
  font-size: 17px;
  font-weight: 900;
  color: var(--usp-text);
  margin: 0 0 6px;
}
.usp-booking-text p {
  font-size: 13px;
  color: var(--usp-text-light);
  margin: 0;
}

.usp-license {
  margin-top: 28px;
  text-align: center;
  font-size: 11.5px;
  color: var(--usp-text-light);
  letter-spacing: .3px;
}
.usp-license strong { color: var(--usp-text); }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
  .usp-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
  .usp-wrap { margin: 24px auto 40px; padding: 0 16px; }
  .usp-hero { padding: 36px 22px; border-radius: 16px; }
  .usp-hero-desc { font-size: 13px; }
  .usp-btn { font-size: 12.5px; padding: 11px 18px; width: 100%; }
  .usp-btn-row { flex-direction: column; align-items: stretch; }
  .usp-grid { grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 28px; }
  .usp-card { padding: 18px 12px; }
  .usp-card-icon { width: 38px; height: 38px; margin-bottom: 10px; }
  .usp-card-title { font-size: 12.5px; }
  .usp-card-desc { font-size: 11px; }
  .usp-booking { flex-direction: column; align-items: stretch; text-align: center; padding: 24px 18px; }
  .usp-booking .usp-btn { width: 100%; }
}
</style>

<div class="usp-wrap">

  <!-- HERO -->
  <div class="usp-hero">
    <h1 class="usp-title">Ultrasound Scanning, <span>Home or In-Store</span></h1>
    <p class="usp-hero-desc">
      Licensed ultrasound scanning in Nairobi from Family Drugmart. Book a home visit or visit our pharmacy ,safe, accurate, and affordable.
    </p>
    <div class="usp-btn-row">
      <a href="<?php echo esc_url($us_form); ?>" class="usp-btn usp-btn-primary" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Book Your Scan
      </a>
      <a href="https://wa.me/<?php echo esc_attr($us_wa); ?>?text=<?php echo urlencode('Hello Family Drugmart! I would like to book an ultrasound scan.'); ?>" class="usp-btn usp-btn-outline" target="_blank" rel="noopener">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
        WhatsApp Us
      </a>
    </div>
  </div>

  <!-- INTRO -->
  <div class="usp-intro">
    <p>
      We bring trusted ultrasound scanning to your doorstep or our pharmacy in Ruaka, Nairobi.
      Every scan is performed by qualified staff using safe, modern equipment ,fast, private, and reliable.
    </p>
  </div>

  <!-- FEATURE GRID -->
  <div class="usp-grid">
    <div class="usp-card">
      <div class="usp-card-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      </div>
      <div class="usp-card-title">Home-Based Scans</div>
      <div class="usp-card-desc">We come to you, anywhere in Nairobi.</div>
    </div>
    <div class="usp-card">
      <div class="usp-card-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/></svg>
      </div>
      <div class="usp-card-title">In-Store Scans</div>
      <div class="usp-card-desc">Visit us at High Point Plaza, Ruaka.</div>
    </div>
    <div class="usp-card">
      <div class="usp-card-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L3 7v6c0 5 4 9 9 9s9-4 9-9V7l-9-5z"/></svg>
      </div>
      <div class="usp-card-title">Licensed & Safe</div>
      <div class="usp-card-desc">Certified pharmacy, qualified staff.</div>
    </div>
    <div class="usp-card">
      <div class="usp-card-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div class="usp-card-title">Quick Booking</div>
      <div class="usp-card-desc">Easy online form, fast confirmation.</div>
    </div>
  </div>

  <!-- BOOKING STRIP -->
  <div class="usp-booking">
    <div class="usp-booking-text">
      <h3>Ready to book your scan?</h3>
      <p>Fill our short form and we'll confirm your appointment by WhatsApp.</p>
    </div>
    <a href="<?php echo esc_url($us_form); ?>" class="usp-btn usp-btn-primary" style="background:var(--usp-blue);color:#fff;box-shadow:0 8px 22px rgba(29,63,143,.25);" target="_blank" rel="noopener">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Book Now
    </a>
  </div>

  <!-- LICENSE -->
  <div class="usp-license">
    Licensed by the Pharmacy and Poisons Board of Kenya · <strong>PPB Reg No: PPBB/F/3208</strong>
  </div>

</div>

<?php get_footer(); ?>