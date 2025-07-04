@props([
    'color' => 'text-gray-800 dark:text-gray-200',
])

<svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => "w-4 h-4 $color"]) }} fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
</svg>