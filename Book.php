<?php
// Book.php — Main booking form
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Book Event — Everest</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet"/>
  <style>
    :root{
      --bg:#f5f8fe; --text:#0d1117; --muted:#5b6775; --link:#0c63ff; --border:#e6ecf7;
      --right-col:260px; --ink:#0d1117;
      --card:#ffffff; --card-soft:#edf3ff;
      --accent:#284b7a;
    }
    *{box-sizing:border-box}
    html,body{margin:0;padding:0;height:100%}
    body{
      font-family:"Inter",system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
      background:var(--bg); color:var(--text);
      min-height:100vh; display:flex; flex-direction:column;
    }

    /* ===== Header (same as other pages) ===== */
    .header{width:100%; padding:14px 24px; display:grid; gap:16px;
            grid-template-columns:240px 1fr var(--right-col); align-items:center;
            background:linear-gradient(#fafcfe,#f1f5fb); border-bottom:1px solid var(--border)}
    .brand{display:flex;align-items:center;gap:12px;font-weight:800;letter-spacing:.5px;min-width:0}
    .brand-logo{width:44px;height:44px;display:grid;place-items:center;text-decoration:none;flex:0 0 44px}
    .brand-logo img{width:44px;height:44px;display:block}
    .brand h1{font-size:16px;margin:0;line-height:1.05;white-space:nowrap}

    .mast{display:grid;grid-template-rows:auto auto;justify-items:center;align-items:center;row-gap:10px;min-width:0}
    .search{position:relative;width:min(620px,52vw)}
    .search input{width:100%; height:44px; padding:10px 16px 10px 44px; border-radius:999px;
                  background:#fff; border:2px solid #133a60; font-size:14px; color:#0d1117;
                  outline:none; box-shadow:inset 0 0 0 1px rgba(19,58,96,.15); transition:.2s}
    .search input:focus{border-color:#0c63ff; box-shadow:0 0 0 3px rgba(12,99,255,.15)}
    .search svg{position:absolute;left:12px;top:50%;transform:translateY(-50%);
                width:20px;height:20px;stroke:#0d2642;stroke-width:1.8;fill:none;opacity:.9;pointer-events:none}

    .nav{display:flex; align-items:center; width:100%; justify-content:space-evenly;
         gap:clamp(24px,5vw,64px); flex-wrap:nowrap; white-space:nowrap; margin:0; padding:0 12px}
    .nav a{display:inline-flex; align-items:center; gap:6px; padding:10px 14px;
           font-size:15px; text-decoration:none; color:#1f2937; font-weight:600; letter-spacing:.2px}
    .nav a.active{color:var(--link)}

    .right-actions{justify-self:end; width:var(--right-col, 260px); display:flex;
                   align-items:center; justify-content:space-between; gap:24px}
    .toplink,.toplink:link,.toplink:visited{display:inline-flex; align-items:center; gap:6px;
           text-decoration:none; color:var(--link) !important; font-size:18px !important;
           font-weight:700 !important; line-height:1; padding:0}
    .toplink:hover{text-decoration:underline}
    .account{position:relative; display:flex; align-items:center}
    .account-toggle{background:none; border:0; cursor:pointer; font:inherit; color:var(--link);
                    padding:6px 0; display:inline-flex; align-items:center; gap:6px}
    .toplink .caret{ width:16px; height:16px; stroke:currentColor; stroke-width:2; fill:none;
                     transition:transform .15s ease }
    .account .dropdown{ display:none; position:absolute; top:100%; right:0; margin-top:8px;
                        min-width:200px; background:#fff; border:1px solid var(--border);
                        border-radius:10px; box-shadow:0 10px 26px rgba(20,35,57,.12); padding:8px; z-index:50 }
    .account:hover .dropdown, .account:focus-within .dropdown{ display:block }
    .account:focus-within .caret{ transform:rotate(180deg) }
    .dropdown a{ display:flex; align-items:center; gap:8px; padding:10px 12px;
                 border-radius:8px; color:#0d1117; text-decoration:none; font-weight:600; font-size:14px }
    .dropdown a:hover{ background:#f5f8fe }

    /* ===== Main layout ===== */
    .wrap{
      max-width:1180px;     /* a bit wider than other pages */
      margin:32px auto 70px;
      padding:0 20px;
      width:100%;
    }
    .page-title{
      font-family:"Playfair Display",Georgia,serif;
      font-size:46px;
      text-align:center;
      letter-spacing:4px;
      margin:0 0 26px;
    }

    .booking-form{
      background:#ffffff;
      border-radius:18px;
      box-shadow:0 16px 40px rgba(15,23,42,.10);
      border:1px solid #dde4f4;
      padding:28px 28px 32px;
      display:flex;
      flex-direction:column;
      gap:28px;
    }

    .block-title-bar{
      background:#315b96;
      color:#fdfdfd;
      padding:10px 16px;
      border-radius:10px 10px 0 0;
      font-weight:700;
      letter-spacing:1.5px;
      text-align:center;
      text-transform:uppercase;
      font-size:13px;
    }
    .block{
      border-radius:12px;
      border:1px solid #d1d9ea;
      overflow:hidden;
      margin-top:4px;
      background:#f9fbff;
    }
    .block-inner{
      padding:18px 18px 20px;
    }
    .section-question{
      font-weight:700;
      text-align:center;
      margin-bottom:10px;
      font-size:14px;
    }
    .radio-row{
      display:flex;
      justify-content:center;
      gap:32px;
      margin-bottom:16px;
      flex-wrap:wrap;
    }
    .radio-pill{
      display:flex;
      align-items:center;
      gap:8px;
      font-size:13px;
    }

    .subheading{
      background:#315b96;
      color:white;
      padding:6px 14px;
      border-radius:8px;
      font-weight:700;
      font-size:13px;
      margin:10px 0 8px;
      display:inline-block;
    }

    .radio-list{
      display:grid;
      grid-template-columns:1fr;
      gap:6px;
      margin-bottom:10px;
    }
    .radio-option{
      display:flex;
      align-items:flex-start;
      gap:8px;
      font-size:13px;
    }
    .radio-option span{
      color:#4b5563;
    }
    .price-tag{
      font-weight:600;
      color:#0c63ff;
      margin-left:4px;
    }

    /* Customize grid (2 columns x multiple rows) */
    .custom-grid{
      display:grid;
      grid-template-columns:repeat(2,minmax(0,1fr));
      gap:14px;
      margin-top:8px;
    }
    .custom-card{
      background:white;
      border-radius:10px;
      border:1px solid #d6def0;
      padding:10px 12px 12px;
    }
    .custom-title{
      font-weight:700;
      font-size:13px;
      margin-bottom:6px;
    }
    .custom-radio-list{
      display:grid;
      gap:4px;
      font-size:12px;
    }

    /* ===== Bottom form fields & summary ===== */
    .form-bottom{
      display:grid;
      grid-template-columns:minmax(0,2.1fr) 260px;
      gap:22px;
      align-items:flex-start;
      margin-top:6px;
    }
    .field-row{
      display:grid;
      grid-template-columns:repeat(2,minmax(0,1fr));
      gap:14px;
      margin-bottom:10px;
    }
    .field-block{
      display:flex;
      flex-direction:column;
      gap:4px;
      font-size:13px;
    }
    .field-block label{
      font-weight:600;
      font-size:13px;
    }
    .field-block input,
    .field-block textarea{
      padding:8px 10px;
      border-radius:8px;
      border:1px solid #cbd5e1;
      font:inherit;
      resize:vertical;
      min-height:38px;
    }
    .field-block textarea{min-height:70px;}

    .summary-box{
      background:#0f172a;
      color:white;
      border-radius:14px;
      padding:16px 16px 18px;
      display:flex;
      flex-direction:column;
      gap:10px;
      box-shadow:0 14px 30px rgba(15,23,42,.45);
    }
    .summary-box h3{
      margin:0;
      font-size:15px;
      letter-spacing:.8px;
      text-transform:uppercase;
    }
    .summary-amount{
      font-size:24px;
      font-weight:800;
      letter-spacing:.5px;
    }
    .summary-note{
      font-size:11px;
      opacity:.85;
    }
    .btn-book{
      margin-top:6px;
      width:100%;
      border:none;
      padding:10px 14px;
      border-radius:999px;
      background:#22c55e;
      color:#04101f;
      font-weight:700;
      font-size:15px;
      cursor:pointer;
      transition:.18s transform ease, .18s box-shadow ease, .18s background ease;
      box-shadow:0 10px 20px rgba(34,197,94,.35);
    }
    .btn-book:hover{
      transform:translateY(-1px);
      box-shadow:0 14px 26px rgba(34,197,94,.45);
      background:#16a34a;
    }

    /* ===== Footer ===== */
    .site-footer{ background:#2f2f2f; color:#e8e8e8; border-top:1px solid #222; margin-top:auto; width:100% }
    .footer-wrap{ max-width:1120px; margin:0 auto; padding:22px 20px; display:grid;
                  grid-template-columns:1fr 1fr 1fr; gap:24px; align-items:flex-start }
    .site-footer h4{ margin:2px 0 14px; font-weight:700; font-size:20px }
    .footer-col .tagline{ margin-top:10px; font-size:12px; color:#c9c9c9; max-width:240px }
    .socials{ display:flex; gap:12px; align-items:center }
    .icon{ width:36px; height:36px; display:grid; place-items:center;
           border:1px solid #bdbdbd; border-radius:6px; text-decoration:none }
    .icon svg{ width:22px; height:22px; fill:#eaeaea }
    .icon:hover{ background:#3a3a3a }
    .mid{text-align:center}
    .links{ list-style:none; margin:0; padding:0 }
    .links li{ margin:6px 0 }
    .links a{ color:#e8e8e8; text-decoration:none; font-size:12px; letter-spacing:.6px }
    .links a:hover{text-decoration:underline}
    .contact{ list-style:none; margin:0; padding:0 }
    .contact li{ display:flex; align-items:center; gap:10px; margin:8px 0; font-size:13px }
    .contact a{ color:#e8e8e8; text-decoration:none }
    .ci{ display:inline-grid; place-items:center; width:22px; height:22px; border:1px solid #bdbdbd; border-radius:6px }
    .ci svg{ width:14px; height:14px; fill:#eaeaea }
    .copyright{ background:#ffffff; color:#2b2b2b; text-align:center; padding:6px 10px;
                font-size:12px; border-top:1px solid #dcdcdc }

    /* ===== Responsive ===== */
    @media (max-width:980px){
      .header{grid-template-columns:1fr}
      .right-actions{justify-content:center; width:100%}
      .nav{gap:22px; flex-wrap:wrap; white-space:normal}
      .booking-form{padding:18px 16px}
      .custom-grid{grid-template-columns:1fr}
      .form-bottom{grid-template-columns:1fr; }
    }
  </style>
</head>
<body>
<header class="header">
  <div class="brand">
    <a class="brand-logo" href="User_Homepage.php" title="Everest Home">
      <img src="everest_logo.png" alt="Everest logo" width="44" height="44"/>
    </a>
    <h1>EVEREST<br>
      <span style="font-weight:600;font-size:11px;opacity:.7">
        WHERE EVERY BOOKING CLIMBS TO SUCCESS
      </span>
    </h1>
  </div>

  <div class="mast">
    <div class="search" role="search">
      <input type="search" placeholder="Search" aria-label="Search"/>
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="10" cy="10" r="6"></circle>
        <line x1="14.5" y1="14.5" x2="21" y2="21"></line>
      </svg>
    </div>
    <nav class="nav" aria-label="Primary">
      <a href="User_Homepage.php">Home</a>
      <a href="directory.php">Directory</a>
      <a href="Packages.php">Packages</a>
      <a href="Catering_Services.php">Catering Services</a>
      <a href="Contact.php">Contact</a>
      <a href="Gallery.php">Gallery</a>
    </nav>
  </div>

  <div class="right-actions">
    <a class="toplink active" href="Book.php">Book</a>
    <div class="account">
      <button class="toplink account-toggle" type="button" aria-haspopup="menu" aria-expanded="false">
        <?php $acctLabel = $_SESSION['name'] ?? 'Account'; echo htmlspecialchars($acctLabel); ?>
        <svg class="caret" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M7 9l5 5 5-5" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
      <div class="dropdown" role="menu">
        <a class="dropdown-item" href="Account.php" role="menuitem">Account</a>
      </div>
    </div>
  </div>
</header>

<main class="wrap">
  <h1 class="page-title">BOOK EVENT</h1>

  <form class="booking-form" method="post" action="Book.php">
    <!-- ========== PACKAGE EVENTS ========== -->
    <div>
      <div class="block-title-bar">PACKAGE EVENTS</div>
      <div class="block">
        <div class="block-inner">
          <div class="section-question">What type of event are you planning?</div>
          <div class="radio-row">
            <label class="radio-pill">
              <input type="radio" name="pkg_event_type" value="wedding" checked>
              Wedding Event
            </label>
            <label class="radio-pill">
              <input type="radio" name="pkg_event_type" value="debut">
              Debut Event
            </label>
          </div>

          <div>
            <span class="subheading">Package events</span>
            <div class="radio-list">
              <label class="radio-option">
                <input type="radio" name="package_main" value="hearts_forever" data-price="250000">
                <span>Hearts of Forever Wedding Package <span class="price-tag">₱250,000</span></span>
              </label>
              <label class="radio-option">
                <input type="radio" name="package_main" value="stars_eternity" data-price="200000">
                <span>Stars of Eternity Wedding Package <span class="price-tag">₱200,000</span></span>
              </label>
              <label class="radio-option">
                <input type="radio" name="package_main" value="midnight_rose" data-price="148000">
                <span>Midnight Rose Debut Package <span class="price-tag">₱148,000</span></span>
              </label>
              <label class="radio-option">
                <input type="radio" name="package_main" value="enchanted_garden" data-price="188000">
                <span>Enchanted Garden Debut Package <span class="price-tag">₱188,000</span></span>
              </label>
            </div>
          </div>

          <div>
            <span class="subheading">Catering services</span>
            <div class="radio-list">
              <label class="radio-option">
                <input type="radio" name="package_catering" value="bronze" data-price="41000">
                <span>Catering Package – Bronze <span class="price-tag">₱41,000</span></span>
              </label>
              <label class="radio-option">
                <input type="radio" name="package_catering" value="silver" data-price="55000">
                <span>Catering Package – Silver <span class="price-tag">₱55,000</span></span>
              </label>
              <label class="radio-option">
                <input type="radio" name="package_catering" value="gold" data-price="70000">
                <span>Catering Package – Gold <span class="price-tag">₱70,000</span></span>
              </label>
              <label class="radio-option">
                <input type="radio" name="package_catering" value="elite" data-price="90000">
                <span>Catering Package – Elite <span class="price-tag">₱90,000</span></span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ========== CUSTOMIZE EVENT ========== -->
    <div>
      <div class="block-title-bar">CUSTOMIZE EVENT</div>
      <div class="block">
        <div class="block-inner">
          <div class="section-question">What type of event are you planning?</div>
          <div class="radio-row">
            <label class="radio-pill">
              <input type="radio" name="custom_event_type" value="wedding" checked>
              Wedding Event
            </label>
            <label class="radio-pill">
              <input type="radio" name="custom_event_type" value="debut">
              Debut Event
            </label>
          </div>

          <div class="custom-grid">
            <!-- Venue -->
            <div class="custom-card">
              <div class="custom-title">Venue</div>
              <div class="custom-radio-list">
                <label><input type="radio" name="venue" value="hyatt" data-price="90000"> Hyatt Regency Maui Resort</label>
                <label><input type="radio" name="venue" value="kauai" data-price="100000"> Kaua'i Wedding Venue</label>
                <label><input type="radio" name="venue" value="alexandrite" data-price="40000"> The Alexandrite Resort</label>
                <label><input type="radio" name="venue" value="golden_palace" data-price="100000"> The Golden Palace</label>
              </div>
            </div>

            <!-- Photos & Videos -->
            <div class="custom-card">
              <div class="custom-title">Photos &amp; Videos</div>
              <div class="custom-radio-list">
                <label><input type="radio" name="pv" value="glee" data-price="20000"> GLEE Package</label>
                <label><input type="radio" name="pv" value="euphoria" data-price="25000"> EUPHORIA Package</label>
                <label><input type="radio" name="pv" value="bliss" data-price="30000"> BLISS Package</label>
                <label><input type="radio" name="pv" value="custom" data-price="0"> Customized coverage</label>
              </div>
            </div>

            <!-- Souvenirs -->
            <div class="custom-card">
              <div class="custom-title">Souvenirs</div>
              <div class="custom-radio-list">
                <label><input type="radio" name="souvenir" value="token" data-price="8000"> TOKEN Package</label>
                <label><input type="radio" name="souvenir" value="classic" data-price="15000"> CLASSIC Keepsake Package</label>
                <label><input type="radio" name="souvenir" value="premium" data-price="28000"> PREMIUM Signature Package</label>
                <label><input type="radio" name="souvenir" value="none" data-price="0"> No souvenirs</label>
              </div>
            </div>

            <!-- Event Styling -->
            <div class="custom-card">
              <div class="custom-title">Event Styling</div>
              <div class="custom-radio-list">
                <label><input type="radio" name="styling" value="aura" data-price="20000"> AURA Styling Package</label>
                <label><input type="radio" name="styling" value="elegance" data-price="30000"> ELEGANCE Styling Package</label>
                <label><input type="radio" name="styling" value="grand_luxe" data-price="45000"> GRAND LUXE Package</label>
                <label><input type="radio" name="styling" value="none" data-price="0"> Minimal styling / venue only</label>
              </div>
            </div>

            <!-- Elegant Gown -->
            <div class="custom-card">
              <div class="custom-title">Elegant Gown</div>
              <div class="custom-radio-list">
                <label><input type="radio" name="gown" value="starter" data-price="15000"> Starter Elegance Package</label>
                <label><input type="radio" name="gown" value="classic" data-price="25000"> Classic Bridal Package</label>
                <label><input type="radio" name="gown" value="signature" data-price="40000"> Signature Couture Package</label>
                <label><input type="radio" name="gown" value="own_gown" data-price="0"> Using own gown</label>
              </div>
            </div>

            <!-- Hair & Make-up -->
            <div class="custom-card">
              <div class="custom-title">Hair and Make-up</div>
              <div class="custom-radio-list">
                <label><input type="radio" name="hmua" value="classic" data-price="10000"> Classic Bridal / Debut Look</label>
                <label><input type="radio" name="hmua" value="premium" data-price="15000"> Premium Airbrush Package</label>
                <label><input type="radio" name="hmua" value="entourage" data-price="22000"> Bride + 3 Entourage</label>
                <label><input type="radio" name="hmua" value="own_hmua" data-price="0"> Own HMUA</label>
              </div>
            </div>

            <!-- Catering for custom -->
            <div class="custom-card" style="grid-column:1 / -1;">
              <div class="custom-title">Catering services (Custom)</div>
              <div class="custom-radio-list">
                <label><input type="radio" name="catering_custom" value="bronze" data-price="41000"> Bronze</label>
                <label><input type="radio" name="catering_custom" value="silver" data-price="55000"> Silver</label>
                <label><input type="radio" name="catering_custom" value="gold" data-price="70000"> Gold</label>
                <label><input type="radio" name="catering_custom" value="none" data-price="0"> Not included / decided later</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ========== BOTTOM FIELDS & SUMMARY ========== -->
    <div class="form-bottom">
      <div>
        <div class="field-row">
          <div class="field-block">
            <label for="attendees">Number of attendees</label>
            <input type="number" id="attendees" name="attendees" min="1" placeholder="e.g. 100">
          </div>
          <div class="field-block">
            <label for="event_name">Event Name</label>
            <input type="text" id="event_name" name="event_name" placeholder="e.g. Eric & Jane Wedding">
          </div>
        </div>

        <div class="field-row">
          <div class="field-block">
            <label for="event_date">Desired event date</label>
            <input type="date" id="event_date" name="event_date">
          </div>
          <div class="field-block">
            <label for="contact_number">Phone Number</label>
            <input type="tel" id="contact_number" name="contact_number" placeholder="09XXXXXXXXX">
          </div>
        </div>

        <div class="field-block">
          <label for="comments">Comment or Special request</label>
          <textarea id="comments" name="comments" placeholder="Tell us about your theme, special requests, or schedule notes..."></textarea>
        </div>
      </div>

      <aside class="summary-box">
        <h3>Estimated Total</h3>
        <div class="summary-amount" id="totalAmount">₱0.00</div>
        <p class="summary-note">
          This is an estimate based on your selected packages. Final pricing will be confirmed
          by our event coordinator.
        </p>
        <button type="submit" class="btn-book">Book Now</button>
      </aside>
    </div>
  </form>
</main>

<footer class="site-footer">
  <div class="footer-wrap">
    <div class="footer-col">
      <h4>Social Media</h4>
      <div class="socials">
        <a href="#" aria-label="Tumblr" class="icon"><svg viewBox="0 0 24 24"><path d="M14.5 20.8c-3.2 0-4.6-2-4.6-4.3v-4.6H7.5V9c1.7-.6 2.5-1.9 2.9-3.4h1.7v3h2.8v2.3h-2.8v4.3c0 1 .5 1.9 1.9 1.9.5 0 1.2-.1 1.7-.4v2.2c-.6.6-1.8 1-3.2 1z"/></svg></a>
        <a href="#" aria-label="X" class="icon"><svg viewBox="0 0 24 24"><path d="M3 3h3.7l5.2 6.9L16.9 3H21l-7.1 8.9L21 21h-3.7l-5.6-7.5L7.1 21H3l7.8-9.8L3 3z"/></svg></a>
        <a href="#" aria-label="Instagram" class="icon"><svg viewBox="0 0 24 24"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7zm5 3.5A5.5 5.5 0 1 1 6.5 13 5.5 5.5 0 0 1 12 7.5zm0 2A3.5 3.5 0 1 0 15.5 13 3.5 3.5 0 0 0 12 9.5zm6-2.6a1 1 0 1 1-1 1 1 1 0 0 1 1-1z"/></svg></a>
      </div>
      <p class="tagline">Event Management System • Your way to book an event</p>
    </div>

    <div class="footer-col mid">
      <h4>Quick Links</h4>
      <ul class="links">
        <li><a href="#about">ABOUT US</a></li>
        <li><a href="#contact">CONTACT US</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Contact Info</h4>
      <ul class="contact">
        <li><span class="ci"><svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 0 0-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 14.5 9 2.5 2.5 0 0 1 12 11.5z"/></svg></span> Metro Manila, Philippines</li>
        <li><span class="ci"><svg viewBox="0 0 24 24"><path d="M2 5l10 7 10-7v12H2zM12 10L2 5h20z"/></svg></span> <a href="mailto:Everest@email.com">Everest@email.com</a></li>
        <li><span class="ci"><svg viewBox="0 0 24 24"><path d="M6.6 10.8c1.4 2.8 3.8 5.3 6.6 6.6l2.2-2.2c.3-.3.8-.4 1.2-.3 1 .3 2 .5 3.1 .5 .7 0 1.3 .6 1.3 1.3v3.3c0 .7 -.6 1.3 -1.3 1.3C9.4 21.3 2.7 14.6 2.7 6.3c0 -.7 .6 -1.3 1.3 -1.3H7c.7 0 1.3 .6 1.3 1.3 0 1.1 .2 2.1 .5 3.1 .1 .4 0 .9 -.3 1.2l-1.9 2.2z"/></svg></span> 12345678901</li>
      </ul>
    </div>
  </div>
  <div class="copyright">©Copyright <?php echo date('Y'); ?>, Everest</div>
</footer>

<script>
// Simple total-price calculator based on checked radios with data-price
function updateTotal() {
  let total = 0;
  document.querySelectorAll('input[type="radio"][data-price]:checked').forEach(el => {
    const val = parseInt(el.dataset.price || "0", 10);
    if (!Number.isNaN(val)) total += val;
  });

  const elTotal = document.getElementById('totalAmount');
  const formatted = total.toLocaleString('en-PH', {
    style: 'currency',
    currency: 'PHP',
    minimumFractionDigits: 2
  });
  elTotal.textContent = formatted;
}

document.querySelectorAll('input[type="radio"][data-price]').forEach(el => {
  el.addEventListener('change', updateTotal);
});

// initialize on load (if some defaults are checked)
updateTotal();
</script>
</body>
</html>
