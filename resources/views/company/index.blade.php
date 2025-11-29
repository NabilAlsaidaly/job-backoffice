<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request()->input('archived') == 'true' ? __('Archived Companies') : __('Companies') }}
        </h2>
    </x-slot>

    <!-- Page Content -->
    <!-- Filter Buttons + Add Button -->
    <div class="flex items-center gap-4 mb-6">
        @if (request()->input('archived') == 'true')
            <!-- When viewing archived -->
            <a href="{{ route('companies.index') }}"
                class="inline-flex items-center px-4 py-2 border text-sm font-semibold rounded-md transition duration-150 ease-in-out
                  bg-white text-black border-black hover:bg-gray-100">
                Active Companies
            </a>
        @else
            <a href="{{ route('companies.index', ['archived' => 'true']) }}"
                class="inline-flex items-center px-4 py-2 border text-sm font-semibold rounded-md transition duration-150 ease-in-out
                  bg-white text-black border-black hover:bg-gray-100">
                Archived Companies
            </a>
        @endif

        <!-- Add New Category button (always visible) -->
        <a href="{{ route('companies.create') }}"
            class="ml-auto inline-flex items-center px-4 py-2 border text-sm font-semibold rounded-md transition duration-150 ease-in-out
              bg-black text-black border-black hover:bg-gray-900">
            + Add New Company
        </a>
    </div>

    <!-- Optional Toast Notification -->
    <x-toast-notification />

    <!-- Companies Table -->
    <div class="bg-white shadow-md sm:rounded-lg overflow-hidden">
        <div class="p-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <!-- Table Head -->
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Address</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Industry</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Website</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Created</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($companies as $company)
                        <tr class="hover:bg-gray-50">
                            <!-- ID -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $company->id }}
                            </td>

                            <!-- Name & Description -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold">
                                            {{ strtoupper(substr($company->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('companies.show', $company) }}">
                                                {{ $company->name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Address -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $company->address }}
                            </td>

                            <!-- Industry -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $company->industry }}
                            </td>

                            <!-- Website -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $company->website }}
                            </td>

                            <!-- Created Date -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <time datetime="{{ $company->created_at }}">
                                    {{ $company->created_at->diffForHumans() }}
                                </time>
                            </td>

                            <!-- Action Buttons -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                <div class="inline-flex items-center space-x-2">
                                    <!-- Edit -->
                                    @if (request()->input('archived') == 'true')
                                        <form action="{{ route('companies.restore', $company) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to restore this company?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-50 border border-green-200 text-green-600 text-sm rounded-md hover:bg-green-100">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Restore
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('companies.edit', $company) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-white border border-indigo-200 text-indigo-600 text-sm rounded-md hover:bg-indigo-50">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <!-- Archive -->
                                        <form action="{{ route('companies.destroy', $company) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to archive this company?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-50 border border-red-200 text-red-600 text-sm rounded-md hover:bg-red-100">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                                </svg>
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
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="max-w-md mx-auto">
                                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7h18M5 7v12a2 2 0 002 2h10a2 2 0 002-2V7M9 7V5a3 3 0 116 0v2" />
                                    </svg>
                                    <p class="mt-4 text-sm text-gray-600">
                                        No companies found. Create your first company to get started.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $companies->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
