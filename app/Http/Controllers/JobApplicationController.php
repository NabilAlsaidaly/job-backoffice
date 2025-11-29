<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\JobApplicationUpdateRequest;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobApplication::latest();

        if (auth()->user()->role == 'company-owner') {

            $company = auth()->user()->companies()->first();

            if ($company) {
                $query->whereHas('jobVacancy', function ($query) use ($company) {
                    $query->where('companyId', $company->id);
                });
            }
        }

        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        $jobApplications = $query->paginate(7)->onEachSide(1);
        return view('job-application.index', compact('jobApplications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('job-application.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdateRequest $request, string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->update([
            'status' => $request->input('status'),
        ]);
        if($request->query('redirecttoList')=='false'){
            return redirect()->route('job-applications.show', $id)->with('success', 'Job application updated successfully');
        }
        return redirect()->route('job-applications.index')->with('success', 'Job application updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();
        return redirect()->route('job-applications.index')->with('success', 'Job application archived successfully');
    }

    public function restore(string $id)
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();
        return redirect()->route('job-applications.index', ['archived' => 'true'])->with('success', 'Job application restored successfully');
    }
}
