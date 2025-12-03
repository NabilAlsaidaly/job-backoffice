🛠️ Job Backoffice – Admin & Company Dashboard

A Laravel-based administrative dashboard for managing the Job Platform ecosystem.
This backend application provides full CRUD operations, analytics, company management, job posting, job applications, user management, and role-based access.

It works together with:

job-app (User Job Application Frontend)

job-shared (Shared Models Package)

📌 Features
🔐 Authentication & Roles

Admin login (via Laravel Breeze)

Company Owner login

Role-based access using custom middleware
(admin, company-owner)

Email verification, password reset, session control

🏢 Company Management

Create / Edit / Archive companies

Assign company owners

View company details and related vacancies

💼 Job Categories

Create, edit, list job categories

Used as filters and classification system

📄 Job Vacancies

Full CRUD for job postings

Attach categories & company

Visibility control

View all applications per vacancy

👤 User Management

Admin can view & edit all users

Company owners can view job seekers who applied to their vacancies

Profile update & password update sections

📨 Job Applications

View, update, manage job applications

View applicant details and resume

Status updates (pending, accepted, rejected)

📊 Dashboard & Analytics

Overview of active users

Total jobs

Total applications

Most applied jobs

Conversion rates (if implemented)

Statistics stored via migration add_analytics.php

🚀 Tech Stack

Laravel 12

Laravel Breeze

TailwindCSS

Blade Components

Vite

MySQL / MariaDB

job-shared package (private shared library)

PestPHP (for testing)

📁 Project Structure
app/
├── Http/
│ ├── Controllers/
│ │ ├── Auth/...
│ │ ├── DashboardController.php
│ │ ├── CompanyController.php
│ │ ├── JobVacancyController.php
│ │ ├── JobApplicationController.php
│ │ └── UserController.php
│ ├── Middleware/RoleMiddleware.php
│ └── Requests/
│ ├── JobVacancyCreateRequest.php
│ ├── CompanyUpdateRequest.php
│ ├── JobApplicationUpdateRequest.php
│ └── ...
├── Models/
└── View/Components/
resources/
├── views/
│ ├── dashboard/
│ ├── company/
│ ├── job-vacancy/
│ ├── job-application/
│ ├── user/
│ └── auth/

📦 Using the Shared Package (job-shared)

This project uses a shared package that contains:

Models

Shared logic

Database-related structures

Installation (already configured):
"repositories": [
{
"type": "vcs",
"url": "https://github.com/NabilAlsaidaly/job-shared.git"
}
]

Then:

composer require job/shared:@dev

Models can be used directly:

use App\Models\JobVacancy;
use App\Models\Company;

🔐 Role Middleware

Custom middleware ensures correct access:

public function handle($request, Closure $next, $role)
{
    if (auth()->user()->role !== $role) {
        abort(403);
    }
    return $next($request);
}

Used in routes:

Route::middleware(['auth', 'role:admin'])->group(function () {
// admin pages
});

🧪 Testing

PestPHP is used for testing:

php artisan test

Includes:

Authentication tests

User tests

Example feature tests

🛠 Installation

1. Clone the Repository
   git clone https://github.com/NabilAlsaidaly/job-backoffice.git
   cd job-backoffice

2. Install Dependencies
   composer install
   npm install

3. Environment Setup
   cp .env.example .env
   php artisan key:generate

Configure database in .env.

4. Run Migrations
   php artisan migrate --seed

5. Start Development Server
   php artisan serve
   npm run dev

🧩 Admin & Company Owner Roles
Role Permissions
Admin Manage users, companies, categories, vacancies, applications, full dashboard access
Company Owner Manage own job vacancies, view applications, update status, view company dashboard
📄 License

MIT License.
