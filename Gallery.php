<?php
// Gallery.php — Gallery page with zoomable images
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en" id="top">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gallery — Everest</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet"/>
  <style>
    :root{
      --bg:#f5f8fe; --text:#0d1117; --muted:#5b6775; --link:#0c63ff; --border:#e6ecf7;
      --right-col:260px;
    }
    *{box-sizing:border-box}
    html,body{margin:0;padding:0;height:100%}
    body{
      font-family:"Inter",system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
      background:var(--bg); color:var(--text);
      min-height:100vh; display:flex; flex-direction:column;
    }

    /* ===== Header ===== */
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

    /* ===== GALLERY ===== */
    .gallery-wrap{
      max-width:1120px;
      margin:0 auto;
      padding:32px 20px 70px;
    }
    .gallery-title{
      font-family:"Playfair Display", Georgia, serif;
      font-size:clamp(42px,5vw,64px);
      text-align:center;
      letter-spacing:4px;
      margin:10px 0 36px;
    }

    .gallery-grid-top{
      display:grid;
      grid-template-columns:repeat(2,minmax(0,1fr));
      gap:32px 40px;
      margin-bottom:40px;
    }
    .gallery-grid-bottom{
      display:grid;
      grid-template-columns:1fr;
      gap:32px;
    }
    .gallery-row{
      display:grid;
      grid-template-columns:repeat(2,minmax(0,1fr));
      gap:32px;
    }

    .gallery-img{
      width:100%;
      height:100%;
      max-height:460px;
      border-radius:28px;
      overflow:hidden;
      background:#000;
      box-shadow:0 18px 40px rgba(15,23,42,.35);
      cursor:zoom-in;
      transition:transform .18s ease-out, box-shadow .18s ease-out;
    }
    .gallery-img:hover{
      transform:translateY(-4px) scale(1.02);
      box-shadow:0 24px 50px rgba(15,23,42,.45);
    }
    .gallery-img img{
      width:100%;
      height:100%;
      display:block;
      object-fit:cover;
    }

    .back-top{
      margin:40px 0 10px;
      text-align:right;
      font-size:13px;
    }
    .back-top a{
      color:#111827;
      text-decoration:none;
      letter-spacing:.05em;
    }
    .back-top a:hover{ text-decoration:underline }

    /* ===== LIGHTBOX (zoom overlay) ===== */
    #lightbox-overlay{
      position:fixed;
      inset:0;
      background:rgba(0,0,0,.78);
      display:none;
      align-items:center;
      justify-content:center;
      z-index:200;
    }
    #lightbox-overlay.open{ display:flex; }
    #lightbox-img{
      max-width:90vw;
      max-height:90vh;
      border-radius:24px;
      box-shadow:0 30px 70px rgba(0,0,0,.7);
      background:#000;
    }
    #lightbox-close{
      position:absolute;
      top:24px;
      right:24px;
      background:rgba(0,0,0,.7);
      color:#f9fafb;
      border:none;
      border-radius:999px;
      padding:8px 14px;
      font-size:13px;
      font-weight:600;
      letter-spacing:.06em;
      cursor:pointer;
    }
    #lightbox-close:hover{
      background:rgba(0,0,0,.9);
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
      .gallery-grid-top,
      .gallery-row{grid-template-columns:1fr}
      .gallery-img{max-height:none}
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
      <a class="active" href="Gallery.php">Gallery</a>
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

<main class="gallery-wrap">
  <h1 class="gallery-title">GALLERY</h1>

  <!-- Top 2 x 2 grid -->
  <section class="gallery-grid-top">
    <div class="gallery-img">
      <img src="gallery1.jpg" alt="Bride portrait">
    </div>
    <div class="gallery-img">
      <img src="gallery2.jpg" alt="Flower girl and ring bearer">
    </div>
    <div class="gallery-img">
      <img src="gallery3.jpg" alt="Couple first dance">
    </div>
    <div class="gallery-img">
      <img src="gallery4.jpg" alt="Couple in spotlight">
    </div>
  </section>

  <!-- Bottom section: big image then 2-column row -->
  <section class="gallery-grid-bottom">
    <div class="gallery-img">
      <img src="gallery5.jpg" alt="Outdoor picnic themed shoot">
    </div>

    <div class="gallery-row">
      <div class="gallery-img">
        <img src="gallery6.jpg" alt="Debut event setup">
      </div>
      <div class="gallery-img">
        <img src="gallery7.jpg" alt="Bride with veil crossing bridge">
      </div>
    </div>
  </section>

  <div class="back-top">
    <a href="#top">BACK TO TOP</a>
  </div>
</main>

<!-- Lightbox overlay for zoom -->
<div id="lightbox-overlay" aria-hidden="true">
  <button id="lightbox-close" type="button">CLOSE</button>
  <img id="lightbox-img" src="" alt="">
</div>

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
document.addEventListener('DOMContentLoaded', function () {
  const overlay   = document.getElementById('lightbox-overlay');
  const overlayImg= document.getElementById('lightbox-img');
  const closeBtn  = document.getElementById('lightbox-close');

  // Open lightbox on image click
  document.querySelectorAll('.gallery-img img').forEach(img => {
    img.addEventListener('click', () => {
      overlayImg.src = img.src;
      overlayImg.alt = img.alt || '';
      overlay.classList.add('open');
      overlay.setAttribute('aria-hidden', 'false');
    });
  });

  function closeLightbox() {
    overlay.classList.remove('open');
    overlay.setAttribute('aria-hidden', 'true');
    overlayImg.src = '';
  }

  // Close via button
  closeBtn.addEventListener('click', closeLightbox);

  // Close when clicking outside the image
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) {
      closeLightbox();
    }
  });

  // Close on Esc key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && overlay.classList.contains('open')) {
      closeLightbox();
    }
  });
});
</script>
</body>
</html>
