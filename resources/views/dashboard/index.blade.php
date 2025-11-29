<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ======================= ADMIN ONLY ======================= --}}
            @if(auth()->user()->role == 'admin')

                {{-- OVERVIEW CARDS --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md">
                        <p class="text-sm text-gray-600">Active Users</p>
                        <p class="text-3xl font-bold">{{ $analytics['activeUsers'] }}</p>
                        <p class="text-xs text-gray-500 mt-2">Last 30 days</p>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md">
                        <p class="text-sm text-gray-600">Total Jobs</p>
                        <p class="text-3xl font-bold">{{ $analytics['totalJobs'] }}</p>
                        <p class="text-xs text-gray-500 mt-2">All time</p>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md">
                        <p class="text-sm text-gray-600">Total Applications</p>
                        <p class="text-3xl font-bold">{{ $analytics['totalApplications'] }}</p>
                        <p class="text-xs text-gray-500 mt-2">All time</p>
                    </div>
                </div>

                {{-- MOST APPLIED JOBS --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Most Applied Jobs</h3>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Applications</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($analytics['mostAppliedJobs'] as $job)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $job->title }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $job->Company->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                            {{ $job->Totalcount }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- CONVERSION RATE --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Conversion Rate</h3>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applications</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Conversion Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($analytics['conversionRate'] as $job)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $job->title }}</td>
                                    <td class="px-6 py-4">{{ $job->viewCount }}</td>
                                    <td class="px-6 py-4">{{ $job->Totalcount }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                            {{ $job->conversionRate }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
            {{-- ======================= END ADMIN ======================= --}}



            {{-- ======================= COMPANY OWNER ======================= --}}
            @if(auth()->user()->role == 'company-owner')

                {{-- OVERVIEW CARDS --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <p class="text-sm text-gray-600">Active Users</p>
                        <p class="text-3xl font-bold">{{ $analytics['activeUsers'] }}</p>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <p class="text-sm text-gray-600">Total Jobs</p>
                        <p class="text-3xl font-bold">{{ $analytics['totalJobs'] }}</p>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <p class="text-sm text-gray-600">Total Applications</p>
                        <p class="text-3xl font-bold">{{ $analytics['totalApplications'] }}</p>
                    </div>
                </div>

                {{-- MOST APPLIED JOBS --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Most Applied Jobs</h3>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Job</th>
                                <th class="px-4 py-2">Applications</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($analytics['mostAppliedJobs'] as $job)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $job->title }}</td>
                                    <td class="px-4 py-2">{{ $job->Totalcount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- COMPANY CONVERSION RATE --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Conversion Rate</h3>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Job Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Views</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Applications</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase">Conversion Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($analytics['conversionRate'] as $job)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $job->title }}</td>
                                    <td class="px-6 py-4">{{ $job->viewCount }}</td>
                                    <td class="px-6 py-4">{{ $job->Totalcount }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                            {{ $job->conversionRate }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
            {{-- ======================= END COMPANY OWNER ======================= --}}

        </div>
    </div>
</x-app-layout>
