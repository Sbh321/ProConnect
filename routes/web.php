<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

//All jobs
Route::get('/', [JobController::class, 'index']);

//Single job
Route::get('/jobs/{jobListing}', [JobController::class, 'show']);
