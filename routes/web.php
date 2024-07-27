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

//Single job by using route model binding in elouquent model
//we dont have to put abort 404 if job not found it will automatically do that
Route::get('/jobs/{jobListing}', function (JobListing $jobListing) {
    return view('job', [
        'job' => $jobListing,
    ]);
});
