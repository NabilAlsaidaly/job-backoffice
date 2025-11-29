<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancy Details for ') . $jobVacancy->title }}
        </h2>
    </x-slot>
    <div class="bg-white shadow-md sm:rounded-lg overflow-hidden">
        <div
            class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">{{ __('Job Vacancy Overview') }}</p>
                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $jobVacancy->title }}</p>
                <p class="text-sm text-gray-500">{{ __('Company') }} : {{ $jobVacancy->Company->name }}</p>
                <p class="text-sm text-gray-500">{{ __('Location') }} : {{ $jobVacancy->location }}</p>
            </div>
            <div class="flex gap-2">
                <!-- Edit Button -->
                <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'redirecttoList' => request('redirecttoList')]) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-md bg-indigo-600 text-black hover:bg-indigo-700 transition">
                    {{ __('Edit') }}
                </a>
                <!-- Archive Button -->
                @if (is_null($jobVacancy->deleted_at))
                    <form action="{{ route('job-vacancies.destroy', $jobVacancy) }}" method="POST"
                        onsubmit="return confirm('{{ __('Are you sure you want to archive this job vacancy?') }}');">
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
                __('Job Vacancy Title') => $jobVacancy->title,
                __('Company') => $jobVacancy->Company->name,
                __('Location') => $jobVacancy->location,
                __('Salary') => $jobVacancy->salary,
                __('Category') => $jobVacancy->JobCategory->name,
                __('Type') => $jobVacancy->type,
                __('Created At') => optional($jobVacancy->created_at)->format('d M Y, H:i'),
                __('Last Updated') => optional($jobVacancy->updated_at)->format('d M Y, H:i'),
                __('Deleted At') => optional($jobVacancy->deleted_at)->format('d M Y, H:i') ?? __('Active'),
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
                            {{ $value }}
                        </dd>
                    </div>
                @endforeach
            </dl>
            <div x-data="{ activeTab: 'jobVacancies' }" class="mt-8">
                <div class="inline-flex overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">

                    <!-- Tab 1 -->
                    <button type="button"
                        @click="activeTab = 'applications'"
                        :class="activeTab === 'applications' ? 'bg-indigo-600 text-black shadow-inner' : 'text-gray-600 hover:text-gray-800'"
                        class="px-4 py-2 text-sm font-semibold transition">
                        {{ __('Job Applications') }}
                    </button>

                    <!-- Tab 2 -->
                    <button type="button"
                        @click="activeTab = 'jobVacancies'"
                        :class="activeTab === 'jobVacancies' ? 'bg-indigo-600 text-black shadow-inner' : 'text-gray-600 hover:text-gray-800'"
                        class="px-4 py-2 text-sm font-semibold transition">
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
                            @forelse ($jobVacancy->Company->jobVacancies()->where('id', '!=', $jobVacancy->id)->get() as $jobVacancy)
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
                                        {{ __('No job vacancies found for this job vacancy.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div x-show="activeTab === 'applications'" x-cloak class="mt-6">
                    @php
                        $applications = $jobVacancy->JobApplications;
                    @endphp

                    @if ($applications->isEmpty())
                        <p class="text-sm text-gray-500">
                            {{ __('No applications submitted for this job vacancy yet.') }}
                        </p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        {{ __('Company') }}
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
                                            {{ $application->jobVacancy?->company?->name }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
