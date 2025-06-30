<div>
    <div class="mb-6 w-full">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Contracts') }}</h1>
        <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage all your contracts') }}</p>
        <hr class="mb-4 border-gray-200 dark:border-gray-700" />
    </div>

    <x-alert-success />

    <div class="flex justify-end mb-4">
        <button wire:click="openModal('create')"
            class="flex items-center px-4 py-2 bg-blue-50 text-blue-700 font-medium rounded hover:bg-blue-100 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"></path>
            </svg>
            {{ __('Add Contract') }}
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($contracts as $contract)
            <div
                class="bg-white dark:bg-gray-900 rounded-lg shadow border border-gray-200 dark:border-gray-800 flex flex-col">
                <div class="p-4 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-400 dark:text-gray-500">#{{ $loop->iteration }}</span>
                        <div class="flex gap-2">
                            <button wire:click="openModal('edit', {{ $contract->id }})"
                                class="p-1.5 rounded-full bg-blue-100 dark:bg-blue-800 hover:bg-blue-200 dark:hover:bg-blue-700"
                                title="{{ __('Edit') }}">
                                <!-- Edit icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-700 dark:text-blue-200"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </button>
                            <button wire:click="openModal('delete', {{ $contract->id }})"
                                class="p-1.5 rounded-full bg-red-100 dark:bg-red-800 hover:bg-red-200 dark:hover:bg-red-700"
                                title="{{ __('Delete') }}">
                                <!-- Delete icon -->

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-700 dark:text-red-200"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mb-1">
                        <span class="block text-xs text-gray-500 dark:text-gray-400">{{ __('Number') }}</span>
                        <span
                            class="text-base font-semibold text-gray-900 dark:text-white">{{ $contract->number }}</span>
                    </div>
                    <div class="mb-1">
                        <span class="block text-xs text-gray-500 dark:text-gray-400">{{ __('Date') }}</span>
                        <span class="text-gray-700 dark:text-gray-200">{{ $contract->date->format('d.m.Y') }}</span>
                    </div>
                    <div class="mb-1">
                        <span
                            class="block text-xs text-gray-500 dark:text-gray-400">{{ __('Inventory Numbers') }}</span>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach ($contract->inventory_numbers as $inv)
                                <span
                                    class="inline-block bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded px-2 py-0.5 text-xs">
                                    {{ $inv }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-1">
                        <span class="block text-xs text-gray-500 dark:text-gray-400">{{ __('PDF') }}</span>
                        @if ($contract->pdf_path)
                            <div class="flex items-center gap-2 mt-0.5">
                                <a href="{{ Storage::disk('public')->url($contract->pdf_path) }}" target="_blank"
                                    class="text-blue-600 dark:text-blue-300 hover:underline flex items-center"
                                    title="{{ __('View') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-blue-700 dark:text-blue-200" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                                        <circle cx="12" cy="12" r="3" stroke="currentColor"
                                            stroke-width="1.5" fill="none" />
                                    </svg>
                                    {{ __('View') }}
                                </a>
                                <a href="{{ Storage::disk('public')->url($contract->pdf_path) }}" download
                                    class="text-green-600 dark:text-green-300 hover:underline flex items-center"
                                    title="{{ __('Download') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                                    </svg>
                                    {{ __('Download') }}
                                </a>
                            </div>
                        @else
                            <span class="text-gray-400">{{ __('No File') }}</span>
                        @endif
                    </div>
                    <div class="mb-1">
                        <span class="block text-xs text-gray-500 dark:text-gray-400">{{ __('Description') }}</span>
                        <span class="text-gray-700 dark:text-gray-200">{{ $contract->description ?? '-' }}</span>
                    </div>
                </div>
                <div
                    class="bg-gray-50 dark:bg-gray-800 px-4 py-2 rounded-b-lg border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Added by') }}:</span>
                        <span
                            class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $contract->user->name ?? '-' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-8 text-gray-400 dark:text-gray-500">
                {{ __('No contracts found') }}
            </div>
        @endforelse
    </div>
    @include('livewire.contracts.contract-modal')
</div>
