<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    // All jobs
    public function index()
    {
        return view('jobs.index', [
            'jobs' => JobListing::latest()->filter(request(['tag', 'search']))->paginate(8),
        ]);
    }

    // Single job
    public function show(JobListing $jobListing)
    {
        return view('jobs.show', [
            'job' => $jobListing,
        ]);

    }

    // Show the form to create a new job
    public function create()
    {
        return view('jobs.create');
    }

    // Store a new job
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('job_listings', 'company')],
            'location' => 'required',
            'description' => 'required',
            'tags' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        JobListing::create($formFields);

        return redirect('/')->with('message', 'Job listing created!');
    }

}
