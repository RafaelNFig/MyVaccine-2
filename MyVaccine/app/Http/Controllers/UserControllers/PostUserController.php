<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostUserController extends Controller
{
    public function index()
    {
       $posts = Post::all();
        return view('users.showPosts', compact('posts'));
    }
}
