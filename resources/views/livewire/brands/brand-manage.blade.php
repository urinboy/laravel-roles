<div class="relative">
    {{-- Modal --}}
    <div x-data="{ show: @entangle('showModal') }" x-show="show" class="fixed inset-0 flex items-center justify-center z-50"
        style="background: rgba(38, 50, 56, 0.12);" x-cloak>
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-lg mx-2 border border-gray-100 dark:border-gray-700 animate-fade-in">
            <div class="px-8 pt-8 pb-2">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                        @if ($actionType === 'edit')
                            {{ __('Edit Brand') }}
                        @elseif($actionType === 'delete')
                            {{ __('Delete Brand') }}
                        @else
                            {{ __('Add Brand') }}
                        @endif
                    </h3>
                    <button @click="show = false" wire:click="closeModal"
                        class="text-gray-400 hover:text-red-500 text-3xl font-bold transition leading-none focus:outline-none cursor-pointer">&times;</button>
                </div>
                <form wire:submit.prevent="{{ $actionType === 'delete' ? 'delete' : 'save' }}">
                    @if ($actionType === 'delete')
                        <p class="mb-2 text-gray-800 dark:text-gray-100">
                            {{ __('Are you sure you want to delete this brand?') }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('This action cannot be undone.') }}
                        </p>
                        @if ($brand_id)
                            @php $brand_name_display = \App\Models\Brand::find($brand_id)->name ?? 'N/A'; @endphp
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                {{ __('Delete brand') }} <strong>{{ $brand_name_display }}</strong>?
                            </p>
                        @endif
                    @else
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-1 text-gray-700 dark:text-gray-200">
                                {{ __('Name') }} <span class="text-red-600">*</span>
                            </label>
                            <input type="text" wire:model.lazy="name" placeholder="e.g., Apple"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2 bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 shadow-sm" />
                            @error('name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-1 text-gray-700 dark:text-gray-200">
                                {{ __('Description') }}
                            </label>
                            <textarea wire:model.lazy="description" placeholder="e.g., Electronics brand"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2 bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 shadow-sm resize-none"></textarea>
                            @error('description')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-1 text-gray-700 dark:text-gray-200">
                                {{ __('Logo') }}
                            </label>
                            <input type="file" wire:model="logo"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2 bg-white dark:bg-gray-700 dark:text-gray-100 shadow-sm" />
                            <div class="mt-2">
                                @if ($logo)
                                    {{-- Livewire file upload preview --}}
                                    <img src="{{ $logo->temporaryUrl() }}" alt="Logo Preview"
                                        class="h-14 p-2 object-contain rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                                @elseif ($logo_path)
                                    {{-- DBdagi logo ni universal accessor tarzida ko‘rsatish --}}
                                    <img src="{{ \App\Models\Brand::getUniversalLogoUrl($logo_path) }}" alt="Logo Preview"
                                        class="h-14 p-2 object-contain rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                                @endif
                            </div>
                            @error('logo')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="is_active"
                                    class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Active') }}</span>
                            </label>
                        </div>
                    @endif

                    <div class="flex justify-end gap-2 mt-8 mb-2">
                        <button type="button" @click="show = false" wire:click="closeModal"
                            class="px-6 py-2 rounded-xl font-medium text-gray-700 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600 transition cursor-pointer">
                            {{ __('Cancel') }}
                        </button>
                        @if ($actionType === 'delete')
                            <button type="submit"
                                class="px-6 py-2 rounded-xl font-medium text-white bg-red-600 hover:bg-red-700 transition">
                                {{ __('Delete') }}
                            </button>
                        @else
                            <button type="submit"
                                class="px-6 py-2 rounded-xl font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                                {{ $actionType === 'edit' ? __('Update') : __('Create') }}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Flash --}}
    <x-flash />

    {{-- Brand List --}}
    <div>
        <div class="mb-6 w-full">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold mb-2 mt-4 text-gray-900 dark:text-white">{{ __('Brands') }}</h2>
                    <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage brands') }}</p>
                </div>
                <div class="mb-6 flex justify-end">
                    <button wire:click="openModal('create')"
                        class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:text-white font-medium rounded hover:bg-blue-500 transition cursor-pointer"
                        title="{{ __('Add New Brand') }}">
                        <x-icons.plus />
                        {{ __("Add New") }}
                    </button>
                </div>
            </div>
            <hr class="mb-4 border-gray-200 dark:border-gray-700" />
        </div>

        {{-- <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-2xl border border-gray-100 dark:border-gray-800"> --}}
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($brands as $brand)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow group border border-gray-200 dark:border-gray-800 p-5 flex flex-col min-h-[170px] transition hover:shadow-lg hover:-translate-y-1 duration-200">
                         @if ($brand->logo)
                                <img src="{{ $brand->logo_url }}" alt="logo" class="p-2 mt-2 object-contain rounded bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 w-full">
                                {{-- <img src="{{ $brand->logo_url }}" alt="logo" class="p-2 h-12 mt-2 object-contain rounded bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 max-w-[150px]"> --}}
                                {{-- <img src="{{ asset('storage/' . $brand->logo) }}" alt="logo" class="p-2 h-12 mt-2 object-contain rounded bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 max-w-[150px]"> --}}
                            @endif
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="flex items-center font-bold text-lg text-gray-900 dark:text-gray-100 truncate">
                                    {{ $brand->name }}
                                    <span class="mr-2">
                                        <x-status-icon :active="$brand->is_active" />
                                    </span>
                                </h3>

                                <div class="flex items-center justify-end gap-3 mt-4">
                                    <button wire:click="openModal('edit', {{ $brand->id }})"
                                        class="inline-flex items-center p-2 rounded-full text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900 dark:hover:bg-blue-700 transition"
                                        title="{{ __('Edit') }}">
                                        <x-icons.edit />
                                    </button>
                                    <button wire:click="openModal('delete', {{ $brand->id }})"
                                        class="inline-flex items-center p-2 rounded-full text-red-500 hover:text-white bg-red-50 hover:bg-red-600 dark:bg-red-900 dark:hover:bg-red-700 transition"
                                        title="{{ __('Delete') }}">
                                        <x-icons.delete />
                                    </button>
                                </div>

                            </div>
                            <div class="mb-2 text-gray-600 dark:text-gray-300 text-sm break-words">
                                {{ $brand->description }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm italic col-span-full">
                        {{ __('No brands found.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
