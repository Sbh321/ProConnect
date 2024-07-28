<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

//All jobs
Route::get('/', [JobController::class, 'index']);

//Show the form to create a new job
Route::get('/jobs/create', [JobController::class, 'create']);

//Store a new job
Route::post('/jobs', [JobController::class, 'store']);

//Show the form to edit a job
Route::get('/jobs/{jobListing}/edit', [JobController::class, 'edit']);

//Update a job
Route::put('/jobs/{jobListing}', [JobController::class, 'update']);

//Delete a job
Route::delete('/jobs/{jobListing}', [JobController::class, 'destroy']);

//Single job
Route::get('/jobs/{jobListing}', [JobController::class, 'show']);
