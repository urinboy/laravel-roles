<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your roles') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>

    <div>
        <x-alert-success />
        <div class="flex justify-end mb-4">
            <a href="{{ route('roles.create') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
               wire:navigate>
                {{ __('Create Role') }}
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">{{ __('Name') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Permissions') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr class="border-b dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3 sm:px-6 font-medium text-gray-900 dark:text-white">{{ $role->id }}</td>
                            <td class="px-4 py-3 sm:px-6 text-gray-700 dark:text-gray-200">{{ $role->name }}</td>
                            <td class="px-4 py-3 sm:px-6 text-gray-600 dark:text-gray-300 break-all">
                                {{-- {{ $role->guard_name ?: __('—') }} --}}
                                @if ($role->permissions->isNotEmpty())
                                        @foreach ($role->permissions as $permission)
                                            <flux:badge color="cyan" class="m-1"> {{ $permission->name }}</flux:badge>
                                        @endforeach
                                @endif
                            </td>
                            <td class="px-4 py-3 sm:px-6 flex flex-row gap-2 justify-center">
                                <!-- Show -->
                                <a href="{{ route('roles.show', $role->id) }}"
                                   wire:navigate
                                   class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 focus:ring-2 focus:outline-none focus:ring-gray-300"
                                   title="{{ __('Show') }}">
                                    <!-- Heroicons Eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    </svg>
                                </a>
                                <!-- Edit -->
                                <a href="{{ route('roles.edit', $role->id) }}"
                                   wire:navigate
                                   class="inline-flex items-center justify-center p-2 rounded-lg bg-blue-100 dark:bg-blue-800 hover:bg-blue-200 dark:hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300"
                                   title="{{ __('Edit') }}">
                                    <!-- Heroicons Pencil Square -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700 dark:text-blue-200" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.5H3v-4.5l13.862-13.513z"/>
                                    </svg>
                                </a>
                                <!-- Delete -->
                                <flux:modal.trigger name="confirm-role-deletion-{{ $role->id }}">
                                    <button type="button"
                                            class="inline-flex items-center justify-center p-2 rounded-lg bg-red-100 dark:bg-red-800 hover:bg-red-200 dark:hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-red-300"
                                            x-data
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-role-deletion-{{ $role->id }}')"
                                            title="{{ __('Delete') }}">
                                        <!-- Heroicons Trash -->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             class="w-5 h-5 text-red-700 dark:text-red-200" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M6 18A2 2 0 008 20h8a2 2 0 002-2V7H6v11zM5 7h14M10 11v6m4-6v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                                        </svg>
                                    </button>
                                </flux:modal.trigger>
                                <!-- Delete Confirmation Modal (o'zgarmagan) -->
                                <flux:modal name="confirm-role-deletion-{{ $role->id }}" focusable class="max-w-lg">
                                    <form wire:submit.prevent="delete({{ $role->id }})" class="space-y-6">
                                        <div>
                                            <flux:heading size="lg">{{ __('Are you sure you want to delete this role?') }}</flux:heading>
                                            <flux:subheading>
                                                {{ __('Once this role is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
                                            </flux:subheading>
                                        </div>
                                        <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                                            <flux:modal.close>
                                                <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                                            </flux:modal.close>
                                            <flux:button variant="danger" type="submit">{{ __('Delete') }}</flux:button>
                                        </div>
                                    </form>
                                </flux:modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No roles found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
