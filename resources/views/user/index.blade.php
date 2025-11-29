<x-app-layout>

    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request()->input('archived') == 'true' ? __('Archived Users') : __('Users') }}
        </h2>
    </x-slot>

    <div class="py-8">

        <!-- Filter Buttons -->
        <div class="flex items-center gap-4 mb-6">
            @if (request()->input('archived') == 'true')
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center px-4 py-2 border text-sm font-semibold rounded-md
                    bg-white text-black border-black hover:bg-gray-100 transition">
                    Active Users
                </a>
            @else
                <a href="{{ route('users.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 border text-sm font-semibold rounded-md
                    bg-white text-black border-black hover:bg-gray-100 transition">
                    Archived Users
                </a>
            @endif
        </div>

        <!-- Toast -->
        <x-toast-notification />

        <div class="bg-white shadow-md sm:rounded-lg overflow-hidden">
            <div class="p-4 overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">

                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50">

                                {{-- If user is admin → no edit, no delete --}}
                                @if ($user->role == 'admin')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Admin
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ---
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ---
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->role }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        <span class="text-gray-400 text-sm">Not allowed</span>
                                    </td>
                                @else
                                    <!-- Normal User Row -->

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $user->id }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{$user->name}}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->email }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->role }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">

                                        <div class="inline-flex items-center space-x-2">

                                            @if (request()->input('archived') == 'true')
                                                <!-- Restore Button -->
                                                <form action="{{ route('users.restore', $user) }}" method="POST"
                                                    onsubmit="return confirm('Restore this user?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 bg-green-50 border border-green-200 text-green-600 text-sm rounded-md hover:bg-green-100">
                                                        Restore
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Edit -->
                                                <a href="{{ route('users.edit', $user) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-white border border-indigo-200 text-indigo-600 text-sm rounded-md hover:bg-indigo-50">
                                                    Edit
                                                </a>

                                                <!-- Archive -->
                                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                    onsubmit="return confirm('Archive this user?');">
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
                                @endif

                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div class="max-w-md mx-auto">
                                        <svg class="mx-auto h-16 w-16 text-gray-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7h18M5 7v12a2 2 0 002 2h10a2 2 0 002-2V7M9 7V5a3 3 0 116 0v2" />
                                        </svg>
                                        <p class="mt-4 text-sm text-gray-600">
                                            No users found. Create your first user.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

                <div class="mt-4">
                    {{ $users->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
