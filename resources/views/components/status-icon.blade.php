@props(['active' => false])
<span class="ml-2">
    @if ($active)
        <!-- Active icon -->
        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4M12 21A9 9 0 1 1 12 3a9 9 0 0 1 0 18z" />
        </svg>
    @else
        <!-- Inactive icon -->
        {{-- <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12M12 21A9 9 0 1 1 12 3a9 9 0 0 1 0 18z" />
        </svg> --}}
        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12H9m12 0A9 9 0 1 1 3 12a9 9 0 0 1 18 0z" />
          </svg>
        @endif
</span>
