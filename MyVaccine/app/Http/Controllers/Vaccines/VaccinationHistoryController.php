<?php

namespace App\Http\Controllers\Vaccines;

use App\Http\Controllers\Controller;
use App\Models\VaccinationHistory;
use Illuminate\Http\Request;

class VaccinationHistoryController extends Controller
{
    public function index()
    {
        $histories = VaccinationHistory::with('user', 'vaccine')->get();
        return view('users.vaccination-history', compact('histories'));
    }

    public function show($id)
    {
        $history = VaccinationHistory::with('user', 'vaccine')->findOrFail($id);
        return view('users.vaccination-history', compact('history'));
    }
}
