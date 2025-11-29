<x-app-layout>

    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request()->input('archived') == 'true' ? __('Archived Job Vacancies') : __('Job Vacancies') }}
        </h2>
    </x-slot>

    <div class="py-8">

        <!-- Filter Buttons + Add Button -->
        <div class="flex items-center gap-4 mb-6">

            @if (request()->input('archived') == 'true')
                <!-- Button: View Active -->
                <a href="{{ route('job-vacancies.index') }}"
                    class="inline-flex items-center px-4 py-2 border text-sm font-semibold rounded-md
                          bg-white text-black border-black hover:bg-gray-100 transition">
                    Active Job Vacancies
                </a>
            @else
                <!-- Button: View Archived -->
                <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 border text-sm font-semibold rounded-md
                          bg-white text-black border-black hover:bg-gray-100 transition">
                    Archived Job Vacancies
                </a>
            @endif

            <!-- Add New Vacancy -->
            <a href="{{ route('job-vacancies.create') }}"
                class="ml-auto inline-flex items-center px-4 py-2 text-sm font-semibold rounded-md
                      bg-indigo-600 text-black hover:bg-indigo-700 transition">
                + Add New Job Vacancy
            </a>

        </div>

        <!-- Optional Toast Notification -->
        <x-toast-notification />

        <!-- Table Container -->
        <div class="bg-white shadow-md sm:rounded-lg overflow-hidden">

            <div class="p-4 overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <!-- Table Head -->
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Title</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Location</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Type</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Company</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Salary</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Created</th>
                            <th
                                class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-100">

                        @forelse ($jobVacancies as $jobVacancy)
                            <tr class="hover:bg-gray-50">

                                <!-- ID -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $jobVacancy->id }}
                                </td>

                                <!-- Title -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold">
                                            {{ strtoupper(substr($jobVacancy->title, 0, 1)) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('job-vacancies.show', $jobVacancy) }}">
                                                    {{ $jobVacancy->title }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Location -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $jobVacancy->location }}
                                </td>

                                <!-- Type -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $jobVacancy->type }}
                                </td>

                                <!-- Category -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $jobVacancy->JobCategory->name }}
                                </td>

                                <!-- Company -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $jobVacancy->Company->name }}
                                </td>

                                <!-- Salary -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($jobVacancy->salary, 2) }}
                                </td>

                                <!-- Created Date -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <time datetime="{{ $jobVacancy->created_at }}">
                                        {{ $jobVacancy->created_at->diffForHumans() }}
                                    </time>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">

                                    <div class="inline-flex items-center space-x-2">

                                        @if (request()->input('archived') == 'true')
                                            <!-- Restore Button -->
                                            <form action="{{ route('job-vacancies.restore', $jobVacancy) }}"
                                                method="POST" onsubmit="return confirm('Restore this job vacancy?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-50 border border-green-200 text-green-600 text-sm rounded-md hover:bg-green-100">
                                                    Restore
                                                </button>
                                            </form>
                                        @else
                                            <!-- Edit -->
                                            <a href="{{ route('job-vacancies.edit', $jobVacancy) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-white border border-indigo-200 text-indigo-600 text-sm rounded-md hover:bg-indigo-50">
                                                Edit
                                            </a>

                                            <!-- Archive -->
                                            <form action="{{ route('job-vacancies.destroy', $jobVacancy) }}"
                                                method="POST" onsubmit="return confirm('Archive this job vacancy?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-50 border border-red-200 text-red-600 text-sm rounded-md hover:bg-red-100">
                                                    Archive
                                                </button>
                                            </form>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <!-- Empty State -->
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div class="max-w-md mx-auto">
                                        <svg class="mx-auto h-16 w-16 text-gray-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7h18M5 7v12a2 2 0 002 2h10a2 2 0 002-2V7M9 7V5a3 3 0 116 0v2" />
                                        </svg>
                                        <p class="mt-4 text-sm text-gray-600">
                                            No job vacancies found. Create your first job vacancy.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $jobVacancies->appends(request()->query())->links() }}
                </div>

            </div>

        </div>

    </div>

</x-app-layout>
