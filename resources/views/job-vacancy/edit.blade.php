<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Vacancy') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">

        <div class="bg-white p-6 rounded-lg shadow-md">

            <form action="{{ route('job-vacancies.update', ['job_vacancy' => $jobVacancy->id, 'redirecttoList' => request('redirecttoList')]) }}" method="POST">

                @csrf
                @method('PUT')

                <!-- Job Vacancy Title -->
                <div class="mb-4">
                    <label for="title" class="block font-medium text-sm text-gray-700">Job Vacancy Title</label>
                    <input type="text" name="title" id="title" value="{{ $jobVacancy->title }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                    @error('title')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Vacancy Location -->
                <div class="mb-4">
                    <label for="location" class="block font-medium text-sm text-gray-700">Job Vacancy Location</label>
                    <input type="text" name="location" id="location" value="{{ $jobVacancy->location }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                    @error('location')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expected Salary -->
                <div class="mb-4">
                    <label for="salary" class="block font-medium text-sm text-gray-700">Expected Salary</label>
                    <input type="number" name="salary" id="salary"
                        value="{{ $jobVacancy->salary }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                    @error('salary')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Job Vacancy Type -->
                <div class="mb-4">
                    <label for="type" class="block font-medium text-sm text-gray-700">Job Vacancy Type</label>

                    <select name="type" id="type"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="Full-Time" @selected($jobVacancy->type == 'Full-Time')>Full-Time</option>
                        <option value="Contract" @selected($jobVacancy->type == 'Contract')>Contract</option>
                        <option value="Remote" @selected($jobVacancy->type == 'Remote')>Remote</option>
                        <option value="Hybrid" @selected($jobVacancy->type == 'Hybrid')>Hybrid</option>
                    </select>

                    @error('type')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company -->
                <div class="mb-4">
                    <label for="companyId" class="block font-medium text-sm text-gray-700">Company</label>

                    <select name="companyId" id="companyId"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" @selected($jobVacancy->companyId == $company->id)>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('companyId')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Category -->
                <div class="mb-4">
                    <label for="jobCategoryId" class="block font-medium text-sm text-gray-700">Job Category</label>

                    <select name="jobCategoryId" id="jobCategoryId"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($jobCategories as $category)
                            <option value="{{ $category->id }}" @selected($jobVacancy->jobCategoryId == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('jobCategoryId')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Vacancy Description -->
                <div class="mb-4">
                    <label for="description" class="block font-medium text-sm text-gray-700">Job Vacancy
                        Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $jobVacancy->description) }}                    </textarea>

                    @error('description')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Global Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-3">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Buttons -->
                <div class="flex justify-between mt-6">
                    <a href="{{ route('job-vacancies.index') }}"
                        class="px-4 py-2 bg-gray-200 border border-gray-300 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-300 transition">
                        Back to Job Vacancies
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-black text-sm font-semibold rounded-md hover:bg-indigo-700 focus:ring-indigo-500 transition shadow-sm">
                        Update Job Vacancy
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>
