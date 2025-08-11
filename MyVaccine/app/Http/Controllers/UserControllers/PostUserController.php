<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostUserController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $query = Post::query();

    if ($search) {
        $searchLower = strtolower($search);

        $query->where(function($q) use ($searchLower) {
            $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchLower}%"])
              ->orWhereRaw('LOWER(city) LIKE ?', ["%{$searchLower}%"])
              ->orWhereRaw('LOWER(state) LIKE ?', ["%{$searchLower}%"])
              ->orWhereHas('stocks.vaccine', function($q2) use ($searchLower) {
                  $q2->whereRaw('LOWER(name) LIKE ?', ["%{$searchLower}%"]);
              });
        });
    }

    // Com eager loading dos stocks e vacinas pra evitar N+1
    $posts = $query->with(['stocks.vaccine'])->get();

    return view('users.showPosts', compact('posts', 'search'));
}
}
