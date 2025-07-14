<?php
namespace App\Http\Controllers\Vaccines;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        return view('stock.index', compact('stocks'));
    }

    public function create()
    {
        return view('stock.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'vaccine_id' => 'required|exists:vaccines,id',
            'quantity' => 'required|integer|min:0',
        ]);

        Stock::create($request->all());
        return redirect()->route('stock.index')->with('success', 'Estoque adicionado com sucesso!');
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.edit', compact('stock'));
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);
        $stock->update($request->all());
        return redirect()->route('stock.index')->with('success', 'Estoque atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Stock::destroy($id);
        return redirect()->route('stock.index')->with('success', 'Estoque removido.');
    }
}