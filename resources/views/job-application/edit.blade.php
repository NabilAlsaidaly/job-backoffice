<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Applicant Status') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">

        <div class="bg-white p-6 rounded-lg shadow-md">

            <form
                action="{{ route('job-applications.update', ['job_application' => $jobApplication->id, 'redirecttoList' => request('redirecttoList')]) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Applicant Name</label>
                    <span>{{ $jobApplication->user->name }}</span>
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Job Vacancy</label>
                    <span>{{ $jobApplication->jobVacancy->company->name }}</span>
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Company</label>
                    <span>{{ $jobApplication->jobVacancy->Company->name }}</span>
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">aiGeneratedScore</label>
                    <span>{{ $jobApplication->aiGeneratedScore }}</span>
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">aiGeneratedfeedback</label>
                    <span>{{ $jobApplication->aiGeneratedFeedback }}</span>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                        <option value="pending"
                            {{ old('status', $jobApplication->status) == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="accepted"
                            {{ old('status', $jobApplication->status) == 'accepted' ? 'selected' : '' }}>
                            Accepted
                        </option>

                        <option value="rejected"
                            {{ old('status', $jobApplication->status) == 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>


                    </select>

                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
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
                    <a href="{{ route('job-applications.index') }}"
                        class="px-4 py-2 bg-gray-200 border border-gray-300 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-300 transition">
                        Back to Job Applications
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-black text-sm font-semibold rounded-md hover:bg-indigo-700 focus:ring-indigo-500 transition shadow-sm">
                        Update Job Application
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>
