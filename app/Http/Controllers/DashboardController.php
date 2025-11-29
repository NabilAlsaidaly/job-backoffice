<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\JobApplication;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $analytics = $this->adminDashboard();
        } else {
            $analytics = $this->companyOwnerDashboard();
        }
        return view('dashboard.index', compact('analytics'));
    }

    private function adminDashboard()
    {
        // <!--last 30 days active users-->
        $activeUsers = User::where('last_login_at', '>=', now()
            ->subDays(30))
            ->where('role', '!=', 'job-seeker')
            ->count();
        //total jobs (not deleted)
        $totalJobs = JobVacancy::whereNull('deleted_at')
            ->count();
        //total applications (not deleted)
        $totalApplications = JobApplication::whereNull('deleted_at')->count();

        //most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('JobApplications as Totalcount')
            ->whereNull('deleted_at')
            ->orderBy('Totalcount', 'desc')
            ->take(5)
            ->get();
        //conversion rate
        $conversionRate = JobVacancy::withCount('JobApplications as Totalcount')
            ->having('Totalcount', '>=', 0)
            ->orderBy('Totalcount', 'desc')
            ->take(5)
            ->get()
            ->map(function ($job) {
                if ($job->viewCount > 0) {
                    $job->conversionRate = round(($job->Totalcount / $job->viewCount) * 100, 2);
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });
        $analytics = [
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'activeUsers' => $activeUsers,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRate' => $conversionRate,
        ];
        return $analytics;
    }


    private function companyOwnerDashboard()
    {
        $company = auth()->user()->companies()->first();

        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->whereHas('jobApplications', function ($query) use ($company) {
                $query->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'));
            })
            ->count();

        $totalJobs = $company->jobVacancies()->count();
        $totalApplications = $company->jobVacancies()->sum('viewCount');

        // most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as Totalcount')
            ->where('companyId', $company->id)
            ->orderBy('Totalcount', 'desc')
            ->take(5)
            ->get();

        // conversion rate (correct version)
        $conversionRate = JobVacancy::withCount('jobApplications as Totalcount')
            ->where('companyId', $company->id)
            ->orderBy('Totalcount', 'desc')
            ->take(5)
            ->get()
            ->map(function ($job) {
                if ($job->viewCount > 0) {
                    $job->conversionRate = round(($job->Totalcount / $job->viewCount) * 100, 2);
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });

        return [
            'activeUsers'      => $activeUsers,
            'totalJobs'        => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs'  => $mostAppliedJobs,
            'conversionRate'   => $conversionRate,
        ];
    }
}
