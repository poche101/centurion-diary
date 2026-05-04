<?php

namespace App\Http\Controllers;

use App\Models\Soul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoulController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $souls = Soul::where('user_id', $user->id)
            ->latest('date_won')
            ->paginate(20);

        $totalSouls     = Soul::where('user_id', $user->id)->count();
        $soulsPercent   = min(round(($totalSouls / 100) * 100, 1), 100);
        $baptizedCount  = Soul::where('user_id', $user->id)->where('baptized', true)->count();

        $thisMonthSouls = Soul::where('user_id', $user->id)
            ->whereMonth('date_won', now()->month)
            ->whereYear('date_won', now()->year)
            ->count();

        return view('dashboard.souls', compact(
            'souls', 'totalSouls', 'soulsPercent', 'baptizedCount', 'thisMonthSouls'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'soul_name'       => ['required', 'string', 'max:120'],
            'date_won'        => ['required', 'date', 'before_or_equal:today'],
            'phone'           => ['nullable', 'string', 'max:30'],
            'location'        => ['nullable', 'string', 'max:200'],
            'baptized'        => ['nullable', 'boolean'],
            'follow_up_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Soul::create([
            'user_id'         => Auth::id(),
            'soul_name'       => $validated['soul_name'],
            'date_won'        => $validated['date_won'],
            'phone'           => $validated['phone'] ?? null,
            'location'        => $validated['location'] ?? null,
            'baptized'        => $request->boolean('baptized'),
            'follow_up_notes' => $validated['follow_up_notes'] ?? null,
        ]);

        $total = Soul::where('user_id', Auth::id())->count();

        return redirect()->route('souls.index')
            ->with('success', "Soul #{$total} — {$validated['soul_name']} — has been registered! ✨ Keep winning souls!");
    }

    public function update(Request $request, Soul $soul)
    {
        abort_unless($soul->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'baptized'        => ['boolean'],
            'follow_up_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $soul->update($validated);

        return redirect()->route('souls.index')
            ->with('success', 'Soul record updated.');
    }

    public function destroy(Soul $soul)
    {
        abort_unless($soul->user_id === Auth::id(), 403);
        $soul->delete();

        return redirect()->route('souls.index')
            ->with('success', 'Soul record removed.');
    }
}
