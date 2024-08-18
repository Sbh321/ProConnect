<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show the form to create/register a new user
    public function create()
    {
        return view('users.register');
    }

    // Store a new user
    public function store(Request $request)
    {
        // Validate the request
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:8',
        ]);

        // Hash the password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create the user
        $user = User::create($formFields);

        // Log the user in
        auth()->login($user);

        return redirect('/')->with('message', 'User Created and Logged In');
    }

    // Log the user out
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Logged Out');
    }

    // Show the form to login
    public function login()
    {
        return view('users.login');
    }

    // Log the user in
    public function auth(Request $request)
    {
        // Validate the request
        $formFields = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'Logged In');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show a single user profile with posts
    public function show(User $user)
    {
        return view('users.profile', [
            'user' => $user,
            'posts' => Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(10)->get(),
            'showFooter' => false,
        ]);
    }

    // Show a single user profile with saved posts
    public function saved(User $user)
    {
        return view('users.profile-saved', [
            'user' => $user,
            'posts' => $user->saves()->orderBy('created_at', 'desc')->get(),
            'showFooter' => false,
        ]);
    }

    // Show a single user profile with followers
    public function followers(User $user, )
    {
        // Get the users that are following the user
        $followers = User::whereIn('id', $user->followers()->pluck('follower_id'))->get();

        return view('users.profile-followers', [
            'user' => $user,
            'showFooter' => false,
            'followers' => $followers,
        ]);
    }

    // Show a single user profile with following
    public function following(User $user)
    {
        // Get the users that the user is following
        $followingUsers = $user->following()->pluck('following_id');

        return view('users.profile-following', [
            'user' => $user,
            'showFooter' => false,
            'followedUsers' => User::whereIn('id', $followingUsers)->get(),
        ]);
    }

    // Show form to edit user profile
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    // Update user profile
    public function update(Request $request, User $user)
    {
        if (auth()->id() !== $user->id) {
            abort(403, 'Unauthorized');
        }

        // Validate the request
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'bio' => 'nullable',
            'location' => 'nullable',
            'education' => 'nullable',
            'occupation' => 'nullable',
        ]);

        // This part ensures that the password is only updated if it was provided with validation
        if ($request->password) {

            $request->validate([
                'password' => 'confirmed|min:8',
            ]);

            $formFields['password'] = $request->password;
        }

        if ($request->hasFile('avatar')) {
            $formFields['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('banner')) {
            $formFields['banner'] = $request->file('banner')->store('banners', 'public');
        }

        // Hash the password if it was provided
        if (isset($formFields['password'])) {
            $formFields['password'] = bcrypt($formFields['password']);
        }

        // Update the user
        $user->update($formFields);

        return redirect()->route('profile', ['user' => auth()->user()->id])->with('message', 'Profile Updated');

    }

    // Toggle follow on a user
    public function toggleFollow(Request $request, User $user)
    {
        $authUser = $request->user();

        // Check if the user is trying to follow themselves
        if ($authUser->id === $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot follow yourself',
            ]);
        }

        // Toggle the follow/unfollow logic
        if ($authUser->isFollowing($user)) {
            $authUser->unfollow($user);
            return response()->json([
                'status' => 'success',
                'message' => 'Unfollowed successfully.',
            ]);
        } else {
            $authUser->follow($user);
            return response()->json([
                'status' => 'success',
                'message' => 'Followed successfully.',
            ]);
        }
    }

    //Search users
    public function search()
    {
        return view('users.search', [
            'users' => User::latest()->filter(request(['keyword']))->get(),
        ]);
    }

    //View admin dashboard
    public function admin()
    {
        return view('users.admin');
    }
}
