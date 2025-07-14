<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Importa o modelo User para buscar o usuário

class AdminAuthController extends Controller
{
    // Mostrar o formulário de login do admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Processar o login do admin
    public function login(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Comentado para permitir login direto sem autenticação real
        /*
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->is_admin) {
                return redirect()->intended('/admin/home');
            }

            Auth::logout();
            return redirect('/admin/login')->withErrors([
                'email' => 'Acesso negado.',
            ]);
        }
        */

        // Busca o usuário pelo email
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            // Loga o usuário diretamente sem validar senha nem verificar admin
            Auth::login($user);

            // Regenera sessão para segurança
            $request->session()->regenerate();

            return redirect()->intended('/admin/home');
        }

        // Caso não encontre usuário
        return back()->withErrors([
            'email' => 'Usuário não encontrado.',
        ])->withInput($request->only('email'));
    }

    // Logout do admin
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
