@extends('layouts.app')
@section('title', 'Leaderboard')

@section('content')

<div style="margin-bottom:24px;" class="fade-in-up">
    <h1 style="font-family:'Cinzel Decorative',serif;font-size:1.6rem;color:#1a2c5b;">🏆 Centurion Leaderboard</h1>
    <p style="font-size:0.88rem;color:#6b7280;margin-top:4px;font-family:'Cinzel',serif;">Honor roll of those walking in excellence</p>
</div>

<!-- Tabs -->
<div style="display:flex;gap:8px;margin-bottom:24px;border-bottom:2px solid #f3f4f6;padding-bottom:0;" x-data="{ tab: 'overall' }">
    <button @click="tab='overall'" :class="tab==='overall' ? 'border-b-2 border-yellow-500 text-yellow-700' : 'text-gray-500'"
            style="font-family:'Cinzel',serif;font-size:0.8rem;padding:8px 16px;background:none;border:none;border-bottom:2px solid transparent;cursor:pointer;transition:all 0.2s;">
        🏆 Overall
    </button>
    <button @click="tab='prayer'" :class="tab==='prayer' ? 'border-b-2 border-blue-600 text-blue-800' : 'text-gray-500'"
            style="font-family:'Cinzel',serif;font-size:0.8rem;padding:8px 16px;background:none;border:none;border-bottom:2px solid transparent;cursor:pointer;transition:all 0.2s;">
        🙏 Prayer
    </button>
    <button @click="tab='souls'" :class="tab==='souls' ? 'border-b-2 border-orange-600 text-orange-800' : 'text-gray-500'"
            style="font-family:'Cinzel',serif;font-size:0.8rem;padding:8px 16px;background:none;border:none;border-bottom:2px solid transparent;cursor:pointer;transition:all 0.2s;">
        ✨ Souls
    </button>
    <button @click="tab='giving'" :class="tab==='giving' ? 'border-b-2 border-green-600 text-green-800' : 'text-gray-500'"
            style="font-family:'Cinzel',serif;font-size:0.8rem;padding:8px 16px;background:none;border:none;border-bottom:2px solid transparent;cursor:pointer;transition:all 0.2s;">
        💝 Giving
    </button>

    <!-- Top 3 Podium -->
    <div x-show="tab==='overall'" style="width:100%;margin-bottom:28px;">
        @if($topOverall->count() >= 3)
        <div style="display:flex;align-items:flex-end;justify-content:center;gap:12px;margin:28px 0;">
            <!-- 2nd Place -->
            <div style="text-align:center;flex:1;max-width:160px;">
                <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#94a3b8,#cbd5e1);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-weight:700;font-size:1.1rem;color:white;margin:0 auto 8px;">
                    {{ strtoupper(substr($topOverall[1]->full_name, 0, 2)) }}
                </div>
                <p style="font-family:'Cinzel',serif;font-size:0.78rem;color:#374151;font-weight:600;">{{ Str::limit($topOverall[1]->full_name, 12) }}</p>
                <p style="font-family:'Cinzel Decorative',serif;font-size:1rem;color:#94a3b8;">{{ $topOverall[1]->overall_progress }}%</p>
                <div style="background:linear-gradient(135deg,#94a3b8,#cbd5e1);height:80px;border-radius:12px 12px 0 0;margin-top:8px;display:flex;align-items:center;justify-content:center;">
                    <span style="font-size:1.8rem;">🥈</span>
                </div>
            </div>

            <!-- 1st Place -->
            <div style="text-align:center;flex:1;max-width:180px;" class="glow-gold">
                <div style="width:68px;height:68px;border-radius:50%;background:linear-gradient(135deg,#d4a017,#f5d060);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-weight:700;font-size:1.3rem;color:#1a2c5b;margin:0 auto 8px;box-shadow:0 0 20px rgba(212,160,23,0.5);">
                    {{ strtoupper(substr($topOverall[0]->full_name, 0, 2)) }}
                </div>
                <p style="font-family:'Cinzel',serif;font-size:0.85rem;color:#1a2c5b;font-weight:700;">{{ Str::limit($topOverall[0]->full_name, 14) }}</p>
                <p style="font-family:'Cinzel Decorative',serif;font-size:1.2rem;color:#d4a017;">{{ $topOverall[0]->overall_progress }}%</p>
                <div style="background:linear-gradient(135deg,#d4a017,#f5d060);height:120px;border-radius:12px 12px 0 0;margin-top:8px;display:flex;align-items:center;justify-content:center;">
                    <span style="font-size:2.5rem;">👑</span>
                </div>
            </div>

            <!-- 3rd Place -->
            <div style="text-align:center;flex:1;max-width:160px;">
                <div style="width:50px;height:50px;border-radius:50%;background:linear-gradient(135deg,#cd7f32,#e8a56e);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-weight:700;color:white;margin:0 auto 8px;">
                    {{ strtoupper(substr($topOverall[2]->full_name, 0, 2)) }}
                </div>
                <p style="font-family:'Cinzel',serif;font-size:0.75rem;color:#374151;font-weight:600;">{{ Str::limit($topOverall[2]->full_name, 12) }}</p>
                <p style="font-family:'Cinzel Decorative',serif;font-size:0.9rem;color:#cd7f32;">{{ $topOverall[2]->overall_progress }}%</p>
                <div style="background:linear-gradient(135deg,#cd7f32,#e8a56e);height:60px;border-radius:12px 12px 0 0;margin-top:8px;display:flex;align-items:center;justify-content:center;">
                    <span style="font-size:1.5rem;">🥉</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Full Leaderboard Table -->
        <div class="centurion-card" style="padding:24px;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="font-family:'Cinzel',serif;font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;color:#9ca3af;text-align:left;padding:0 0 12px;width:50px;">#</th>
                        <th style="font-family:'Cinzel',serif;font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;color:#9ca3af;text-align:left;padding:0 0 12px;">Name</th>
                        <th style="font-family:'Cinzel',serif;font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;color:#9ca3af;text-align:center;padding:0 0 12px;">🙏 Hours</th>
                        <th style="font-family:'Cinzel',serif;font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;color:#9ca3af;text-align:center;padding:0 0 12px;">✨ Souls</th>
                        <th style="font-family:'Cinzel',serif;font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;color:#9ca3af;text-align:center;padding:0 0 12px;">💝 Espees</th>
                        <th style="font-family:'Cinzel',serif;font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;color:#9ca3af;text-align:right;padding:0 0 12px;">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topOverall as $i => $user)
                    <tr style="{{ auth()->id() === $user->id ? 'background:rgba(212,160,23,0.04);' : '' }}">
                        <td style="padding:12px 0;border-bottom:1px solid rgba(212,160,23,0.06);">
                            <span style="font-family:'Cinzel Decorative',serif;font-size:0.9rem;color:{{ $i===0?'#d4a017':($i===1?'#94a3b8':($i===2?'#cd7f32':'#9ca3af')) }}">
                                {{ $i < 3 ? ['👑','🥈','🥉'][$i] : ($i + 1) }}
                            </span>
                        </td>
                        <td style="padding:12px 0;border-bottom:1px solid rgba(212,160,23,0.06);">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#1a2c5b,#2a3f7a);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-size:0.72rem;color:#f5d060;flex-shrink:0;">
                                    {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                </div>
                                <div>
                                    <p style="font-family:'Cinzel',serif;font-size:0.82rem;color:#1a2c5b;font-weight:600;">{{ $user->full_name }} {{ auth()->id() === $user->id ? '(You)' : '' }}</p>
                                    <p style="font-size:0.68rem;color:#9ca3af;">{{ $user->church }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="padding:12px 0;border-bottom:1px solid rgba(212,160,23,0.06);text-align:center;">
                            <p style="font-family:'Cinzel',serif;font-size:0.85rem;color:#1a2c5b;font-weight:700;">{{ number_format($user->prayer_hours, 1) }}</p>
                            @if($user->prayer_hours >= 100)
                            <span style="font-size:0.6rem;background:#eff6ff;color:#1d4ed8;padding:1px 6px;border-radius:4px;">✓ Centurion</span>
                            @endif
                        </td>
                        <td style="padding:12px 0;border-bottom:1px solid rgba(212,160,23,0.06);text-align:center;">
                            <p style="font-family:'Cinzel',serif;font-size:0.85rem;color:#1a2c5b;font-weight:700;">{{ $user->souls_count }}</p>
                            @if($user->souls_count >= 100)
                            <span style="font-size:0.6rem;background:#fff7ed;color:#c2410c;padding:1px 6px;border-radius:4px;">✓ Centurion</span>
                            @endif
                        </td>
                        <td style="padding:12px 0;border-bottom:1px solid rgba(212,160,23,0.06);text-align:center;">
                            <p style="font-family:'Cinzel',serif;font-size:0.85rem;color:#1a2c5b;font-weight:700;">{{ number_format($user->giving_espees, 1) }}</p>
                            @if($user->giving_espees >= 100)
                            <span style="font-size:0.6rem;background:#f0fdf4;color:#15803d;padding:1px 6px;border-radius:4px;">✓ Centurion</span>
                            @endif
                        </td>
                        <td style="padding:12px 0;border-bottom:1px solid rgba(212,160,23,0.06);text-align:right;">
                            <div style="display:flex;align-items:center;gap:8px;justify-content:flex-end;">
                                <div style="width:80px;height:6px;background:#f3f4f6;border-radius:3px;overflow:hidden;">
                                    <div style="height:100%;width:{{ min($user->overall_progress, 100) }}%;background:linear-gradient(90deg,#1a2c5b,#4a7fd4);border-radius:3px;"></div>
                                </div>
                                <span style="font-family:'Cinzel',serif;font-size:0.78rem;color:#1a2c5b;font-weight:700;min-width:32px;text-align:right;">{{ $user->overall_progress }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
