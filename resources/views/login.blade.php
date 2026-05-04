@extends('layouts.auth')
@section('title', 'Sign In — Centurion Diary')

@section('left-panel')
<div sstyle="
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 100vh;
    overflow: hidden;
">
    {{-- Background image --}}
     <img
        src="{{ asset('images/join.jpeg') }}"
        alt="Join Centurion Diary"
        style="
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        "
    >

    {{-- Dark overlay for readability --}}
    <div style="
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(10, 18, 45, 0.45) 0%,
            rgba(10, 18, 45, 0.75) 100%
        );
    "></div>

    {{-- Content layered on top --}}
    <div style="
        position: relative;
        z-index: 1;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 48px 40px;
    ">
        {{-- Logo / Brand mark --}}
        <div style="margin-bottom: auto; padding-top: 40px;">
            <div style="
                display: inline-flex;
                align-items: center;
                gap: 10px;
                background: rgba(255,255,255,0.08);
                border: 1px solid rgba(212,160,23,0.3);
                border-radius: 50px;
                padding: 8px 18px;
                backdrop-filter: blur(8px);
            ">
                <i class="fas fa-shield-alt" style="color: #d4a017; font-size: 0.85rem;"></i>
                <span style="font-family:'Cinzel',serif; font-size: 0.75rem; color: rgba(255,255,255,0.9); letter-spacing: 0.08em;">CENTURION DIARY</span>
            </div>
        </div>

        {{-- Bottom quote / tagline --}}
        <div>
            <blockquote style="
                font-family: 'Cinzel', serif;
                font-size: 1.45rem;
                font-weight: 600;
                color: #ffffff;
                line-height: 1.55;
                margin: 0 0 16px;
                text-shadow: 0 2px 12px rgba(0,0,0,0.5);
            ">
                "Track your walk.<br>Strengthen your faith."
            </blockquote>
            <p style="
                font-family: 'Cinzel', serif;
                font-size: 0.72rem;
                color: rgba(212, 160, 23, 0.8);
                letter-spacing: 0.12em;
                text-transform: uppercase;
                margin: 0;
            ">Your Spiritual Growth Journal</p>

            {{-- Stats row --}}
            <div style="
                display: flex;
                gap: 28px;
                margin-top: 28px;
                padding-top: 24px;
                border-top: 1px solid rgba(255,255,255,0.12);
            ">
                <div>
                    <p style="font-family:'Cinzel',serif; font-size: 1.2rem; font-weight: 700; color: #f5d060; margin: 0;">100+</p>
                    <p style="font-size: 0.68rem; color: rgba(255,255,255,0.5); margin: 4px 0 0; font-family:'Cinzel',serif; letter-spacing: 0.05em;">Days Tracked</p>
                </div>
                <div>
                    <p style="font-family:'Cinzel',serif; font-size: 1.2rem; font-weight: 700; color: #f5d060; margin: 0;">Daily</p>
                    <p style="font-size: 0.68rem; color: rgba(255,255,255,0.5); margin: 4px 0 0; font-family:'Cinzel',serif; letter-spacing: 0.05em;">Scripture Verses</p>
                </div>
                <div>
                    <p style="font-family:'Cinzel',serif; font-size: 1.2rem; font-weight: 700; color: #f5d060; margin: 0;">∞</p>
                    <p style="font-size: 0.68rem; color: rgba(255,255,255,0.5); margin: 4px 0 0; font-family:'Cinzel',serif; letter-spacing: 0.05em;">Growth Potential</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('form')
<div>
    <h2 class="auth-form-title">Welcome Back, Centurion</h2>
    <p class="auth-form-subtitle">Your journey continues. Sign in to track your spiritual growth.</p>

    @if($errors->any())
    <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:12px 16px;margin-bottom:20px;color:#dc2626;font-size:0.82rem;">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
    </div>
    @endif

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:12px 16px;margin-bottom:20px;color:#166534;font-size:0.82rem;font-family:'Cinzel',serif;">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <div class="form-group">
            <label>Email Address</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" class="form-input has-icon"
                       placeholder="your@email.com"
                       value="{{ old('email') }}" required autofocus>
            </div>
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="input-wrapper" x-data="{ show: false }">
                <i class="fas fa-lock input-icon"></i>
                <input :type="show ? 'text' : 'password'" name="password"
                       class="form-input has-icon" placeholder="Your password" required
                       style="padding-right: 44px;">
                <button type="button" @click="show = !show"
                        style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:#9ca3af;cursor:pointer;font-size:0.85rem;">
                    <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                </button>
            </div>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:0.85rem;color:#6b7280;">
                <input type="checkbox" name="remember" style="accent-color:#1a2c5b;">
                Remember me
            </label>
            <a href="{{ route('password.request') }}" style="font-family:'Cinzel',serif;font-size:0.75rem;color:#1a2c5b;text-decoration:none;border-bottom:1px solid rgba(26,44,91,0.2);">
                Forgot Password?
            </a>
        </div>

        <button type="submit" class="submit-btn" :disabled="loading">
            <span x-show="!loading"><i class="fas fa-sign-in-alt mr-2"></i>Enter the Centurion Diary</span>
            <span x-show="loading"><i class="fas fa-spinner fa-spin mr-2"></i>Signing In...</span>
        </button>
    </form>

    <!-- Daily Verse Preview -->
    <div style="margin-top:28px;padding:20px;background:linear-gradient(135deg,#1a2c5b,#2a3f7a);border-radius:16px;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-15px;left:15px;font-size:6rem;font-family:'Cinzel Decorative',serif;color:rgba(212,160,23,0.06);pointer-events:none;">"</div>
        <p style="font-family:'Cinzel',serif;font-size:0.78rem;color:rgba(245,208,96,0.85);line-height:1.7;position:relative;">
            I can do all things through Christ who strengthens me.
        </p>
        <p style="font-size:0.7rem;color:rgba(255,255,255,0.35);margin-top:8px;font-family:'Cinzel',serif;">— Philippians 4:13</p>
    </div>

    <div class="auth-link">
        New to Centurion Diary? <a href="{{ route('register') }}">Create an Account</a>
    </div>
</div>
@endsection
