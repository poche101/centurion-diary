@extends('layouts.app')
@section('title', 'Prayer Tracker')

@section('content')
<div x-data="prayerApp()">

    <!-- Page Header -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;" class="fade-in-up">
        <div>
            <h1 style="font-family:'Cinzel Decorative',serif;font-size:1.6rem;color:#1a2c5b;">🙏 Prayer Tracker</h1>
            <p style="font-size:0.88rem;color:#6b7280;margin-top:4px;font-family:'Cinzel',serif;">Journey toward 100 Hours of Intercession</p>
        </div>
        <button @click="showModal = true" class="cd-btn cd-btn-gold">
            <i class="fas fa-plus"></i> Log Prayer Session
        </button>
    </div>

    <!-- Stats Row -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:28px;">
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Total Hours</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2rem;color:#1a2c5b;" class="stat-number">{{ number_format($totalHours, 1) }}</p>
            <p style="font-size:0.72rem;color:#d4a017;font-family:'Cinzel',serif;">of 100 hours</p>
        </div>
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Sessions Logged</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2rem;color:#1a2c5b;" class="stat-number">{{ $totalSessions }}</p>
            <p style="font-size:0.72rem;color:#6b7280;font-family:'Cinzel',serif;">all time</p>
        </div>
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Today</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2rem;color:#1a2c5b;" class="stat-number">{{ $todayMinutes }}</p>
            <p style="font-size:0.72rem;color:#6b7280;font-family:'Cinzel',serif;">minutes</p>
        </div>
        <div class="centurion-card fade-in-up" style="padding:20px;text-align:center;">
            <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:8px;">Streak</p>
            <p style="font-family:'Cinzel Decorative',serif;font-size:2rem;color:#1a2c5b;" class="stat-number">{{ $streak }}</p>
            <p style="font-size:0.72rem;color:#d4a017;font-family:'Cinzel',serif;">🔥 days</p>
        </div>
    </div>

    <!-- Main Progress + Log List -->
    <div style="display:grid;grid-template-columns:1fr 2fr;gap:20px;">

        <!-- Big Progress Ring + Milestones -->
        <div class="centurion-card fade-in-up" style="padding:28px;text-align:center;">
            <p style="font-family:'Cinzel',serif;font-size:0.72rem;letter-spacing:2px;text-transform:uppercase;color:#9ca3af;margin-bottom:20px;">Progress to Centurion</p>

            <div style="position:relative;display:inline-flex;align-items:center;justify-content:center;margin-bottom:20px;">
                <svg width="180" height="180" class="progress-ring">
                    <circle cx="90" cy="90" r="78" fill="none" stroke="#f3f4f6" stroke-width="12"/>
                    <circle cx="90" cy="90" r="78" fill="none"
                            stroke="url(#prayerGrad)" stroke-width="12"
                            class="progress-ring-circle"
                            data-progress="{{ min($prayerPercent, 100) }}"
                            style="stroke-dasharray:{{ 2 * M_PI * 78 }};stroke-dashoffset:{{ 2 * M_PI * 78 * (1 - min($prayerPercent, 100) / 100) }}"/>
                    <defs>
                        <linearGradient id="prayerGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#1a2c5b"/>
                            <stop offset="100%" stop-color="#4a7fd4"/>
                        </linearGradient>
                    </defs>
                </svg>
                <div style="position:absolute;text-align:center;">
                    <p style="font-family:'Cinzel Decorative',serif;font-size:1.8rem;color:#1a2c5b;line-height:1;">{{ number_format($prayerPercent, 0) }}%</p>
                    <p style="font-size:0.62rem;font-family:'Cinzel',serif;color:#9ca3af;letter-spacing:1px;margin-top:2px;">COMPLETE</p>
                </div>
            </div>

            <!-- Milestones -->
            <div style="width:100%;">
                <p style="font-family:'Cinzel',serif;font-size:0.72rem;letter-spacing:1px;color:#9ca3af;margin-bottom:12px;text-transform:uppercase;">Milestones</p>
                @foreach([25 => '25 Hours', 50 => '50 Hours', 75 => '75 Hours', 100 => '🏆 100 Hours — Centurion!'] as $milestone => $label)
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                    <div style="width:20px;height:20px;border-radius:50%;border:2px solid {{ $totalHours >= $milestone ? '#1a2c5b' : '#e5e7eb' }};background:{{ $totalHours >= $milestone ? '#1a2c5b' : 'transparent' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        @if($totalHours >= $milestone)
                        <i class="fas fa-check" style="font-size:0.55rem;color:white;"></i>
                        @endif
                    </div>
                    <p style="font-family:'Cinzel',serif;font-size:0.75rem;color:{{ $totalHours >= $milestone ? '#1a2c5b' : '#9ca3af' }};{{ $milestone === 100 && $totalHours >= 100 ? 'font-weight:700;' : '' }}">{{ $label }}</p>
                    @if($totalHours >= $milestone)
                    <span style="margin-left:auto;font-size:0.65rem;color:#d4a017;">✓</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Prayer Log History -->
        <div class="centurion-card fade-in-up" style="padding:24px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;">Prayer Sessions</h3>
                <div style="display:flex;gap:8px;">
                    <select style="border:1px solid #e5e7eb;border-radius:8px;padding:6px 12px;font-size:0.78rem;font-family:'Cinzel',serif;color:#374151;background:white;">
                        <option>All Time</option>
                        <option>This Month</option>
                        <option>This Week</option>
                    </select>
                </div>
            </div>

            <div style="overflow-y:auto;max-height:420px;">
                @forelse($prayerLogs as $log)
                <div style="display:flex;align-items:flex-start;gap:14px;padding:14px 0;border-bottom:1px solid rgba(212,160,23,0.06);">
                    <div style="width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,#1a2c5b,#2a3f7a);display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">
                        🙏
                    </div>
                    <div style="flex:1;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                            <p style="font-family:'Cinzel',serif;font-size:0.85rem;color:#1a2c5b;font-weight:600;">
                                {{ $log->duration_minutes >= 60 ? floor($log->duration_minutes/60).'h '.($log->duration_minutes%60).'m' : $log->duration_minutes.' min' }}
                                <span style="font-weight:400;color:#6b7280;font-size:0.75rem;">of prayer</span>
                            </p>
                            <span style="font-size:0.7rem;color:#9ca3af;font-family:'Cinzel',serif;">{{ $log->created_at->format('M j, Y') }}</span>
                        </div>
                        @if($log->notes)
                        <p style="font-size:0.78rem;color:#6b7280;line-height:1.5;font-style:italic;">"{{ $log->notes }}"</p>
                        @endif
                        @if($log->prayer_type)
                        <span style="display:inline-block;margin-top:4px;background:#eff6ff;color:#1d4ed8;padding:2px 10px;border-radius:20px;font-size:0.65rem;font-family:'Cinzel',serif;">
                            {{ ucfirst($log->prayer_type) }}
                        </span>
                        @endif
                    </div>
                    <div style="text-align:right;font-family:'Cinzel',serif;font-size:0.8rem;color:#d4a017;font-weight:700;">
                        +{{ number_format($log->duration_minutes / 60, 2) }}h
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:40px 0;">
                    <p style="font-size:3rem;margin-bottom:12px;">🙏</p>
                    <p style="font-family:'Cinzel',serif;font-size:0.9rem;color:#374151;font-weight:600;">Begin Your Prayer Journey</p>
                    <p style="font-size:0.8rem;color:#9ca3af;margin-top:6px;">Log your first prayer session to start tracking.</p>
                    <button @click="showModal = true" class="cd-btn cd-btn-primary" style="margin-top:16px;font-size:0.8rem;">
                        Log First Session
                    </button>
                </div>
                @endforelse
            </div>

            @if($prayerLogs->hasPages())
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid #f3f4f6;">
                {{ $prayerLogs->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Log Prayer Modal -->
    <div x-show="showModal" x-transition.opacity class="modal-overlay" @click.self="showModal = false">
        <div class="modal-box" @click.stop>
            <div class="modal-header">
                <div style="display:flex;align-items:center;gap:12px;">
                    <span style="font-size:1.5rem;">🙏</span>
                    <div>
                        <h3>Log Prayer Session</h3>
                        <p style="color:rgba(255,255,255,0.5);font-size:0.75rem;margin-top:2px;">Record your time with God</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('prayer.store') }}" style="padding:24px;">
                @csrf

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Date *</label>
                        <input type="date" name="prayer_date" class="cd-input"
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Duration (minutes) *</label>
                        <input type="number" name="duration_minutes" class="cd-input"
                               placeholder="e.g. 30" min="1" max="720" required>
                    </div>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Prayer Type</label>
                    <select name="prayer_type" class="cd-input">
                        <option value="intercession">Intercession</option>
                        <option value="worship">Worship & Adoration</option>
                        <option value="tongues">Praying in Tongues</option>
                        <option value="meditation">Word Meditation</option>
                        <option value="general">General Prayer</option>
                    </select>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Notes / Testimony</label>
                    <textarea name="notes" class="cd-input" rows="3"
                              placeholder="What did God reveal during prayer?..."
                              style="resize:vertical;"></textarea>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <button type="button" @click="showModal = false" class="cd-btn" style="background:#f3f4f6;color:#6b7280;">
                        Cancel
                    </button>
                    <button type="submit" class="cd-btn cd-btn-primary">
                        <i class="fas fa-save"></i> Save Prayer Session
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function prayerApp() {
    return {
        showModal: {{ $errors->any() ? 'true' : 'false' }}
    }
}
</script>
@endpush
