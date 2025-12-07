<?php
// Catering_Services.php — standalone hard-coded page
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Catering Services — Everest Events</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet"/>
  <style>
    :root{
      --bg:#f5f8fe; --text:#0d1117; --muted:#5b6775; --link:#0c63ff; --border:#e6ecf7;
      --accent:#6d28d9; --right-col:260px; --toplink-size:18px;
    }
    *{box-sizing:border-box}
    html,body{margin:0;padding:0;height:100%}
    body{
      font-family:"Inter",system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
      background:var(--bg); color:var(--text);
      min-height:100vh; display:flex; flex-direction:column;
    }

    /* ===== Header (logo | centered mast | right buttons) ===== */
    .header{
      width:100%; padding:14px 24px;
      display:grid; gap:16px;
      grid-template-columns:240px 1fr var(--right-col);
      align-items:center;
      background:linear-gradient(#fafcfe,#f1f5fb);
      border-bottom:1px solid #e6ecf7;
    }
    .brand{display:flex;align-items:center;gap:12px;font-weight:800;letter-spacing:.5px;min-width:0}
    .brand-logo{width:44px;height:44px;display:grid;place-items:center;text-decoration:none;flex:0 0 44px}
    .brand-logo img{width:44px;height:44px;display:block}
    .brand h1{font-size:16px;margin:0;line-height:1.05;white-space:nowrap}

    .mast{display:grid;grid-template-rows:auto auto;justify-items:center;align-items:center;row-gap:10px;min-width:0}

    .search{position:relative;width:min(620px,52vw)}
    .search input{
      width:100%; height:44px; padding:10px 16px 10px 44px;
      border-radius:999px; background:#fff; border:2px solid #133a60;
      font-size:14px; color:#0d1117; outline:none;
      box-shadow:inset 0 0 0 1px rgba(19,58,96,.15); transition:.2s;
    }
    .search input:focus{border-color:#0c63ff; box-shadow:0 0 0 3px rgba(12,99,255,.15)}
    .search svg{position:absolute;left:12px;top:50%;transform:translateY(-50%);width:20px;height:20px;stroke:#0d2642;stroke-width:1.8;fill:none;opacity:.9;pointer-events:none}

    /* Wide nav */
    .nav{
      display:flex; align-items:center;
      width:100%; max-width:none; justify-self:stretch;
      justify-content:space-evenly; gap:clamp(24px,5vw,64px);
      flex-wrap:nowrap; white-space:nowrap; margin:0; padding:0 12px;
    }
    .nav a{
      display:inline-flex; align-items:center; gap:6px;
      padding:10px 14px; font-size:15px;
      text-decoration:none; color:#1f2937; font-weight:600; letter-spacing:.2px;
    }
    .nav a.active{color:var(--link)}

    /* Right: Book + Account (CSS-only dropdown) */
    .right-actions{
      justify-self:end; width:var(--right-col, 260 px);
      display:flex; align-items:center; justify-content:space-between; gap: 24px;
    }
    .toplink,
	.toplink:link,
	.toplink:visited{
	  display:inline-flex;
	  align-items:center;
	  gap:6px;
	  text-decoration:none;
	  color: var(--link) !important;      /* same blue */
	  font-size: 18px !important;         /* same size */
	  font-weight: 700 !important;        /* same weight */
	  line-height:1;
	  padding:0;
	}
    .toplink:hover{ text-decoration:underline; }

    .account{ position:relative; display:flex; align-items:center; }
    .account-toggle{
      background:none; border:0; cursor:pointer; font:inherit; color: var(--link); padding:6px 0;
      display:inline-flex; align-items:center; gap:6px;
    }
    .toplink .caret{ width:16px; height:16px; stroke:currentColor; stroke-width:1.8; fill:none; transition:transform .15s ease; }

    .account .dropdown{ display:none; position:absolute; top:100%; right:0; margin-top:8px;
      min-width:200px; background:#fff; border:1px solid var(--border); border-radius:10px;
      box-shadow:0 10px 26px rgba(20,35,57,.12); padding:8px; z-index:50;
    }
    .account:hover .dropdown,
    .account:focus-within .dropdown{ display:block; }
    .account:focus-within .caret{ transform:rotate(180deg); }

    .dropdown a{
      display:flex; align-items:center; gap:8px;
      padding:10px 12px; border-radius:8px; color:#0d1117; text-decoration:none;
      font-weight:600; font-size:14px;
    }
    .dropdown a:hover{ background:#f5f8fe; }

    /* ===== Catering page hero ===== */
    .page-hero.catering{
      background:#fff; padding:28px 20px;
      border-top:0; border-bottom:1px solid var(--border);
    }
    .page-hero.catering h1{
      margin:0; text-align:center; font-family:"Playfair Display",Georgia,serif;
      font-size:54px; text-transform:uppercase; letter-spacing:3px;
    }
    .cater-heading{ text-align:center; font-weight:700; margin:18px 0 6px; }

    /* ===== Cards grid ===== */
    .cater-grid{
      max-width:1024px; margin:8px auto 48px; padding:0 20px;
      display:grid; grid-template-columns:repeat(2, minmax(280px, 1fr)); gap:22px;
    }
    .cater-card{
      background:#fff; border:1px solid var(--border); border-radius:12px;
      box-shadow:0 6px 18px rgba(15,23,42,.06); padding:16px 16px 18px;
    }
    .cater-card .card-title{
      margin:-16px -16px 12px; padding:10px 16px;
      background:#f7faff; border-bottom:1px solid var(--border); font-weight:700;
    }
    .cater-card dl{margin:0}
    .cater-card dt{font-weight:700}
    .cater-card dd{margin:0 0 8px 0;color:#334155}
    .cater-foot{display:flex;justify-content:space-between;align-items:center;margin-top:8px}
    .btn-view{display:inline-block;border:0;background:#16a34a;color:#fff;font-weight:700;font-size:12px;padding:8px 12px;border-radius:6px;text-decoration:none}
    .btn-view:hover{filter:brightness(.92)}
    .price{color:#64748b;font-weight:700;font-size:12px}

    /* ===== Footer (shared) ===== */
    .site-footer{ background:#2f2f2f; color:#e8e8e8; border-top:1px solid #222; margin-top:auto; width:100% }
    .footer-wrap{ max-width:1120px; margin:0 auto; padding:22px 20px; display:grid; grid-template-columns:1fr 1fr 1fr; gap:24px; align-items:flex-start }
    .site-footer h4{ margin:2px 0 14px; font-weight:700; font-size:20px }
    .footer-col .tagline{ margin-top:10px; font-size:12px; color:#c9c9c9; max-width:240px }
    .socials{ display:flex; gap:12px; align-items:center }
    .icon{ width:36px; height:36px; display:grid; place-items:center; border:1px solid #bdbdbd; border-radius:6px; text-decoration:none }
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
    .contact a:hover{text-decoration:underline}
    .ci{ display:inline-grid; place-items:center; width:22px; height:22px; border:1px solid #bdbdbd; border-radius:6px }
    .ci svg{ width:14px; height:14px; fill:#eaeaea }
	.copyright{ background:#ffffff; color:#2b2b2b; text-align:center; padding:6px 10px; font-size:12px; border-top:1px solid #dcdcdc; }
	
    /* ===== Responsive ===== */
    @media (max-width:980px){
      .header{grid-template-columns:1fr}
      .right-actions{justify-content:center; width:100%}
      .nav{gap:22px; flex-wrap:wrap; white-space:normal}
      .page-hero.catering h1{font-size:42px; letter-spacing:2px}
      .cater-grid{grid-template-columns:1fr}
      .footer-wrap{grid-template-columns:1fr; gap:18px}
      .mid{text-align:left}
    }
  </style>
</head>
<body>

  <header class="header">
    <!-- Left: Brand -->
    <div class="brand">
      <a class="brand-logo" href="Catering_Services.php" title="Everest Home">
        <img src="everest_logo.png" alt="Everest logo" width="44" height="44"/>
      </a>
      <h1>EVEREST<br><span style="font-weight:600;font-size:11px;opacity:.7">WHERE EVERY BOOKING CLIMBS TO SUCCESS</span></h1>
    </div>

    <!-- Center: Search + Nav -->
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
        <a class="active" href="Catering_Services.php">Catering Services</a>
        <a href="Contact.php">Contact</a>
        <a href="Gallery.php">Gallery</a>
      </nav>
    </div>

    <!-- Right: Book + Account (CSS-only dropdown) -->
    <div class="right-actions">
      <a class="toplink" href="Book.php">Book</a>

      <div class="account">
        <button class="toplink account-toggle" type="button" aria-haspopup="menu" aria-expanded="false">
          <?php
            $acctLabel = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Account';
            echo $acctLabel;
          ?>
          <svg class="caret" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M7 9l5 5 5-5" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <div class="dropdown" role="menu">
          <a class="dropdown-item" href="Account.php" role="menuitem">Account</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Page hero -->
  <section class="page-hero catering">
    <h1>CATERING SERVICES</h1>
  </section>

  <h3 class="cater-heading">Catering Service Packages</h3>

  <!-- Cards grid -->
  <section class="cater-grid">
    <article class="cater-card">
      <div class="card-title">Catering Package – Bronze</div>
      <dl>
        <dt>Appetizer:</dt><dd>Choice of One</dd>
        <dt>Soup:</dt><dd>Choice of One</dd>
        <dt>Entree/Salad:</dt><dd>Choice of One</dd>
        <dt>Main Entrees:</dt><dd>Choice of Three Main Courses with Steamed Rice</dd>
        <dt>Dessert:</dt><dd>Choice of One</dd>
        <dt>Drinks:</dt><dd>Refillable Iced Tea</dd>
      </dl>
      <div class="cater-foot">
		<a class="btn-view" href="Catering_Bronze.php">View Details</a>
        <span class="price">₱41,000</span>
      </div>
    </article>

    <article class="cater-card">
      <div class="card-title">Catering Package – Tiffany</div>
      <dl>
        <dt>Appetizer:</dt><dd>Choice of One</dd>
        <dt>Soup:</dt><dd>Choice of One</dd>
        <dt>Entree/Salad:</dt><dd>Choice of One</dd>
        <dt>Main Entrees:</dt><dd>Choice of Five Main Courses with Steamed Rice</dd>
        <dt>Dessert:</dt><dd>Choice of One</dd>
        <dt>Drinks:</dt><dd>Refillable Iced Tea</dd>
      </dl>
      <div class="cater-foot">
        <a class="btn-view" href="#">View Details</a>
        <span class="price">₱46,000</span>
      </div>
    </article>

    <article class="cater-card">
      <div class="card-title">Catering Package – Silver</div>
      <dl>
        <dt>Appetizer:</dt><dd>Choice of One</dd>
        <dt>Soup:</dt><dd>Choice of One</dd>
        <dt>Entree/Salad:</dt><dd>Choice of One</dd>
        <dt>Main Entrees:</dt><dd>Choice of Four Main Courses with Steamed Rice</dd>
        <dt>Dessert:</dt><dd>Choice of One</dd>
        <dt>Drinks:</dt><dd>Refillable Iced Tea</dd>
      </dl>
      <div class="cater-foot">
        <a class="btn-view" href="#">View Details</a>
        <span class="price">₱51,000</span>
      </div>
    </article>

    <article class="cater-card">
      <div class="card-title">Catering Package – Elite</div>
      <dl>
        <dt>Appetizer:</dt><dd>Choice of One</dd>
        <dt>Soup:</dt><dd>Choice of One</dd>
        <dt>Entree/Salad:</dt><dd>Choice of One</dd>
        <dt>Main Entrees:</dt><dd>Choice of Five High-End Main Courses with Steamed Rice</dd>
        <dt>Dessert:</dt><dd>Choice of One</dd>
        <dt>Drinks:</dt><dd>Refillable Iced Tea</dd>
      </dl>
      <div class="cater-foot">
        <a class="btn-view" href="#">View Details</a>
        <span class="price">₱61,000</span>
      </div>
    </article>

    <article class="cater-card">
      <div class="card-title">Catering Package – Diamond</div>
      <dl>
        <dt>Appetizer:</dt><dd>Choice of One</dd>
        <dt>Soup:</dt><dd>Choice of One</dd>
        <dt>Entree/Salad:</dt><dd>Choice of One</dd>
        <dt>Main Entrees:</dt><dd>Choice of Five Main Courses with Steamed Rice</dd>
        <dt>Dessert:</dt><dd>Choice of One</dd>
        <dt>Drinks:</dt><dd>Refillable Iced Tea</dd>
      </dl>
      <div class="cater-foot">
        <a class="btn-view" href="#">View Details</a>
        <span class="price">₱70,000</span>
      </div>
    </article>
  </section>

  <!-- ===== FOOTER (shared) ===== -->
  <footer class="site-footer">
    <div class="footer-wrap">
      <div class="footer-col">
        <h4>Social Media</h4>
        <div class="socials">
          <a href="#" aria-label="Tumblr" class="icon">
            <svg viewBox="0 0 24 24"><path d="M14.5 20.8c-3.2 0-4.6-2-4.6-4.3v-4.6H7.5V9c1.7-.6 2.5-1.9 2.9-3.4h1.7v3h2.8v2.3h-2.8v4.3c0 1 .5 1.9 1.9 1.9.5 0 1.2-.1 1.7-.4v2.2c-.6.6-1.8 1-3.2 1z"/></svg>
          </a>
          <a href="#" aria-label="X" class="icon">
            <svg viewBox="0 0 24 24"><path d="M3 3h3.7l5.2 6.9L16.9 3H21l-7.1 8.9L21 21h-3.7l-5.6-7.5L7.1 21H3l7.8-9.8L3 3z"/></svg>
          </a>
          <a href="#" aria-label="Instagram" class="icon">
            <svg viewBox="0 0 24 24"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1 5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7zm5 3.5A5.5 5.5 0 1 1 6.5 13 5.5 5.5 0 0 1 12 7.5zm0 2A3.5 3.5 0 1 0 15.5 13 3.5 3.5 0 0 0 12 9.5zm6-2.6a1 1 0 1 1-1 1 1 1 0 0 1 1-1z"/></svg>
          </a>
        </div>
        <p class="tagline">Event Management System • Your way to book an event</p>
      </div>

      <div class="footer-col mid">
        <h4>Quick Links</h4>
        <ul class="links">
          <li><a href="User_Homepage.php#about">ABOUT US</a></li>
          <li><a href="User_Homepage.php#contact">CONTACT US</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Contact Info</h4>
        <ul class="contact">
          <li>
            <span class="ci"><svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 0 0-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 14.5 9 2.5 2.5 0 0 1 12 11.5z"/></svg></span>
            Metro Manila, Philippines
          </li>
          <li>
            <span class="ci"><svg viewBox="0 0 24 24"><path d="M2 5l10 7 10-7v12H2zM12 10L2 5h20z"/></svg></span>
            <a href="mailto:Everest@email.com">Everest@email.com</a>
          </li>
          <li>
            <span class="ci"><svg viewBox="0 0 24 24"><path d="M6.6 10.8c1.4 2.8 3.8 5.3 6.6 6.6l2.2-2.2c.3-.3.8-.4 1.2-.3 1 .3 2 .5 3.1 .5 .7 0 1.3 .6 1.3 1.3v3.3c0 .7 -.6 1.3 -1.3 1.3C9.4 21.3 2.7 14.6 2.7 6.3c0 -.7 .6 -1.3 1.3 -1.3H7c.7 0 1.3 .6 1.3 1.3 0 1.1 .2 2.1 .5 3.1 .1 .4 0 .9 -.3 1.2l-1.9 2.2z"/></svg></span>
            12345678901
          </li>
        </ul>
      </div>
    </div>
	<div class="copyright">©Copyright 2025, Everest</div>
  </footer>
</body>
</html>
