<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Mostrar o formulário de login do admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Processar o login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Aqui você pode usar um guard específico para admin, se configurar isso no Auth
        if (Auth::attempt($credentials)) {
            // Verifica se o usuário é admin (exemplo usando campo "is_admin")
            if (Auth::user()->is_admin) {
                return redirect()->intended('/admin/home');
            } else {
                Auth::logout();
                return redirect('/admin/login')->withErrors('Acesso negado.');
            }
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    // Fazer logout
    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}