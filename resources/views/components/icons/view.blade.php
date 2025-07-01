@props([
    'color' => 'text-gray-700 dark:text-gray-200',
])
<svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => "w-4 h-4 $color"]) }} fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
        d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5" fill="none" />
</svg>
