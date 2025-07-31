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
        return view('postos.index', compact('postos'));
    }

    public function create()
    {
        return view('postos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'address' => 'required|max:100',
            'city' => 'required|max:50',
            'state' => 'required|size:2',
            'status' => 'required|in:ativo,inativo',
        ]);

        Post::create($request->all());
        return redirect()->route('postos.index')->with('success', 'Posto criado com sucesso.');
    }

    public function show($id)
    {
        $posto = Post::findOrFail($id);
        return view('postos.show', compact('posto'));
    }

    public function edit($id)
    {
        $posto = Post::findOrFail($id);
        return view('postos.edit', compact('posto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'address' => 'required|max:100',
            'city' => 'required|max:50',
            'state' => 'required|size:2',
            'status' => 'required|in:ativo,inativo',
        ]);

        $posto = Post::findOrFail($id);
        $posto->update($request->all());

        return redirect()->route('postos.index')->with('success', 'Posto atualizado com sucesso.');
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->route('postos.index')->with('success', 'Posto removido.');
    }
}
