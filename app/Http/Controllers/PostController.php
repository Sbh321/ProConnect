<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Show Home page
    public function index()
    {
        return view('posts.index', [
            'showFooter' => false,
            'posts' => Post::orderBy('created_at', 'desc')->get(),
        ]);
    }

    // Show form to create a new post
    public function create()
    {
        return view('posts.create');
    }

// Store a new post
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'status' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('post_images', 'public');
        }

        if ($request->has('hashtags') && !empty($request->input('hashtags'))) {
            $formFields['hashtags'] = $request->input('hashtags');
        }

        $formFields['user_id'] = auth()->id();

        Post::create($formFields);

        return redirect('/')->with('success', 'Post created!');
    }

    // Toggle star on a post
    public function toggleStar(Post $post)
    {
        $user = auth()->user();

        if ($post->stars()->where('user_id', $user->id)->exists()) {
            // Unstar the post
            $post->stars()->detach($user->id);
            return response()->json(['status' => 'unstarred']);
        } else {
            // Star the post
            $post->stars()->attach($user->id);
            return response()->json(['status' => 'starred']);
        }
    }

    //Toggle save on a post
    public function toggleSave(Post $post)
    {
        $user = auth()->user();

        if ($post->saves()->where('user_id', $user->id)->exists()) {
            // Unsave the post
            $post->saves()->detach($user->id);
            return response()->json(['status' => 'unsaved']);
        } else {
            // Save the post
            $post->saves()->attach($user->id);
            return response()->json(['status' => 'saved']);
        }
    }
}
