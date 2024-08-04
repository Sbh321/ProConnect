<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Show Home page
    public function index(Request $request)
    {
        if ($request->user()) {
            // Get the current authenticated user
            $authUser = $request->user();

            // Get the users that the authenticated user is following
            $followingUsers = $authUser->following()->pluck('following_id');

            // Get the users that are following the authenticated user
            $followers = User::whereIn('id', $authUser->followers()->pluck('follower_id'))->get();

            // Get the users that the authenticated user is not following (suggested users)
            $suggestedUsers = User::whereNotIn('id', $followingUsers)
                ->where('id', '!=', $authUser->id)
                ->get();

            return view('posts.index', [
                'showFooter' => false,
                'posts' => Post::orderBy('created_at', 'desc')->take(10)->get(),
                'followedUsers' => User::whereIn('id', $followingUsers)->get(),
                'suggestedUsers' => $suggestedUsers,
                'followers' => $followers,
            ]);
        } else {
            return view('posts.index', [
                'showFooter' => true,
                'posts' => Post::orderBy('created_at', 'desc')->take(10)->get(),
                'users' => User::orderBy('created_at', 'desc')->take(10)->get(),
            ]);
        }
    }

    // Load more posts
    public function loadMorePosts(Request $request)
    {
        // if ($request->ajax()) {
        //     $posts = Post::orderBy('created_at', 'desc')
        //         ->skip($request->skip)
        //         ->take(10)
        //         ->get();

        //     return view('posts.post-list', compact('posts'))->render();
        // }
        return view('posts.post-list', [
            'posts' => Post::orderBy('created_at', 'desc')
                ->skip($request->skip)
                ->take(10)
                ->get(),
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

    // Show the form to edit a post
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    // Update a post
    public function update(Request $request, Post $post)
    {
        // Make sure logged in user is the owner of the post
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized');
        }

        $formFields = $request->validate([
            'status' => 'required',
            'hashtags' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('post_images', 'public');
        }

        $post->update($formFields);

        return back()->with('message', 'Post updated!');
    }

    // Delete a post
    public function destroy(Post $post)
    {
        // Make sure logged in user is the owner of the post
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized');
        }

        $post->delete();

        // return redirect()->route('profile', ['user' => auth()->id()])->with('message', 'Post deleted!');
        return back()->with('message', 'Post deleted!');

    }

    //Search posts
    public function search()
    {
        return view('posts.search', [
            'posts' => Post::latest()->filter(request(['keyword', 'hashtag']))->get(),
            // 'users' => User::latest()->filter(request(['keyword']))->get(),
        ]);
    }
}
