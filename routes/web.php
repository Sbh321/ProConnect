<?php

use App\Models\Jobs;
use Illuminate\Support\Facades\Route;

//All jobs
Route::get('/', function () {
    return view('jobs', [
        'heading' => 'Jobs',
        'jobs' => Jobs::all(),
    ]);
});

//Single job
Route::get('/jobs/{id}', function ($id) {
    return view('job', [
        'job' => Jobs::find($id),
    ]);
});
