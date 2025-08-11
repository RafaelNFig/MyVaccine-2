<?php

namespace App\Http\Controllers\Vaccines;

use App\Models\Stock;
use App\Models\Post;
use App\Models\Vaccine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Lista o estoque de um posto específico.
     */
    public function index($postId)
    {
        $post = Post::findOrFail($postId);

        $stocks = Stock::where('post_id', $postId)->get();

        $vaccines = Vaccine::all();

        return view('admin.stocksPosts', compact('post', 'stocks', 'vaccines'));
    }

    /**
     * Salva um novo lote no estoque do posto.
     */
    public function store(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);

        $request->validate([
            'vaccine_id' => 'required|exists:vaccines,id',
            'quantity' => 'required|integer|min:0',
            'batch' => 'required|string|max:50',
            'expiration_date' => 'required|date',
        ]);

        Stock::create([
            'post_id' => $post->id,
            'vaccine_id' => $request->vaccine_id,
            'quantity' => $request->quantity,
            'batch' => $request->batch,
            'expiration_date' => $request->expiration_date,
        ]);

        return redirect()->route('stock.index', $post->id)
            ->with('success', 'Vacina adicionada ao estoque com sucesso!');
    }

    /**
     * Remove um lote do estoque.
     */
    public function destroy($postId, $stockId)
    {
        $post = Post::findOrFail($postId);

        $stock = Stock::where('post_id', $post->id)->findOrFail($stockId);
        $stock->delete();

        return redirect()->route('stock.index', $post->id)
            ->with('success', 'Lote removido do estoque.');
    }

    /**
     * Retorna o estoque do posto em JSON para API (para o modal).
     */
    public function apiStocks($postId)
    {
        $post = Post::findOrFail($postId);
    
        $stocks = Stock::with('vaccine')
            ->where('post_id', $postId)
            ->get()
            ->map(function ($stock) {
                return [
                    'vaccine_name' => $stock->vaccine->name,
                    'quantity' => $stock->quantity,
                    'expiration_date' => $stock->expiration_date,
                ];
            });
    
        return response()->json($stocks);
    }
}
