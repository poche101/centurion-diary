<?php

namespace App\Http\Controllers;

use App\Models\Scripture;

class ScriptureController extends Controller
{
    public function index()
    {
        $todayScripture = Scripture::today();

        $recent = Scripture::orderByDesc('date')->take(14)->get();

        return view('dashboard.scripture', compact('todayScripture', 'recent'));
    }
}
