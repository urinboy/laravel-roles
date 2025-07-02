@props([
    'color' => 'text-res-700 dark:text-res-200',
])
<svg xmlns="http://www.w3.org/2000/svg"  {{ $attributes->merge(['class' => "w-4 h-4 $color"]) }}
fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
</svg>
