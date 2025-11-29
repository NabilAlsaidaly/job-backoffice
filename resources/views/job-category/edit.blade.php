<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Category') }}
        </h2>
    </x-slot>

    <div class="max-w-md mx-auto py-8">
        <x-toast-notification />

        <div class="bg-white shadow rounded-md p-6">
            <form action="{{ route('job-categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for='name' class="block font-medium text-sm text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name ) }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    @error('name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <a href="{{ route('job-categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                    Back to Categories
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-semibold text-black hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm">
                    Update Category
                </button>
            </form>
        </div>
    </div>
</x-app-layout>

