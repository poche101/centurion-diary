<?php

namespace App\Http\Controllers;

use App\Models\GivingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GivingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $givingLogs = GivingLog::where('user_id', $user->id)
            ->latest('date_given')
            ->paginate(20);

        $totalEspees = GivingLog::where('user_id', $user->id)->sum('amount_espees');
        $totalGifts  = GivingLog::where('user_id', $user->id)->count();
        $givingPercent = min(round(($totalEspees / 100) * 100, 1), 100);

        $thisMonthEspees = GivingLog::where('user_id', $user->id)
            ->whereMonth('date_given', now()->month)
            ->whereYear('date_given', now()->year)
            ->sum('amount_espees');

        $byCategory = GivingLog::where('user_id', $user->id)
            ->select('category', DB::raw('SUM(amount_espees) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        return view('dashboard.giving', compact(
            'givingLogs', 'totalEspees', 'totalGifts',
            'givingPercent', 'thisMonthEspees', 'byCategory'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount_espees' => ['required', 'numeric', 'min:0.01', 'max:99999'],
            'category'      => ['required', 'string', 'in:manifestation_conference,offering,missions,welfare,building_fund,special_seed,other'],
            'description'   => ['nullable', 'string', 'max:300'],
            'date_given'    => ['required', 'date', 'before_or_equal:today'],
        ]);

        GivingLog::create([
            'user_id'       => Auth::id(),
            'amount_espees' => $validated['amount_espees'],
            'category'      => $validated['category'],
            'description'   => $validated['description'] ?? null,
            'date_given'    => $validated['date_given'],
        ]);

        return redirect()->route('giving.index')
            ->with('success', number_format($validated['amount_espees'], 2) . " espees logged under " . ucfirst($validated['category']) . ". God loves a cheerful giver! 💝");
    }

    public function destroy(GivingLog $givingLog)
    {
        abort_unless($givingLog->user_id === Auth::id(), 403);
        $givingLog->delete();

        return redirect()->route('giving.index')
            ->with('success', 'Contribution record removed.');
    }
}
