<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

//All jobs
Route::get('/', [JobController::class, 'index']);

//Show the form to create a new job
Route::get('/jobs/create', [JobController::class, 'create']);

//Single job
Route::get('/jobs/{jobListing}', [JobController::class, 'show']);
