<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

//All jobs
Route::get('/', [JobController::class, 'index']);

//Single job
Route::get('/jobs/{jobListing}', [JobController::class, 'show']);

//Single job by id
// Route::get('/jobs/{id}', function ($id) {
//     $jobId = JobListing::find($id);

//     if ($jobId) {
//         return view('job', [
//             'job' => JobListing::find($id),
//         ]);
//     } else {
//         abort(404);
//     }

// });
