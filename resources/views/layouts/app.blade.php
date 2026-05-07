<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="vapid-public-key" content="{{ config('webpush.vapid.public_key') }}">
    <title>@yield('title', 'Centurion Diary') — Walk in Excellence</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1a2c5b">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="manifest" href="/manifest.json">


    <!-- Tailwind via CDN for demo -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    royal: { 50:'#eef2ff',100:'#dde6ff',500:'#1a2c5b',600:'#152349',700:'#101b38',800:'#0b1227',900:'#060a16' },
                    gold: { 50:'#fffbeb',100:'#fef3c7',200:'#fde68a',300:'#fcd34d',400:'#fbbf24',500:'#d4a017',600:'#b8860b',700:'#92680a',800:'#6b4c08',900:'#4a3305' },
                    crimson: { 500:'#dc143c', 600:'#b01030' }
                },
                fontFamily: {
                    cinzel: ['Cinzel', 'serif'],
                    'cinzel-deco': ['Cinzel Decorative', 'serif'],
                    lato: ['Lato', 'sans-serif'],
                }
            }
        }
    }
    </script>

    <style>
        :root {
            --royal: #1a2c5b;
            --gold: #d4a017;
            --gold-light: #f5d060;
            --cream: #fdfbf5;
            --parchment: #f8f3e8;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Lato', sans-serif;
            background: var(--cream);
            color: #1a1a1a;
            overflow-x: hidden;
        }

        /* Animated background particles */
        .particle-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 4px; height: 4px;
            background: var(--gold);
            border-radius: 50%;
            opacity: 0;
            animation: floatUp linear infinite;
        }

        @keyframes floatUp {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 0.6; }
            90% { opacity: 0.3; }
            100% { transform: translateY(-20px) scale(1); opacity: 0; }
        }

        /* ── Sidebar overlay — click outside to close ─────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(3px);
            z-index: 49;
            cursor: pointer;
        }
        .sidebar-overlay.open { display: block; }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(160deg, #0f1f45 0%, #1a2c5b 40%, #1e3370 100%);
            min-height: 100vh;
            position: fixed;
            left: 0; top: 0;
            width: 260px;
            z-index: 50;
            box-shadow: 4px 0 30px rgba(0,0,0,0.25);
            transition: transform 0.3s ease;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4a017' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .sidebar-logo {
            padding: 20px 24px 18px;
            border-bottom: 1px solid rgba(212,160,23,0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-logo .logo-crown {
            font-size: 2rem;
            filter: drop-shadow(0 0 8px rgba(212,160,23,0.8));
        }

        .sidebar-logo h1 {
            font-family: 'Cinzel Decorative', serif;
            color: var(--gold-light);
            font-size: 1.1rem;
            line-height: 1.2;
            text-shadow: 0 0 20px rgba(212,160,23,0.4);
        }

        .sidebar-logo p {
            font-family: 'Cinzel', serif;
            color: rgba(255,255,255,0.5);
            font-size: 0.65rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* ── Sidebar close button (mobile only) ───────────────── */
        .sidebar-close-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 32px; height: 32px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.6);
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .sidebar-close-btn:hover {
            background: rgba(212,160,23,0.2);
            border-color: rgba(212,160,23,0.4);
            color: var(--gold-light);
            transform: rotate(90deg);
        }

        .nav-section {
            padding: 16px 0 8px;
        }

        .nav-section-title {
            font-family: 'Cinzel', serif;
            font-size: 0.6rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(212,160,23,0.5);
            padding: 0 24px 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 24px;
            color: rgba(255,255,255,0.65);
            font-family: 'Cinzel', serif;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            transition: all 0.25s ease;
            position: relative;
            text-decoration: none;
            cursor: pointer;
        }

        .nav-item:hover, .nav-item.active {
            color: var(--gold-light);
            background: rgba(212,160,23,0.1);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, var(--gold), var(--gold-light));
            border-radius: 0 2px 2px 0;
        }

        .nav-item .icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            background: rgba(255,255,255,0.06);
            transition: all 0.25s ease;
            flex-shrink: 0;
        }

        .nav-item:hover .icon, .nav-item.active .icon {
            background: rgba(212,160,23,0.2);
        }

        /* Main content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Top bar */
        .topbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(212,160,23,0.15);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        }

        .topbar-greeting {
            font-family: 'Cinzel', serif;
            font-size: 0.85rem;
            color: #555;
        }

        .topbar-greeting span {
            color: var(--royal);
            font-weight: 600;
        }

        .user-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #1a2c5b 0%, #2a3f7a 100%);
            color: white;
            padding: 8px 16px 8px 8px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26,44,91,0.3);
        }

        .user-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(26,44,91,0.4);
        }

        .avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cinzel', serif;
            font-weight: 700;
            font-size: 0.8rem;
            color: #1a2c5b;
        }

        /* Cards */
        .centurion-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.06);
            border: 1px solid rgba(212,160,23,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .centurion-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.1);
            border-color: rgba(212,160,23,0.3);
        }

        /* Progress rings */
        .progress-ring { transform: rotate(-90deg); }
        .progress-ring-circle {
            transition: stroke-dashoffset 1s ease;
            stroke-linecap: round;
        }

        /* Pillar cards */
        .pillar-prayer { background: linear-gradient(135deg, #1a2c5b 0%, #2d4a8a 100%); }
        .pillar-souls { background: linear-gradient(135deg, #7c2d12 0%, #c2410c 100%); }
        .pillar-giving { background: linear-gradient(135deg, #14532d 0%, #15803d 100%); }

        /* Shimmer animation */
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .shimmer-text {
            background: linear-gradient(90deg, #d4a017, #f5d060, #d4a017, #b8860b, #d4a017);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        /* Glow pulse */
        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 0 10px rgba(212,160,23,0.3); }
            50% { box-shadow: 0 0 30px rgba(212,160,23,0.7), 0 0 60px rgba(212,160,23,0.3); }
        }

        .glow-gold { animation: glowPulse 2.5s ease-in-out infinite; }

        /* Flash notification */
        .flash-success {
            background: linear-gradient(135deg, #14532d, #15803d);
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Cinzel', serif;
            font-size: 0.85rem;
            box-shadow: 0 4px 20px rgba(21,128,61,0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .sidebar-close-btn { display: flex; }
            .main-content { margin-left: 0; }
        }

        /* Fade in animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in-up {
            animation: fadeInUp 0.5s ease forwards;
        }

        .fade-in-up:nth-child(1) { animation-delay: 0.05s; }
        .fade-in-up:nth-child(2) { animation-delay: 0.1s; }
        .fade-in-up:nth-child(3) { animation-delay: 0.15s; }
        .fade-in-up:nth-child(4) { animation-delay: 0.2s; }
        .fade-in-up:nth-child(5) { animation-delay: 0.25s; }

        /* Modal */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(10,15,40,0.7);
            backdrop-filter: blur(4px);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-box {
            background: white;
            border-radius: 24px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.3);
            overflow: hidden;
            animation: fadeInUp 0.3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #1a2c5b, #2a3f7a);
            padding: 24px 28px;
            color: white;
        }

        .modal-header h3 {
            font-family: 'Cinzel', serif;
            font-size: 1.1rem;
            color: var(--gold-light);
        }

        /* Form inputs */
        .cd-input {
            width: 100%;
            padding: 11px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-family: 'Lato', sans-serif;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            background: #fafafa;
            color: #1a1a1a;
        }

        .cd-input:focus {
            outline: none;
            border-color: var(--gold);
            background: white;
            box-shadow: 0 0 0 4px rgba(212,160,23,0.1);
        }

        .cd-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px;
            font-family: 'Cinzel', serif;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.25s ease;
            cursor: pointer;
            border: none;
        }

        .cd-btn-primary {
            background: linear-gradient(135deg, #1a2c5b, #2a3f7a);
            color: white;
            box-shadow: 0 4px 15px rgba(26,44,91,0.3);
        }

        .cd-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26,44,91,0.4);
        }

        .cd-btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: #1a2c5b;
            box-shadow: 0 4px 15px rgba(212,160,23,0.3);
        }

        .cd-btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212,160,23,0.5);
        }

        .timer-display {
            font-family: 'Cinzel Decorative', serif;
            font-size: 3rem;
            color: #1a2c5b;
            text-align: center;
            letter-spacing: 4px;
        }

        /* Badge */
        .centurion-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 50px;
            font-family: 'Cinzel', serif;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .badge-gold {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border: 1px solid #fcd34d;
        }

        .badge-silver {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .badge-bronze {
            background: linear-gradient(135deg, #fef3c7, #fed7aa);
            color: #7c2d12;
            border: 1px solid #fdba74;
        }

        /* Sidebar progress bar */
        .sidebar-progress {
            background: rgba(255,255,255,0.1);
            height: 4px;
            border-radius: 2px;
            overflow: hidden;
        }

        .sidebar-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            border-radius: 2px;
            transition: width 1s ease;
        }

        /* Scripture card */
        .scripture-card {
            background: linear-gradient(135deg, #1a2c5b 0%, #0f1f45 100%);
            border-radius: 20px;
            padding: 28px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .scripture-card::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 20px;
            font-size: 12rem;
            font-family: 'Cinzel Decorative', serif;
            color: rgba(212,160,23,0.08);
            line-height: 1;
            pointer-events: none;
        }

        /* Stats counter animation */
        @keyframes countUp {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        .stat-number { animation: countUp 0.6s ease; }

        /* Leaderboard row */
        .lb-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(212,160,23,0.08);
            transition: all 0.2s ease;
        }

        .lb-row:hover {
            background: rgba(212,160,23,0.03);
            padding-left: 8px;
        }

        .lb-rank {
            font-family: 'Cinzel Decorative', serif;
            font-size: 1.1rem;
            width: 32px;
            text-align: center;
        }
    </style>
    @stack('styles')
</head>
<body x-data="{ sidebarOpen: false }">

<!-- Particle Background -->
<div class="particle-bg" id="particles"></div>

{{-- ── Overlay — clicking anywhere outside sidebar closes it ──── --}}
<div class="sidebar-overlay"
     :class="{ 'open': sidebarOpen }"
     @click="sidebarOpen = false">
</div>

<!-- Sidebar -->
<aside class="sidebar" :class="{ 'open': sidebarOpen }">
    <div class="sidebar-logo">
        <div class="flex items-center gap-3 mb-1">
            <span class="logo-crown">👑</span>
            <div>
                <h1>Centurion<br>Diary</h1>
                <p>Rule of 100</p>
            </div>
        </div>

        {{-- Close button — visible on mobile only ──────────────── --}}
        <button class="sidebar-close-btn"
                @click="sidebarOpen = false"
                aria-label="Close sidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>

    @auth
    <!-- User mini profile -->
    <div style="padding: 16px 24px; border-bottom: 1px solid rgba(212,160,23,0.1);">
        <div class="flex items-center gap-3 mb-3">
            <div class="avatar" style="width:40px;height:40px;font-size:1rem;">
                {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
            </div>
            <div>
                <p style="color:rgba(255,255,255,0.9);font-family:'Cinzel',serif;font-size:0.8rem;font-weight:600;">
                    {{ Str::limit(auth()->user()->full_name, 18) }}
                </p>
                <p style="color:rgba(212,160,23,0.7);font-size:0.65rem;font-family:'Cinzel',serif;">
                    {{ auth()->user()->church }}
                </p>
            </div>
        </div>
        <!-- Overall Progress -->
        <div style="font-size:0.62rem;font-family:'Cinzel',serif;color:rgba(212,160,23,0.6);letter-spacing:1px;margin-bottom:4px;">OVERALL PROGRESS</div>
        <div class="sidebar-progress">
            <div class="sidebar-progress-fill" style="width: {{ auth()->user()->overall_progress }}%;"></div>
        </div>
        <p style="text-align:right;color:rgba(255,255,255,0.5);font-size:0.65rem;margin-top:3px;">{{ auth()->user()->overall_progress }}% to Centurion</p>
    </div>
    @endauth

    <nav style="padding: 8px 0; overflow-y: auto; max-height: calc(100vh - 280px);">

        <div class="nav-section">
            <div class="nav-section-title">Main</div>

            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <div class="icon"><i class="fas fa-home"></i></div>
                Home
            </a>

            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <div class="icon"><i class="fas fa-th-large"></i></div>
                Dashboard
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">The Three Pillars</div>
            <a href="{{ route('prayer.index') }}" class="nav-item {{ request()->routeIs('prayer.*') ? 'active' : '' }}">
                <div class="icon">🙏</div>
                Prayer Tracker
            </a>
            <a href="{{ route('souls.index') }}" class="nav-item {{ request()->routeIs('souls.*') ? 'active' : '' }}">
                <div class="icon">✨</div>
                Soul Winning
            </a>
            <a href="{{ route('giving.index') }}" class="nav-item {{ request()->routeIs('giving.*') ? 'active' : '' }}">
                <div class="icon">💝</div>
                Giving Ledger
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Community</div>
            <a href="{{ route('leaderboard') }}" class="nav-item {{ request()->routeIs('leaderboard') ? 'active' : '' }}">
                <div class="icon">🏆</div>
                Leaderboard
            </a>
            <a href="{{ route('scripture') }}" class="nav-item {{ request()->routeIs('scripture') ? 'active' : '' }}">
                <div class="icon">📖</div>
                Daily Scripture
            </a>
        </div>

        @auth
        @if(auth()->user()->is_admin)
        <div class="nav-section">
            <div class="nav-section-title">Admin</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <div class="icon"><i class="fas fa-shield-alt"></i></div>
                Admin Panel
            </a>
        </div>
        @endif
        @endauth

        <div class="nav-section" style="margin-top: auto;">
            <a href="{{ route('profile') }}" class="nav-item">
                <div class="icon"><i class="fas fa-user"></i></div>
                My Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item w-full text-left" style="background:none;border:none;">
                    <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
                    Sign Out
                </button>
            </form>
        </div>

    </nav>
</aside>

<!-- Main Content -->
<main class="main-content">
    <!-- Topbar -->
    <header class="topbar">
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
            <div>
                <p class="topbar-greeting">
                    @auth
                    Welcome back, <span>{{ auth()->user()->full_name }}</span> 🔥
                    @else
                    <span>Centurion Diary</span>
                    @endauth
                </p>
                <p style="font-size:0.72rem;color:#999;font-family:'Cinzel',serif;">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>

        @auth
        <div class="flex items-center gap-3">
            <!-- Notification bell -->
            <div class="relative cursor-pointer p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-bell text-gray-500"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </div>

            <div class="user-badge">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}</div>
                <span style="font-family:'Cinzel',serif;font-size:0.78rem;">{{ Str::words(auth()->user()->full_name, 1, '') }}</span>
                <i class="fas fa-chevron-down" style="font-size:0.65rem;opacity:0.7;"></i>
            </div>
        </div>
        @endauth
    </header>

    <!-- Flash Messages -->
    <div style="padding: 0 32px; padding-top: 20px;">
        @if(session('success'))
        <div class="flash-success fade-in-up">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div style="background:linear-gradient(135deg,#7c2d12,#c2410c);color:white;padding:12px 20px;border-radius:12px;margin-bottom:20px;font-family:'Cinzel',serif;font-size:0.85rem;" class="fade-in-up">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ $errors->first() }}
        </div>
        @endif
    </div>

    <!-- Page Content -->
    <div style="padding: 0 32px 40px;">
        @yield('content')
    </div>
</main>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>

<script>
// Generate particles
function createParticles() {
    const container = document.getElementById('particles');
    if (!container) return;
    for (let i = 0; i < 20; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.left = Math.random() * 100 + '%';
        p.style.width = p.style.height = (Math.random() * 4 + 2) + 'px';
        p.style.animationDuration = (Math.random() * 15 + 10) + 's';
        p.style.animationDelay = (Math.random() * 10) + 's';
        p.style.opacity = Math.random() * 0.5;
        container.appendChild(p);
    }
}
createParticles();

// Animate progress rings on load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.progress-ring-circle[data-progress]').forEach(circle => {
        const radius = circle.getAttribute('r');
        const circumference = 2 * Math.PI * radius;
        const progress = circle.getAttribute('data-progress');
        const offset = circumference - (progress / 100) * circumference;
        circle.style.strokeDasharray = circumference;
        circle.style.strokeDashoffset = offset;
    });
});
</script>

{{-- ── Service Worker + Push Notification Setup ─────────────────────────── --}}
<script>
  // ── Helpers ──────────────────────────────────────────────────────
  function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
    const base64  = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const raw     = atob(base64);
    return Uint8Array.from([...raw].map(c => c.charCodeAt(0)));
  }

  async function subscribeToPush(registration) {
    try {
      // Check if already subscribed
      const existing = await registration.pushManager.getSubscription();
      if (existing) return;

      const vapidKey = '{{ config("webpush.vapid.public_key") }}';
      if (!vapidKey) return;

      const subscription = await registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(vapidKey),
      });

      await fetch('/push/subscribe', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(subscription),
      });

      console.log('✅ Push subscription saved.');
    } catch (err) {
      console.error('❌ Push subscription failed:', err);
    }
  }

  async function requestNotificationPermission(registration) {
    if (!('Notification' in window)) return;
    if (Notification.permission === 'granted') {
      // Already granted — just subscribe silently
      await subscribeToPush(registration);
      return;
    }
    if (Notification.permission === 'denied') return;

    // Show a friendly prompt button instead of firing the browser dialog immediately
    showNotificationBanner(registration);
  }

  function showNotificationBanner(registration) {
    // Don't show if already dismissed
    if (localStorage.getItem('push_banner_dismissed')) return;

    const banner = document.createElement('div');
    banner.id = 'push-banner';
    banner.innerHTML = `
      <div style="
        position:fixed;bottom:24px;left:50%;transform:translateX(-50%);
        background:linear-gradient(135deg,#1a2c5b,#2a3f7a);
        color:white;padding:16px 24px;border-radius:16px;
        box-shadow:0 8px 32px rgba(0,0,0,0.3);
        display:flex;align-items:center;gap:16px;
        font-family:'Cinzel',serif;font-size:0.82rem;
        z-index:9999;max-width:420px;width:calc(100% - 48px);
        animation:slideUp 0.4s cubic-bezier(0.34,1.56,0.64,1);
      ">
        <span style="font-size:1.6rem;flex-shrink:0;">🙏</span>
        <div style="flex:1;">
          <p style="font-weight:700;color:#f5d060;margin-bottom:3px;">Stay Spiritually Accountable</p>
          <p style="color:rgba(255,255,255,0.7);font-size:0.75rem;">Enable notifications for prayer reminders & updates.</p>
        </div>
        <div style="display:flex;flex-direction:column;gap:6px;flex-shrink:0;">
          <button id="push-allow" style="
            background:linear-gradient(135deg,#d4a017,#f5d060);
            color:#1a2c5b;border:none;padding:7px 16px;
            border-radius:8px;font-family:'Cinzel',serif;
            font-size:0.72rem;font-weight:700;cursor:pointer;
            white-space:nowrap;
          ">Allow</button>
          <button id="push-dismiss" style="
            background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.6);
            border:1px solid rgba(255,255,255,0.15);padding:5px 16px;
            border-radius:8px;font-family:'Cinzel',serif;
            font-size:0.68rem;cursor:pointer;white-space:nowrap;
          ">Not now</button>
        </div>
      </div>
      <style>
        @keyframes slideUp {
          from { opacity:0; transform:translateX(-50%) translateY(20px); }
          to   { opacity:1; transform:translateX(-50%) translateY(0); }
        }
      </style>
    `;

    document.body.appendChild(banner);

    // Allow button — triggers the real browser permission dialog
    document.getElementById('push-allow').addEventListener('click', async () => {
      banner.remove();
      const permission = await Notification.requestPermission();
      if (permission === 'granted') {
        await subscribeToPush(registration);
      }
    });

    // Dismiss button — hide for 7 days
    document.getElementById('push-dismiss').addEventListener('click', () => {
      banner.remove();
      localStorage.setItem('push_banner_dismissed', Date.now());
    });

    // Auto-dismiss after 10 seconds
    setTimeout(() => {
      if (document.getElementById('push-banner')) {
        banner.remove();
      }
    }, 10000);
  }

  // ── Register Service Worker ───────────────────────────────────────
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', async () => {
      try {
        const registration = await navigator.serviceWorker.register('/sw.js');
        console.log('✅ SW registered.');

        // Wait for SW to be active before prompting
        if (registration.active) {
          await requestNotificationPermission(registration);
        } else {
          registration.addEventListener('updatefound', () => {
            const newWorker = registration.installing;
            newWorker.addEventListener('statechange', async () => {
              if (newWorker.state === 'activated') {
                await requestNotificationPermission(registration);
              }
            });
          });

          // Fallback: prompt after short delay
          setTimeout(() => requestNotificationPermission(registration), 3000);
        }
      } catch (err) {
        console.error('❌ SW registration failed:', err);
      }
    });
  }
</script>

@stack('scripts')
</body>
</html>
