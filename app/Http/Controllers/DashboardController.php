<?php

namespace App\Http\Controllers;

use App\Models\GivingLog;
use App\Models\PrayerLog;
use App\Models\Scripture;
use App\Models\Soul;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ── Pillar totals ──────────────────────────────────────────
        $prayerHours     = $user->prayer_hours;
        $soulsCount      = $user->souls_count;
        $givingEspees    = $user->giving_espees;

        $todayPrayerMinutes = PrayerLog::where('user_id', $user->id)
            ->whereDate('prayer_date', today())
            ->sum('duration_minutes');

        $thisMonthSouls = Soul::where('user_id', $user->id)
            ->whereMonth('date_won', now()->month)
            ->whereYear('date_won', now()->year)
            ->count();

        $thisMonthGiving = GivingLog::where('user_id', $user->id)
            ->whereMonth('date_given', now()->month)
            ->whereYear('date_given', now()->year)
            ->sum('amount_espees');

        // ── Recent activity (last 7 days, mixed types) ─────────────
        $recentPrayers = PrayerLog::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        $recentSouls = Soul::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        $recentGiving = GivingLog::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        $recentActivity = collect()
            ->merge($recentPrayers)
            ->merge($recentSouls)
            ->merge($recentGiving)
            ->sortByDesc('created_at')
            ->take(8)
            ->values();

        // ── Top users for leaderboard widget ──────────────────────
        $topUsers = User::where('is_admin', false)
            ->get()
            ->sortByDesc('overall_progress')
            ->take(5)
            ->values();

        // ── Today's scripture ─────────────────────────────────────
        $todayScripture = Scripture::today() ?? (object)[
            'text'      => 'Be strong and courageous. Do not be afraid; do not be discouraged, for the Lord your God will be with you wherever you go.',
            'reference' => 'Joshua 1:9',
        ];

        return view('dashboard.index', compact(
            'prayerHours', 'soulsCount', 'givingEspees',
            'todayPrayerMinutes', 'thisMonthSouls', 'thisMonthGiving',
            'recentActivity', 'topUsers', 'todayScripture'
        ));
    }
}
