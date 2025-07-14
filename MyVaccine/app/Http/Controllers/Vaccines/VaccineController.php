<?php

namespace App\Http\Controllers\Vaccines;

use App\Http\Controllers\Controller;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    public function index()
    {
        $vaccines = Vaccine::all();
        return view('vaccine.index', compact('vaccines'));
    }

    public function create()
    {
        return view('vaccine.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Vaccine::create($request->all());
        return redirect()->route('vaccine.index')->with('success', 'Vacina adicionada com sucesso!');
    }

    public function edit($id)
    {
        $vaccine = Vaccine::findOrFail($id);
        return view('vaccine.edit', compact('vaccine'));
    }

    public function update(Request $request, $id)
    {
        $vaccine = Vaccine::findOrFail($id);
        $vaccine->update($request->all());
        return redirect()->route('vaccine.index')->with('success', 'Vacina atualizada com sucesso!');
    }

    public function destroy($id)
    {
        Vaccine::destroy($id);
        return redirect()->route('vaccine.index')->with('success', 'Vacina removida.');
    }
}
