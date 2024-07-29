<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//All jobs
Route::get('/', [JobController::class, 'index']);

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
