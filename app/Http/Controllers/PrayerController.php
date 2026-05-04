<?php

namespace App\Http\Controllers;

use App\Models\PrayerLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrayerController extends Controller
{
    // ── List & stats ──────────────────────────────────────────────

    public function index()
    {
        $user = Auth::user();

        $prayerLogs = PrayerLog::where('user_id', $user->id)
            ->latest('prayer_date')
            ->paginate(15);

        $totalMinutes  = PrayerLog::where('user_id', $user->id)->sum('duration_minutes');
        $totalHours    = round($totalMinutes / 60, 2);
        $totalSessions = PrayerLog::where('user_id', $user->id)->count();
        $prayerPercent = min(round(($totalHours / 100) * 100, 1), 100);

        $todayMinutes = PrayerLog::where('user_id', $user->id)
            ->whereDate('prayer_date', today())
            ->sum('duration_minutes');

        $streak = $user->prayer_streak;

        return view('dashboard.prayer', compact(
            'prayerLogs', 'totalHours', 'totalSessions',
            'prayerPercent', 'todayMinutes', 'streak'
        ));
    }

    // ── Store from form ───────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prayer_date'      => ['required', 'date', 'before_or_equal:today'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:720'],
            'prayer_type'      => ['nullable', 'string', 'in:intercession,worship,tongues,meditation,general'],
            'notes'            => ['nullable', 'string', 'max:1000'],
        ]);

        PrayerLog::create([
            'user_id'          => Auth::id(),
            'prayer_date'      => $validated['prayer_date'],
            'duration_minutes' => $validated['duration_minutes'],
            'prayer_type'      => $validated['prayer_type'] ?? 'general',
            'notes'            => $validated['notes'],
        ]);

        $hours = round($validated['duration_minutes'] / 60, 2);

        return redirect()->route('prayer.index')
            ->with('success', "Prayer session of {$validated['duration_minutes']} min (+{$hours}h) logged successfully! 🙏");
    }

    // ── Quick log from timer (AJAX) ────────────────────────────────

    public function quickLog(Request $request)
    {
        $validated = $request->validate([
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:720'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ]);

        PrayerLog::create([
            'user_id'          => Auth::id(),
            'prayer_date'      => today(),
            'duration_minutes' => $validated['duration_minutes'],
            'prayer_type'      => 'general',
            'notes'            => $validated['notes'] ?? 'Quick timer session',
        ]);

        $totalHours = round(Auth::user()->prayer_hours, 2);

        return response()->json([
            'success'     => true,
            'message'     => 'Prayer session saved!',
            'total_hours' => $totalHours,
        ]);
    }

    // ── Delete ─────────────────────────────────────────────────────

    public function destroy(PrayerLog $prayerLog)
    {
        abort_unless($prayerLog->user_id === Auth::id(), 403);
        $prayerLog->delete();

        return redirect()->route('prayer.index')
            ->with('success', 'Prayer session removed.');
    }
}
