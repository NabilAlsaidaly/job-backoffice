<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin user
        User::firstOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Load seed data from JSON fixtures
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobApplications = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        // Job categories
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        // Companies
        foreach ($jobData['companies'] as $company) {
            $companyOwner = User::firstOrCreate(
                [
                    'email' => fake()->unique()->safeEmail(),
                ],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('password'),
                    'role' => 'company-owner',
                    'email_verified_at' => now(),
                ]
            );

            Company::firstOrCreate(
                [
                    'name' => $company['name'],
                ],
                [
                    'address' => $company['address'],
                    'industry' => $company['industry'],
                    'website' => $company['website'],
                    'ownerId' => $companyOwner->id,
                ]
            );
        }

        // Job vacancies
        foreach ($jobData['jobVacancies'] as $job) {
            $company = Company::where('name', $job['company'])->firstOrFail();
            $jobCategory = JobCategory::where('name', $job['category'])->firstOrFail();

            JobVacancy::firstOrCreate(
                [
                    'title' => $job['title'],
                    'companyId' => $company->id,
                ],
                [
                    'description' => $job['description'],
                    'location' => $job['location'],
                    'type' => $job['type'],
                    'salary' => $job['salary'],
                    'jobCategoryId' => $jobCategory->id,
                ]
            );
        }

        // // Job applications
        // foreach ($jobApplications['jobApplications'] as $application) {
        //     $jobVacancy = JobVacancy::inRandomOrder()->first();

        //     if (!$jobVacancy) {
        //         continue;
        //     }

        //     $applicant = User::firstOrCreate(
        //         [
        //             'email' => fake()->unique()->safeEmail(),
        //         ],
        //         [
        //             'name' => fake()->name(),
        //             'password' => Hash::make('12345678'),
        //             'role' => 'job-seeker',
        //             'email_verified_at' => now(),
        //         ]
        //     );

        //     $resume = Resume::create([
        //         'userId' => $applicant->id,
        //         'filename' => $application['resume']['filename'],
        //         'fileUrl' => $application['resume']['fileUrl'],
        //         'contactDetails' => $application['resume']['contactDetails'],
        //         'summary' => $application['resume']['summary'],
        //         'skills' => $application['resume']['skills'],
        //         'experience' => $application['resume']['experience'],
        //         'education' => $application['resume']['education'],
        //     ]);

        //     JobApplication::create([
        //         'jobVacancyId' => $jobVacancy->id,
        //         'userId' => $applicant->id,
        //         'resumeId' => $resume->id,
        //         'status' => $application['status'],
        //         'aiGeneratedScore' => $application['aiGeneratedScore'],
        //         'aiGeneratedFeedback' => $application['aiGeneratedFeedback'],
        //     ]);
        // }
    }
}
