<?php

namespace App\Http\Controllers\Vaccines;

use App\Http\Controllers\Controller;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    /**
     * Lista todas as vacinas
     */
    public function index()
    {
        $vaccines = Vaccine::orderBy('id', 'desc')->get();
        return view('admin.Vaccines.homevaccines', compact('vaccines'));
    }

    /**
     * Salva uma nova vacina (Cadastro)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:100',
            'min_age'            => 'required|integer|min:0',
            'max_age'            => 'nullable|integer|min:0',
            'contraindications'  => 'nullable|string',
        ]);

        $vaccine = Vaccine::create($request->only([
            'name', 'min_age', 'max_age', 'contraindications'
        ]));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'vaccine' => $vaccine,
                'message' => 'Vacina cadastrada com sucesso!'
            ]);
        }

        return redirect()->route('vaccines.index')
                         ->with('success', 'Vacina cadastrada com sucesso!');
    }

    public function homeVaccines($post_id = null)
    {
        $vaccines = Vaccine::orderBy('id', 'desc')->get();
        return view('admin.Vaccines.homevaccines', compact('vaccines'));
    }

    /**
     * Atualiza uma vacina (Edição)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'               => 'required|string|max:100',
            'min_age'            => 'required|integer|min:0',
            'max_age'            => 'nullable|integer|min:0',
            'contraindications'  => 'nullable|string',
        ]);

        $vaccine = Vaccine::findOrFail($id);
        $vaccine->update($request->only([
            'name', 'min_age', 'max_age', 'contraindications'
        ]));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'vaccine' => $vaccine,
                'message' => 'Vacina atualizada com sucesso!'
            ]);
        }

        return redirect()->route('vaccines.index')
                         ->with('success', 'Vacina atualizada com sucesso!');
    }

    /**
     * Remove uma vacina (Remoção)
     */
    public function destroy(Request $request, $id)
    {
        $vaccine = Vaccine::find($id);

        if (!$vaccine) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Vacina não encontrada.'], 404);
            }
            // Opcional: para requisições não ajax, redirecione ou retorne erro
            return response()->json(['success' => false, 'message' => 'Vacina não encontrada.'], 404);
        }

        try {
            $vaccine->delete();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao excluir vacina: ' . $e->getMessage()
                ], 500);
            }
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir vacina.'
            ], 500);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Vacina removida com sucesso!']);
        }

        return response()->json(['success' => true, 'message' => 'Vacina removida com sucesso!']);
    }
}
