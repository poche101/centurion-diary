<?php

namespace App\Http\Controllers;

use App\Models\GivingLog;
use App\Models\PrayerLog;
use App\Models\Scripture;
use App\Models\Soul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ── Admin Dashboard ────────────────────────────────────────────

    public function dashboard()
    {
        // Global totals
        $totalUsers       = User::where('is_admin', false)->count();
        $totalPrayerHours = round(PrayerLog::sum('duration_minutes') / 60, 1);
        $totalSouls       = Soul::count();
        $totalEspees      = round(GivingLog::sum('amount_espees'), 2);

        // Active today (logged in during last 24 h)
        $activeToday = User::where('is_admin', false)
            ->where('last_login_at', '>=', now()->subDay())
            ->count();

        // Centurion counts (computed via PHP accessors)
        $allRegularUsers   = User::where('is_admin', false)
            ->with(['prayerLogs', 'souls', 'givingLogs'])
            ->get();

        $prayerCenturions  = $allRegularUsers->filter(fn($u) => $u->prayer_hours  >= 100)->count();
        $soulsCenturions   = $allRegularUsers->filter(fn($u) => $u->souls_count   >= 100)->count();
        $givingCenturions  = $allRegularUsers->filter(fn($u) => $u->giving_espees >= 100)->count();
        $fullCenturions    = $allRegularUsers->filter(fn($u) => $u->overall_progress >= 100)->count();

        // Distribution buckets
        $stage0_25  = $allRegularUsers->filter(fn($u) => $u->overall_progress <= 25)->count();
        $stage25_50 = $allRegularUsers->filter(fn($u) => $u->overall_progress > 25 && $u->overall_progress <= 50)->count();
        $stage50_75 = $allRegularUsers->filter(fn($u) => $u->overall_progress > 50 && $u->overall_progress <= 75)->count();
        $stage75_99 = $allRegularUsers->filter(fn($u) => $u->overall_progress > 75 && $u->overall_progress < 100)->count();

        // Hall of fame
        $centurionHeroes = $allRegularUsers
            ->filter(fn($u) => $u->overall_progress >= 100)
            ->sortByDesc('overall_progress')
            ->take(10)
            ->values();

        // Paginated user table
        $allUsers = User::where('is_admin', false)
            ->with(['prayerLogs', 'souls', 'givingLogs'])
            ->latest()
            ->paginate(20);

        // Scriptures
        $scriptures = Scripture::orderByDesc('date')->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalPrayerHours', 'totalSouls', 'totalEspees',
            'activeToday',
            'prayerCenturions', 'soulsCenturions', 'givingCenturions', 'fullCenturions',
            'stage0_25', 'stage25_50', 'stage50_75', 'stage75_99',
            'centurionHeroes', 'allUsers', 'scriptures'
        ));
    }

    // ── Scripture CMS ─────────────────────────────────────────────

public function storeScripture(Request $request)
{
    $validated = $request->validate([
        'date'      => ['required', 'date_format:Y-m-d'],
        'reference' => ['required', 'string', 'max:80'],
        'text'      => ['required', 'string', 'max:2000'],
    ]);

    DB::table('scriptures')->updateOrInsert(
        ['date' => $validated['date']],
        [
            'reference'  => $validated['reference'],
            'text'       => $validated['text'],
            'updated_at' => now(),
            'created_at' => now(),
        ]
    );

    return redirect()->route('admin.dashboard')
        ->with('success', "Scripture for {$validated['date']} saved successfully!");
}

    public function destroyScripture(Scripture $scripture)
    {
        $scripture->delete();
        return redirect()->route('admin.dashboard')
            ->with('success', 'Scripture deleted.');
    }

    // ── Bulk Notification ─────────────────────────────────────────

    public function sendNotification(Request $request)
    {
        $validated = $request->validate([
            'title'   => ['required', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:1000'],
            'target'  => ['required', 'in:all,inactive,centurions'],
        ]);

        // In a real app: dispatch a queued job / push to FCM / broadcast
        // Here we just return success — wire up your push service as needed

        return redirect()->route('admin.dashboard')
            ->with('success', "Notification '{$validated['title']}' queued for {$validated['target']} members!");
    }

    // ── Toggle Admin ──────────────────────────────────────────────

    public function toggleAdmin(User $user)
    {
        $user->update(['is_admin' => ! $user->is_admin]);

        return back()->with('success', "{$user->full_name}'s admin status updated.");
    }
}
