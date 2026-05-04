@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

<div style="margin-bottom:24px;" class="fade-in-up">
    <div style="display:flex;align-items:center;gap:12px;">
        <div style="width:48px;height:48px;background:linear-gradient(135deg,#d4a017,#f5d060);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">
            🛡️
        </div>
        <div>
            <h1 style="font-family:'Cinzel Decorative',serif;font-size:1.6rem;color:#1a2c5b;">Admin Command Center</h1>
            <p style="font-size:0.85rem;color:#6b7280;font-family:'Cinzel',serif;">Overseeing the spiritual health of the community</p>
        </div>
    </div>
</div>

<!-- Global Stats -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:28px;">

    <div class="centurion-card fade-in-up" style="padding:22px;background:linear-gradient(135deg,#1a2c5b,#2a3f7a);color:white;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <span style="font-size:1.5rem;">👥</span>
            <span style="font-family:'Cinzel',serif;font-size:0.62rem;letter-spacing:2px;color:rgba(245,208,96,0.6);text-transform:uppercase;">Members</span>
        </div>
        <p style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:#f5d060;">{{ $totalUsers }}</p>
        <p style="font-size:0.75rem;color:rgba(255,255,255,0.4);margin-top:4px;font-family:'Cinzel',serif;">{{ $activeToday }} active today</p>
    </div>

    <div class="centurion-card fade-in-up" style="padding:22px;background:linear-gradient(135deg,#0f3460,#1e4d87);color:white;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <span style="font-size:1.5rem;">🙏</span>
            <span style="font-family:'Cinzel',serif;font-size:0.62rem;letter-spacing:2px;color:rgba(245,208,96,0.6);text-transform:uppercase;">Total Prayer</span>
        </div>
        <p style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:#93c5fd;">{{ number_format($totalPrayerHours, 0) }}h</p>
        <p style="font-size:0.75rem;color:rgba(255,255,255,0.4);margin-top:4px;font-family:'Cinzel',serif;">{{ $prayerCenturions }} centurions</p>
    </div>

    {{-- ✅ Total Souls card — bg changed to white --}}
    <div class="centurion-card fade-in-up" style="padding:22px;background:#ffffff;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <span style="font-size:1.5rem;">✨</span>
            <span style="font-family:'Cinzel',serif;font-size:0.62rem;letter-spacing:2px;color:rgba(194,65,12,0.5);text-transform:uppercase;">Total Souls</span>
        </div>
        <p style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:#c2410c;">{{ number_format($totalSouls) }}</p>
        <p style="font-size:0.75rem;color:rgba(0,0,0,0.35);margin-top:4px;font-family:'Cinzel',serif;">{{ $soulsCenturions }} centurions</p>
    </div>

    <div class="centurion-card fade-in-up" style="padding:22px;background:linear-gradient(135deg,#14532d,#15803d);color:white;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <span style="font-size:1.5rem;">💝</span>
            <span style="font-family:'Cinzel',serif;font-size:0.62rem;letter-spacing:2px;color:rgba(134,239,172,0.6);text-transform:uppercase;">Total Espees</span>
        </div>
        <p style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:#86efac;">{{ number_format($totalEspees, 0) }}</p>
        <p style="font-size:0.75rem;color:rgba(255,255,255,0.4);margin-top:4px;font-family:'Cinzel',serif;">{{ $givingCenturions }} centurions</p>
    </div>

    <div class="centurion-card fade-in-up" style="padding:22px;background:linear-gradient(135deg,#4a1d96,#6d28d9);color:white;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <span style="font-size:1.5rem;">👑</span>
            <span style="font-family:'Cinzel',serif;font-size:0.62rem;letter-spacing:2px;color:rgba(233,213,255,0.6);text-transform:uppercase;">Full Centurions</span>
        </div>
        <p style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:#e9d5ff;">{{ $fullCenturions }}</p>
        <p style="font-size:0.75rem;color:rgba(255,255,255,0.4);margin-top:4px;font-family:'Cinzel',serif;">all 3 pillars complete</p>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:20px;">

    <!-- User Distribution -->
    <div class="centurion-card fade-in-up" style="padding:24px;">
        <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;margin-bottom:20px;">User Progress Distribution</h3>

        @php
        $stages = [
            ['label' => 'Starting Out',     'range' => '0–25%',  'count' => $stage0_25,      'color' => '#e5e7eb', 'text' => '#6b7280'],
            ['label' => 'Building Up',      'range' => '26–50%', 'count' => $stage25_50,     'color' => '#93c5fd', 'text' => '#1d4ed8'],
            ['label' => 'Half Way',         'range' => '51–75%', 'count' => $stage50_75,     'color' => '#fcd34d', 'text' => '#92400e'],
            ['label' => 'Almost There',     'range' => '76–99%', 'count' => $stage75_99,     'color' => '#fb923c', 'text' => '#7c2d12'],
            ['label' => '🏆 Full Centurion','range' => '100%',   'count' => $fullCenturions, 'color' => '#d4a017', 'text' => '#1a2c5b'],
        ];
        @endphp

        @foreach($stages as $stage)
        <div style="margin-bottom:16px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:10px;height:10px;border-radius:2px;background:{{ $stage['color'] }};"></div>
                    <p style="font-family:'Cinzel',serif;font-size:0.8rem;color:#374151;">{{ $stage['label'] }}</p>
                    <p style="font-size:0.72rem;color:#9ca3af;">({{ $stage['range'] }})</p>
                </div>
                <p style="font-family:'Cinzel',serif;font-size:0.8rem;font-weight:700;color:{{ $stage['text'] }};">{{ $stage['count'] }} users</p>
            </div>
            <div style="background:#f3f4f6;height:8px;border-radius:4px;overflow:hidden;">
                <div style="height:100%;width:{{ $totalUsers > 0 ? min(($stage['count'] / $totalUsers) * 100, 100) : 0 }}%;background:{{ $stage['color'] }};border-radius:4px;transition:width 1s ease;"></div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Centurion Hall of Fame -->
    <div class="centurion-card fade-in-up" style="padding:24px;background:linear-gradient(160deg,#1a2c5b,#2a3f7a);">
        <h3 style="font-family:'Cinzel',serif;font-size:0.9rem;color:#f5d060;font-weight:700;margin-bottom:16px;">👑 Hall of Fame</h3>
        <p style="font-size:0.72rem;color:rgba(255,255,255,0.4);margin-bottom:16px;font-family:'Cinzel',serif;">Full Centurions — all 3 pillars</p>

        @foreach($centurionHeroes as $hero)
        <div style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid rgba(212,160,23,0.1);">
            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#d4a017,#f5d060);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-weight:700;color:#1a2c5b;font-size:0.85rem;flex-shrink:0;">
                {{ strtoupper(substr($hero->full_name, 0, 2)) }}
            </div>
            <div style="flex:1;">
                <p style="font-family:'Cinzel',serif;font-size:0.8rem;color:white;font-weight:600;">{{ Str::limit($hero->full_name, 16) }}</p>
                <p style="font-size:0.65rem;color:rgba(245,208,96,0.5);font-family:'Cinzel',serif;">{{ $hero->church }}</p>
            </div>
            <span style="font-size:1rem;">👑</span>
        </div>
        @endforeach

        @if($centurionHeroes->isEmpty())
        <p style="text-align:center;color:rgba(255,255,255,0.3);font-family:'Cinzel',serif;font-size:0.8rem;padding:20px 0;">The throne awaits...</p>
        @endif
    </div>
</div>

<!-- User Management Table -->
<div class="centurion-card fade-in-up" style="padding:24px;margin-bottom:20px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;">All Members</h3>
        <div style="display:flex;gap:10px;">
            <input type="text" placeholder="Search members..."
                   style="border:1px solid #e5e7eb;border-radius:8px;padding:7px 14px;font-size:0.78rem;outline:none;width:200px;">
        </div>
    </div>

    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;min-width:700px;">
            <thead>
                <tr style="background:#fafafa;">
                    <th style="font-family:'Cinzel',serif;font-size:0.68rem;text-transform:uppercase;color:#9ca3af;text-align:left;padding:10px 12px;">Member</th>
                    <th style="font-family:'Cinzel',serif;font-size:0.68rem;text-transform:uppercase;color:#9ca3af;text-align:left;padding:10px 12px;">Church</th>
                    <th style="font-family:'Cinzel',serif;font-size:0.68rem;text-transform:uppercase;color:#9ca3af;text-align:center;padding:10px 12px;">🙏 Hours</th>
                    <th style="font-family:'Cinzel',serif;font-size:0.68rem;text-transform:uppercase;color:#9ca3af;text-align:center;padding:10px 12px;">✨ Souls</th>
                    <th style="font-family:'Cinzel',serif;font-size:0.68rem;text-transform:uppercase;color:#9ca3af;text-align:center;padding:10px 12px;">💝 Espees</th>
                    <th style="font-family:'Cinzel',serif;font-size:0.68rem;text-transform:uppercase;color:#9ca3af;text-align:center;padding:10px 12px;">Progress</th>
                    <th style="font-family:'Cinzel',serif;font-size:0.68rem;text-transform:uppercase;color:#9ca3af;text-align:center;padding:10px 12px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allUsers as $user)
                <tr style="border-bottom:1px solid rgba(212,160,23,0.06);transition:background 0.2s;" onmouseover="this.style.background='rgba(212,160,23,0.03)'" onmouseout="this.style.background='transparent'">
                    <td style="padding:12px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#1a2c5b,#2a3f7a);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-size:0.7rem;color:#f5d060;flex-shrink:0;">
                                {{ strtoupper(substr($user->full_name, 0, 2)) }}
                            </div>
                            <div>
                                <p style="font-family:'Cinzel',serif;font-size:0.8rem;color:#1a2c5b;font-weight:600;">{{ $user->full_name }}</p>
                                <p style="font-size:0.68rem;color:#9ca3af;">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td style="padding:12px;font-size:0.78rem;color:#6b7280;font-family:'Cinzel',serif;">{{ Str::limit($user->church, 20) }}</td>
                    <td style="padding:12px;text-align:center;font-family:'Cinzel',serif;font-size:0.82rem;color:{{ $user->prayer_hours >= 100 ? '#1d4ed8' : '#374151' }};font-weight:{{ $user->prayer_hours >= 100 ? '700' : '400' }};">
                        {{ number_format($user->prayer_hours, 1) }}
                    </td>
                    <td style="padding:12px;text-align:center;font-family:'Cinzel',serif;font-size:0.82rem;color:{{ $user->souls_count >= 100 ? '#c2410c' : '#374151' }};font-weight:{{ $user->souls_count >= 100 ? '700' : '400' }};">
                        {{ $user->souls_count }}
                    </td>
                    <td style="padding:12px;text-align:center;font-family:'Cinzel',serif;font-size:0.82rem;color:{{ $user->giving_espees >= 100 ? '#15803d' : '#374151' }};font-weight:{{ $user->giving_espees >= 100 ? '700' : '400' }};">
                        {{ number_format($user->giving_espees, 1) }}
                    </td>
                    <td style="padding:12px;text-align:center;">
                        <div style="display:flex;align-items:center;gap:6px;justify-content:center;">
                            <div style="width:60px;height:5px;background:#f3f4f6;border-radius:3px;overflow:hidden;">
                                <div style="height:100%;width:{{ min($user->overall_progress, 100) }}%;background:linear-gradient(90deg,#d4a017,#f5d060);border-radius:3px;"></div>
                            </div>
                            <span style="font-family:'Cinzel',serif;font-size:0.72rem;color:#1a2c5b;">{{ $user->overall_progress }}%</span>
                        </div>
                    </td>
                    <td style="padding:12px;text-align:center;">
                        @if($user->overall_progress >= 100)
                        <span style="background:linear-gradient(135deg,#fef3c7,#fde68a);color:#92400e;padding:3px 10px;border-radius:20px;font-family:'Cinzel',serif;font-size:0.62rem;font-weight:700;">👑 CENTURION</span>
                        @elseif($user->last_login_at && $user->last_login_at > now()->subDays(7))
                        <span style="background:#f0fdf4;color:#15803d;padding:3px 10px;border-radius:20px;font-family:'Cinzel',serif;font-size:0.62rem;">● Active</span>
                        @else
                        <span style="background:#f3f4f6;color:#9ca3af;padding:3px 10px;border-radius:20px;font-family:'Cinzel',serif;font-size:0.62rem;">Inactive</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($allUsers->hasPages())
    <div style="margin-top:20px;padding-top:16px;border-top:1px solid #f3f4f6;">
        {{ $allUsers->links() }}
    </div>
    @endif
</div>

<!-- Scripture Management + Bulk Notification -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

    <!-- Scripture CMS -->
    <div class="centurion-card fade-in-up" style="padding:24px;" x-data="{ showScripture: false }">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;">📖 Scripture Management</h3>
            <button @click="showScripture = true" class="cd-btn cd-btn-primary" style="font-size:0.75rem;padding:8px 14px;">
                <i class="fas fa-plus"></i> Add Scripture
            </button>
        </div>

        @foreach($scriptures->take(5) as $scripture)
        <div style="padding:12px 0;border-bottom:1px solid rgba(212,160,23,0.06);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                <p style="font-family:'Cinzel',serif;font-size:0.78rem;color:#1a2c5b;font-weight:600;">{{ $scripture->reference }}</p>
                <div style="display:flex;gap:4px;align-items:center;">
                    <span style="font-size:0.65rem;background:{{ $scripture->date === today()->format('Y-m-d') ? '#f0fdf4' : '#f3f4f6' }};color:{{ $scripture->date === today()->format('Y-m-d') ? '#15803d' : '#6b7280' }};padding:2px 8px;border-radius:20px;font-family:'Cinzel',serif;">
                        {{ $scripture->date === today()->format('Y-m-d') ? '● Today' : $scripture->date }}
                    </span>
                </div>
            </div>
            <p style="font-size:0.75rem;color:#6b7280;line-height:1.5;">{{ Str::limit($scripture->text, 80) }}</p>
        </div>
        @endforeach

        <!-- Add Scripture Modal -->
        <div x-show="showScripture" x-transition.opacity class="modal-overlay" @click.self="showScripture = false">
            <div class="modal-box" @click.stop>
                <div class="modal-header">
                    <h3>📖 Add Daily Scripture</h3>
                </div>
                <form method="POST" action="{{ route('admin.scripture.store') }}" style="padding:24px;">
                    @csrf
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Date</label>
                        <input type="date" name="date" class="cd-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Reference *</label>
                        <input type="text" name="reference" class="cd-input" placeholder="e.g. John 3:16" required>
                    </div>
                    <div style="margin-bottom:20px;">
                        <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Scripture Text *</label>
                        <textarea name="text" class="cd-input" rows="4" placeholder="Enter scripture text..." style="resize:vertical;" required></textarea>
                    </div>
                    <div style="display:flex;gap:10px;justify-content:flex-end;">
                        <button type="button" @click="showScripture = false" class="cd-btn" style="background:#f3f4f6;color:#6b7280;">Cancel</button>
                        <button type="submit" class="cd-btn cd-btn-primary"><i class="fas fa-save"></i> Save Scripture</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Notification -->
    <div class="centurion-card fade-in-up" style="padding:24px;">
        <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;margin-bottom:20px;">📢 Send Announcement</h3>

        <form method="POST" action="{{ route('admin.notify') }}">
            @csrf
            <div style="margin-bottom:14px;">
                <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Title *</label>
                <input type="text" name="title" class="cd-input" placeholder="Notification title" required>
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Message *</label>
                <textarea name="message" class="cd-input" rows="4" placeholder="Your encouraging message..." style="resize:vertical;" required></textarea>
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block;font-family:'Cinzel',serif;font-size:0.72rem;text-transform:uppercase;color:#374151;margin-bottom:6px;">Send To</label>
                {{-- ✅ "All Members" now has selected attribute so it shows by default --}}
                <select name="target" class="cd-input">
                    <option value="all" selected>All Members</option>
                </select>
            </div>
            <button type="submit" class="cd-btn cd-btn-gold" style="width:100%;">
                <i class="fas fa-paper-plane"></i> Send to {{ $totalUsers }} Members
            </button>
        </form>
    </div>
</div>

@endsection
