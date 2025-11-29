<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User Password') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">

        <div class="bg-white p-6 rounded-lg shadow-md">

            <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name (Read Only) -->
                <div class="mb-4">
                    <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                    <input type="text" id="name" value="{{ $user->name }}" readonly
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm cursor-not-allowed">
                </div>

                <!-- Email (Read Only) -->
                <div class="mb-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input type="text" id="email" value="{{ $user->email }}" readonly
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm cursor-not-allowed">
                </div>

                <!-- Role (Read Only) -->
                <div class="mb-4">
                    <label for="role" class="block font-medium text-sm text-gray-700">Role</label>
                    <input type="text" id="role" value="{{ $user->role }}" readonly
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm cursor-not-allowed">
                </div>

                <!-- Password (Editable) -->
                <div class="mb-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">New Password</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-between mt-6">
                    <a href="{{ route('users.index') }}"
                        class="px-4 py-2 bg-gray-200 border border-gray-300 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-300 transition">
                        Back to Users
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-black text-sm font-semibold rounded-md hover:bg-indigo-700 focus:ring-indigo-500 transition shadow-sm">
                        Update Password
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>
