@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div x-data="dashboardApp()">

    <!-- Hero Welcome Banner -->
    <div style="background:linear-gradient(135deg,#1a2c5b 0%,#2a3f7a 60%,#0f3460 100%);border-radius:24px;padding:32px 36px;margin-bottom:28px;position:relative;overflow:hidden;" class="fade-in-up">
        <!-- Decorative -->
        <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;border-radius:50%;background:rgba(212,160,23,0.08);"></div>
        <div style="position:absolute;bottom:-60px;right:60px;width:150px;height:150px;border-radius:50%;background:rgba(212,160,23,0.05);"></div>

        <div style="position:relative;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:20px;">
            <div>
                <p style="font-family:'Cinzel',serif;font-size:0.72rem;letter-spacing:3px;text-transform:uppercase;color:rgba(212,160,23,0.7);margin-bottom:6px;">
                    YOUR CENTURION JOURNEY
                </p>
                <h2 style="font-family:'Cinzel Decorative',serif;font-size:1.8rem;color:#f5d060;line-height:1.2;margin-bottom:8px;">
                    {{ auth()->user()->full_name }}
                </h2>
                <p style="color:rgba(255,255,255,0.5);font-size:0.88rem;">
                    {{ auth()->user()->church }} · {{ auth()->user()->group }}
                </p>

                <div style="display:flex;gap:10px;margin-top:16px;flex-wrap:wrap;">
                    @if(auth()->user()->overall_progress >= 100)
                    <span style="background:linear-gradient(135deg,#d4a017,#f5d060);color:#1a2c5b;padding:6px 16px;border-radius:50px;font-family:'Cinzel',serif;font-size:0.72rem;font-weight:700;">
                        👑 FULL CENTURION
                    </span>
                    @elseif(auth()->user()->overall_progress >= 50)
                    <span style="background:rgba(212,160,23,0.15);color:#f5d060;border:1px solid rgba(212,160,23,0.3);padding:6px 16px;border-radius:50px;font-family:'Cinzel',serif;font-size:0.72rem;">
                        ⚡ ADVANCING
                    </span>
                    @else
                    <span style="background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.5);border:1px solid rgba(255,255,255,0.1);padding:6px 16px;border-radius:50px;font-family:'Cinzel',serif;font-size:0.72rem;">
                        🌱 STARTED
                    </span>
                    @endif
                </div>
            </div>

            <!-- Overall Progress Circle -->
            <div style="text-align:center;">
                <div style="position:relative;display:inline-flex;align-items:center;justify-content:center;">
                    <svg width="130" height="130" class="progress-ring">
                        <circle cx="65" cy="65" r="56" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="8"/>
                        <circle cx="65" cy="65" r="56" fill="none"
                                stroke="url(#goldGrad)" stroke-width="8"
                                class="progress-ring-circle"
                                data-progress="{{ auth()->user()->overall_progress }}"
                                style="stroke-dasharray: {{ 2 * M_PI * 56 }};stroke-dashoffset:{{ 2 * M_PI * 56 * (1 - auth()->user()->overall_progress / 100) }}"/>
                        <defs>
                            <linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#d4a017"/>
                                <stop offset="100%" stop-color="#f5d060"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <div style="position:absolute;text-align:center;">
                        <p style="font-family:'Cinzel Decorative',serif;font-size:1.4rem;color:#f5d060;line-height:1;">{{ auth()->user()->overall_progress }}%</p>
                        <p style="font-size:0.6rem;font-family:'Cinzel',serif;color:rgba(255,255,255,0.4);letter-spacing:1px;">OVERALL</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Three Pillar Cards -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;margin-bottom:28px;">

        <!-- Prayer Pillar -->
        <div class="centurion-card fade-in-up" style="overflow:visible;">
            <div class="pillar-prayer" style="padding:24px;border-radius:20px 20px 0 0;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                    <div>
                        <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:3px;color:rgba(212,160,23,0.7);text-transform:uppercase;">Pillar I</p>
                        <h3 style="font-family:'Cinzel',serif;font-size:1.2rem;color:#f5d060;margin-top:2px;">Prayer</h3>
                    </div>
                    <div style="width:50px;height:50px;background:rgba(212,160,23,0.15);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;">🙏</div>
                </div>

                <div style="display:flex;align-items:flex-end;gap:6px;margin-bottom:12px;">
                    <span style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:white;line-height:1;">{{ number_format($prayerHours, 1) }}</span>
                    <span style="font-family:'Cinzel',serif;font-size:0.8rem;color:rgba(255,255,255,0.5);padding-bottom:6px;">/ 100 hours</span>
                </div>

                <!-- Progress bar -->
                <div style="background:rgba(255,255,255,0.1);height:6px;border-radius:3px;overflow:hidden;">
                    <div style="height:100%;width:{{ min($prayerHours, 100) }}%;background:linear-gradient(90deg,#d4a017,#f5d060);border-radius:3px;transition:width 1s ease;"></div>
                </div>
                <p style="font-family:'Cinzel',serif;font-size:0.65rem;color:rgba(255,255,255,0.4);margin-top:6px;text-align:right;">{{ number_format(100 - $prayerHours, 1) }} hrs to go</p>
            </div>

            <div style="padding:16px 24px;display:flex;justify-content:space-between;align-items:center;">
                <a href="{{ route('prayer.index') }}" class="cd-btn cd-btn-primary" style="font-size:0.75rem;padding:9px 18px;">
                    <i class="fas fa-plus"></i> Log Prayer
                </a>
                <div style="text-align:right;">
                    <p style="font-size:0.7rem;font-family:'Cinzel',serif;color:#6b7280;">Today</p>
                    <p style="font-size:0.9rem;font-family:'Cinzel',serif;color:#1a2c5b;font-weight:700;">{{ $todayPrayerMinutes }} min</p>
                </div>
            </div>
        </div>

        <!-- Soul Winning Pillar -->
      <div class="centurion-card fade-in-up" style="overflow:visible;">
    <div style="background:#ffffff;padding:24px;border-radius:20px 20px 0 0;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <div>
                <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:3px;color:rgba(212,160,23,0.7);text-transform:uppercase;">Pillar II</p>
                <h3 style="font-family:'Cinzel',serif;font-size:1.2rem;color:#b8860b;margin-top:2px;">Soul Winning</h3>
            </div>
            <div style="width:50px;height:50px;background:rgba(212,160,23,0.15);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;">✨</div>
        </div>

        <div style="display:flex;align-items:flex-end;gap:6px;margin-bottom:12px;">
            <span style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:#1a2c5b;line-height:1;">{{ $soulsCount }}</span>
            <span style="font-family:'Cinzel',serif;font-size:0.8rem;color:rgba(0,0,0,0.4);padding-bottom:6px;">/ 100 souls</span>
        </div>

        <div style="background:rgba(0,0,0,0.08);height:6px;border-radius:3px;overflow:hidden;">
            <div style="height:100%;width:{{ min($soulsCount, 100) }}%;background:linear-gradient(90deg,#fb923c,#fde68a);border-radius:3px;"></div>
        </div>
        <p style="font-family:'Cinzel',serif;font-size:0.65rem;color:rgba(0,0,0,0.35);margin-top:6px;text-align:right;">{{ 100 - $soulsCount }} souls to go</p>
    </div>

    <div style="background:#ffffff;padding:16px 24px;display:flex;justify-content:space-between;align-items:center;border-radius:0 0 20px 20px;border-top:1px solid rgba(0,0,0,0.06);">
        <a href="{{ route('souls.index') }}" class="cd-btn cd-btn-primary" style="font-size:0.75rem;padding:9px 18px;">
            <i class="fas fa-plus"></i> Add Soul
        </a>
        <div style="text-align:right;">
            <p style="font-size:0.7rem;font-family:'Cinzel',serif;color:#6b7280;">This Month</p>
            <p style="font-size:0.9rem;font-family:'Cinzel',serif;color:#1a2c5b;font-weight:700;">{{ $thisMonthSouls }} souls</p>
        </div>
    </div>
</div>

        <!-- Giving Pillar -->
        <div class="centurion-card fade-in-up" style="overflow:visible;">
            <div class="pillar-giving" style="padding:24px;border-radius:20px 20px 0 0;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                    <div>
                        <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:3px;color:rgba(212,160,23,0.7);text-transform:uppercase;">Pillar III</p>
                        <h3 style="font-family:'Cinzel',serif;font-size:1.2rem;color:#f5d060;margin-top:2px;">Giving</h3>
                    </div>
                    <div style="width:50px;height:50px;background:rgba(212,160,23,0.15);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;">💝</div>
                </div>

                <div style="display:flex;align-items:flex-end;gap:6px;margin-bottom:12px;">
                    <span style="font-family:'Cinzel Decorative',serif;font-size:2.2rem;color:white;line-height:1;">{{ number_format($givingEspees, 1) }}</span>
                    <span style="font-family:'Cinzel',serif;font-size:0.8rem;color:rgba(255,255,255,0.5);padding-bottom:6px;">/ 100 espees</span>
                </div>

                <div style="background:rgba(255,255,255,0.1);height:6px;border-radius:3px;overflow:hidden;">
                    <div style="height:100%;width:{{ min($givingEspees, 100) }}%;background:linear-gradient(90deg,#4ade80,#86efac);border-radius:3px;"></div>
                </div>
                <p style="font-family:'Cinzel',serif;font-size:0.65rem;color:rgba(255,255,255,0.4);margin-top:6px;text-align:right;">{{ number_format(100 - $givingEspees, 1) }} espees to go</p>
            </div>

            <div style="padding:16px 24px;display:flex;justify-content:space-between;align-items:center;">
                <a href="{{ route('giving.index') }}" class="cd-btn cd-btn-primary" style="font-size:0.75rem;padding:9px 18px;">
                    <i class="fas fa-plus"></i> Log Giving
                </a>
                <div style="text-align:right;">
                    <p style="font-size:0.7rem;font-family:'Cinzel',serif;color:#6b7280;">This Month</p>
                    <p style="font-size:0.9rem;font-family:'Cinzel',serif;color:#1a2c5b;font-weight:700;">{{ number_format($thisMonthGiving, 1) }} esp.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Scripture + Quick Prayer Timer + Leaderboard Preview -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:28px;">

        <!-- Daily Scripture -->
        <div class="scripture-card fade-in-up" style="grid-column:1;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                <span style="font-size:1.2rem;">📖</span>
                <p style="font-family:'Cinzel',serif;font-size:0.65rem;letter-spacing:3px;color:rgba(212,160,23,0.7);text-transform:uppercase;">Today's Scripture</p>
            </div>
            <p style="font-family:'Cinzel',serif;font-size:1rem;color:white;line-height:1.8;position:relative;">
                {{ $todayScripture->text ?? 'Be strong and courageous. Do not be afraid; do not be discouraged, for the Lord your God will be with you wherever you go.' }}
            </p>
            <p style="font-family:'Cinzel',serif;font-size:0.78rem;color:rgba(212,160,23,0.7);margin-top:14px;font-style:italic;">
                — {{ $todayScripture->reference ?? 'Joshua 1:9' }}
            </p>
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid rgba(212,160,23,0.1);">
                <p style="font-size:0.75rem;color:rgba(255,255,255,0.35);font-family:'Cinzel',serif;">
                    {{ now()->format('F j, Y') }}
                </p>
            </div>
        </div>

        <!-- Quick Prayer Timer -->
       <div class="centurion-card fade-in-up" style="padding:24px;" x-data="prayerTimer()">
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
        <span style="font-size:1.2rem;">⏱️</span>
        <p style="font-family:'Cinzel',serif;font-size:0.8rem;font-weight:600;color:#1a2c5b;">Quick Prayer Timer</p>
    </div>

    <div style="text-align:center;padding:20px 0;">
        <div class="timer-display" x-text="formatTime(elapsed)">00:00:00</div>
        <p style="font-family:'Cinzel',serif;font-size:0.72rem;color:#9ca3af;margin-top:8px;letter-spacing:1px;">
            HH : MM : SS
        </p>
    </div>

    {{-- 🎵 Now Playing Banner --}}
    <div x-show="running || paused" x-transition
         style="margin-bottom:14px;background:linear-gradient(135deg,#1a2c5b,#2d4a8a);border-radius:12px;padding:12px 16px;">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
            <div style="display:flex;align-items:center;gap:10px;overflow:hidden;">
                <div x-show="running" style="display:flex;gap:2px;align-items:flex-end;height:16px;flex-shrink:0;">
                    <span style="width:3px;background:#f5d060;border-radius:2px;animation:bar1 0.8s ease infinite alternate;"></span>
                    <span style="width:3px;background:#f5d060;border-radius:2px;animation:bar2 0.6s ease infinite alternate;"></span>
                    <span style="width:3px;background:#f5d060;border-radius:2px;animation:bar3 1s ease infinite alternate;"></span>
                    <span style="width:3px;background:#f5d060;border-radius:2px;animation:bar2 0.7s ease infinite alternate;"></span>
                </div>
                <div x-show="paused" style="flex-shrink:0;color:#f5d060;font-size:0.8rem;">⏸</div>
                <div style="overflow:hidden;">
                    <p style="font-family:'Cinzel',serif;font-size:0.7rem;color:rgba(255,255,255,0.5);letter-spacing:1px;">NOW PLAYING</p>
                    <p x-text="songs[currentSong].title" style="font-family:'Cinzel',serif;font-size:0.78rem;color:#f5d060;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></p>
                    <p style="font-family:'Cinzel',serif;font-size:0.65rem;color:rgba(255,255,255,0.4);">Loveworld Singers</p>
                </div>
            </div>
            <div style="display:flex;gap:6px;flex-shrink:0;">
                <button @click="prevSong()"
                        style="width:28px;height:28px;border-radius:50%;background:rgba(255,255,255,0.1);border:none;color:white;cursor:pointer;font-size:0.7rem;display:flex;align-items:center;justify-content:center;">
                    ⏮
                </button>
                <button @click="nextSong()"
                        style="width:28px;height:28px;border-radius:50%;background:rgba(255,255,255,0.1);border:none;color:white;cursor:pointer;font-size:0.7rem;display:flex;align-items:center;justify-content:center;">
                    ⏭
                </button>
                <button @click="toggleMute()"
                        style="width:28px;height:28px;border-radius:50%;background:rgba(255,255,255,0.1);border:none;color:white;cursor:pointer;font-size:0.7rem;display:flex;align-items:center;justify-content:center;">
                    <span x-text="muted ? '🔇' : '🔊'"></span>
                </button>
            </div>
        </div>

        {{-- Song Progress --}}
        <div style="margin-top:10px;">
            <div style="background:rgba(255,255,255,0.1);height:3px;border-radius:2px;overflow:hidden;">
                <div :style="`width:${songProgress}%;`"
                     style="height:100%;background:linear-gradient(90deg,#f5d060,#fb923c);border-radius:2px;transition:width 1s linear;"></div>
            </div>
            <div style="display:flex;justify-content:space-between;margin-top:4px;">
                <span x-text="formatTime(songElapsed)" style="font-size:0.6rem;color:rgba(255,255,255,0.4);font-family:'Cinzel',serif;"></span>
                <span x-text="formatTime(songDuration)" style="font-size:0.6rem;color:rgba(255,255,255,0.4);font-family:'Cinzel',serif;"></span>
            </div>
        </div>

        {{-- Song List --}}
        <div style="margin-top:10px;display:flex;flex-direction:column;gap:4px;">
            <template x-for="(song, index) in songs" :key="index">
                <div @click="playSong(index)"
                     :style="currentSong === index ? 'background:rgba(245,208,96,0.15);border:1px solid rgba(245,208,96,0.3);' : 'background:rgba(255,255,255,0.05);border:1px solid transparent;'"
                     style="display:flex;align-items:center;gap:8px;padding:6px 10px;border-radius:8px;cursor:pointer;">
                    <span :style="currentSong === index && running ? 'color:#f5d060;' : 'color:rgba(255,255,255,0.3);'"
                          style="font-size:0.65rem;">▶</span>
                    <span x-text="song.title"
                          :style="currentSong === index ? 'color:#f5d060;' : 'color:rgba(255,255,255,0.5);'"
                          style="font-family:'Cinzel',serif;font-size:0.68rem;"></span>
                </div>
            </template>
        </div>
    </div>

    <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
        <button @click="start()" x-show="!running" class="cd-btn cd-btn-gold" style="font-size:0.8rem;">
            <i class="fas fa-play"></i> Start Prayer
        </button>
        <button @click="pause()" x-show="running && !paused" class="cd-btn" style="background:#fef3c7;color:#92400e;font-size:0.8rem;">
            <i class="fas fa-pause"></i> Pause
        </button>
        <button @click="resume()" x-show="paused" class="cd-btn cd-btn-gold" style="font-size:0.8rem;">
            <i class="fas fa-play"></i> Resume
        </button>
        <button @click="saveSession()" x-show="elapsed > 0" class="cd-btn cd-btn-primary" style="font-size:0.8rem;">
            <i class="fas fa-save"></i> Save
        </button>
        <button @click="reset()" x-show="elapsed > 0" class="cd-btn" style="background:#f3f4f6;color:#6b7280;font-size:0.8rem;">
            <i class="fas fa-redo"></i>
        </button>
    </div>

    {{-- Save confirmation --}}
    <div x-show="saved" x-transition
         style="margin-top:16px;background:#f0fdf4;border:1px solid #86efac;border-radius:10px;padding:10px 14px;text-align:center;">
        <p style="font-family:'Cinzel',serif;font-size:0.78rem;color:#166534;">✅ Prayer session logged!</p>
    </div>
</div>

{{-- Audio elements --}}
<audio id="prayerAudio" preload="auto"></audio>

<style>
    @keyframes bar1 { from { height: 4px; } to { height: 14px; } }
    @keyframes bar2 { from { height: 6px; } to { height: 12px; } }
    @keyframes bar3 { from { height: 3px; } to { height: 16px; } }
</style>

    </div>

    <!-- Recent Activity + Leaderboard Preview -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

        <!-- Recent Activity -->
        <div class="centurion-card fade-in-up" style="padding:24px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;">Recent Activity</h3>
                <span style="font-size:0.72rem;color:#9ca3af;font-family:'Cinzel',serif;">Last 7 days</span>
            </div>

            @forelse($recentActivity as $activity)
            <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid rgba(212,160,23,0.06);">
                <div style="width:36px;height:36px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1rem;
                    background:{{ $activity->type === 'prayer' ? 'rgba(26,44,91,0.08)' : ($activity->type === 'soul' ? 'rgba(194,65,12,0.08)' : 'rgba(21,128,61,0.08)') }}">
                    {{ $activity->type === 'prayer' ? '🙏' : ($activity->type === 'soul' ? '✨' : '💝') }}
                </div>
                <div style="flex:1;">
                    <p style="font-family:'Cinzel',serif;font-size:0.8rem;color:#374151;font-weight:600;">{{ $activity->title }}</p>
                    <p style="font-size:0.72rem;color:#9ca3af;margin-top:2px;">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
                <span style="font-family:'Cinzel',serif;font-size:0.78rem;color:#1a2c5b;font-weight:700;">{{ $activity->value }}</span>
            </div>
            @empty
            <div style="text-align:center;padding:30px 0;">
                <p style="font-size:2.5rem;margin-bottom:10px;">🌟</p>
                <p style="font-family:'Cinzel',serif;font-size:0.82rem;color:#9ca3af;">Your journey begins today!</p>
                <p style="font-size:0.78rem;color:#d1d5db;margin-top:4px;">Start logging to see activity here.</p>
            </div>
            @endforelse
        </div>

        <!-- Top Centurions Preview -->
        <div class="centurion-card fade-in-up" style="padding:24px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <h3 style="font-family:'Cinzel',serif;font-size:0.95rem;color:#1a2c5b;font-weight:700;">🏆 Centurion Leaders</h3>
                <a href="{{ route('leaderboard') }}" style="font-size:0.72rem;font-family:'Cinzel',serif;color:var(--gold);text-decoration:none;border-bottom:1px solid rgba(212,160,23,0.3);">View All</a>
            </div>

            @foreach($topUsers as $index => $user)
            <div class="lb-row">
                <span class="lb-rank" style="color:{{ $index === 0 ? '#d4a017' : ($index === 1 ? '#94a3b8' : '#cd7f32') }}">
                    {{ ['👑','🥈','🥉'][$index] ?? ($index + 1) }}
                </span>
                <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#1a2c5b,#2a3f7a);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-size:0.7rem;color:var(--gold-light);flex-shrink:0;">
                    {{ strtoupper(substr($user->full_name, 0, 2)) }}
                </div>
                <div style="flex:1;">
                    <p style="font-family:'Cinzel',serif;font-size:0.8rem;color:#374151;font-weight:600;">{{ Str::limit($user->full_name, 16) }}</p>
                    <p style="font-size:0.68rem;color:#9ca3af;">{{ $user->church }}</p>
                </div>
                <div style="text-align:right;">
                    <div style="display:flex;gap:4px;align-items:center;justify-content:flex-end;flex-wrap:wrap;">
                        @if($user->prayer_hours >= 100)
                        <span style="font-size:0.6rem;background:#eff6ff;color:#1d4ed8;padding:2px 6px;border-radius:4px;font-family:'Cinzel',serif;">🙏 100h</span>
                        @endif
                        @if($user->souls_count >= 100)
                        <span style="font-size:0.6rem;background:#fff7ed;color:#c2410c;padding:2px 6px;border-radius:4px;font-family:'Cinzel',serif;">✨ 100s</span>
                        @endif
                        @if($user->giving_espees >= 100)
                        <span style="font-size:0.6rem;background:#f0fdf4;color:#15803d;padding:2px 6px;border-radius:4px;font-family:'Cinzel',serif;">💝 100e</span>
                        @endif
                    </div>
                    <p style="font-family:'Cinzel Decorative',serif;font-size:0.9rem;color:#1a2c5b;margin-top:2px;">{{ $user->overall_progress }}%</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function dashboardApp() {
    return {};
}

function prayerTimer() {
    return {
        running: false,
        paused: false,
        elapsed: 0,
        saved: false,
        interval: null,
        start() {
            this.running = true;
            this.paused = false;
            this.interval = setInterval(() => {
                this.elapsed++;
            }, 1000);
        },
        pause() {
            clearInterval(this.interval);
            this.paused = true;
        },
        resume() {
            this.paused = false;
            this.interval = setInterval(() => { this.elapsed++; }, 1000);
        },
        reset() {
            clearInterval(this.interval);
            this.running = false;
            this.paused = false;
            this.elapsed = 0;
            this.saved = false;
        },
        formatTime(seconds) {
            const h = String(Math.floor(seconds / 3600)).padStart(2, '0');
            const m = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
            const s = String(seconds % 60).padStart(2, '0');
            return `${h}:${m}:${s}`;
        },
        async saveSession() {
            clearInterval(this.interval);
            const minutes = Math.floor(this.elapsed / 60);
            if (minutes < 1) { alert('Please pray for at least 1 minute.'); return; }
            try {
                const response = await fetch('{{ route("prayer.quick-log") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ duration_minutes: minutes, notes: 'Quick timer session' })
                });
                const data = await response.json();
                if (data.success) {
                    this.saved = true;
                    this.running = false;
                    this.elapsed = 0;
                    setTimeout(() => { this.saved = false; location.reload(); }, 2000);
                }
            } catch (e) { console.error(e); }
        }
    }
}
</script>

{{-- PRAYER TIME PLAYER --}}
<script>
function prayerTimer() {
    return {
        running: false,
        paused: false,
        elapsed: 0,
        saved: false,
        interval: null,

        // ── Music ──────────────────────────────────────────────
        audio: null,
        muted: false,
        currentSong: 0,
        songElapsed: 0,
        songDuration: 0,
        songProgress: 0,

        songs: [
            { title: 'King Of Eternity',           src: '/audio/king-of-eternity.mp3' },
            { title: 'Person Of Sovereign Majesty', src: '/audio/person-of-sovereign-majesty.mp3' },
            { title: 'You Are Amazing',             src: '/audio/you-are-amazing.mp3' },
            { title: 'Extraordinary Strategist',             src: '/audio/extraordinary-strategist.mp3' },
        ],

        init() {
            // ✅ Fix 2: wait for DOM to be ready before grabbing audio element
            this.$nextTick(() => {
                this.audio = document.getElementById('prayerAudio');
                this.audio.volume = 1.0;  // ✅ Fix 1: ensure full volume
                this.audio.muted = false; // ✅ Fix 1: ensure not muted

                this.audio.addEventListener('ended', () => this.nextSong());

                this.audio.addEventListener('timeupdate', () => {
                    this.songElapsed  = Math.floor(this.audio.currentTime);
                    this.songDuration = Math.floor(this.audio.duration) || 0;
                    this.songProgress = this.songDuration
                        ? (this.songElapsed / this.songDuration) * 100
                        : 0;
                });
            });
        },

        // ── Timer controls ─────────────────────────────────────
        start() {
            this.running  = true;
            this.paused   = false;
            this.interval = setInterval(() => this.elapsed++, 1000);
            this.playCurrentSong(); // ✅ plays immediately on start
        },

        pause() {
            this.paused  = true;
            this.running = false;
            clearInterval(this.interval);
            this.audio.pause();
        },

        resume() {
            this.paused   = false;
            this.running  = true;
            this.interval = setInterval(() => this.elapsed++, 1000);
            this.audio.play();
        },

        reset() {
            clearInterval(this.interval);
            this.running  = false;
            this.paused   = false;
            this.elapsed  = 0;
            this.saved    = false;
            this.audio.pause();
            this.audio.currentTime = 0;
            this.songElapsed  = 0;
            this.songDuration = 0;
            this.songProgress = 0;
        },

        saveSession() {
            clearInterval(this.interval);
            this.running = false;
            this.paused  = false;
            this.audio.pause();

            fetch('{{ route("prayer.quick-log") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ duration_minutes: Math.floor(this.elapsed / 60) }),
            }).then(() => {
                this.saved   = true;
                this.elapsed = 0;
                setTimeout(() => this.saved = false, 3000);
            });
        },

        // ── Music controls ─────────────────────────────────────
        playCurrentSong() {
            this.audio.src    = this.songs[this.currentSong].src;
            this.audio.muted  = false;  // ✅ always unmuted when playing
            this.audio.volume = 1.0;    // ✅ always full volume
            this.audio.load();

            this.audio.play().catch(err => console.error('Playback error:', err));
        },

        playSong(index) {
            this.currentSong = index;
            this.playCurrentSong();
        },

        nextSong() {
            this.currentSong = (this.currentSong + 1) % this.songs.length;
            this.playCurrentSong();
        },

        prevSong() {
            this.currentSong = (this.currentSong - 1 + this.songs.length) % this.songs.length;
            this.playCurrentSong();
        },

        toggleMute() {
            this.muted        = !this.muted;
            this.audio.muted  = this.muted;
        },

        // ── Helpers ────────────────────────────────────────────
        formatTime(s) {
            const h   = String(Math.floor(s / 3600)).padStart(2, '0');
            const m   = String(Math.floor((s % 3600) / 60)).padStart(2, '0');
            const sec = String(s % 60).padStart(2, '0');
            return `${h}:${m}:${sec}`;
        },
    }
}
</script>

@endpush
