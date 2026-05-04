@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div x-data="{ tab: 'info' }">

    <div style="margin-bottom:24px;" class="fade-in-up">
        <h1 style="font-family:'Cinzel Decorative',serif;font-size:1.6rem;color:#1a2c5b;">👤 My Profile</h1>
        <p style="font-size:0.88rem;color:#6b7280;margin-top:4px;font-family:'Cinzel',serif;">Manage your account and prayer schedule</p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 2fr;gap:20px;">

        <!-- Profile Card -->
        <div class="centurion-card fade-in-up" style="padding:28px;text-align:center;height:fit-content;">
            <!-- Avatar -->
            <div style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#d4a017,#f5d060);display:flex;align-items:center;justify-content:center;font-family:'Cinzel Decorative',serif;font-size:2rem;color:#1a2c5b;margin:0 auto 16px;box-shadow:0 8px 30px rgba(212,160,23,0.3);" class="glow-gold">
                {{ strtoupper(substr($user->full_name, 0, 2)) }}
            </div>

            <h2 style="font-family:'Cinzel',serif;font-size:1.1rem;color:#1a2c5b;font-weight:700;">{{ $user->full_name }}</h2>
            <p style="font-size:0.82rem;color:#6b7280;margin-top:4px;">{{ $user->email }}</p>
            <p style="font-family:'Cinzel',serif;font-size:0.75rem;color:#d4a017;margin-top:6px;">{{ $user->church }}</p>

            @if($user->is_admin)
            <span style="display:inline-block;margin-top:10px;background:linear-gradient(135deg,#d4a017,#f5d060);color:#1a2c5b;padding:4px 14px;border-radius:20px;font-family:'Cinzel',serif;font-size:0.7rem;font-weight:700;">
                🛡️ Administrator
            </span>
            @endif

            <div style="margin-top:20px;padding-top:20px;border-top:1px solid rgba(212,160,23,0.1);">
                <!-- Overall progress ring -->
                <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;color:#9ca3af;text-transform:uppercase;margin-bottom:12px;">Centurion Progress</p>
                <div style="position:relative;display:inline-flex;align-items:center;justify-content:center;">
                    <svg width="120" height="120" class="progress-ring">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#f3f4f6" stroke-width="8"/>
                        <circle cx="60" cy="60" r="50" fill="none"
                                stroke="url(#profileGrad)" stroke-width="8"
                                class="progress-ring-circle"
                                data-progress="{{ $user->overall_progress }}"
                                style="stroke-dasharray:{{ 2 * M_PI * 50 }};stroke-dashoffset:{{ 2 * M_PI * 50 * (1 - $user->overall_progress / 100) }}"/>
                        <defs>
                            <linearGradient id="profileGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#d4a017"/>
                                <stop offset="100%" stop-color="#f5d060"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <div style="position:absolute;text-align:center;">
                        <p style="font-family:'Cinzel Decorative',serif;font-size:1.2rem;color:#1a2c5b;">{{ $user->overall_progress }}%</p>
                    </div>
                </div>

                <!-- Mini pillar bars -->
                <div style="margin-top:16px;text-align:left;">
                    @php $pillars = [
                        ['icon'=>'🙏','label'=>'Prayer','value'=>min($user->prayer_hours,100),'max'=>100,'unit'=>'h','color'=>'#1a2c5b'],
                        ['icon'=>'✨','label'=>'Souls','value'=>min($user->souls_count,100),'max'=>100,'unit'=>'','color'=>'#c2410c'],
                        ['icon'=>'💝','label'=>'Giving','value'=>min($user->giving_espees,100),'max'=>100,'unit'=>' esp','color'=>'#15803d'],
                    ]; @endphp
                    @foreach($pillars as $p)
                    <div style="margin-bottom:10px;">
                        <div style="display:flex;justify-content:space-between;margin-bottom:3px;">
                            <span style="font-family:'Cinzel',serif;font-size:0.72rem;color:#374151;">{{ $p['icon'] }} {{ $p['label'] }}</span>
                            <span style="font-family:'Cinzel',serif;font-size:0.72rem;color:{{ $p['color'] }};font-weight:700;">{{ number_format($p['value'],1) }}{{ $p['unit'] }}</span>
                        </div>
                        <div style="background:#f3f4f6;height:5px;border-radius:3px;overflow:hidden;">
                            <div style="height:100%;width:{{ ($p['value']/$p['max'])*100 }}%;background:{{ $p['color'] }};border-radius:3px;"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div style="margin-top:20px;padding-top:20px;border-top:1px solid rgba(212,160,23,0.1);font-family:'Cinzel',serif;font-size:0.72rem;color:#9ca3af;">
                Member since {{ $user->created_at->format('F Y') }}
            </div>
        </div>

        <!-- Edit Forms -->
        <div>
            <!-- Tab nav -->
            <div style="display:flex;gap:4px;margin-bottom:20px;background:#f3f4f6;padding:4px;border-radius:12px;width:fit-content;">
                <button @click="tab='info'"
                        :style="tab==='info' ? 'background:white;color:#1a2c5b;box-shadow:0 2px 8px rgba(0,0,0,0.08);' : 'background:transparent;color:#6b7280;'"
                        style="font-family:'Cinzel',serif;font-size:0.78rem;padding:8px 18px;border:none;border-radius:9px;cursor:pointer;transition:all 0.2s;">
                    Personal Info
                </button>
                <button @click="tab='security'"
                        :style="tab==='security' ? 'background:white;color:#1a2c5b;box-shadow:0 2px 8px rgba(0,0,0,0.08);' : 'background:transparent;color:#6b7280;'"
                        style="font-family:'Cinzel',serif;font-size:0.78rem;padding:8px 18px;border:none;border-radius:9px;cursor:pointer;transition:all 0.2s;">
                    Security
                </button>
                <button @click="tab='schedule'"
                        :style="tab==='schedule' ? 'background:white;color:#1a2c5b;box-shadow:0 2px 8px rgba(0,0,0,0.08);' : 'background:transparent;color:#6b7280;'"
                        style="font-family:'Cinzel',serif;font-size:0.78rem;padding:8px 18px;border:none;border-radius:9px;cursor:pointer;transition:all 0.2s;">
                    Prayer Schedule
                </button>
            </div>

            <!-- Personal Info -->
            <div x-show="tab==='info'" class="centurion-card fade-in-up" style="padding:28px;">
                <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;margin-bottom:20px;">Personal Information</h3>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                        <div>
                            <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Full Name *</label>
                            <input type="text" name="full_name" class="cd-input" value="{{ old('full_name', $user->full_name) }}" required>
                        </div>
                        <div>
                            <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Email</label>
                            <input type="email" class="cd-input" value="{{ $user->email }}" disabled style="background:#f9fafb;color:#9ca3af;cursor:not-allowed;">
                            <p style="font-size:0.7rem;color:#9ca3af;margin-top:3px;">Email cannot be changed.</p>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                        <div>
                            <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Phone *</label>
                            <input type="tel" name="phone" class="cd-input" value="{{ old('phone', $user->phone) }}" required>
                        </div>
                        <div>
                            <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">KingsChat *</label>
                            <input type="text" name="kingschat" class="cd-input" value="{{ old('kingschat', $user->kingschat) }}" required>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px;">
                        <div>
                            <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Group / Zone *</label>
                            <input type="text" name="group" class="cd-input" value="{{ old('group', $user->group) }}" required>
                        </div>
                        <div>
                            <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Church / Fellowship *</label>
                            <input type="text" name="church" class="cd-input" value="{{ old('church', $user->church) }}" required>
                        </div>
                    </div>

                    <button type="submit" class="cd-btn cd-btn-primary">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </form>
            </div>

            <!-- Security -->
            <div x-show="tab==='security'" class="centurion-card fade-in-up" style="padding:28px;">
                <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;margin-bottom:20px;">Change Password</h3>

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PATCH')

                    <div style="margin-bottom:16px;">
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Current Password *</label>
                        <input type="password" name="current_password" class="cd-input" required>
                        @error('current_password') <p style="color:#dc2626;font-size:0.75rem;margin-top:4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">New Password *</label>
                        <input type="password" name="password" class="cd-input" required>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Confirm New Password *</label>
                        <input type="password" name="password_confirmation" class="cd-input" required>
                    </div>

                    <button type="submit" class="cd-btn cd-btn-primary">
                        <i class="fas fa-lock"></i> Update Password
                    </button>
                </form>
            </div>

            <!-- Prayer Schedule -->
            <div x-show="tab==='schedule'" class="centurion-card fade-in-up" style="padding:28px;">
                <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;margin-bottom:8px;">🙏 Daily Prayer Reminder</h3>
                <p style="font-size:0.85rem;color:#6b7280;margin-bottom:20px;">Set your daily prayer time. You will receive a push notification to remind you.</p>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="full_name" value="{{ $user->full_name }}">
                    <input type="hidden" name="phone" value="{{ $user->phone }}">
                    <input type="hidden" name="kingschat" value="{{ $user->kingschat }}">
                    <input type="hidden" name="group" value="{{ $user->group }}">
                    <input type="hidden" name="church" value="{{ $user->church }}">

                    <div style="max-width:260px;margin-bottom:24px;">
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Preferred Prayer Time</label>
                        <input type="time" name="prayer_time" class="cd-input" value="{{ old('prayer_time', $user->prayer_time) }}">
                    </div>

                    <div style="padding:16px;background:linear-gradient(135deg,#eff6ff,#dbeafe);border-radius:12px;margin-bottom:24px;">
                        <p style="font-family:'Cinzel',serif;font-size:0.8rem;color:#1d4ed8;font-weight:600;">📱 PWA Notifications</p>
                        <p style="font-size:0.78rem;color:#3b82f6;margin-top:4px;">Install this app on your device for daily prayer reminders at your chosen time.</p>
                    </div>

                    <button type="submit" class="cd-btn cd-btn-primary">
                        <i class="fas fa-bell"></i> Save Prayer Schedule
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
