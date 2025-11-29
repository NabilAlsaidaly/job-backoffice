@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
        class="mb-4 px-4 py-3 rounded-md bg-green-100 border border-green-200 text-green-800 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif
