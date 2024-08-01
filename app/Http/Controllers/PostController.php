<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    // Show Home page
    public function index()
    {
        return view('posts.index', [
            'showFooter' => false,
            'posts' => Post::all(),
        ]);
    }
}
