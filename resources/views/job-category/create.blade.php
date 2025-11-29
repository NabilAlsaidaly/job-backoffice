<x-app-layout>
<x-slot name="header">

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Job Category') }}</h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <form action="{{ route('job-categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for='name' class="block font-medium text-sm text-gray-700">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <a href="{{ route('job-categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                Back to Categories
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-semibold text-black hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm">
                Create Category
            </button>
        </form>
        </div>
    </div>
</x-app-layout>

