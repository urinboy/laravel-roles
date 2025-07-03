@can('role.create')
<div>
    <div class="mb-6 w-full">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold mb-2 mt-4 text-gray-900 dark:text-white">{{ __('Create Role') }}</h2>
                <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Form for creating a new role') }}</p>
            </div>
            <div class="mb-6 flex justify-end">
                <a href="{{ route('roles.index') }}"
                   title="{{ __('Back to Roles List') }}"
                   class="flex items-center px-4 py-2 bg-gray-100 text-gray-800 hover:bg-gray-200 font-medium rounded transition cursor-pointer dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
                   wire:navigate>
                    <x-icons.arrow-left class="mr-2" />
                    {{ __("Back") }}
                </a>
            </div>
        </div>
        <hr class="mb-4 border-gray-200 dark:border-gray-700" />
    </div>
    <div>

        <form wire:submit.prevent="submit" class="mt-6 space-y-6">
            <flux:input
                wire:model.live="name"
                label="{{ __('Role Name') }} *"
                placeholder="{{ __('Enter role name') }}"
                :error="$errors->first('name')"
            />

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Permissions') }}</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $groupedPermissions = [];
                        foreach ($allPermissions as $perm) {
                            [$model, $action] = explode('.', $perm->name);
                            $groupedPermissions[$model][] = $perm->name;
                        }
                        // 'list' action qo'shildi
                        $permissionOrder = ['list', 'view', 'create', 'edit', 'delete'];
                    @endphp

                    @foreach ($groupedPermissions as $model => $perms)
                        @php
                            $modelPermissions = collect($permissionOrder)
                                ->map(fn($action) => $model.'.'.$action)
                                ->filter(fn($permName) => in_array($permName, $perms))
                                ->values()->toArray();
                            $allChecked = count($modelPermissions) > 0 && count(array_intersect($modelPermissions, $permissions ?? [])) === count($modelPermissions);
                        @endphp
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow p-4 flex flex-col items-start">
                            <div class="mb-3 w-full flex items-center justify-between">
                                <span class="block text-base font-semibold text-gray-900 dark:text-white uppercase tracking-wide">
                                    {{ __(ucfirst($model)) }}
                                </span>
                                <label class="flex items-center ml-2 cursor-pointer select-none">
                                    <input
                                        type="checkbox"
                                        class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                                        wire:click="{{ $allChecked ? "uncheckAllPermissions('{$model}')" : "checkAllPermissions('{$model}')" }}"
                                        {{ $allChecked ? 'checked' : '' }}
                                    >
                                    <span class="ml-1 text-xs text-gray-700 dark:text-gray-300">
                                        {{ $allChecked ? __('Unselect all') : __('Select all') }}
                                    </span>
                                </label>
                            </div>
                            <div class="flex flex-col gap-2 w-full">
                                @foreach ($permissionOrder as $action)
                                    @php
                                        $permName = $model . '.' . $action;
                                    @endphp
                                    <label class="flex items-center px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <input
                                            type="checkbox"
                                            wire:model.live="permissions"
                                            value="{{ $permName }}"
                                            class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                                            @if (!in_array($permName, $perms)) disabled @endif
                                        >
                                        <span class="ml-2 text-gray-700 dark:text-gray-300 capitalize {{ !in_array($permName, $perms) ? 'opacity-40 line-through' : '' }}">
                                            {{ __($action) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($errors->first('permissions'))
                    <div class="text-red-500 text-xs mt-2">{{ $errors->first('permissions') }}</div>
                @endif
            </div>

            <flux:button type="submit" variant="primary">
                {{ __('Create Role') }}
            </flux:button>
        </form>
    </div>
</div>
@else
    <div class="text-red-500 p-4">{{ __("You do not have permission to create roles.") }}</div>
@endcan
