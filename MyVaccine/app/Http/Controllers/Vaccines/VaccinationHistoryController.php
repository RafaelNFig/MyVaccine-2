<?php

namespace App\Http\Controllers\Vaccines;

use App\Http\Controllers\Controller;
use App\Models\VaccinationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class VaccinationHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pega as vacinações do usuário logado ordenadas pela data decrescente
        $histories = VaccinationHistory::with('vaccine', 'post')
            ->where('user_cpf', $user->cpf)
            ->orderBy('application_date', 'desc')
            ->get();

        // Contador para doses por vacina
        $doseCount = [];

        $histories->transform(function ($history) use (&$doseCount) {
            $vaccineId = $history->vaccine_id;

            if (!isset($doseCount[$vaccineId])) {
                $doseCount[$vaccineId] = 1;
            } else {
                $doseCount[$vaccineId]++;
            }

            // Define a propriedade dose que a view espera
            $history->dose = $doseCount[$vaccineId];

            return $history;
        });

        return view('users.vaccination-history', compact('histories'));
    }

    public function store(Request $request)
    {
        try {
            VaccinationHistory::create([
                'user_cpf'        => $request->user_cpf,
                'vaccine_id'      => $request->vaccine_id,
                'post_id'         => $request->post_id,
                'application_date'=> now(),
            ]);

            return redirect()
                ->route('vaccination-history.index')
                ->with('notification', [
                    'message' => 'Vacina aplicada com sucesso!',
                    'type' => 'success'
                ]);
        } catch (Exception $e) {
            return redirect()
                ->route('vaccination-history.index')
                ->with('notification', [
                    'message' => 'Erro ao aplicar a vacina.',
                    'type' => 'error'
                ]);
        }
    }
}
