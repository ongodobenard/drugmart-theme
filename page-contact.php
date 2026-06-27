<?php
/**
 * Template Name: Contact
 */
get_header();

$ct_wa    = '254796140021';
$ct_phone = '+254 796140021';
$ct_email = function_exists('medicare_email') ? medicare_email() : 'info@familydrugmartkenya.com';
$ct_addr  = 'High Point Plaza, along Ruaka-Banana Raini Road.';
?>

<style>
:root {
  --ct-blue:        #1d3f8f;
  --ct-blue-dark:   #15306e;
  --ct-blue-darker: #0e2358;
  --ct-blue-navy:   #0a1228;
  --ct-gold:        #f5a623;
  --ct-text:        #1b2230;
  --ct-text-light:  #6b7280;
  --ct-bg-soft:     #f7f8fa;
  --ct-font-head:   'Nunito', sans-serif;
  --ct-font-body:   'Lato', sans-serif;
}

* { box-sizing: border-box; }

.ct-wrap {
  max-width: 1100px;
  margin: 40px auto 60px;
  padding: 0 24px;
  box-sizing: border-box;
  font-family: var(--ct-font-body);
  overflow-x: hidden;
}

/* ── HERO ── */
.ct-hero {
  background: rgba(14,35,88,.92);
  border: 1px solid rgba(245,166,35,.25);
  border-top: 3px solid var(--ct-gold);
  border-radius: 20px;
  padding: 48px 40px;
  text-align: center;
  box-sizing: border-box;
}
.ct-tag {
  display: inline-block;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 1.4px;
  text-transform: uppercase;
  color: var(--ct-gold);
  background: rgba(245,166,35,.10);
  border: 1px solid rgba(245,166,35,.30);
  padding: 6px 16px;
  border-radius: 50px;
  margin-bottom: 16px;
}
.ct-title {
  font-family: var(--ct-font-head);
  font-size: clamp(22px, 4vw, 32px);
  font-weight: 900;
  color: #fff;
  margin: 0 0 10px;
  line-height: 1.25;
}
.ct-title span { color: var(--ct-gold); }
.ct-hero-desc {
  font-size: 13.5px;
  color: rgba(255,255,255,.70);
  line-height: 1.7;
  max-width: 520px;
  margin: 0 auto;
}

/* ── MAIN GRID ── */
.ct-grid {
  display: grid;
  grid-template-columns: minmax(0,1fr) minmax(0,1.3fr);
  gap: 32px;
  margin-top: 36px;
  align-items: start;
}

/* ── INFO COLUMN ── */
.ct-info-card {
  background: var(--ct-bg-soft);
  border: 1.5px solid #edf0f5;
  border-radius: 16px;
  padding: 26px;
  min-width: 0;
}
.ct-info-row {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  margin-bottom: 18px;
  min-width: 0;
}
.ct-info-row:last-child { margin-bottom: 0; }
.ct-info-icon {
  width: 38px; height: 38px;
  border-radius: 10px;
  background: rgba(29,63,143,.08);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  color: var(--ct-blue);
}
.ct-info-text {
  min-width: 0;
  flex: 1 1 auto;
}
.ct-info-label {
  font-size: 11px;
  font-weight: 800;
  letter-spacing: .5px;
  text-transform: uppercase;
  color: var(--ct-text-light);
  margin-bottom: 3px;
}
.ct-info-value {
  font-size: 13.5px;
  font-weight: 700;
  color: var(--ct-text);
  line-height: 1.5;
  word-break: break-word;
  overflow-wrap: anywhere;
}
.ct-info-value a {
  color: var(--ct-blue);
  text-decoration: none;
  word-break: break-word;
  overflow-wrap: anywhere;
}
.ct-info-value a:hover { color: var(--ct-gold); }

.ct-socials { display: flex; gap: 8px; margin-top: 22px; flex-wrap: wrap; }
.ct-soc {
  width: 34px; height: 34px;
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  text-decoration: none;
  color: #fff;
  flex-shrink: 0;
  transition: transform .2s, opacity .2s;
}
.ct-soc:hover { transform: translateY(-2px); opacity: .88; }
.ct-soc-fb { background: #1877f2; }
.ct-soc-ig { background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); }
.ct-soc-tw { background: #15202b; }
.ct-soc-wa { background: #25d366; }

/* ── FORM ── */
.ct-form-card {
  background: #fff;
  border: 1.5px solid #edf0f5;
  border-radius: 16px;
  padding: 28px;
  min-width: 0;
}
.ct-form-title {
  font-family: var(--ct-font-head);
  font-size: 16.5px;
  font-weight: 900;
  color: var(--ct-text);
  margin-bottom: 18px;
}

.fg { position: relative; margin-bottom: 14px; min-width: 0; }
.fg label {
  display: block;
  font-size: 12px;
  font-weight: 800;
  color: var(--ct-text-light);
  margin-bottom: 5px;
}
.fg label .req { color: var(--ct-gold); margin-left: 2px; }
.fg input, .fg select, .fg textarea {
  width: 100%;
  padding: 10px 13px;
  border: 1.5px solid #e0e4ec;
  border-radius: 8px;
  font-size: 13px;
  font-family: var(--ct-font-body);
  color: var(--ct-text);
  outline: none;
  transition: border-color .2s, box-shadow .2s;
  background: #fff;
  box-sizing: border-box;
}
.fg input:focus, .fg select:focus, .fg textarea:focus {
  border-color: var(--ct-blue);
  box-shadow: 0 0 0 3px rgba(29,63,143,.10);
}
.fg.invalid input, .fg.invalid select, .fg.invalid textarea {
  border-color: #e53935 !important;
  box-shadow: 0 0 0 3px rgba(229,57,53,.10) !important;
}
.fg .error-msg {
  font-size: 11px;
  color: #e53935;
  font-weight: 700;
  margin-top: 4px;
  display: none;
  word-break: break-word;
  overflow-wrap: anywhere;
}
.fg.invalid .error-msg { display: block; }
.fg.valid input, .fg.valid select, .fg.valid textarea { border-color: #2eaf6e !important; }

.form-row {
  display: grid;
  grid-template-columns: minmax(0,1fr) minmax(0,1fr);
  gap: 12px;
}

.ct-submit-btn {
  width: 100%;
  padding: 12px;
  background: var(--ct-blue);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 13.5px;
  font-weight: 800;
  font-family: var(--ct-font-head);
  cursor: pointer;
  transition: background .2s, transform .15s;
}
.ct-submit-btn:hover { background: var(--ct-blue-dark); transform: translateY(-1px); }
.ct-submit-btn:disabled { opacity: .65; cursor: default; transform: none; }

.ct-toast {
  display: flex; align-items: flex-start; gap: 9px;
  border-radius: 10px; font-size: 12.5px; font-weight: 700;
  line-height: 1.5; border: 1.5px solid transparent;
  opacity: 0; max-height: 0; overflow: hidden; padding: 0 16px;
  pointer-events: none;
  transition: opacity .3s ease, max-height .4s ease, padding .4s ease, margin-top .4s ease;
}
.ct-toast.show { opacity: 1; max-height: 220px; padding: 13px 16px; margin-top: 14px; pointer-events: auto; }
.ct-toast svg { flex-shrink: 0; margin-top: 1px; }
.ct-toast span { min-width: 0; word-break: break-word; overflow-wrap: anywhere; }
.ct-toast-success { background: #edfaf3; color: #1a6e44; border-color: #6fcf97; }
.ct-toast-error   { background: #fff0f0; color: #b71c1c; border-color: #ef9a9a; }

/* ── FAQ ACCORDION ── */
.ct-faq { margin-top: 44px; }
.ct-faq-head { text-align: center; margin-bottom: 22px; }
.ct-faq-head h2 {
  font-family: var(--ct-font-head);
  font-size: 19px;
  font-weight: 900;
  color: var(--ct-text);
  margin: 0;
}
.ct-faq-item {
  border: 1.5px solid #edf0f5;
  border-radius: 12px;
  margin-bottom: 10px;
  overflow: hidden;
}
.ct-faq-q {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding: 16px 20px;
  cursor: pointer;
  background: var(--ct-bg-soft);
  font-family: var(--ct-font-head);
  font-size: 13.5px;
  font-weight: 800;
  color: var(--ct-text);
}
.ct-faq-q span:first-child { min-width: 0; word-break: break-word; }
.ct-faq-icon {
  width: 22px; height: 22px;
  border-radius: 50%;
  background: var(--ct-blue);
  color: #fff;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  font-size: 14px;
  font-weight: 900;
  transition: transform .2s;
}
.ct-faq-item.open .ct-faq-icon { transform: rotate(45deg); background: var(--ct-gold); color: var(--ct-blue-navy); }
.ct-faq-a {
  max-height: 0;
  overflow: hidden;
  transition: max-height .3s ease, padding .3s ease;
  font-size: 12.5px;
  color: var(--ct-text-light);
  line-height: 1.75;
  padding: 0 20px;
  word-break: break-word;
  overflow-wrap: anywhere;
}
.ct-faq-item.open .ct-faq-a { max-height: 260px; padding: 14px 20px 18px; }
.ct-faq-a a { color: var(--ct-blue); font-weight: 700; text-decoration: none; }

/* ── RESPONSIVE ── */
@media (max-width: 860px) {
  .ct-grid { grid-template-columns: minmax(0,1fr); }
}
@media (max-width: 640px) {
  .ct-wrap { margin: 24px auto 40px; padding: 0 16px; }
  .ct-hero { padding: 32px 20px; border-radius: 16px; }
  .ct-hero-desc { font-size: 12.5px; }
  .ct-info-card, .ct-form-card { padding: 18px; }
  .form-row { grid-template-columns: minmax(0,1fr); }
  .ct-faq-head h2 { font-size: 16px; }
  .ct-faq-q { font-size: 12.5px; padding: 14px 16px; }
}
</style>

<div class="ct-wrap">

  <!-- HERO -->
  <div class="ct-hero">
    <span class="ct-tag">Get In Touch</span>
    <h1 class="ct-title">Contact <span>Family Drugmart</span></h1>
    <p class="ct-hero-desc">Have a question or need help? We're available via WhatsApp, phone or email.</p>
  </div>

  <!-- MAIN GRID -->
  <div class="ct-grid">

    <!-- INFO -->
    <div class="ct-info-card">
      <div class="ct-info-row">
        <div class="ct-info-icon">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 3.07 9.81a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 2 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L6.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </div>
        <div class="ct-info-text">
          <div class="ct-info-label">Phone / WhatsApp</div>
          <div class="ct-info-value"><a href="https://wa.me/<?php echo esc_attr($ct_wa); ?>" target="_blank" rel="noopener"><?php echo esc_html($ct_phone); ?></a></div>
        </div>
      </div>

      <div class="ct-info-row">
        <div class="ct-info-icon">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <div class="ct-info-text">
          <div class="ct-info-label">Email Address</div>
          <div class="ct-info-value"><a href="mailto:<?php echo esc_attr($ct_email); ?>"><?php echo esc_html($ct_email); ?></a></div>
        </div>
      </div>

      <div class="ct-info-row">
        <div class="ct-info-icon">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div class="ct-info-text">
          <div class="ct-info-label">Our Location</div>
          <div class="ct-info-value"><?php echo esc_html($ct_addr); ?></div>
        </div>
      </div>

      <div class="ct-info-row">
        <div class="ct-info-icon">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="ct-info-text">
          <div class="ct-info-label">Working Hours</div>
          <div class="ct-info-value">Mon – Fri: 8:30 AM – 6:00 PM<br>Sat: 9:00 AM – 1:00 PM<br>Sun &amp; Holidays: Closed</div>
        </div>
      </div>

      <div class="ct-socials">
        <a href="<?php echo esc_url(get_option('medicare_facebook','#')); ?>" class="ct-soc ct-soc-fb" target="_blank" rel="noopener" aria-label="Facebook">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="white"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
        </a>
        <a href="<?php echo esc_url(get_option('medicare_instagram','#')); ?>" class="ct-soc ct-soc-ig" target="_blank" rel="noopener" aria-label="Instagram">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </a>
        <a href="<?php echo esc_url(get_option('medicare_twitter','#')); ?>" class="ct-soc ct-soc-tw" target="_blank" rel="noopener" aria-label="X">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="white"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <a href="https://wa.me/<?php echo esc_attr($ct_wa); ?>" class="ct-soc ct-soc-wa" target="_blank" rel="noopener" aria-label="WhatsApp">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/></svg>
        </a>
      </div>
    </div>

    <!-- FORM -->
    <div class="ct-form-card">
      <div class="ct-form-title">Send Us a Message</div>
      <form data-cvform="contact" method="post" novalidate>
        <?php wp_nonce_field('medicare_nonce','nonce'); ?>
        <input type="hidden" name="action" value="medicare_contact">

        <div class="form-row">
          <div class="fg" id="fg-name">
            <label for="cv_name">Full Name <span class="req">*</span></label>
            <input type="text" id="cv_name" name="contact_name" placeholder="e.g. James Kamau">
            <div class="error-msg">Please enter your full name</div>
          </div>
          <div class="fg" id="fg-email">
            <label for="cv_email">Email Address <span class="req">*</span></label>
            <input type="email" id="cv_email" name="contact_email" placeholder="e.g. james@email.com">
            <div class="error-msg">Please enter a valid email</div>
          </div>
        </div>

        <div class="form-row">
          <div class="fg" id="fg-phone">
            <label for="cv_phone">Phone / WhatsApp <span class="req">*</span></label>
            <input type="tel" id="cv_phone" name="contact_phone" placeholder="e.g. 0796140021">
            <div class="error-msg">Please enter your phone number</div>
          </div>
          <div class="fg" id="fg-dept">
            <label for="cv_dept">Department <span class="req">*</span></label>
            <select id="cv_dept" name="contact_dept">
              <option value="">Select department...</option>
              <option value="Prescription">Prescription</option>
              <option value="Product Enquiry">Product Enquiry</option>
              <option value="Delivery">Delivery</option>
              <option value="General">General</option>
            </select>
            <div class="error-msg">Please select a department</div>
          </div>
        </div>

        <div class="fg" id="fg-msg">
          <label for="cv_msg">Your Message <span class="req">*</span></label>
          <textarea id="cv_msg" name="contact_msg" placeholder="How can we help you?" style="min-height:110px;resize:vertical;"></textarea>
          <div class="error-msg">Please enter your message (min 5 characters)</div>
        </div>

        <button type="button" class="ct-submit-btn" id="cvSubmitBtn">Send Message</button>

        <div class="ct-toast ct-toast-success" id="cvSuccess" role="alert" aria-live="polite">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Thanks for contacting Family Drugmart! We'll get back to you shortly. For urgent enquiries, WhatsApp us on <a href="https://wa.me/<?php echo esc_attr($ct_wa); ?>" style="color:inherit;text-decoration:underline;font-weight:900;" target="_blank"><?php echo esc_html($ct_phone); ?></a>.</span>
        </div>

        <div class="ct-toast ct-toast-error" id="cvError" role="alert" aria-live="polite">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16"/></svg>
          <span id="cvErrorText"></span>
        </div>
      </form>
    </div>

  </div>

  <!-- FAQ -->
  <div class="ct-faq">
    <div class="ct-faq-head"><h2>Frequently Asked Questions</h2></div>

    <div class="ct-faq-item">
      <div class="ct-faq-q"><span>Contacts</span><span class="ct-faq-icon">+</span></div>
      <div class="ct-faq-a">
        Phone: <a href="https://wa.me/<?php echo esc_attr($ct_wa); ?>" target="_blank" rel="noopener"><?php echo esc_html($ct_phone); ?></a><br>
        Email: <a href="mailto:<?php echo esc_attr($ct_email); ?>"><?php echo esc_html($ct_email); ?></a><br>
        Location: <?php echo esc_html($ct_addr); ?>
      </div>
    </div>

    <div class="ct-faq-item">
      <div class="ct-faq-q"><span>Working Hours</span><span class="ct-faq-icon">+</span></div>
      <div class="ct-faq-a">
        Mon – Fri: 8:30 AM – 6:00 PM<br>
        Sat: 9:00 AM – 1:00 PM<br>
        Sun &amp; Holidays: Closed
      </div>
    </div>

    <div class="ct-faq-item">
      <div class="ct-faq-q"><span>Delivery</span><span class="ct-faq-icon">+</span></div>
      <div class="ct-faq-a">
        We offer same-day delivery within Nairobi for orders placed before 3:00 PM. Orders placed between 3:00 PM and 6:00 PM may still qualify for same-day delivery, subject to location confirmation via WhatsApp. Orders after 6:00 PM are delivered the next morning.
        We deliver outside Nairobi within 1–2 business days. All orders are shipped via a secure cold-chain system to maintain the required temperature and preserve medicine quality.


      </div>
    </div>
  </div>

</div>

<script>
window.addEventListener('load', function () {

  /* FAQ accordion */
  document.querySelectorAll('.ct-faq-q').forEach(function(q){
    q.addEventListener('click', function(){
      var item = q.closest('.ct-faq-item');
      var wasOpen = item.classList.contains('open');
      document.querySelectorAll('.ct-faq-item').forEach(function(i){ i.classList.remove('open'); });
      if (!wasOpen) item.classList.add('open');
    });
  });

  /* Contact form */
  var form = document.querySelector('[data-cvform="contact"]');
  if (!form) return;

  var fresh = form.cloneNode(true);
  form.parentNode.replaceChild(fresh, form);
  form = fresh;

  var successEl = document.getElementById('cvSuccess');
  var errorEl   = document.getElementById('cvError');
  var errorText = document.getElementById('cvErrorText');
  var btn       = document.getElementById('cvSubmitBtn');
  var toastTimer = null, isSending = false;

  var fields = [
    { id:'fg-name',  input:'cv_name',  check:function(v){ return v.trim().length >= 2; } },
    { id:'fg-email', input:'cv_email', check:function(v){ return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()); } },
    { id:'fg-phone', input:'cv_phone', check:function(v){ return v.trim().replace(/\s/g,'').length >= 9; } },
    { id:'fg-dept',  input:'cv_dept',  check:function(v){ return v !== ''; } },
    { id:'fg-msg',   input:'cv_msg',   check:function(v){ return v.trim().length >= 5; } }
  ];

  function showToast(el, ms) {
    clearTimeout(toastTimer);
    successEl.classList.remove('show');
    errorEl.classList.remove('show');
    el.classList.add('show');
    toastTimer = setTimeout(function(){ el.classList.remove('show'); }, ms || 6000);
  }
  function btnLoading() { btn.textContent='Sending…'; btn.disabled=true; isSending=true; }
  function btnReset()   { btn.textContent='Send Message'; btn.disabled=false; isSending=false; }

  function validateField(f, el, fg) {
    var pass = f.check(el.value);
    fg.classList.toggle('valid', pass);
    fg.classList.toggle('invalid', !pass);
    return pass;
  }
  function validateAll() {
    var ok = true;
    fields.forEach(function(f){
      var el=document.getElementById(f.input), fg=document.getElementById(f.id);
      if (el && fg && !validateField(f, el, fg)) ok=false;
    });
    return ok;
  }
  function resetForm() {
    btnReset();
    form.reset();
    fields.forEach(function(f){
      var fg=document.getElementById(f.id);
      if (fg) fg.classList.remove('valid','invalid');
    });
  }

  fields.forEach(function(f){
    var el=document.getElementById(f.input), fg=document.getElementById(f.id);
    if (!el || !fg) return;
    el.addEventListener('blur',   function(){ if (!isSending) validateField(f, el, fg); });
    el.addEventListener('input',  function(){ if (!isSending && fg.classList.contains('invalid')) validateField(f, el, fg); });
    el.addEventListener('change', function(){ if (!isSending && fg.classList.contains('invalid')) validateField(f, el, fg); });
  });

  btn.addEventListener('click', function () {
    if (isSending) return;
    if (!validateAll()) {
      var first = form.querySelector('.fg.invalid');
      if (first) first.scrollIntoView({behavior:'smooth', block:'center'});
      return;
    }
    btnLoading();
    var formData = new FormData(form);
    fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', { method:'POST', body:formData })
      .then(function(r){ return r.text(); })
      .then(function(raw){
        var clean = raw.trim();
        var s = clean.indexOf('{');
        if (s > 0) clean = clean.substring(s);
        var data;
        try { data = JSON.parse(clean); }
        catch(e){
          btnReset();
          errorText.textContent = 'Server error. Please contact us via WhatsApp on <?php echo esc_js($ct_phone); ?>.';
          showToast(errorEl, 8000);
          return;
        }
        if (data.success) {
          resetForm();
          showToast(successEl, 7000);
        } else {
          btnReset();
          errorText.textContent = (data.data && data.data.msg) ? data.data.msg : 'Mail delivery failed. Please contact us via WhatsApp on <?php echo esc_js($ct_phone); ?>.';
          showToast(errorEl, 7000);
        }
      })
      .catch(function(){
        btnReset();
        errorText.textContent = 'Network error. Please check your connection and try again.';
        showToast(errorEl, 7000);
      });
  });

});
</script>

<?php get_footer(); ?>