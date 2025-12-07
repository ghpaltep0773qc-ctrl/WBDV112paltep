<?php /* Catering_Bronze.php — hard-coded Bronze package detail page */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bronze Package — Everest Events</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet" />
  <style>
    :root{
      --bg:#f5f8fe; --panel:#ffffff; --text:#0d1117; --muted:#5b6775; --link:#1155ff;
      --border:#e6ecf7; --right-col:260px; --toplink-size:18px;
    }
    *{box-sizing:border-box}
    html,body{margin:0;padding:0;height:100%}
    body{
      font-family:"Inter",system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
      background:var(--bg); color:var(--text);
      min-height:100vh; display:flex; flex-direction:column;
    }

    /* ===== Header (same as Catering_Services) ===== */
    .header{
      width:100%; padding:14px 24px;
      display:grid; align-items:center; gap:16px;
      grid-template-columns:240px 1fr var(--right-col);
      background:linear-gradient(#fafcfe,#f1f5fb); border-bottom:1px solid var(--border);
    }
    .brand{display:flex;align-items:center;gap:12px;font-weight:800;letter-spacing:.5px;min-width:0}
    .brand-logo{width:44px;height:44px;display:grid;place-items:center;text-decoration:none;flex:0 0 44px}
    .brand-logo img{width:44px;height:44px;display:block}
    .brand h1{font-size:16px;margin:0;line-height:1.05;white-space:nowrap}

    .mast{display:grid;grid-template-rows:auto auto;justify-items:center;row-gap:10px}
    .search{position:relative;width:min(620px,52vw)}
    .search input{width:100%;height:44px;padding:10px 16px 10px 44px;border-radius:999px;background:#fff;border:2px solid #133a60;font-size:14px;outline:none;box-shadow:inset 0 0 0 1px rgba(19,58,96,.15)}
    .search svg{position:absolute;left:12px;top:50%;transform:translateY(-50%);width:20px;height:20px;stroke:#0d2642;stroke-width:1.8;fill:none;opacity:.9;pointer-events:none}

    .nav{display:flex;justify-content:space-evenly;gap:clamp(24px,5vw,64px);white-space:nowrap;margin:0;padding:0 12px}
    .nav a{display:inline-flex;align-items:center;gap:6px;padding:10px 14px;font-size:15px;text-decoration:none;color:#1f2937;font-weight:600}
    .nav a.active{color:var(--link)}

    .right-actions{
      justify-self:end;width:var(--right-col);
      display:flex;align-items:center;justify-content:space-between;gap:16px;
    }
    .toplink{
      display:inline-flex;align-items:center;gap:6px;
      padding:6px 0;font-size:var(--toplink-size);font-weight:700;
      color:var(--link);text-decoration:none;line-height:1;
    }
    .toplink:hover{text-decoration:underline}
    .caret{width:16px;height:16px;stroke:currentColor;stroke-width:1.8;fill:none}

    /* ===== Page header ===== */
    .pkg-hero{
      background:#fff;border-bottom:1px solid var(--border);
      padding:32px 20px 24px;text-align:center
    }
    .pkg-hero h1{
      font-family:"Playfair Display",Georgia,serif;
      font-size:36px;letter-spacing:.5px;margin:0 0 4px
    }
    .pkg-hero .price{font-size:12px;color:#64748b;font-weight:700;letter-spacing:.4px}

    /* ===== Menus ===== */
    .menus{
      max-width:1000px;margin:26px auto 14px;padding:0 20px;
      display:grid;grid-template-columns:1fr 1fr;gap:40px
    }
    .menu-col h3{font-size:16px;text-align:center;margin:0 0 10px}
    .menu-col section{margin:12px 0}
    .menu-col h4{font-size:12px;text-transform:none;text-align:center;margin:8px 0 4px}
    .menu-col p{font-size:12px;line-height:1.5;text-align:center;margin:0}

    /* ===== Inclusions ===== */
    .inclusions{
      max-width:1000px;margin:18px auto 40px;padding:0 20px;
    }
    .inc-card{
      background:var(--panel);border:1px solid var(--border);border-radius:12px;
      box-shadow:0 6px 18px rgba(15,23,42,.06);
      padding:18px
    }
    .inc-card h3{
      font-family:"Playfair Display",Georgia,serif;font-size:18px;text-align:center;margin:0 0 14px
    }
    .inc-grid{
      display:grid;grid-template-columns:1fr 1fr;gap:10px
    }
    .inc-grid ul{margin:0;padding-left:18px}
    .inc-grid li{font-size:12px;line-height:1.5;margin:6px 0}

    /* ===== Footer (compact) ===== */
    .site-footer{background:#2f2f2f;color:#e8e8e8;border-top:1px solid #222;margin-top:auto}
    .footer-wrap{max-width:1120px;margin:0 auto;padding:22px 20px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:24px}
    .site-footer h4{margin:2px 0 14px;font-weight:700;font-size:16px}
    .links,.contact{list-style:none;margin:0;padding:0}
    .links li,.contact li{margin:6px 0;font-size:12px}
    .links a,.contact a{color:#e8e8e8;text-decoration:none}
    .links a:hover,.contact a:hover{text-decoration:underline}
    .socials{display:flex;gap:12px}
    .icon{width:32px;height:32px;display:grid;place-items:center;border:1px solid #bdbdbd;border-radius:6px}
    .icon svg{width:20px;height:20px;fill:#eaeaea}
	.copyright{ background:#ffffff; color:#2b2b2b; text-align:center; padding:6px 10px; font-size:12px; border-top:1px solid #dcdcdc; }
	
    @media (max-width:980px){
      .header{grid-template-columns:1fr}
      .right-actions{justify-content:center;width:100%}
      .nav{gap:22px;flex-wrap:wrap}
      .menus{grid-template-columns:1fr}
      .inc-grid{grid-template-columns:1fr}
    }
  </style>
</head>
<body>

<header class="header">
  <div class="brand">
    <a class="brand-logo" href="User_Homepage.php" title="Everest Home">
      <img src="everest_logo.png" alt="Everest logo" />
    </a>
    <h1>EVEREST<br><span style="font-weight:600;font-size:11px;opacity:.7">WHERE EVERY BOOKING CLIMBS TO SUCCESS</span></h1>
  </div>

  <div class="mast">
    <div class="search" role="search">
      <input type="search" placeholder="Search" aria-label="Search" />
      <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10" cy="10" r="6"/><line x1="14.5" y1="14.5" x2="21" y2="21"/></svg>
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

  <div class="right-actions">
    <a class="toplink" href="Book.php">Book</a>
    <a class="toplink" href="Account.php">
      <?php
        $acctLabel = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Account';
        echo $acctLabel;
      ?>
      <svg class="caret" viewBox="0 0 24 24"><path d="M7 9l5 5 5-5"/></svg>
    </a>
  </div>
</header>

<section class="pkg-hero">
  <h1>Catering Package – Bronze</h1>
  <div class="price">₱41,000</div>
</section>

<!-- Two best menus -->
<section class="menus">
  <div class="menu-col">
    <h3>Best Menu 1</h3>

    <section><h4>Appetizer</h4>
      <p>Parmesan Fish Fingers</p></section>

    <section><h4>Main Entrées</h4>
      <p>Steamed Rice<br>
         Slow-Roasted Beef with Pepper Sauce<br>
         Pan-Grilled Porkloin with Diane Sauce<br>
         Pan-Seared Fish Fillet with Mango Salsa<br>
         Baked Spaghetti</p></section>

    <section><h4>Desserts</h4>
      <p>Mango Delights</p></section>

    <section><h4>Beverages</h4>
      <p>Refillable Iced Tea<br>Purified Water</p></section>
  </div>

  <div class="menu-col">
    <h3>Best Menu 2</h3>

    <section><h4>Appetizer</h4>
      <p>Nachos with Quattro Formaggio</p></section>

    <section><h4>Main Entrées</h4>
      <p>Steamed Rice<br>
         Slow-Roasted Beef Ribs w/ Red Wine Sauce<br>
         Chicken Cordon Bleu<br>
         Fish Fillet with Lemon Butter Sauce<br>
         Cheesy Baked Mac</p></section>

    <section><h4>Desserts</h4>
      <p>Mango Sago</p></section>

    <section><h4>Beverages</h4>
      <p>Refillable Iced Tea<br>Purified Water</p></section>
  </div>
</section>

<!-- Inclusions -->
<section class="inclusions">
  <div class="inc-card">
    <h3>Bronze Package Inclusions</h3>
    <div class="inc-grid">
      <ul>
        <li>Stylish Couch and Dazzling Backdrop for the Couple</li>
        <li>Guest List Online Portal</li>
        <li>Elegant Setup for Presidential tables (Maximum of 20 persons)</li>
        <li>Plated Service for VIP guests</li>
        <li>Modern Table Centerpieces with Tea lights</li>
        <li>Classy Dining Setup with Chinaware, Glassware &amp; Silverware</li>
        <li>Table Numbers with Holders</li>
        <li>Custom-built Menu Cards and Place Cards</li>
        <li>Table linens in striking colors of your choice</li>
      </ul>
      <ul>
        <li>Sparkling Roll Top Chaffing Dishes</li>
        <li>Superb Wedding Aisle Decor</li>
        <li>Red Carpet</li>
        <li>Extraordinary Full Buffet Setup</li>
        <li>Name Labels at the Buffet</li>
        <li>Chilled bottle of Wine for toasting</li>
        <li>Tables for Registration, Gifts, and Wedding Cake</li>
        <li>Ruby Chairs with cover and Ribbons</li>
        <li>Bar Setup for Beverage Station</li>
        <li>Well-Trained Uniformed Waiters</li>
        <li>Menu tasting for 2 persons</li>
      </ul>
    </div>
  </div>
</section>

<footer class="site-footer">
  <div class="footer-wrap">
    <div class="footer-col">
      <h4>Social Media</h4>
      <div class="socials">
        <span class="icon"><svg viewBox="0 0 24 24"><path d="M14.5 20.8c-3.2 0-4.6-2-4.6-4.3v-4.6H7.5V9c1.7-.6 2.5-1.9 2.9-3.4h1.7v3h2.8v2.3h-2.8v4.3c0 1 .5 1.9 1.9 1.9"/></svg></span>
        <span class="icon"><svg viewBox="0 0 24 24"><path d="M3 3h3.7l5.2 6.9L16.9 3H21l-7.1 8.9L21 21h-3.7l-5.6-7.5L7.1 21H3z"/></svg></span>
        <span class="icon"><svg viewBox="0 0 24 24"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5z"/></svg></span>
      </div>
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
        <li>Metro Manila, Philippines</li>
        <li><a href="mailto:Everest@email.com">Everest@email.com</a></li>
        <li>12345678901</li>
      </ul>
    </div>
  </div>
  <div class="copyright">©Copyright 2025, Everest</div>
</footer>

</body>
</html>
