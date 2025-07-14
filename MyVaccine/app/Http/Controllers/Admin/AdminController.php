<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Mostrar a página inicial do painel do admin
    public function index()
    {
        return view('admin.home'); // Ex: Painel com dados gerais, gráficos, etc.
    }

}