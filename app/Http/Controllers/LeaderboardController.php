<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Eager-load all logs to compute aggregates in PHP
        // (avoids N+1 and allows custom accessor sorting)
        $allUsers = User::where('is_admin', false)
            ->with(['prayerLogs', 'souls', 'givingLogs'])
            ->get();

        $topOverall = $allUsers->sortByDesc('overall_progress')->take(20)->values();
        $topPrayer  = $allUsers->sortByDesc('prayer_hours')->take(20)->values();
        $topSouls   = $allUsers->sortByDesc('souls_count')->take(20)->values();
        $topGiving  = $allUsers->sortByDesc('giving_espees')->take(20)->values();

        return view('dashboard.leaderboard', compact(
            'topOverall', 'topPrayer', 'topSouls', 'topGiving'
        ));
    }
}
