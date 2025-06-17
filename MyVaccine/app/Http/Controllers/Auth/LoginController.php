<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    // Exibe o formulário de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Realiza o login do usuário
    public function login(Request $request)
    {
        // Validação dos dados recebidos
        $credentials = $request->validate([
            'cpf' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Tenta autenticar com cpf e senha
        if (Auth::attempt(['cpf' => $credentials['cpf'], 'password' => $credentials['password']])) {
            // Regenera a sessão para evitar fixação
            $request->session()->regenerate();

            // Guarda dados adicionais na sessão (opcional)
            Session::put('cpf', Auth::user()->cpf);
            Session::put('name', Auth::user()->name);

            // Redireciona para a página anterior ou home
            return redirect()->intended('/');
        }

        // Caso falhe, volta com erro específico
        return back()->withErrors([
            'cpf' => 'CPF ou senha inválidos.',
        ])->withInput($request->only('cpf'));
    }

    // Realiza logout do usuário
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
