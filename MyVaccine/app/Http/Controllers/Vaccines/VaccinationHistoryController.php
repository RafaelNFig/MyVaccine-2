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
        return view('vaccination_history.index', compact('histories'));
    }

    public function show($id)
    {
        $history = VaccinationHistory::with('user', 'vaccine')->findOrFail($id);
        return view('vaccination_history.show', compact('history'));
    }
}
