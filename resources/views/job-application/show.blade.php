<x-app-layout>

    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobApplication->user->name }} | Applied to {{ $jobApplication->jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="py-8">

        <!-- Main Wrapper -->
        <div class="bg-white shadow-md sm:rounded-lg p-6">

            <!-- Back Button -->
            <a href="{{ route('job-applications.index') }}"
                class="inline-flex items-center px-3 py-1.5 mb-4 text-sm bg-gray-200 hover:bg-gray-300 rounded-md">
                ← Back
            </a>

            <!-- Application Details -->
            <div class="mb-6">
                <h3 class="text-xl font-bold mb-3">Application Details</h3>

                <p><strong>Applicant:</strong> {{ $jobApplication->user->name }}</p>
                <p><strong>Job Vacancy:</strong> {{ $jobApplication->jobVacancy->title }}</p>
                <p><strong>Company:</strong> {{ $jobApplication->jobVacancy->Company->name ?? '—' }}</p>
                <p>
                    <strong>Status:</strong>

                    @php
                        $color = match ($jobApplication->status) {
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'accepted' => 'bg-green-100 text-green-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-600',
                        };
                    @endphp

                    <span class="ml-2 px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                        {{ ucfirst($jobApplication->status) }}
                    </span>
                </p>


                <p>
                    <strong>Resume:</strong>

                    <a class="text-blue-500 hover:text-blue-700 underline"
                        href="{{ Storage::url($jobApplication->resume->fileUrl) }}" target="_blank">
                        {{ $jobApplication->resume->fileUrl }}
                    </a>
                </p>


            </div>

            <!-- Edit / Archive Buttons -->
            <div class="flex gap-3 mb-6">
                <a href="{{ route('job-applications.edit', $jobApplication) }}"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    Edit
                </a>

                @if (is_null($jobApplication->deleted_at))
                    <form method="POST" action="{{ route('job-applications.destroy', $jobApplication) }}"
                        onsubmit="return confirm('Are you sure you want to archive this application?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">
                            Archive
                        </button>
                    </form>
                @endif
            </div>

            <!-- Tabs -->
            <div x-data="{ tab: 'resume' }">

                <!-- Tab Buttons -->
                <div class="border-b border-gray-200 mb-4">
                    <nav class="flex gap-6">
                        <button @click="tab = 'resume'"
                            :class="tab === 'resume'
                                ?
                                'border-b-2 border-blue-600 text-blue-600 pb-2' :
                                'text-gray-600 hover:text-gray-800 pb-2'">
                            Resume
                        </button>

                        <button @click="tab = 'ai'"
                            :class="tab === 'ai'
                                ?
                                'border-b-2 border-blue-600 text-blue-600 pb-2' :
                                'text-gray-600 hover:text-gray-800 pb-2'">
                            AI Feedback
                        </button>
                    </nav>
                </div>

                <!-- Resume Tab Content -->
                <div x-show="tab === 'resume'" class="mt-4">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg">

                        <!-- Summary -->
                        <div>
                            <h4 class="font-semibold mb-1">Summary</h4>
                            <p class="text-sm text-gray-700">
                                {{ $jobApplication->resume->summary ?? '—' }}
                            </p>
                        </div>

                        <!-- Skills -->
                        <div>
                            <h4 class="font-semibold mb-1">Skills</h4>
                            <p class="text-sm text-gray-700">
                                {{ $jobApplication->resume->skills ?? '—' }}
                            </p>
                        </div>

                        <!-- Experience -->
                        <div>
                            <h4 class="font-semibold mb-1">Experience</h4>
                            <p class="text-sm text-gray-700">
                                {{ $jobApplication->resume->experience ?? '—' }}
                            </p>
                        </div>

                        <!-- Education -->
                        <div>
                            <h4 class="font-semibold mb-1">Education</h4>
                            <p class="text-sm text-gray-700">
                                {{ $jobApplication->resume->education ?? '—' }}
                            </p>
                        </div>

                    </div>

                </div>

                <!-- AI Feedback Tab -->
                <div x-show="tab === 'ai'" class="mt-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">AI Feedback</h4>

                        <p class="text-sm text-gray-700">
                            {{ $jobApplication->aiGeneratedFeedback ?? 'No AI feedback available.' }}
                        </p>

                        @if ($jobApplication->aiGeneratedScore)
                            <p class="mt-3 text-sm">
                                <strong>AI Score:</strong> {{ $jobApplication->aiGeneratedScore }}/10
                            </p>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </div>

</x-app-layout>
