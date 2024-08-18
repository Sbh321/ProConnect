<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $formFields['user_id'] = Auth::id();

        JobListing::create($formFields);

        return redirect('/')->with('message', 'Job listing created!');
    }

    // Show the form to edit a job
    public function edit(JobListing $jobListing)
    {
        return view('jobs.edit', [
            'job' => $jobListing,
        ]);
    }

    // Update a job
    public function update(Request $request, JobListing $jobListing)
    {
        if (Auth::id() !== $jobListing->user_id && !Auth::user()->isAdmin) {
            abort(403, 'Unauthorized');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'description' => 'required',
            'tags' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $jobListing->update($formFields);

        return back()->with('message', 'Job listing updated!');
    }

    // Delete a job
    public function destroy(JobListing $jobListing)
    {
        if (Auth::id() !== $jobListing->user_id && !Auth::user()->isAdmin) {
            abort(403, 'Unauthorized');
        }

        $jobListing->delete();

        return back()->with('message', 'Job listing deleted!');
    }

    // Manage Jobs
    public function manage(Request $request)
    {
        $user = $request->user();
        $jobs = $user->jobListing()->paginate(8);

        return view('jobs.manage', [
            'jobs' => $jobs,
        ]);
    }
}
