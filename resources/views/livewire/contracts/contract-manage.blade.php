<div>
    <div class="mb-6 w-full">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Contracts') }}</h1>
        <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage all your contracts') }}</p>
        <hr class="mb-4 border-gray-200 dark:border-gray-700" />
    </div>

    <x-alert-success />

    <div class="flex justify-end mb-4">
        <button wire:click="openModal('create')"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
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
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.5H3v-4.5l13.862-13.513z" />
                                </svg>
                            </button>
                            <button wire:click="openModal('delete', {{ $contract->id }})"
                                class="p-1.5 rounded-full bg-red-100 dark:bg-red-800 hover:bg-red-200 dark:hover:bg-red-700"
                                title="{{ __('Delete') }}">
                                <!-- Delete icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-700 dark:text-red-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M6 18A2 2 0 008 20h8a2 2 0 002-2V7H6v11zM5 7h14M10 11v6m4-6v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2" />
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
                                    <!-- View icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700 dark:text-blue-200" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    </svg>
                                    {{ __('View') }}
                                </a>
                                <a href="{{ Storage::disk('public')->url($contract->pdf_path) }}" download
                                    class="text-green-600 dark:text-green-300 hover:underline flex items-center"
                                    title="{{ __('Download') }}">
                                    <!-- Download icon -->
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
    {{-- <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-lg shadow">
        <table class="w-full text-sm text-left text-gray-900 dark:text-gray-100">
            <thead class="bg-gray-100 dark:bg-gray-800 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">{{ __('Number') }}</th>
                    <th class="px-4 py-3">{{ __('Date') }}</th>
                    <th class="px-4 py-3">{{ __('Inventory Numbers') }}</th>
                    <th class="px-4 py-3">{{ __('PDF') }}</th>
                    <th class="px-4 py-3">{{ __('Added by') }}</th>
                    <th class="px-4 py-3 text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contracts as $contract)
                    <tr class="border-b dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $contract->number }}</td>
                        <td class="px-4 py-3">{{ $contract->date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">
                            @foreach ($contract->inventory_numbers as $inv)
                                <span class="inline-block bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded px-2 py-0.5 text-xs mr-1">{{ $inv }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3">
                            @if ($contract->pdf_path)
                                <a href="{{ Storage::disk('public')->url($contract->pdf_path) }}" target="_blank" class="text-blue-600 dark:text-blue-300 underline">{{ __('View') }}</a>
                            @else
                                <span class="text-gray-400">{{ __('No File') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $contract->user->name ?? '-' }}</td>
                        <td class="px-4 py-3 flex gap-2 justify-center">
                            <button wire:click="openModal('edit', {{ $contract->id }})"
                                class="inline-flex items-center justify-center p-2 rounded-lg bg-blue-100 dark:bg-blue-800 hover:bg-blue-200 dark:hover:bg-blue-700"
                                title="{{ __('Edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700 dark:text-blue-200" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.5H3v-4.5l13.862-13.513z"/>
                                </svg>
                            </button>
                            <button wire:click="openModal('delete', {{ $contract->id }})"
                                class="inline-flex items-center justify-center p-2 rounded-lg bg-red-100 dark:bg-red-800 hover:bg-red-200 dark:hover:bg-red-700"
                                title="{{ __('Delete') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    class="w-5 h-5 text-red-700 dark:text-red-200" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M6 18A2 2 0 008 20h8a2 2 0 002-2V7H6v11zM5 7h14M10 11v6m4-6v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                            {{ __('No contracts found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div> --}}

    @include('livewire.contracts.contract-modal')
</div>
