<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\PostRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index(Request $request, PostRecommendationService $recommendationService)
    {
        if ($request->user()) {
            $authUser = $request->user();

            // Users that the authenticated user is following
            $followingUsers = $authUser->following()->pluck('following_id');

            // Followers of the authenticated user
            $followers = User::whereIn('id', $authUser->followers()->pluck('follower_id'))->get();

            // Suggested users
            $suggestedUsers = User::whereNotIn('id', $followingUsers)
                ->where('id', '!=', $authUser->id)
                ->get();

            // Fetch all posts except those of the auth user (optional, depends on your requirement)
            $allPosts = Post::where('user_id', '!=', $authUser->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Build user profile vector
            $userVector = $recommendationService->buildUserProfileVector($authUser);

            // Compute similarity of each post to user
            $postsWithSimilarity = $allPosts->map(function ($post) use ($recommendationService, $userVector) {
                $postVector       = $recommendationService->textToVector($post->status . ' ' . $post->hashtags);
                $similarity       = $recommendationService->cosineSimilarity($userVector, $postVector);
                $post->similarity = $similarity;
                return $post;
            });

            // Sort posts by similarity descending and take first 10
            $recommendedPosts = $postsWithSimilarity->sortByDesc('similarity')->take(10);

            return view('posts.index', [
                'showFooter'     => false,
                'posts'          => $recommendedPosts,
                'followedUsers'  => User::whereIn('id', $followingUsers)->get(),
                'suggestedUsers' => $suggestedUsers,
                'followers'      => $followers,
            ]);
        } else {
            // Guest users - chronological posts
            return view('posts.index', [
                'showFooter' => true,
                'posts'      => Post::orderBy('created_at', 'desc')->take(10)->get(),
                'users'      => User::orderBy('created_at', 'desc')->take(10)->get(),
            ]);
        }
    }

    public function loadMorePosts(Request $request, PostRecommendationService $recommendationService)
    {
        $skip = $request->skip ?? 0;

        if ($request->user()) {
            $authUser = $request->user();

            // Build user profile vector
            $userVector = $recommendationService->buildUserProfileVector($authUser);

            // Fetch posts excluding already loaded ones
            $allPosts = Post::where('user_id', '!=', $authUser->id)
                ->orderBy('created_at', 'desc')
                ->skip($skip)
                ->take(50) // take more to rank and select top 10
                ->get();

            // Compute similarity
            $postsWithSimilarity = $allPosts->map(function ($post) use ($recommendationService, $userVector) {
                $postVector       = $recommendationService->textToVector($post->status . ' ' . $post->hashtags);
                $post->similarity = $recommendationService->cosineSimilarity($userVector, $postVector);
                return $post;
            });

            // Sort by similarity and take 10
            $recommendedPosts = $postsWithSimilarity->sortByDesc('similarity')->take(10);

            return view('posts.post-list', [
                'posts' => $recommendedPosts,
            ]);
        } else {
            // Guests: simple chronological load
            $posts = Post::orderBy('created_at', 'desc')
                ->skip($skip)
                ->take(10)
                ->get();

            return view('posts.post-list', [
                'posts' => $posts,
            ]);
        }
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

        if ($request->has('hashtags') && ! empty($request->input('hashtags'))) {
            $formFields['hashtags'] = $request->input('hashtags');
        }

        $formFields['user_id'] = Auth::id();

        Post::create($formFields);

        return redirect('/')->with('success', 'Post created!');
    }

    // Toggle star on a post
    public function toggleStar(Post $post)
    {
        $user = Auth::user();

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
        $user = Auth::user();

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
        if (Auth::id() !== $post->user_id && ! Auth::user()->isAdmin) {
            abort(403, 'Unauthorized');
        }

        $formFields = $request->validate([
            'status'   => 'required',
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
        if (Auth::id() !== $post->user_id && ! Auth::user()->isAdmin) {
            abort(403, 'Unauthorized');
        }

        $post->delete();

        return back()->with('message', 'Post deleted!');

    }

    //Search posts
    public function search()
    {
        return view('posts.search', [
            'posts' => Post::latest()->filter(request(['keyword', 'hashtag']))->get(),
        ]);
    }

    //Store a new comment on a post
    public function storeComment(Request $request, Post $post)
    {
        $formFields = $request->validate([
            'body' => 'required',
        ]);

        $formFields['user_id'] = Auth::id();

        $formFields['post_id'] = $post->id;

        Comment::create($formFields);

        return back()->with('message', 'Comment added!');
    }

    //Show comments on a post
    public function comments(Post $post)
    {
        // $comments = [
        //     [
        //         'user' => 'Alice Johnson',
        //         'content' => 'This is an awesome post! Thanks for sharing.',
        //         'created_at' => now()->subMinutes(5)->diffForHumans(),
        //     ],
        //     [
        //         'user' => 'Bob Smith',
        //         'content' => 'I completely agree with your thoughts!',
        //         'created_at' => now()->subHours(1)->diffForHumans(),
        //     ],
        //     [
        //         'user' => 'Bob Smith',
        //         'content' => 'I completely agree with your thoughts!',
        //         'created_at' => now()->subHours(1)->diffForHumans(),
        //     ],
        //     [
        //         'user' => 'Bob Smith',
        //         'content' => 'I completely agree with your thoughts!',
        //         'created_at' => now()->subHours(1)->diffForHumans(),
        //     ],
        //     [
        //         'user' => 'Bob Smith',
        //         'content' => 'I completely agree with your thoughts!',
        //         'created_at' => now()->subHours(1)->diffForHumans(),
        //     ],
        //     [
        //         'user' => 'Charlie Brown',
        //         'content' => 'Can you provide more information on this topic?',
        //         'created_at' => now()->subDays(1)->diffForHumans(),
        //     ],
        // ];

        $comments = $post->comments()->with('user')->get()->map(function ($comment) {
            return [
                'user'       => $comment->user->name,
                'body'       => $comment->body,
                'created_at' => $comment->created_at->diffForHumans(),
                'user_image' => $comment->user->avatar,
            ];
        });

        return response()->json(['comments' => $comments]);
    }

    //Manage posts
    public function manage(Request $request)
    {
        $user  = $request->user();
        $posts = $user->posts()->paginate(8);

        return view('posts.manage', [
            'posts' => $posts,
        ]);
    }
}
