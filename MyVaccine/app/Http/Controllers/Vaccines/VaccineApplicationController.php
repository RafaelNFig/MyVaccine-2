<?php

namespace App\Http\Controllers\Vaccines;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Vaccine;
use App\Models\Stock;
use App\Models\VaccinationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class VaccineApplicationController extends Controller
{
    // Página inicial da aplicação da vacina (lista ou overview)
    public function index()
    {
        $users = User::all();
        $posts = Post::where('status', 'ativo')->get();

        return view('admin.Pacients.vaccineaplication', compact('users', 'posts'));
    }

    // Mostrar formulário de vacinação (mesma view, mesma lógica)
    public function create()
    {
        $posts = Post::where('status', 'ativo')->get();
        $vaccines = Vaccine::all();
        $users = User::where('role', 'usuario')->get();

        return view('admin.Pacients.vaccineaplication', compact('posts', 'vaccines', 'users'));
    }

    // Processar a vacinação
    public function store(Request $request)
    {
        $request->validate([
            'user_cpf' => 'required|string|exists:users,cpf',
            'post_id' => 'required|exists:posts,id',
            'vaccine_id' => 'required|exists:vaccines,id',
        ]);

        $user = User::where('cpf', $request->user_cpf)->first();
        $post = Post::find($request->post_id);
        $vaccine = Vaccine::find($request->vaccine_id);

        if (!$user) {
            throw ValidationException::withMessages([
                'user_cpf' => ['Usuário não encontrado.'],
            ]);
        }

        if (!$post) {
            throw ValidationException::withMessages([
                'post_id' => ['Posto não encontrado.'],
            ]);
        }

        if (!$vaccine) {
            throw ValidationException::withMessages([
                'vaccine_id' => ['Vacina não encontrada.'],
            ]);
        }

        // Verificar estoque do posto para essa vacina
        $stock = Stock::where('post_id', $post->id)
                      ->where('vaccine_id', $vaccine->id)
                      ->where('quantity', '>', 0)
                      ->first();

        if (!$stock) {
            throw ValidationException::withMessages([
                'vaccine_id' => ['Vacina não disponível ou estoque zerado neste posto.'],
            ]);
        }

        // Registrar vacinação no histórico
        VaccinationHistory::create([
            'user_cpf' => $user->cpf,
            'vaccine_id' => $vaccine->id,
            'post_id' => $post->id,
            'batch' => $stock->batch,
            'application_date' => Carbon::now(),
        ]);

        // Diminuir estoque em 1
        $stock->decrement('quantity');

        return redirect()->route('admin.patients.vaccinate')->with('success', 'Vacina aplicada com sucesso!');
    }

    // Retorna vacinas disponíveis para um posto via AJAX
    public function getVaccinesByPost(Post $post)
    {
        $vaccines = Vaccine::whereHas('stocks', function($query) use ($post) {
            $query->where('post_id', $post->id)
                  ->where('quantity', '>', 0);
        })->get();

        return response()->json($vaccines);
    }
}
