<?php
namespace App\Http\Controllers\Vaccines;

use App\Models\Stock;
use App\Models\Post;
use App\Models\Vaccine;
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
            'post_id' => 'required|exists:posts,id',
            'vaccine_id' => 'required|exists:vaccines,id',
            'quantity' => 'required|integer|min:0',
            'batch' => 'required|string|max:50',
            'expiration_date' => 'required|date',
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

    /**
     * Exibe a tela de vacinas/estoque.
     * - Se $post_id informado: mostra estoques do posto.
     * - Se não informado: mostra a tela de vacinas vazia (sem depender de posto).
     *
     * @param int|null $post_id
     * @return \Illuminate\View\View
     */
    public function homeVaccines($post_id = null)
    {
        if ($post_id) {
            $post = Post::find($post_id);

            if (!$post) {
                abort(404, 'Posto não encontrado');
            }

            $stocks = Stock::where('post_id', $post_id)->get();
        } else {
            // não há posto selecionado -> não quebrar a view
            $post = null;
            // manter estoque vazio (a view pode exibir mensagem "nenhum lote" ou listar vacinas separadamente)
            $stocks = collect();
        }

        // lista de vacinas (mesmo sem posto)
        $vaccines = Vaccine::all();

        return view('admin.Vaccines.homevaccines', compact('post', 'stocks', 'vaccines'));
    }
}
