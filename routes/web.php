<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Home page
Route::get('/', [PostController::class, 'index']);

//Lode more posts
Route::get('/posts/load-more', [PostController::class, 'loadMorePosts'])->name('posts.loadMore');

//Show the form to create a new post
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth');

//Store a new post
Route::post('/posts', [PostController::class, 'store'])->middleware('auth');

//Toggle star on a post
Route::post('/posts/{post}/toggle-star', [PostController::class, 'toggleStar'])->middleware('auth');

//Toggle save on a post
Route::post('/posts/{post}/toggle-save', [PostController::class, 'toggleSave'])->middleware('auth');

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

// Single user profile
Route::get('/users/{user}', [UserController::class, 'show'])->name('profile');

// Show form to edit user profile
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('auth');

// Update user profile
Route::put('/users/{user}', [UserController::class, 'update'])->middleware('auth');

// Toggle follow on a user
Route::post('/users/{user}/toggle-follow', [UserController::class, 'toggleFollow'])->middleware('auth');
