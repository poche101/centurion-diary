@extends('layouts.auth')
@section('title', 'Join Centurion Diary')

@section('form')
<div>
    <h2 class="auth-form-title">Begin Your Journey</h2>
    <p class="auth-form-subtitle">Join thousands walking the path of excellence. Create your Centurion account.</p>

    @if($errors->any())
    <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:12px;padding:12px 16px;margin-bottom:20px;color:#dc2626;font-size:0.82rem;">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}" x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <div class="form-grid-2">
            <div class="form-group">
                <label>Full Name *</label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="full_name" class="form-input has-icon" placeholder="Your full name"
                           value="{{ old('full_name') }}" required>
                </div>
                @error('full_name') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Email Address *</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-input has-icon" placeholder="you@example.com"
                           value="{{ old('email') }}" required>
                </div>
                @error('email') <p class="error-msg">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label>Phone Number *</label>
                <div class="input-wrapper">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="tel" name="phone" class="form-input has-icon" placeholder="+234..."
                           value="{{ old('phone') }}" required>
                </div>
                @error('phone') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>KingsChat Username *</label>
                <div class="input-wrapper">
                    <i class="fas fa-comments input-icon"></i>
                    <input type="text" name="kingschat" class="form-input has-icon" placeholder="@username"
                           value="{{ old('kingschat') }}" required>
                </div>
                @error('kingschat') <p class="error-msg">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label>Group / Zone *</label>
                <div class="input-wrapper">
                    <i class="fas fa-users input-icon"></i>
                    <input type="text" name="group" class="form-input has-icon" placeholder="Your group/zone"
                           value="{{ old('group') }}" required>
                </div>
                @error('group') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Church / Fellowship *</label>
                <div class="input-wrapper">
                    <i class="fas fa-church input-icon"></i>
                    <input type="text" name="church" class="form-input has-icon" placeholder="Your church"
                           value="{{ old('church') }}" required>
                </div>
                @error('church') <p class="error-msg">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label>Password *</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-input has-icon" placeholder="Min. 8 characters" required>
                </div>
                @error('password') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Confirm Password *</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password_confirmation" class="form-input has-icon" placeholder="Confirm password" required>
                </div>
            </div>
        </div>

        <!-- Prayer Reminder Slot -->
        <div class="form-group">
            <label>🙏 Daily Prayer Reminder Time</label>
            <div class="input-wrapper">
                <i class="fas fa-clock input-icon"></i>
                <input type="time" name="prayer_time" class="form-input has-icon"
                       value="{{ old('prayer_time', '06:00') }}">
            </div>
            <p style="font-size:0.72rem;color:#9ca3af;margin-top:4px;">You'll receive a daily push notification at this time.</p>
        </div>

        <button type="submit" class="submit-btn" :disabled="loading">
            <span x-show="!loading"><i class="fas fa-crown mr-2"></i>Create My Centurion Account</span>
            <span x-show="loading"><i class="fas fa-spinner fa-spin mr-2"></i>Creating Account...</span>
        </button>

        <div style="margin-top:14px;padding:14px;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:12px;border:1px solid #fcd34d;text-align:center;">
            <p style="font-family:'Cinzel',serif;font-size:0.75rem;color:#92400e;">
                🏆 Join the Centurion Elite — 100 Hours · 100 Souls · 100 Espees
            </p>
        </div>
    </form>

    <div class="auth-link">
        Already have an account? <a href="{{ route('login') }}">Sign In Here</a>
    </div>
</div>
@endsection
