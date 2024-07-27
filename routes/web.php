<?php

use App\Models\JobListing;
use Illuminate\Support\Facades\Route;

//All jobs
Route::get('/', function () {
    return view('jobs', [
        'heading' => 'Jobs',
        'jobs' => JobListing::all(),
    ]);
});

//Single job
Route::get('/jobs/{id}', function ($id) {
    return view('job', [
        'job' => JobListing::find($id),
    ]);
});
