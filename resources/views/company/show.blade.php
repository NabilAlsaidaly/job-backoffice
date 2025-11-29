<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company Details for ') . $company->name }}
        </h2>
    </x-slot>
    <div class="bg-white shadow-md sm:rounded-lg overflow-hidden">
        <div
            class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
            <div>
                {{-- <p class="text-sm text-gray-500">{{ __('Company Overview') }}</p> --}}
                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $company->name }}</p>
            </div>
            <div class="flex gap-2">
                <!-- Edit Button -->
                @if (auth()->user()->role == 'company-owner')
                <a href="{{ route('my-company.edit', $company) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-md bg-indigo-600 text-black hover:bg-indigo-700 transition">
                    {{ __('Edit') }}
                </a>
                @else
                <a href="{{ route('companies.edit', $company) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-md bg-indigo-600 text-black hover:bg-indigo-700 transition">
                    {{ __('Edit') }}
                </a>
                @endif
                <!-- Archive Button -->
                @if (auth()->user()->role == 'admin')
                <form action="{{ route('companies.destroy', $company) }}" method="POST"
                        onsubmit="return confirm('{{ __('Are you sure you want to archive this company?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 transition">
                            {{ __('Archive') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @php
            $details = [
                __('Company Name') => $company->name,
                __('Email') => $company->owner->email,
                __('Address') => $company->address,
                __('Industry') => $company->industry,
                __('Website') => $company->website,
                __('Created At') => optional($company->created_at)->format('d M Y, H:i'),
                __('Last Updated') => optional($company->updated_at)->format('d M Y, H:i'),
                __('Deleted At') => optional($company->deleted_at)->format('d M Y, H:i') ?? __('Active'),
            ];
        @endphp

        <div class="p-6 bg-gray-50">
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                @foreach ($details as $label => $value)
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                        <dt
                            class="px-5 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            {{ $label }}
                        </dt>
                        <dd class="px-5 py-4 text-sm text-gray-900">
                            @if ($label === __('Website') && filled($value))
                                <a href="{{ $value }}" target="_blank" rel="noopener"
                                    class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-500">
                                    <span>{{ parse_url($value, PHP_URL_HOST) ?? $value }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 6H18m0 0v4.5M18 6l-5.25 5.25M10.5 6H6m0 0v4.5M6 6l5.25 5.25M13.5 18H18m0 0v-4.5M18 18l-5.25-5.25M10.5 18H6m0 0v-4.5M6 18l5.25-5.25" />
                                    </svg>
                                </a>
                            @else
                                {{ $value ?? __('Not Provided') }}
                            @endif
                        </dd>
                    </div>
                @endforeach
            </dl>
            @if (auth()->user()->role == 'admin')
            <div x-data="{ activeTab: 'jobVacancies' }" class="mt-8">
                <div class="inline-flex overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <button type="button" @click="activeTab = 'jobVacancies'"
                        :class="activeTab === 'jobVacancies' ? 'bg-indigo-600 text-white shadow-inner' :
                            'text-gray-600 hover:text-gray-800'"
                        class="px-4 py-2 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                        {{ __('Applications') }}
                    </button>
                    <button type="button" @click="activeTab = 'applications'"
                        :class="activeTab === 'applications' ? 'bg-indigo-600 text-white shadow-inner' :
                            'text-gray-600 hover:text-gray-800'"
                        class="px-4 py-2 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                        {{ __('Job Vacancies') }}
                    </button>
                </div>

                <div x-show="activeTab === 'jobVacancies'" x-cloak class="mt-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    {{ __('Title') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    {{ __('Type') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    {{ __('Category') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    {{ __('Location') }}
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($company->jobVacancies as $jobVacancy)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $jobVacancy->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $jobVacancy->type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $jobVacancy->JobCategory->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $jobVacancy->location }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        <div class="inline-flex items-center space-x-2">
                                            <a href="{{ route('job-vacancies.show', $jobVacancy) }}"
                                                class="text-indigo-600 hover:text-indigo-500">
                                                {{ __('View') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        {{ __('No job vacancies found for this company.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div x-show="activeTab === 'applications'" x-cloak class="mt-6">
                    @php
                        $applications = $company->jobVacancies->flatMap->JobApplications;
                    @endphp

                    @if ($applications->isEmpty())
                        <p class="text-sm text-gray-500">
                            {{ __('No applications submitted for this company yet.') }}
                        </p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        {{ __('Candidate') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        {{ __('Job Vacancy') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        {{ __('Status') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        {{ __('AI Score') }}
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($applications as $application)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ optional($application->user)->name ?? __('Unknown Applicant') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $application->jobVacancy->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $application->status }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                            <a href="{{ route('job-applications.show', $application->id) }}" class="text-indigo-600 hover:text-indigo-500">
                                                {{ __('View') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
