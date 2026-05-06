<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="vapid-public-key" content="{{ config('webpush.vapid.public_key') }}">
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

  /* ═══════════════════════════════════════════════════════════
     CINEMATIC SLIDER
  ═══════════════════════════════════════════════════════════ */

  .gallery-section {
    padding: 80px 0;
    background: #0d0d0d;
    position: relative;
    overflow: hidden;
  }

  /* Subtle grain overlay */
  .gallery-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    opacity: 0.35;
    pointer-events: none;
    z-index: 0;
  }

  .gallery-section-header {
    text-align: center;
    padding: 0 24px 56px;
    position: relative;
    z-index: 1;
  }
  .gallery-section-header .sec-label {
    color: #b8860b;
    letter-spacing: 4px;
    font-size: 10px;
  }
  .gallery-section-header .sec-title {
    color: #fff;
    font-size: clamp(26px, 5vw, 42px);
    font-weight: 800;
    letter-spacing: -0.5px;
  }
  .gallery-section-header .sec-title span {
    color: #ffc107;
  }

  /* ── Track ─────────────────────────────────────────── */
  .slider-viewport {
    position: relative;
    overflow: hidden;
    z-index: 1;
  }

  .slider-track {
    display: flex;
    gap: 20px;
    padding: 0 calc(50vw - 200px);
    transition: transform 0.7s cubic-bezier(0.77, 0, 0.175, 1);
    will-change: transform;
  }

  /* ── Cards ─────────────────────────────────────────── */
  .slide-card {
    flex: 0 0 360px;
    height: 520px;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.5s ease,
                filter 0.5s ease;
    filter: brightness(0.55) saturate(0.7);
    transform: scale(0.88);
    box-shadow: 0 10px 40px rgba(0,0,0,0.4);
  }

  .slide-card.active {
    filter: brightness(1) saturate(1.1);
    transform: scale(1);
    box-shadow: 0 30px 80px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,193,7,0.25);
    z-index: 2;
  }

  .slide-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.8s ease;
  }
  .slide-card.active img {
    transform: scale(1.04);
  }

  /* Gold shimmer border on active */
  .slide-card.active::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 20px;
    border: 1.5px solid rgba(255,193,7,0.45);
    z-index: 3;
    pointer-events: none;
  }

  /* Gradient overlay on card */
  .slide-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
      to top,
      rgba(13,13,13,0.75) 0%,
      rgba(13,13,13,0.2) 40%,
      transparent 70%
    );
    transition: opacity 0.4s ease;
    z-index: 1;
  }
  .slide-card.active::after {
    opacity: 0.5;
  }

  /* ── Active card decorative line ──────────────────── */
  .slide-card-accent {
    position: absolute;
    bottom: 28px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 48px;
    height: 2px;
    background: #ffc107;
    border-radius: 2px;
    z-index: 4;
    transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s;
  }
  .slide-card.active .slide-card-accent {
    transform: translateX(-50%) scaleX(1);
  }

  /* ── Navigation ────────────────────────────────────── */
  .slider-nav {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 48px;
    position: relative;
    z-index: 2;
  }

  .slider-btn {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    border: 1.5px solid rgba(255,193,7,0.4);
    background: rgba(255,255,255,0.05);
    color: #ffc107;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    backdrop-filter: blur(8px);
  }
  .slider-btn:hover {
    background: #b8860b;
    border-color: #b8860b;
    color: #fff;
    transform: scale(1.1);
    box-shadow: 0 8px 24px rgba(184,134,11,0.4);
  }
  .slider-btn:active { transform: scale(0.95); }

  /* ── Dots ──────────────────────────────────────────── */
  .slider-dots {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .slider-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  .slider-dot.active {
    width: 28px;
    border-radius: 3px;
    background: #ffc107;
  }

  /* ── Counter ───────────────────────────────────────── */
  .slider-counter {
    color: rgba(255,255,255,0.3);
    font-size: 11px;
    letter-spacing: 2px;
    font-weight: 600;
    min-width: 52px;
    text-align: center;
  }
  .slider-counter span { color: #ffc107; }

  /* ── Fullscreen Lightbox ───────────────────────────── */
  .film-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(0,0,0,0.97);
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(16px);
  }
  .film-lightbox.open { display: flex; animation: lbIn 0.4s ease; }
  @keyframes lbIn { from { opacity: 0; } to { opacity: 1; } }

  .film-lb-inner {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
    animation: lbScale 0.45s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  @keyframes lbScale {
    from { transform: scale(0.85); opacity: 0; }
    to   { transform: scale(1);    opacity: 1; }
  }

  .film-lb-inner img {
    max-width: 100%;
    max-height: 88vh;
    border-radius: 16px;
    display: block;
    object-fit: contain;
    box-shadow: 0 40px 100px rgba(0,0,0,0.8);
  }

  /* Gold frame lines — cinematic letterbox feel */
  .film-lb-inner::before,
  .film-lb-inner::after {
    content: '';
    position: absolute;
    left: 0; right: 0;
    height: 2px;
    background: linear-gradient(to right, transparent, #ffc107, transparent);
    opacity: 0.5;
  }
  .film-lb-inner::before { top: -10px; }
  .film-lb-inner::after  { bottom: -10px; }

  .film-lb-close {
    position: fixed;
    top: 24px; right: 28px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.7);
    font-size: 16px;
    width: 44px; height: 44px;
    border-radius: 50%;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
    backdrop-filter: blur(8px);
    z-index: 10000;
  }
  .film-lb-close:hover {
    background: rgba(255,193,7,0.2);
    border-color: rgba(255,193,7,0.4);
    color: #ffc107;
    transform: rotate(90deg);
  }

  /* ── Swipe hint on mobile ──────────────────────────── */
  .swipe-hint {
    text-align: center;
    color: rgba(255,255,255,0.2);
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-top: 20px;
    display: none;
  }
  @media (max-width: 768px) {
    .swipe-hint { display: block; }

    .slide-card {
      flex: 0 0 260px;
      height: 380px;
    }
    .slider-track {
      padding: 0 calc(50vw - 130px);
    }
  }
  @media (max-width: 480px) {
    .slide-card {
      flex: 0 0 220px;
      height: 320px;
    }
    .slider-track {
      padding: 0 calc(50vw - 110px);
      gap: 14px;
    }
  }

  @media (max-width: 600px) {
    .hero-img-section {
        max-height: none;
    }

    .hero-img-section img {
        height: auto;
        object-fit: contain;
    }
}
</style>
</head>
<body>

<nav class="flex items-center justify-between p-4 bg-white shadow-sm">
    <img src="images/lz5.png" alt="LZ5 Logo" class="h-10 w-auto object-contain" style="width:120px;">
    <a href="{{ route('dashboard') }}" class="nav-cta px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
        Dashboard
    </a>
</nav>

<div class="hero-img-section">
    <img src="images/mani.jpeg" alt="">
    <div class="hero-img-overlay"></div>
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

<!-- ════════════════════════════════════════════════════
     CINEMATIC SLIDER SECTION
════════════════════════════════════════════════════ -->
<div class="gallery-section" id="gallery">
  <div class="gallery-section-header section">
    <div class="sec-label"></div>
    <div class="sec-title">The <span>Men</span> of MANifestation</div>
  </div>

  <div class="slider-viewport" id="sliderViewport">
    <div class="slider-track" id="sliderTrack">
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/tom.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/chris.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/efe.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/asore.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/ray.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/nwa.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/edo.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/beke.jpeg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/bless.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/udeh.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/kunle.jpeg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/cele.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/ef.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/ehi.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/sunny.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/edward.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/okorie.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/val.jpeg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/ozuzu.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/stan2.jpeg" alt="">
        <div class="slide-card-accent"></div>
      </div>
      <div class="slide-card" onclick="openFilmbox(this)">
        <img src="images/kalu.jpg" alt="">
        <div class="slide-card-accent"></div>
      </div>
    </div>
  </div>

  <div class="slider-nav">
    <button class="slider-btn" id="prevBtn" onclick="slideBy(-1)">&#8592;</button>
    <div class="slider-dots" id="sliderDots"></div>
    <span class="slider-counter" id="sliderCounter"><span id="cCurrent">1</span> / <span id="cTotal">1</span></span>
    <button class="slider-btn" id="nextBtn" onclick="slideBy(1)">&#8594;</button>
  </div>

  <div class="swipe-hint">← swipe to explore →</div>
</div>

<!-- Filmbox (no names, no captions) -->
<div class="film-lightbox" id="filmLightbox" onclick="closeFilmbox()">
  <button class="film-lb-close" onclick="closeFilmbox()">✕</button>
  <div class="film-lb-inner" onclick="event.stopPropagation()">
    <img id="filmLbImg" src="" alt="">
  </div>
</div>

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
  // ── Slider ─────────────────────────────────────────────────
  const track    = document.getElementById('sliderTrack');
  const cards    = Array.from(track.querySelectorAll('.slide-card'));
  const dotsWrap = document.getElementById('sliderDots');
  const cCurrent = document.getElementById('cCurrent');
  const cTotal   = document.getElementById('cTotal');
  let current    = 0;
  let autoTimer  = null;

  // Build dots
  cards.forEach((_, i) => {
    const d = document.createElement('div');
    d.className = 'slider-dot' + (i === 0 ? ' active' : '');
    d.onclick = () => goTo(i);
    dotsWrap.appendChild(d);
  });

  cTotal.textContent = cards.length;

  function getCardWidth() {
    return cards[0].offsetWidth + parseInt(getComputedStyle(track).gap || 20);
  }

  function goTo(index) {
    current = (index + cards.length) % cards.length;

    // Update active card
    cards.forEach((c, i) => c.classList.toggle('active', i === current));

    // Update dots
    dotsWrap.querySelectorAll('.slider-dot').forEach((d, i) => d.classList.toggle('active', i === current));

    // Update counter
    cCurrent.textContent = current + 1;

    // Shift track so active card is centred
    const cardW   = getCardWidth();
    const vw      = document.getElementById('sliderViewport').offsetWidth;
    const activeW = cards[current].offsetWidth;
    const offset  = current * cardW - (vw / 2 - activeW / 2);
    track.style.transform = `translateX(${-offset}px)`;
  }

  function slideBy(dir) {
    resetAuto();
    goTo(current + dir);
  }

  function resetAuto() {
    clearInterval(autoTimer);
    autoTimer = setInterval(() => goTo(current + 1), 4000);
  }

  // Keyboard
  document.addEventListener('keydown', e => {
    if (document.getElementById('filmLightbox').classList.contains('open')) return;
    if (e.key === 'ArrowLeft')  slideBy(-1);
    if (e.key === 'ArrowRight') slideBy(1);
  });

  // Touch / swipe
  let touchX = null;
  track.addEventListener('touchstart', e => { touchX = e.touches[0].clientX; }, { passive: true });
  track.addEventListener('touchend', e => {
    if (touchX === null) return;
    const diff = touchX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 40) slideBy(diff > 0 ? 1 : -1);
    touchX = null;
    resetAuto();
  });

  // Init
  goTo(0);
  resetAuto();
  window.addEventListener('resize', () => goTo(current));

  // ── Filmbox ────────────────────────────────────────────────
  function openFilmbox(card) {
    const src = card.querySelector('img').src;
    document.getElementById('filmLbImg').src = src;
    document.getElementById('filmLightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
    clearInterval(autoTimer);
  }

  function closeFilmbox() {
    document.getElementById('filmLightbox').classList.remove('open');
    document.body.style.overflow = '';
    resetAuto();
  }

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeFilmbox();
  });
</script>

</body>
</html>
