<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Home page
Route::get('/', [PostController::class, 'index'])->name('home');

//Search posts and hashtags
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search')->middleware('auth');

//Search users
Route::get('/users/search', [UserController::class, 'search'])->name('users.search')->middleware('auth');

//Lode more posts
Route::get('/posts/load-more', [PostController::class, 'loadMorePosts'])->name('posts.loadMore');

//Show the form to create a new post
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth');

//Manage posts
Route::get('/posts/manage', [PostController::class, 'manage'])->middleware('auth');

//Store a new post
Route::post('/posts', [PostController::class, 'store'])->middleware('auth');

//Show the form to edit a post
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('posts.edit');

//Update a post
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth');

//Delete a post
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('posts.delete');

//Toggle star on a post
Route::post('/posts/{post}/toggle-star', [PostController::class, 'toggleStar'])->middleware('auth');

//Toggle save on a post
Route::post('/posts/{post}/toggle-save', [PostController::class, 'toggleSave'])->middleware('auth');

//Show comments on a post
Route::get('/posts/{post}/comments', [PostController::class, 'comments'])->name('posts.comments');

//Store a new comment on a post
Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->middleware('auth');

//All jobs
Route::get('/jobs', [JobController::class, 'index']);

//Show the form to create a new job
Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth');

//Manage Jobs
Route::get('/jobs/manage', [JobController::class, 'manage'])->middleware('auth');

//Store a new job
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');

//Show the form to edit a job
Route::get('/jobs/{jobListing}/edit', [JobController::class, 'edit'])->middleware('auth');

//Update a job
Route::put('/jobs/{jobListing}', [JobController::class, 'update'])->middleware('auth');

//Delete a job
Route::delete('/jobs/{jobListing}', [JobController::class, 'destroy'])->middleware('auth');

//Single job
Route::get('/jobs/{jobListing}', [JobController::class, 'show']);

// Show Register Page/form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Store a new user
Route::post('/users', [UserController::class, 'store']);

// Log the user out
Route::post('/logout', [UserController::class, 'logout']);

// Show Login Page/form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log the user in
Route::post('/users/auth', [UserController::class, 'auth']);

// Single user profile with posts
Route::get('/users/{user}', [UserController::class, 'show'])->name('profile');

//Single user profile with saved posts
Route::get('/users/{user}/saved', [UserController::class, 'saved'])->name('saved');

// Single user profile with followers
Route::get('/users/{user}/followers', [UserController::class, 'followers'])->name('followers');

// Single user profile with following
Route::get('/users/{user}/following', [UserController::class, 'following'])->name('following');

// Show form to edit user profile
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('auth');

// Update user profile
Route::put('/users/{user}', [UserController::class, 'update'])->middleware('auth');

// Toggle follow on a user
Route::post('/users/{user}/toggle-follow', [UserController::class, 'toggleFollow'])->middleware('auth');

//View admin dashboard
Route::get('/admin', [UserController::class, 'dashboard'])->middleware('auth', 'admin')->name('dashboard');
