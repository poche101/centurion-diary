<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MANifestation Conference · CELZ5</title>
<link rel="manifest" href="/manifest.json">
<script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js');
  }
</script>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f0e8; color: #1a1a1a; }

  nav {
    position: sticky; top: 0; z-index: 100;
    background: #fff;
    border-bottom: 1px solid rgba(0,0,0,0.08);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 40px; height: 62px;
    box-shadow: 0 1px 12px rgba(0,0,0,0.06);
  }
  .nav-logo { font-size: 13px; font-weight: 700; color: #b8860b; letter-spacing: 1.5px; text-transform: uppercase; }
  .nav-cta {
    background: #b8860b; color: #fff;
    font-weight: 700; border-radius: 24px;
    padding: 10px 24px; font-size: 13px;
    text-decoration: none; letter-spacing: 0.3px;
    transition: background 0.2s;
  }
  .nav-cta:hover { background: #9a7009; }

  .hero-img-section {
    width: 100%; max-height: 520px; overflow: hidden;
    position: relative;
  }
  .hero-img-section img {
    width: 100%; height: 100%; object-fit: cover; object-position: center top;
    display: block;
  }
  .hero-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.55) 100%);
    display: flex; flex-direction: column;
    align-items: center; justify-content: flex-end;
    padding-bottom: 48px; text-align: center;
  }
  .hero-img-overlay h1 {
    font-size: clamp(52px, 9vw, 88px); font-weight: 900; line-height: 0.95;
    color: #fff; margin-bottom: 4px;
  }
  .hero-img-overlay h1 .man { color: #ffc107; }
  .hero-img-overlay .conf-sub {
    font-size: clamp(22px, 4vw, 38px); font-weight: 300;
    color: rgba(255,255,255,0.7); font-style: italic; letter-spacing: 2px;
    margin-bottom: 16px;
  }
  .hero-tag-pill {
    font-size: 11px; letter-spacing: 2px; text-transform: uppercase;
    color: #ffc107; border: 1px solid rgba(255,193,7,0.5);
    padding: 5px 18px; border-radius: 24px; margin-bottom: 20px;
  }

  .hero-info-bar {
    background: #fff; border-bottom: 1px solid rgba(0,0,0,0.07);
    display: flex; justify-content: center; flex-wrap: wrap; gap: 0;
  }
  .info-item {
    display: flex; align-items: center; gap: 12px;
    padding: 20px 36px; border-right: 1px solid rgba(0,0,0,0.07);
  }
  .info-item:last-child { border-right: none; }
  .info-icon { font-size: 20px; }
  .info-label { font-size: 10px; color: #999; text-transform: uppercase; letter-spacing: 1px; }
  .info-val { font-size: 14px; font-weight: 700; color: #1a1a1a; margin-top: 2px; }

  .hero-cta-bar {
    background: #f5f0e8; text-align: center; padding: 40px 24px;
    border-bottom: 1px solid rgba(0,0,0,0.06);
  }
  .hero-cta-bar p {
    font-size: 13px; color: #888; letter-spacing: 2px; text-transform: uppercase;
    margin-bottom: 20px;
  }
  .btn-gold {
    background: #b8860b; color: #fff; font-weight: 700;
    padding: 16px 40px; border-radius: 32px; font-size: 14px;
    text-decoration: none; letter-spacing: 0.5px; border: none; cursor: pointer;
    transition: background 0.2s, transform 0.1s; display: inline-block;
  }
  .btn-gold:hover { background: #9a7009; transform: translateY(-1px); }

  .divider { height: 1px; background: rgba(0,0,0,0.07); }

  .section { padding: 64px 32px; max-width: 960px; margin: 0 auto; }
  .sec-label { font-size: 11px; letter-spacing: 2.5px; text-transform: uppercase; color: #b8860b; margin-bottom: 6px; }
  .sec-title { font-size: clamp(22px, 4vw, 32px); font-weight: 700; margin-bottom: 32px; color: #1a1a1a; }

  .schedule { display: flex; flex-direction: column; gap: 14px; }
  .sched-card {
    display: flex; gap: 20px; align-items: flex-start;
    background: #fff;
    border: 1px solid rgba(0,0,0,0.07);
    border-left: 4px solid #b8860b;
    border-radius: 0 12px 12px 0; padding: 22px;
    transition: box-shadow 0.2s;
  }
  .sched-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
  .day-badge {
    background: #b8860b; color: #fff;
    font-size: 11px; font-weight: 800; text-transform: uppercase;
    padding: 5px 14px; border-radius: 24px; white-space: nowrap;
    letter-spacing: 0.5px; align-self: flex-start;
  }
  .sched-info { flex: 1; }
  .sched-time { font-size: 11px; color: #999; margin-bottom: 5px; }
  .sched-name { font-size: 16px; font-weight: 700; margin-bottom: 6px; color: #1a1a1a; }
  .sched-loc { font-size: 12px; color: #b8860b; font-weight: 500; }

  .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
  .gallery-item {
    border-radius: 12px; overflow: hidden;
    background: #e8e0d0;
    border: 1px solid rgba(0,0,0,0.07);
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: box-shadow 0.2s;
  }
  .gallery-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.1); }
  .gallery-item.tall { grid-row: span 2; aspect-ratio: auto; min-height: 220px; }
  .gallery-item img { width: 100%; height: 100%; object-fit: cover; }
  .gallery-placeholder {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 10px; color: rgba(0,0,0,0.2); width: 100%; height: 100%; min-height: 120px;
  }
  .gallery-placeholder svg { width: 28px; height: 28px; stroke: currentColor; fill: none; }
  .gallery-placeholder span { font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; }

  .cta-section { max-width: 960px; margin: 0 auto; padding: 0 32px 72px; }
  .cta-box {
    background: #fff;
    border: 1px solid rgba(0,0,0,0.07);
    border-radius: 20px; padding: 56px 32px; text-align: center;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
  }
  .cta-box h2 { font-size: 30px; font-weight: 800; margin-bottom: 10px; color: #1a1a1a; }
  .cta-box p { color: #888; font-size: 14px; margin-bottom: 32px; }

  footer {
    background: #1a1a1a; border-top: 1px solid rgba(255,255,255,0.05);
    text-align: center; padding: 28px 24px;
    font-size: 12px; color: rgba(255,255,255,0.3); line-height: 1.8;
  }
  footer span { color: rgba(255,193,7,0.6); }

  @media (max-width: 600px) {
    nav { padding: 0 20px; }
    .info-item { padding: 16px 20px; }
    .section { padding: 48px 20px; }
    .hero-img-section img { height: 380px; }
  }
</style>
</head>
<body>

<nav class="flex items-center justify-between p-4 bg-white shadow-sm">
    <!-- Height set to 10 (2.5rem or 40px) ensures it stays within standard nav bounds -->
    <img src="images/lz5.png" alt="LZ5 Logo" class="h-10 w-auto object-contain" style="width:120px;">

    <a href="{{ route('dashboard') }}" class="nav-cta px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
        Dashboard
    </a>
</nav>
<div class="hero-img-section">
    <img src="images/man.jpeg" alt="">
  <div class="hero-img-overlay">
  </div>
</div>

<div class="hero-info-bar">
  <div class="info-item">
    <div class="info-icon">📅</div>
    <div>
      <div class="info-label">Saturday</div>
      <div class="info-val">May 9th · 10:00 AM</div>
    </div>

  </div>
  <div class="info-item">
    <div class="info-icon">📅</div>
    <div>
      <div class="info-label">Sunday</div>
      <div class="info-val">May 10th · 1:00 PM</div>
    </div>
  </div>
  <div class="info-item">
    <div class="info-icon">📍</div>
    <div>
      <div class="info-label">Venue</div>
      <div class="info-val">Loveworld Arena, Lekki</div>
    </div>
  </div>
  <div class="info-item">
    <div class="info-icon">👥</div>
    <div>
      <div class="info-label">For</div>
      <div class="info-val">All Men · 18yrs & Above</div>
    </div>
  </div>
</div>

<div class="hero-cta-bar">
  <p>Across the zone · Attendance is free</p>
  <a href="https://celz5.org/manifestation" class="btn-gold">Register Now</a>
</div>

<div class="divider"></div>

<div class="section" id="schedule">
  <div class="sec-label">Programme</div>
  <div class="sec-title">Event Schedule</div>
  <div class="schedule">
    <div class="sched-card">
      <div class="day-badge">SAT</div>
      <div class="sched-info">
        <div class="sched-time">Saturday, May 9th, 2025</div>
        <div class="sched-name">MANifestation Conference — Day 1</div>
        <div class="sched-loc">📍 Loveworld Arena Lekki · Begins 10:00 AM</div>
      </div>
    </div>
    <div class="sched-card">
      <div class="day-badge">SUN</div>
      <div class="sched-info">
        <div class="sched-time">Sunday, May 10th, 2025 · After Sunday Service</div>
        <div class="sched-name">MANifestation Conference — Day 2</div>
        <div class="sched-loc">📍 Loveworld Arena Lekki · 1:00 PM</div>
      </div>
    </div>
  </div>
</div>

<div class="divider"></div>

<div class="section" id="gallery">
  <div class="sec-label">Memories</div>
  <div class="sec-title">Photo Gallery</div>

  {{-- Filter Tabs --}}
  <div class="gallery-filters">
    <button class="gf-btn active" onclick="filterGallery('all', this)">All</button>
    <button class="gf-btn" onclick="filterGallery('tall', this)">Portraits</button>
    <button class="gf-btn" onclick="filterGallery('wide', this)">Featured</button>
  </div>

  <div class="gallery-grid" id="galleryGrid">

    {{-- Row 1 --}}
    <div class="gallery-item tall" data-category="tall" onclick="openLightbox('images/tom.jpg', 'Tom')">
      <img src="images/tom.jpg" alt="Tom">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
      <div class="gallery-badge">Portrait</div>
    </div>

    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/chris.jpg', 'Chris')">
      <img src="images/chris.jpg" alt="Chris">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/efe.jpg', 'Efe')">
      <img src="images/efe.jpg" alt="Efe">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    <div class="gallery-item wide" data-category="wide" onclick="openLightbox('images/asore.jpg', 'Asore')">
      <img src="images/asore.jpg" alt="Asore">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
      <div class="gallery-badge featured">Featured</div>
    </div>

    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/ray.jpg', 'Ray')">
      <img src="images/ray.jpg" alt="Ray">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

     <div class="gallery-item" data-category="normal" onclick="openLightbox('images/nwa.jpg', 'nwa')">
      <img src="images/nwa.jpg" alt="nwa">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

     <div class="gallery-item" data-category="normal" onclick="openLightbox('images/edo.jpg', 'edo')">
      <img src="images/edo.jpg" alt="edo">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    {{-- Row 2 --}}
    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/beke.jpeg', 'Beke')">
      <img src="images/beke.jpeg" alt="Beke">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    <div class="gallery-item tall" data-category="tall" onclick="openLightbox('images/bless.jpg', 'Bless')">
      <img src="images/bless.jpg" alt="Bless">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
      <div class="gallery-badge">Portrait</div>
    </div>

    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/udeh.jpg', 'Udeh')">
      <img src="images/udeh.jpg" alt="Udeh">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/kunle.jpeg', 'Kunle')">
      <img src="images/kunle.jpeg" alt="Kunle">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/cele.jpg', 'cele')">
      <img src="images/cele.jpg" alt="cele">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/ef.jpg', 'ef')">
      <img src="images/ef.jpg" alt="ef">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    <div class="gallery-item wide" data-category="wide" onclick="openLightbox('images/ehi.jpg', 'Ehi')">
      <img src="images/ehi.jpg" alt="Ehi">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
      <div class="gallery-badge featured">Featured</div>
    </div>

    {{-- Row 3 --}}
    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/sunny.jpg', 'Sunny')">
      <img src="images/sunny.jpg" alt="Sunny">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/asore.jpg', 'Asore')">
      <img src="images/asore.jpg" alt="Asore">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    <div class="gallery-item tall" data-category="tall" onclick="openLightbox('images/edward.jpg', 'Edward')">
      <img src="images/edward.jpg" alt="Edward">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
      <div class="gallery-badge">Portrait</div>
    </div>

    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/okorie.jpg', 'Okorie')">
      <img src="images/okorie.jpg" alt="Okorie">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

    <div class="gallery-item" data-category="normal" onclick="openLightbox('images/val.jpeg', 'Val')">
      <img src="images/val.jpeg" alt="Val">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

      <div class="gallery-item" data-category="normal" onclick="openLightbox('images/ozuzu.jpg', 'ozuzu')">
      <img src="images/ozuzu.jpg" alt="ozuzu">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

     <div class="gallery-item" data-category="normal" onclick="openLightbox('images/kalu.jpg', 'kalu')">
      <img src="images/kalu.jpg" alt="kalu">
      <div class="gallery-overlay">
        <div class="gallery-overlay-content">
          <span class="gallery-icon">🔍</span>
        </div>
      </div>
    </div>

  </div>
</div>

{{-- Lightbox --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
  <button class="lightbox-close" onclick="closeLightbox()">✕</button>
  <div class="lightbox-inner" onclick="event.stopPropagation()">
    <img id="lightboxImg" src="" alt="">
    <p id="lightboxCaption"></p>
  </div>
</div>

<style>
  /* ── Filters ───────────────────────────────────────── */
  .gallery-filters {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 28px;
    flex-wrap: wrap;
  }
  .gf-btn {
    padding: 8px 22px;
    border-radius: 999px;
    border: 1px solid rgba(0,0,0,0.12);
    background: transparent;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    letter-spacing: 0.5px;
  }
  .gf-btn:hover { background: #1a2c5b; color: #fff; border-color: #1a2c5b; }
  .gf-btn.active { background: #1a2c5b; color: #fff; border-color: #1a2c5b; }

  /* ── Grid ──────────────────────────────────────────── */
  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-auto-rows: 200px;
    gap: 12px;
  }

  /* ── Items ─────────────────────────────────────────── */
  .gallery-item {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    background: #e5e7eb;
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease;
  }
  .gallery-item:hover { transform: scale(1.03); box-shadow: 0 20px 60px rgba(0,0,0,0.18); z-index: 2; }
  .gallery-item.tall { grid-row: span 2; }
  .gallery-item.wide { grid-column: span 2; }

  .gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
  }
  .gallery-item:hover img { transform: scale(1.08); }

  /* ── Overlay ───────────────────────────────────────── */
  .gallery-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(26,44,91,0.85) 0%, rgba(26,44,91,0.2) 50%, transparent 100%);
    opacity: 0;
    transition: opacity 0.35s ease;
    display: flex;
    align-items: flex-end;
    padding: 16px;
  }
  .gallery-item:hover .gallery-overlay { opacity: 1; }

  .gallery-overlay-content {
    display: flex;
    align-items: center;
    gap: 8px;
    transform: translateY(10px);
    transition: transform 0.35s ease;
  }
  .gallery-item:hover .gallery-overlay-content { transform: translateY(0); }

  .gallery-icon { font-size: 1rem; }
  .gallery-name {
    color: #fff;
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
  }

  /* ── Badge ─────────────────────────────────────────── */
  .gallery-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(26,44,91,0.85);
    color: #f5d060;
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 999px;
    backdrop-filter: blur(6px);
  }
  .gallery-badge.featured { background: rgba(212,160,23,0.9); color: #1a2c5b; }

  /* ── Hidden state for filter ───────────────────────── */
  .gallery-item.hidden {
    display: none;
  }

  /* ── Lightbox ──────────────────────────────────────── */
  .lightbox {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.92);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(8px);
    animation: lbFadeIn 0.3s ease;
  }
  .lightbox.open { display: flex; }
  @keyframes lbFadeIn { from { opacity: 0; } to { opacity: 1; } }

  .lightbox-inner {
    max-width: 88vw;
    max-height: 88vh;
    text-align: center;
    animation: lbSlideUp 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  @keyframes lbSlideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

  .lightbox-inner img {
    max-width: 100%;
    max-height: 80vh;
    border-radius: 16px;
    object-fit: contain;
    box-shadow: 0 30px 80px rgba(0,0,0,0.5);
  }

  #lightboxCaption {
    color: rgba(255,255,255,0.7);
    margin-top: 14px;
    font-size: 0.88rem;
    letter-spacing: 1px;
  }

  .lightbox-close {
    position: absolute;
    top: 24px;
    right: 28px;
    background: rgba(255,255,255,0.1);
    border: none;
    color: #fff;
    font-size: 1.2rem;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.2s;
    backdrop-filter: blur(6px);
  }
  .lightbox-close:hover { background: rgba(255,255,255,0.2); }

  /* ── Responsive ────────────────────────────────────── */
  @media (max-width: 768px) {
    .gallery-grid {
      grid-template-columns: repeat(2, 1fr);
      grid-auto-rows: 160px;
    }
  }
  @media (max-width: 480px) {
    .gallery-grid {
      grid-template-columns: 1fr 1fr;
      grid-auto-rows: 140px;
    }
  }
</style>

<div class="divider"></div>

<div class="cta-section" id="register">
  <div style="height:64px"></div>
  <div class="cta-box">
    <h2>Ready to be part of it?</h2>
    <p>All men 18 years and above across the zone are welcome. Attendance is free.</p>
    <a href="https://celz5.org/manifestation" class="btn-gold">Register Here</a>
  </div>
</div>

<footer>
  <p>&copy; 2025 <span>Christ Embassy Lagos Zone 5</span></p>
  <p>MANifestation Conference · Loveworld Arena, Lekki · May 9–10, 2025</p>
</footer>

<script>
  function openLightbox(src, name) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxCaption').innerText = name;
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightbox();
  });

  function filterGallery(category, btn) {
    document.querySelectorAll('.gf-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.gallery-item').forEach(item => {
      if (category === 'all') {
        item.classList.remove('hidden');
      } else {
        const match = item.dataset.category === category;
        item.classList.toggle('hidden', !match);
      }
    });
  }
</script>

</body>
</html>
