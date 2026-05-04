@extends('layouts.auth')
@section('title', 'Reset Password')

@section('form')
<div>
    <h2 class="auth-form-title">Reset Your Password</h2>
    <p class="auth-form-subtitle">Enter your email and we'll send you a reset link.</p>

    @if(session('status'))
    <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:12px 16px;margin-bottom:20px;color:#166534;font-size:0.82rem;font-family:'Cinzel',serif;">
        <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" x-data="{ loading: false }" @submit="loading = true">
        @csrf
        <div class="form-group">
            <label>Email Address</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" class="form-input has-icon"
                       placeholder="your@email.com" value="{{ old('email') }}" required autofocus>
            </div>
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="submit-btn" :disabled="loading">
            <span x-show="!loading"><i class="fas fa-paper-plane mr-2"></i>Send Reset Link</span>
            <span x-show="loading"><i class="fas fa-spinner fa-spin mr-2"></i>Sending...</span>
        </button>
    </form>

    <div class="auth-link">
        Remember your password? <a href="{{ route('login') }}">Sign In</a>
    </div>
</div>
@endsection
