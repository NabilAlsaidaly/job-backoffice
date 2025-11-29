{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="w-64 bg-white border-r border-gray-200 h-screen flex flex-col">
    {{-- Logo --}}
    <div class="flex items-center justify-center border-b border-gray-200 h-16 px-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <x-application-logo class="h-6 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800">Shaghalni</span>
        </a>
    </div>

    {{-- Links --}}
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-nav-link>
        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                Companies
            </x-nav-link>
        @endif
        @if (auth()->user()->role == 'company-owner')
            <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.*')">
                My Company
            </x-nav-link>
        @endif
        <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.*')">
            Applications
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('job-categories.index')" :active="request()->routeIs('job-categories.*')">
                Categories
            </x-nav-link>
        @endif

        <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.*')">
            Job Vacancies
        </x-nav-link>
        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                Users
            </x-nav-link>
        @endif
    </div>

    {{-- Logout --}}
    <div class="border-t border-gray-200 px-4 py-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center px-3 py-2 text-sm rounded-lg bg-red-50 text-red-700 hover:bg-red-100">
                Log Out
            </button>
        </form>
    </div>
</nav>
