<?php

namespace App\Http\Controllers;

use App\Models\JobListing;

class JobController extends Controller
{
    // All jobs
    public function index()
    {
        return view('jobs.index', [
            'jobs' => JobListing::latest()->filter(request(['tag']))->get(),
        ]);
    }

    // Single job
    public function show(JobListing $jobListing)
    {
        return view('jobs.show', [
            'job' => $jobListing,
        ]);

    }

}
