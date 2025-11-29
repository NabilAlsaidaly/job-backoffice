@php

if (auth()->user()->role == 'admin')
    {
    $formAction = route('companies.update',['company' => $company->id],['redirectToList' => request('redirectToList')]);
    }
else if (auth()->user()->role == 'company-owner')
    {
    $formAction = route('my-company.update');
    }
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-md">

            <form action="{{ $formAction }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Company Name -->
                <div class="mb-4">
                    <label for="name" class="block font-medium text-sm text-gray-700">Company Name</label>
                    <input type="text" name="name" id="name" value="{{ $company->name }}"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                    @error('name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Address -->
                <div class="mb-4">
                    <label for="address" class="block font-medium text-sm text-gray-700">Company Address</label>
                    <input type="text" name="address" id="address" value="{{ $company->address }}"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                    @error('address')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Industry -->
                <div class="mb-4">
                    <label for="industry" class="block font-medium text-sm text-gray-700">Company Industry</label>

                    <select name="industry" id="industry"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach ($industries as $industry)
                            <option value="{{ $industry }}" @selected($company->industry == $industry)>
                                {{ $industry }}
                            </option>
                        @endforeach
                    </select>

                    @error('industry')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Website -->
                <div class="mb-4">
                    <label for="website" class="block font-medium text-sm text-gray-700">
                        Company Website (Optional)
                    </label>

                    <input type="text" name="website" id="website" value="{{ $company->website }}"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                    @error('website')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Owner Name -->
                <div class="mb-4">
                    <label for="owner_name" class="block font-medium text-sm text-gray-700">Owner Name</label>
                    <input type="text" name="owner_name" id="owner_name" value="{{ $company->owner->name }}"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                    @error('owner_name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Owner Email -->
                <div class="mb-4">
                    <label for="owner_email" class="block font-medium text-sm text-gray-700">Owner Email</label>
                    <input disabled type="email" name="owner_email" id="owner_email"
                        value="{{ old('owner_email', $company->owner->email) }}"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                    @error('owner_email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Owner Password -->
                <div class="mb-4" x-data="{ show: false }">
                    <label for="owner_password" class="block font-medium text-sm text-gray-700">Owner Password</label>

                    <div class="relative">
                        <input id="owner_password" name="owner_password" value="{{ $company->owner->password }}"
                            x-bind:type="show ? 'text' : 'password'"
                            class="block mt-1 w-full pr-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            autocomplete="new-password">

                        <!-- Eye Button -->
                        <button type="button" class="absolute inset-y-0 right-2 flex items-center text-gray-500"
                            @click="show = !show">

                            <!-- Eye Open -->
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478
                                        0 8.268 2.943 9.542 7-1.274 4.057-5.064
                                        7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- Eye Closed -->
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825a9.56 9.56 0 01-1.875.175c-4.478
                                        0-8.268-2.943-9.542-7 1.002-3.364 3.843-6
                                        7.542-7.575M15 12a3 3 0 00-6 0 3 3 0
                                        006 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            </svg>

                        </button>
                    </div>

                    @error('owner_password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Global Validation Errors Under Form -->
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-3">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Buttons -->
                <div class="flex justify-between mt-6">
                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('companies.index') }}"
                            class="px-4 py-2 bg-gray-200 border border-gray-300 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-300 transition">
                            Back to Companies
                        </a>
                    @else
                        <a href="{{ route('my-company.show') }}"
                            class="px-4 py-2 bg-gray-200 border border-gray-300 text-sm font-semibold text-gray-700 rounded-md hover:bg-gray-300 transition">
                            Back to My Company
                        </a>
                    @endif

                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-black text-sm font-semibold rounded-md hover:bg-indigo-700 focus:ring-indigo-500 transition shadow-sm">
                        Update Company
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
