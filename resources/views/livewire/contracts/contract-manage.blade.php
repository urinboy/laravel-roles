<div>
    <div class="mb-6 w-full">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Contracts') }}</h1>
            <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage all your contracts') }}</p>
        </div>
        <div class="mb-6 flex justify-end">
            <button wire:click="openModal('create')"
                class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:text-white font-medium rounded hover:bg-blue-500 transition cursor-pointer"
                title="{{ __('Add Contract') }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('Add Contract') }}
            </button>
        </div>
    </div>
    <hr class="mb-4 border-gray-200 dark:border-gray-700" />
</div>

<x-alert-success />

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
                                <x-icons.edit />
                            </button>
                            <button wire:click="openModal('delete', {{ $contract->id }})"
                                class="p-1.5 rounded-full bg-red-100 dark:bg-red-800 hover:bg-red-200 dark:hover:bg-red-700"
                                title="{{ __('Delete') }}">
                                <!-- Delete icon -->
                                <x-icons.delete />
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
                                    <x-icons.view color="text-blue-700 dark:text-blue-200 mr-1" />
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
