<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    // Exibe o formulário de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Processa o cadastro do usuário
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|digits:11|unique:users,cpf',
            'telephone' => 'required|string|max:15',
            'dob' => 'required|date',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'cpf' => $validated['cpf'],
            'telephone' => $validated['telephone'],
            'dob' => $validated['dob'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
            
        ]);


        // Redireciona para a home do usuário com mensagem
        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso!');
    }
}