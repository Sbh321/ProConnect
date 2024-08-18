<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{jobListing}', [JobController::class, 'show']);
Route::get('/users/{user}', [UserController::class, 'show'])->name('profile');
Route::get('/posts/load-more', [PostController::class, 'loadMorePosts'])->name('posts.loadMore');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/users/auth', [UserController::class, 'auth']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Posts Routes
    Route::prefix('posts')->group(function () {
        Route::get('/search', [PostController::class, 'search'])->name('posts.search');
        Route::get('/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.delete');
        Route::post('/{post}/toggle-star', [PostController::class, 'toggleStar']);
        Route::post('/{post}/toggle-save', [PostController::class, 'toggleSave']);
        Route::get('/{post}/comments', [PostController::class, 'comments'])->name('posts.comments');
        Route::post('/{post}/comments', [PostController::class, 'storeComment']);
    });

    // Jobs Routes
    Route::prefix('jobs')->group(function () {
        Route::get('/create', [JobController::class, 'create'])->name('jobs.create');
        Route::post('/', [JobController::class, 'store'])->name('jobs.store');
        Route::get('/{jobListing}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/{jobListing}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/{jobListing}', [JobController::class, 'destroy'])->name('jobs.delete');
        Route::get('/manage', [JobController::class, 'manage'])->name('jobs.manage');
    });

    // User Profile and Settings Routes
    Route::prefix('users')->group(function () {
        Route::get('/{user}/saved', [UserController::class, 'saved'])->name('saved');
        Route::get('/{user}/followers', [UserController::class, 'followers'])->name('followers');
        Route::get('/{user}/following', [UserController::class, 'following'])->name('following');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::post('/{user}/toggle-follow', [UserController::class, 'toggleFollow']);
    });

    // Logout Route
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/posts', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/jobs', [UserController::class, 'jobsDashboard'])->name('jobsDashboard');
    Route::get('/users', [UserController::class, 'usersDashboard'])->name('usersDashboard');
    Route::get('/users/add', [UserController::class, 'addUser'])->name('addUser');
    Route::post('/users', [UserController::class, 'storeUser'])->name('storeUser');
    Route::delete('/users/{user}', [UserController::class, 'destroyUser'])->name('deleteUser');
});
