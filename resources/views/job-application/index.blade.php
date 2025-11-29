<x-app-layout>

    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request()->input('archived') == 'true' ? __('Archived Job Applications') : __('Job Applications') }}
        </h2>
    </x-slot>

    <div class="py-8">

        <!-- Filter Buttons + Add Button -->
        <div class="flex items-center gap-4 mb-6">

            @if (request()->input('archived') == 'true')
                <!-- Button: View Active -->
                <a href="{{ route('job-applications.index') }}"
                    class="inline-flex items-center px-4 py-2 border text-sm font-semibold rounded-md
                          bg-white text-black border-black hover:bg-gray-100 transition">
                    Active Job Applications
                </a>
            @else
                <!-- Button: View Archived -->
                <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 border text-sm font-semibold rounded-md
                          bg-white text-black border-black hover:bg-gray-100 transition">
                    Archived Job Applications
                </a>
            @endif

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
                                Applicant Name</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Job Vacancy</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Company</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Salary</th>

                            <th
                                class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Actions</th>

                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-100">

                        @forelse ($jobApplications as $jobApplication)
                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('job-applications.show', $jobApplication) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $jobApplication->user->name }}
                                    </a>
                                </td>


                                <!-- (position) Job Vacancy -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $jobApplication->jobVacancy->title }}
                                </td>

                                <!-- company -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $jobApplication->jobVacancy->Company->name }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm">

                                    @php
                                        $color = match ($jobApplication->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'accepted' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                        {{ ucfirst($jobApplication->status) }}
                                    </span>

                                </td>


                                <!-- Job Vacancy Salary -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($jobApplication->jobVacancy->salary, 2) }}
                                </td>


                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">

                                    <div class="inline-flex items-center space-x-2">

                                        @if (request()->input('archived') == 'true')
                                            <!-- Restore Button -->
                                            <form action="{{ route('job-applications.restore', $jobApplication) }}"
                                                method="POST"
                                                onsubmit="return confirm('Restore this job application?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-50 border border-green-200 text-green-600 text-sm rounded-md hover:bg-green-100">
                                                    Restore
                                                </button>
                                            </form>
                                        @else
                                            <!-- Edit -->
                                            <a href="{{ route('job-applications.edit', $jobApplication) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-white border border-indigo-200 text-indigo-600 text-sm rounded-md hover:bg-indigo-50">
                                                Edit
                                            </a>

                                            <!-- Archive -->
                                            <form action="{{ route('job-applications.destroy', $jobApplication) }}"
                                                method="POST"
                                                onsubmit="return confirm('Archive this job application?');">
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
                                            No job applications found. Create your first job application.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $jobApplications->links() }}
                </div>

            </div>

        </div>

    </div>

</x-app-layout>
