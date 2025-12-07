<?php
// Packages.php — Wedding & Debut Packages (single scrollable page)
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Wedding &amp; Debut Packages — Everest</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet"/>
  <style>
    :root{
      --bg:#f5f8fe; --text:#0d1117; --muted:#5b6775; --link:#0c63ff; --border:#e6ecf7;
      --right-col:260px; --card:#ffffff;
    }
    *{box-sizing:border-box}
    html,body{margin:0;padding:0;height:100%}
    body{
      font-family:"Inter",system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
      background:var(--bg); color:var(--text);
      min-height:100vh; display:flex; flex-direction:column;
    }

    /* ===== Header (same pattern as other pages) ===== */
    .header{
      width:100%; padding:14px 24px; display:grid; gap:16px;
      grid-template-columns:240px 1fr var(--right-col); align-items:center;
      background:linear-gradient(#fafcfe,#f1f5fb); border-bottom:1px solid var(--border);
    }
    .brand{display:flex;align-items:center;gap:12px;font-weight:800;letter-spacing:.5px;min-width:0}
    .brand-logo{width:44px;height:44px;display:grid;place-items:center;text-decoration:none;flex:0 0 44px}
    .brand-logo img{width:44px;height:44px;display:block}
    .brand h1{font-size:16px;margin:0;line-height:1.05;white-space:nowrap}

    .mast{display:grid;grid-template-rows:auto auto;justify-items:center;align-items:center;row-gap:10px;min-width:0}
    .search{position:relative;width:min(620px,52vw)}
    .search input{
      width:100%; height:44px; padding:10px 16px 10px 44px; border-radius:999px;
      background:#fff; border:2px solid #133a60; font-size:14px; color:#0d1117;
      outline:none; box-shadow:inset 0 0 0 1px rgba(19,58,96,.15); transition:.2s;
    }
    .search input:focus{border-color:#0c63ff; box-shadow:0 0 0 3px rgba(12,99,255,.15)}
    .search svg{
      position:absolute;left:12px;top:50%;transform:translateY(-50%);
      width:20px;height:20px;stroke:#0d2642;stroke-width:1.8;fill:none;opacity:.9;pointer-events:none;
    }

    .nav{
      display:flex; align-items:center; width:100%; justify-content:space-evenly;
      gap:clamp(24px,5vw,64px); flex-wrap:nowrap; white-space:nowrap; margin:0; padding:0 12px;
    }
    .nav a{
      display:inline-flex; align-items:center; gap:6px; padding:10px 14px;
      font-size:15px; text-decoration:none; color:#1f2937; font-weight:600; letter-spacing:.2px;
    }
    .nav a.active{color:var(--link)}

    .right-actions{
      justify-self:end; width:var(--right-col,260px); display:flex;
      align-items:center; justify-content:space-between; gap:24px;
    }
    .toplink,.toplink:link,.toplink:visited{
      display:inline-flex; align-items:center; gap:6px;
      text-decoration:none; color:var(--link) !important;
      font-size:18px !important; font-weight:700 !important; line-height:1; padding:0;
    }
    .toplink:hover{text-decoration:underline}
    .account{position:relative; display:flex; align-items:center}
    .account-toggle{
      background:none; border:0; cursor:pointer; font:inherit; color:var(--link);
      padding:6px 0; display:inline-flex; align-items:center; gap:6px;
    }
    .caret{ width:16px; height:16px; stroke:currentColor; stroke-width:2; fill:none; transition:transform .15s ease }
    .account .dropdown{
      display:none; position:absolute; top:100%; right:0; margin-top:8px;
      min-width:200px; background:#fff; border:1px solid var(--border);
      border-radius:10px; box-shadow:0 10px 26px rgba(20,35,57,.12); padding:8px; z-index:50;
    }
    .account:hover .dropdown, .account:focus-within .dropdown{display:block}
    .account:focus-within .caret{transform:rotate(180deg)}
    .dropdown a{
      display:flex; align-items:center; gap:8px; padding:10px 12px;
      border-radius:8px; color:#0d1117; text-decoration:none; font-weight:600; font-size:14px;
    }
    .dropdown a:hover{background:#f5f8fe}

    /* ===== Main layout ===== */
    main{max-width:1120px; margin:0 auto; padding:32px 20px 80px;}

    .page-title{
      text-align:center; margin:12px 0 10px;
      font-family:"Playfair Display",Georgia,serif;
      font-size:clamp(32px,4vw,44px);
      letter-spacing:2px;
    }
    .page-sub{
      text-align:center;
      font-size:14px;
      color:#4b5563;
      max-width:560px;
      margin:0 auto 26px;
    }

    /* quick anchor nav inside page */
    .pkg-anchor-nav{
      display:flex; flex-wrap:wrap; justify-content:center; gap:10px;
      margin-bottom:28px;
    }
    .pkg-anchor-nav a{
      text-decoration:none;
      font-size:12px;
      padding:6px 10px;
      border-radius:999px;
      border:1px solid #c7d2fe;
      background:#e5edff;
      color:#1f2937;
      font-weight:600;
    }
    .pkg-anchor-nav a:hover{background:#d4e2ff}

    .pkg-section{
      margin-bottom:60px;
      background:#f9fbff;
      border-radius:20px;
      box-shadow:0 10px 30px rgba(15,23,42,.08);
      border:1px solid #dde5f6;
      overflow:hidden;
    }

    .pkg-header{
      padding:26px 26px 18px;
      text-align:center;
    }
    .pkg-name{
      font-family:"Playfair Display",Georgia,serif;
      font-size:22px;
      margin:0 0 8px;
    }
    .pkg-price{
      font-weight:700;
      margin:0 0 10px;
      font-size:14px;
    }
    .pkg-desc{
      font-size:13px;
      color:#4b5563;
      max-width:620px;
      margin:0 auto;
      line-height:1.6;
    }

    .pkg-photos{
      display:grid;
      grid-template-columns:repeat(4,minmax(0,1fr));
      gap:0;
      border-top:1px solid #dde5f6;
      border-bottom:1px solid #dde5f6;
    }
    .pkg-photos img{
      width:100%;
      height:170px;
      object-fit:cover;
      display:block;
    }

    .pkg-body{
      padding:24px 30px 26px;
      background:#fff;
    }
    .pkg-body-title{
      text-align:center;
      font-weight:700;
      margin:0 0 18px;
      font-size:16px;
    }
    .pkg-columns{
      display:grid;
      grid-template-columns:1.1fr 1fr;
      gap:36px;
      font-size:13px;
      line-height:1.55;
    }
    .pkg-col h4{
      margin:0 0 6px;
      font-size:13px;
      font-weight:700;
    }
    .pkg-col ul{
      margin:0 0 8px;
      padding-left:16px;
    }
    .pkg-bottom-note{
      text-align:right;
      margin-top:4px;
      font-size:12px;
      color:#4b5563;
      font-style:italic;
    }

    .back-top{
      text-align:right;
      margin-top:10px;
      font-size:12px;
    }
    .back-top a{
      color:#0c63ff;
      text-decoration:none;
      font-weight:600;
      letter-spacing:.5px;
    }
    .back-top a:hover{text-decoration:underline}

    /* ===== Footer ===== */
    .site-footer{
      background:#2f2f2f; color:#e8e8e8;
      border-top:1px solid #222; margin-top:auto; width:100%;
    }
    .footer-wrap{
      max-width:1120px; margin:0 auto; padding:22px 20px;
      display:grid; grid-template-columns:1fr 1fr 1fr; gap:24px; align-items:flex-start;
    }
    .site-footer h4{margin:2px 0 14px; font-weight:700; font-size:20px}
    .footer-col .tagline{margin-top:10px; font-size:12px; color:#c9c9c9; max-width:240px}
    .socials{display:flex; gap:12px; align-items:center}
    .icon{
      width:36px; height:36px; display:grid; place-items:center;
      border:1px solid #bdbdbd; border-radius:6px; text-decoration:none;
    }
    .icon svg{width:22px;height:22px;fill:#eaeaea}
    .icon:hover{background:#3a3a3a}
    .mid{text-align:center}
    .links{list-style:none;margin:0;padding:0}
    .links li{margin:6px 0}
    .links a{color:#e8e8e8;text-decoration:none;font-size:12px;letter-spacing:.6px}
    .links a:hover{text-decoration:underline}
    .contact{list-style:none;margin:0;padding:0}
    .contact li{display:flex;align-items:center;gap:10px;margin:8px 0;font-size:13px}
    .contact a{color:#e8e8e8;text-decoration:none}
    .ci{
      display:inline-grid; place-items:center; width:22px; height:22px;
      border:1px solid #bdbdbd; border-radius:6px;
    }
    .ci svg{width:14px;height:14px;fill:#eaeaea}
    .copyright{
      background:#ffffff; color:#2b2b2b; text-align:center;
      padding:6px 10px; font-size:12px; border-top:1px solid #dcdcdc;
    }

    /* ===== Responsive ===== */
    @media (max-width:980px){
      .header{grid-template-columns:1fr}
      .right-actions{justify-content:center;width:100%}
      .nav{gap:22px;flex-wrap:wrap;white-space:normal}
      .pkg-photos img{height:130px}
      .pkg-columns{grid-template-columns:1fr}
      .pkg-section{margin-bottom:40px}
    }
  </style>
</head>
<body id="top">
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
      <a class="active" href="Packages.php">Packages</a>
      <a href="Catering_Services.php">Catering Services</a>
      <a href="Contact.php">Contact</a>
      <a href="Gallery.php">Gallery</a>
    </nav>
  </div>

  <div class="right-actions">
    <a class="toplink" href="Book.php">Book</a>
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

<main>
  <h1 class="page-title">WEDDING &amp; DEBUT PACKAGES</h1>
  <p class="page-sub">
    All-in celebration bundles that combine venue, catering, styling, photo &amp; video, gown,
    souvenirs, and more — designed to keep planning simple and stress-free.
  </p>

  <div class="pkg-anchor-nav">
    <a href="#stars">Stars of Eternity</a>
    <a href="#hearts">Hearts of Forever</a>
    <a href="#midnight">Midnight Rose Debut</a>
    <a href="#enchanted">Enchanted Garden Debut</a>
  </div>

  <!-- ===== Stars of Eternity Wedding Package ===== -->
  <section id="stars" class="pkg-section">
    <div class="pkg-header">
      <h2 class="pkg-name">Stars of Eternity Wedding Package</h2>
      <p class="pkg-price">Php 200k All-in Complete Promo</p>
      <p class="pkg-desc">
        Introducing the “Stars of Eternity” package for 200k: catering for 100 guests, elegant cake,
        100 souvenirs, flowers, RTW gown, bridesmaid dresses, make-up, photo &amp; video, and a choice
        of venue at Hyatt Regency Maui Resort or Kaua’i Wedding Venue.
      </p>
    </div>

    <div class="pkg-photos">
      <img src="stars1.jpg" alt="Stars of Eternity venue styling 1">
      <img src="stars2.jpg" alt="Stars of Eternity venue styling 2">
      <img src="stars3.jpg" alt="Stars of Eternity venue styling 3">
      <img src="stars4.jpg" alt="Stars of Eternity venue styling 4">
    </div>

    <div class="pkg-body">
      <h3 class="pkg-body-title">Bridal Package Inclusions</h3>
      <div class="pkg-columns">
        <div class="pkg-col">
          <h4>Affordable Catering Package 100 pax</h4>
          <ul>
            <li>Rice, pasta soup, vegetables</li>
            <li>3 main course (chicken, fish and pork or beef)</li>
            <li>Unlimited iced tea or drinks</li>
            <li>Complete catering set-up</li>
            <li>Couple’s table &amp; presidential table</li>
            <li>Cake/gift and registration table</li>
            <li>1 bottle of red wine</li>
          </ul>

          <h4>Wedding Cake</h4>
          <ul>
            <li>Three-tier cake top, edible</li>
            <li>Sounds and light system</li>
            <li>LED wall 12ft x 9ft</li>
          </ul>

          <h4>Wedding Souvenir</h4>
          <ul>
            <li>100 pieces (upon availability)</li>
          </ul>

          <h4>Photo and Video Highlights Coverage Package</h4>
          <ul>
            <li>Photo coverage – 1 photographer</li>
            <li>Video coverage – 1 videographer</li>
            <li>3–5 mins MTV-style wedding video highlights</li>
            <li>Prenup photoshoot session (4 hours, 25–50 images)</li>
          </ul>
        </div>

        <div class="pkg-col">
          <h4>Elegant Bridal Gown (Owned)</h4>
          <ul>
            <li>A choice from our practical collections</li>
            <li>Ready to wear</li>
          </ul>

          <h4>Dress for Bridesmaids (Owned)</h4>
          <ul>
            <li>Six elegant boho dresses with headdress</li>
          </ul>

          <h4>Hair and Make-up Service Package</h4>
          <ul>
            <li>Traditional wedding make-up</li>
          </ul>

          <h4>FREE Wedding Venue at Quezon Ave</h4>
          <ul>
            <li>Choice of Hyatt Regency Maui Resort or Kaua’i Wedding Venue</li>
            <li>Elegant styling included</li>
            <li>Three (3) hours rental venue</li>
            <li>Fully air-conditioned</li>
          </ul>
        </div>
      </div>

      <p class="pkg-bottom-note">
        For any add-on pax, Php 1,500 per head &mdash; minimum of 25 pax.
      </p>
    </div>
  </section>

  <!-- ===== Hearts of Forever Wedding Package ===== -->
  <section id="hearts" class="pkg-section">
    <div class="pkg-header">
      <h2 class="pkg-name">Hearts of Forever Wedding Package</h2>
      <p class="pkg-price">Php 250k All-in Complete Promo</p>
      <p class="pkg-desc">
        The “Hearts of Forever” package upgrades your reception with premium menu selections,
        enhanced styling, and the same all-in coverage for 100 guests — perfect for couples
        who want a more luxurious feel while keeping everything in one bundle.
      </p>
    </div>

    <div class="pkg-photos">
      <img src="hearts1.jpg" alt="Hearts of Forever styling 1">
      <img src="hearts2.jpg" alt="Hearts of Forever styling 2">
      <img src="hearts3.jpg" alt="Hearts of Forever styling 3">
      <img src="hearts4.jpg" alt="Hearts of Forever styling 4">
    </div>

    <div class="pkg-body">
      <h3 class="pkg-body-title">Bridal Package Inclusions</h3>
      <div class="pkg-columns">
        <div class="pkg-col">
          <h4>Affordable Catering Package 100 pax</h4>
          <ul>
            <li>Rice, pasta soup, vegetables</li>
            <li>4 main course selections</li>
            <li>Dessert buffet</li>
            <li>Unlimited iced tea or drinks</li>
            <li>Complete catering set-up</li>
            <li>Couple’s table &amp; presidential table</li>
            <li>Cake/gift and registration table</li>
            <li>1 bottle of red wine</li>
          </ul>

          <h4>Wedding Cake</h4>
          <ul>
            <li>Three-tier premium cake, edible</li>
            <li>Upgraded lights and sound system</li>
            <li>LED wall 12ft x 9ft</li>
          </ul>

          <h4>Wedding Souvenir</h4>
          <ul>
            <li>100 pieces (upgraded designs, subject to availability)</li>
          </ul>

          <h4>Photo and Video Highlights Coverage Package</h4>
          <ul>
            <li>Photo coverage – 1 photographer</li>
            <li>Video coverage – 1 videographer</li>
            <li>3–5 mins MTV-style wedding video highlights</li>
            <li>Prenup photoshoot session (4 hours, 25–50 images)</li>
          </ul>
        </div>

        <div class="pkg-col">
          <h4>Elegant Bridal Gown (Owned)</h4>
          <ul>
            <li>Choice from our premium bridal collections</li>
            <li>Ready to wear, with detailed lace/beadwork</li>
          </ul>

          <h4>Dress for Bridesmaids (Owned)</h4>
          <ul>
            <li>Six coordinated gowns with accessories</li>
          </ul>

          <h4>Hair and Make-up Service Package</h4>
          <ul>
            <li>Traditional wedding make-up with retouch</li>
          </ul>

          <h4>FREE Wedding Venue at Quezon Ave</h4>
          <ul>
            <li>Choice of Hyatt Regency Maui Resort or Kaua’i Wedding Venue</li>
            <li>Enhanced styling and table details</li>
            <li>Three (3) hours rental venue</li>
            <li>Fully air-conditioned</li>
          </ul>
        </div>
      </div>

      <p class="pkg-bottom-note">
        For any add-on pax, Php 1,500 per head &mdash; minimum of 25 pax.
      </p>
    </div>
  </section>

  <!-- ===== Midnight Rose Debut Package ===== -->
  <section id="midnight" class="pkg-section">
    <div class="pkg-header">
      <h2 class="pkg-name">Midnight Rose Debut Package</h2>
      <p class="pkg-price">Php 148k All-in Complete Promo</p>
      <p class="pkg-desc">
        A complete 18th-birthday experience: catering for 100 guests, debut styling, photo &amp; video,
        gown rental, 18 roses and candles, coordinators, and a free venue — all in one themed package.
      </p>
    </div>

    <div class="pkg-photos">
      <img src="midnight1.jpg" alt="Midnight Rose debut styling 1">
      <img src="midnight2.jpg" alt="Midnight Rose debut styling 2">
      <img src="midnight3.jpg" alt="Midnight Rose debut styling 3">
      <img src="midnight4.jpg" alt="Midnight Rose debut styling 4">
    </div>

    <div class="pkg-body">
      <h3 class="pkg-body-title">Debut Package Inclusions</h3>
      <div class="pkg-columns">
        <div class="pkg-col">
          <h4>Affordable Catering Package 100 pax</h4>
          <ul>
            <li>Rice, pasta, soup and vegetables</li>
            <li>3 main course (pork, chicken and fish)</li>
            <li>Unlimited iced tea or drinks</li>
            <li>Complete catering set-up</li>
            <li>Cake/gift and registration table</li>
            <li>Presidential table</li>
            <li>Tables and chairs</li>
          </ul>

          <h4>Elegant Birthday Cake</h4>
          <ul>
            <li>Three-tier cake, top edible</li>
          </ul>

          <h4>Photo and Video Coverage Package</h4>
          <ul>
            <li>1 photographer</li>
            <li>1 videographer</li>
            <li>3–5 mins debut highlights video</li>
          </ul>

          <h4>Elegant Debutant Gown (Owned)</h4>
          <ul>
            <li>Choice from our practical collections</li>
            <li>Ready to wear</li>
          </ul>

          <h4>On the Day Coordinators</h4>
          <ul>
            <li>Two (2) staff</li>
          </ul>
        </div>

        <div class="pkg-col">
          <h4>On the Day Coordinators</h4>
          <ul>
            <li>Timeline management and basic program flow</li>
          </ul>

          <h4>Hair and Make-up Service Package</h4>
          <ul>
            <li>Traditional make-up for debutant</li>
          </ul>

          <h4>18 Roses and Candles</h4>
          <ul>
            <li>Basic coordination and cueing for 18s program</li>
          </ul>

          <h4>FREE Debut Venue (Events Place)</h4>
          <ul>
            <li>The Alexandrite Resort (max 200 pax) or</li>
            <li>The Golden Palace (max 300 pax)</li>
            <li>Three (3) hours rental venue</li>
          </ul>
        </div>
      </div>

      <p class="pkg-bottom-note">
        For any add-on pax, Php 1,250 per head &mdash; minimum of 25 pax.
      </p>
    </div>
  </section>

  <!-- ===== Enchanted Garden Debut Package ===== -->
  <section id="enchanted" class="pkg-section">
    <div class="pkg-header">
      <h2 class="pkg-name">Enchanted Garden Debut Package</h2>
      <p class="pkg-price">Php 188k All-in Complete Promo</p>
      <p class="pkg-desc">
        A garden-themed debut package with lush styling, full catering, gown, coordinators, and
        complete 18s program support — ideal for outdoor-inspired celebrations with a magical feel.
      </p>
    </div>

    <div class="pkg-photos">
      <img src="enchanted1.jpg" alt="Enchanted Garden debut styling 1">
      <img src="enchanted2.jpg" alt="Enchanted Garden debut styling 2">
      <img src="enchanted3.jpg" alt="Enchanted Garden debut styling 3">
      <img src="enchanted4.jpg" alt="Enchanted Garden debut styling 4">
    </div>

    <div class="pkg-body">
      <h3 class="pkg-body-title">Debut Package Inclusions</h3>
      <div class="pkg-columns">
        <div class="pkg-col">
          <h4>Affordable Catering Package 100 pax</h4>
          <ul>
            <li>Rice, pasta, soup and vegetables</li>
            <li>3 main course (pork, chicken and fish)</li>
            <li>Unlimited iced tea or drinks</li>
            <li>Complete catering set-up</li>
            <li>Cake/gift and registration table</li>
            <li>Presidential table</li>
            <li>Tables and chairs</li>
          </ul>

          <h4>Elegant Birthday Cake</h4>
          <ul>
            <li>Three-tier cake, top edible</li>
          </ul>

          <h4>Photo and Video Coverage Package</h4>
          <ul>
            <li>1 photographer</li>
            <li>1 videographer</li>
            <li>3–5 mins debut highlights video</li>
          </ul>

          <h4>Elegant Debutant Gown (Owned)</h4>
          <ul>
            <li>Choice from our practical collections</li>
            <li>Ready to wear</li>
          </ul>

          <h4>On the Day Coordinators</h4>
          <ul>
            <li>Two (2) staff</li>
          </ul>
        </div>

        <div class="pkg-col">
          <h4>Hair and Make-up Service Package</h4>
          <ul>
            <li>Traditional make-up for debutant</li>
          </ul>

          <h4>18 Roses and Candles</h4>
          <ul>
            <li>Basic coordination and cueing for 18s program</li>
          </ul>

          <h4>FREE Debut Venue (Events Place)</h4>
          <ul>
            <li>The Alexandrite Resort (max 200 pax) or</li>
            <li>The Golden Palace (max 300 pax)</li>
            <li>Three (3) hours rental venue</li>
          </ul>
        </div>
      </div>

      <p class="pkg-bottom-note">
        For any add-on pax, Php 1,250 per head &mdash; minimum of 25 pax.
      </p>
    </div>
  </section>

  <div class="back-top">
    <a href="#top">BACK TO TOP</a>
  </div>
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
        <li><a href="#top">BACK TO TOP</a></li>
        <li><a href="Contact.php">CONTACT US</a></li>
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
</body>
</html>
