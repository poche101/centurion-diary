<?php

namespace App\Http\Controllers;

use App\Models\GivingLog;
use App\Models\PrayerLog;
use App\Models\Scripture;
use App\Models\Soul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use NotificationChannels\WebPush\PushSubscription;

class AdminController extends Controller
{
    // ── Admin Dashboard ────────────────────────────────────────────

    public function dashboard()
    {
        $totalUsers       = User::where('is_admin', false)->count();
        $totalPrayerHours = round(PrayerLog::sum('duration_minutes') / 60, 1);
        $totalSouls       = Soul::count();
        $totalEspees      = round(GivingLog::sum('amount_espees'), 2);

        $activeToday = User::where('is_admin', false)
            ->where('last_login_at', '>=', now()->subDay())
            ->count();

        $allRegularUsers   = User::where('is_admin', false)
            ->with(['prayerLogs', 'souls', 'givingLogs'])
            ->get();

        $prayerCenturions  = $allRegularUsers->filter(fn($u) => $u->prayer_hours  >= 100)->count();
        $soulsCenturions   = $allRegularUsers->filter(fn($u) => $u->souls_count   >= 100)->count();
        $givingCenturions  = $allRegularUsers->filter(fn($u) => $u->giving_espees >= 100)->count();
        $fullCenturions    = $allRegularUsers->filter(fn($u) => $u->overall_progress >= 100)->count();

        $stage0_25  = $allRegularUsers->filter(fn($u) => $u->overall_progress <= 25)->count();
        $stage25_50 = $allRegularUsers->filter(fn($u) => $u->overall_progress > 25 && $u->overall_progress <= 50)->count();
        $stage50_75 = $allRegularUsers->filter(fn($u) => $u->overall_progress > 50 && $u->overall_progress <= 75)->count();
        $stage75_99 = $allRegularUsers->filter(fn($u) => $u->overall_progress > 75 && $u->overall_progress < 100)->count();

        $centurionHeroes = $allRegularUsers
            ->filter(fn($u) => $u->overall_progress >= 100)
            ->sortByDesc('overall_progress')
            ->take(10)
            ->values();

        $allUsers = User::where('is_admin', false)
            ->with(['prayerLogs', 'souls', 'givingLogs'])
            ->latest()
            ->paginate(20);

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

    \Log::info('sendNotification called', $validated); // ← moved here

    $query = User::with(['prayerLogs', 'souls', 'givingLogs', 'pushSubscriptions']);

    if ($validated['target'] === 'inactive') {
        $query->where('last_login_at', '<', now()->subDays(3));
        $users = $query->get();
    } elseif ($validated['target'] === 'centurions') {
        $users = $query->get()->filter(fn($u) => $u->overall_progress >= 100);
    } else {
        $users = $query->get();
    }

    \Log::info('Users found', ['count' => $users->count()]); // ← add this too

    $auth = [
        'VAPID' => [
            'subject'    => config('webpush.vapid.subject', 'mailto:admin@centuriondiary.com'),
            'publicKey'  => config('webpush.vapid.public_key'),
            'privateKey' => config('webpush.vapid.private_key'),
        ],
    ];

    $webPush = new WebPush($auth);

    $payload = json_encode([
        'title' => $validated['title'],
        'body'  => $validated['message'],
        'url'   => '/dashboard',
    ]);

    $sent = 0;
    foreach ($users as $user) {
        foreach ($user->pushSubscriptions as $sub) {
            \Log::info('Queuing notification', ['user' => $user->id, 'endpoint' => $sub->endpoint]);
            $webPush->queueNotification(
                Subscription::create([
                    'endpoint'        => $sub->endpoint,
                    'contentEncoding' => $sub->content_encoding ?? 'aesgcm',
                    'keys'            => [
                        'p256dh' => $sub->public_key,
                        'auth'   => $sub->auth_token,
                    ],
                ]),
                $payload
            );
            $sent++;
        }
    }

    \Log::info('Flushing notifications', ['sent' => $sent]);

    foreach ($webPush->flush() as $report) {
        if ($report->isSuccess()) {
            \Log::info('Push sent successfully', ['endpoint' => $report->getEndpoint()]);
        } else {
            \Log::error('Push failed', [
                'endpoint' => $report->getEndpoint(),
                'reason'   => $report->getReason(),
                'response' => $report->getResponse() ? $report->getResponse()->getBody()->__toString() : 'no response',
            ]);
            PushSubscription::where('endpoint', $report->getEndpoint())->delete();
        }
    }

    return redirect()->route('admin.dashboard')
        ->with('success', "Notification '{$validated['title']}' sent to {$sent} device(s)!");
}

    // ── Toggle Admin ──────────────────────────────────────────────

    public function toggleAdmin(User $user)
    {
        $user->update(['is_admin' => ! $user->is_admin]);

        return back()->with('success', "{$user->full_name}'s admin status updated.");
    }
}
