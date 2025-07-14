<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User; // lembre-se de importar o modelo User

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Valida somente o email (sem senha)
        $request->validate([
            'email' => ['required', 'email'],
            //'password' => ['required', 'string'], // comentado
        ]);

        // Busca usuário pelo email
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            // Loga o usuário diretamente, sem validar senha
            Auth::login($user);

            // Regenera sessão para segurança
            $request->session()->regenerate();

            // Armazena dados na sessão (opcional)
            Session::put('email', $user->email);
            Session::put('name', $user->name);

            return redirect()->intended('/');
        }

        // Se não achar usuário, retorna erro
        return back()->withErrors([
            'email' => 'Usuário não encontrado.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function username()
    {
        return 'email';
    }
}
