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
        return view('admin.home', compact('vaccines'));
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
            'min_age' => 'required|integer',
            'max_age' => 'nullable|integer',
            'contraindications' => 'nullable|string',
        ]);


        Vaccine::create($request->all());
        return redirect()->route('vaccines.index')->with('success', 'Vacina adicionada com sucesso!');
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
        return redirect()->route('vaccines.index')->with('success', 'Vacina removida.');
    }
}
