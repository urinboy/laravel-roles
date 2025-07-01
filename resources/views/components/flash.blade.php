{{-- Flash messages section (Success) --}}
@if (session()->has('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
    x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-end="opacity-0 translate-y-full"
    class="fixed top-4 right-4 flex items-center p-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-md z-50"
    role="alert">
    <svg class="flex-shrink-0 w-6 h-6 mr-2 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
    </svg>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif
@if (session()->has('error'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
    x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-end="opacity-0 translate-y-full"
    class="fixed top-4 right-4 flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-md z-50"
    role="alert">
    <svg class="flex-shrink-0 w-6 h-6 mr-2 text-red-700" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span class="font-medium">{{ session('error') }}</span>
</div>
@endif