<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostoController extends Controller
{
    public function index()
    {
        $postos = Post::all();
        return view('home', compact('postos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'address' => 'required|max:100',
            'city' => 'required|max:50',
            'state' => 'required|size:2',
            'status' => 'sometimes|in:ativo,inativo',
        ]);

        // Se status não enviado, seta 'ativo'
        if (!isset($validated['status'])) {
            $validated['status'] = 'ativo';
        }

        $posto = Post::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Posto criado com sucesso.',
            'post' => $posto,
        ]);
    }

    public function edit($id)
    {
        $posto = Post::findOrFail($id);

        return response()->json([
            'success' => true,
            'post' => $posto,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Permite PUT ou PATCH
        if (!$request->isMethod('put') && !$request->isMethod('patch')) {
            return response()->json(['success' => false, 'message' => 'Método HTTP inválido.'], 405);
        }

        $validated = $request->validate([
            'name' => 'required|max:100',
            'address' => 'required|max:100',
            'city' => 'required|max:50',
            'state' => 'required|size:2',
            'status' => 'sometimes|in:ativo,inativo',
        ]);

        $posto = Post::findOrFail($id);
        $posto->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Posto atualizado com sucesso.',
            'post' => $posto,
        ]);
    }

    public function destroy($id)
    {
        $deleted = Post::destroy($id);

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Posto removido com sucesso.',
                'post_id' => $id,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao remover posto.',
        ], 500);
    }
}
