@can('role.view')
<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Role Details') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Information about the selected role') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>
    <div>
        <a href="{{ route('roles.index') }}"
           class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
           wire:navigate>
            {{ __('Back') }}
        </a>

        <div class="mt-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow p-6">
            <div class="mb-4">
                <span class="block text-sm text-gray-600 dark:text-gray-300">{{ __('Role Name') }}</span>
                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $role->name }}</span>
            </div>

            <div>
                <span class="block text-sm text-gray-600 dark:text-gray-300 mb-2">{{ __('Permissions') }}</span>
                @if (count($permissions))
                    @php
                        $grouped = [];
                        foreach($permissions as $perm) {
                            [$model, $action] = explode('.', $perm);
                            $grouped[$model][] = $action;
                        }
                        $permissionOrder = ['list', 'view', 'create', 'edit', 'delete'];
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($grouped as $model => $actions)
                            <div class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded p-4">
                                <div class="font-semibold uppercase text-gray-800 dark:text-gray-100 mb-2">{{ ucfirst($model) }}</div>
                                <ul class="flex flex-col gap-1">
                                    @foreach($permissionOrder as $action)
                                        <li>
                                            <span class="inline-block px-2 py-1 text-xs rounded
                                                {{ in_array($action, $actions) ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' : 'bg-gray-200 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                                {{ __($action) }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @else
                    <span class="text-gray-500 dark:text-gray-400">{{ __('No permissions assigned.') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
@else
    <div class="text-red-500 p-4">{{ __("You do not have permission to view this role.") }}</div>
@endcan
