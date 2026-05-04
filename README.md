# 👑 Centurion Diary

> **Spiritual productivity platform** built with Laravel 11 · Tailwind CSS · Alpine.js · MySQL · PWA

Walk in excellence through the **Rule of 100** — 100 Hours of Prayer · 100 Souls Won · 100 Espees Given.

---

## ✨ Features

| Module | Description |
|---|---|
| **Prayer Tracker** | Log sessions, built-in live timer, streak counter, milestones |
| **Soul Winning Registry** | Record every soul won with name, contact, follow-up notes, baptism status |
| **Giving Ledger** | Track Espee contributions by category with progress toward 100 |
| **Leaderboard** | Overall + per-pillar rankings with podium, sortable table |
| **Daily Scripture** | Admin-managed verse delivered each day; share / copy support |
| **Admin Dashboard** | Global analytics, user distribution chart, Hall of Fame, Scripture CMS, bulk push notifications |
| **PWA** | Installable on iOS & Android; offline support; daily push reminders |

---

## 🚀 Quick Start

### 1 — Clone & Install

```bash
git clone https://github.com/your-org/centurion-diary.git
cd centurion-diary
composer install
```

### 2 — Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials:

```
DB_DATABASE=centurion_diary
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3 — Database

```bash
# Create the database first:
mysql -u root -p -e "CREATE DATABASE centurion_diary CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations + seed demo data:
php artisan migrate --seed
```

### 4 — Run

```bash
php artisan serve
```

Visit **http://localhost:8000**

---

## 🔑 Default Credentials

| Role | Email | Password |
|---|---|---|
| **Admin** | admin@centuriondiary.com | password |
| **Demo User** | grace@demo.com | password |
| **Demo User** | david@demo.com | password |

---

## 📁 Project Structure

```
app/
  Http/
    Controllers/
      AuthController.php          ← Register, login, logout
      DashboardController.php     ← Main dashboard
      PrayerController.php        ← Prayer CRUD + quick-log (AJAX)
      SoulController.php          ← Soul registry CRUD
      GivingController.php        ← Giving ledger CRUD
      LeaderboardController.php   ← Rankings
      ScriptureController.php     ← Daily scripture page
      ProfileController.php       ← Profile & password
      AdminController.php         ← Admin panel, scripture CMS, notifications
    Middleware/
      IsAdmin.php                 ← Admin gate
  Models/
    User.php                      ← with prayer_hours, souls_count, giving_espees, overall_progress accessors
    PrayerLog.php
    Soul.php
    GivingLog.php
    Scripture.php

database/
  migrations/                     ← All 5 migrations
  seeders/
    DatabaseSeeder.php            ← Admin + 5 demo users + scriptures

resources/views/
  layouts/
    app.blade.php                 ← Main authenticated layout (sidebar)
    auth.blade.php                ← Split-panel auth layout
  auth/
    login.blade.php
    register.blade.php
    forgot-password.blade.php
  dashboard/
    index.blade.php               ← Main dashboard
    prayer.blade.php
    souls.blade.php
    giving.blade.php
    leaderboard.blade.php
    scripture.blade.php
    profile.blade.php
  admin/
    dashboard.blade.php

routes/
  web.php                         ← All routes (guest + auth + admin)

public/
  manifest.json                   ← PWA manifest
  sw.js                           ← Service worker (offline + push)
```

---

## 🎨 Design System

- **Font**: Cinzel Decorative (headings), Cinzel (UI), Lato (body)
- **Palette**: Royal Blue `#1a2c5b` · Gold `#d4a017` · Cream `#fdfbf5`
- **Animations**: Floating particles, progress ring draw, fade-in-up stagger, glow pulse
- **Components**: Modal overlays, progress rings (SVG), pillar cards, live prayer timer

---

## 📱 PWA Setup

Add icon files to `public/images/`:
- `icon-192.png` (192×192)
- `icon-512.png` (512×512)

Register the service worker by adding this to your layout (already in `app.blade.php`):
```js
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js');
}
```

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11 (PHP 8.2) |
| Frontend | Tailwind CSS (CDN), Alpine.js |
| Database | MySQL 8+ |
| PWA | Web App Manifest + Service Workers |
| Auth | Laravel's built-in session auth |
| Icons | Font Awesome 6 |
| Fonts | Google Fonts (Cinzel, Lato) |

---

## 📜 License

MIT — Use freely for ministry and kingdom purposes. 🙏
