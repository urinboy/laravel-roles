<div class="space-y-6">
    <!-- Top Section: Back + Profile Heading -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
               href="{{ route('users.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" class="h-4 w-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                {{ __('Назад') }}
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('Профиль пользователя') }}</h1>
                <p class="text-sm text-gray-500">{{ __('Детальная информация и история активности') }}</p>
            </div>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6">
        <div class="flex items-start space-x-6">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">
                        {{ strtoupper(mb_substr($user->name ?? $user->username ?? 'U', 0, 1)) }}
                    </span>
                </div>
            </div>
            <!-- User Main Info -->
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ $user->name }}</h2>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>
                                <span class="text-sm text-gray-600">
                                    Имя пользователя:
                                    <span class="font-medium">
                                        @{{ $user->username }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M6 6h.008v.008H6V6Z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">
                                        Роль:
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $user->role_label ?? '—' }}
                                        </span>
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">
                                        Зарегистрирован:
                                        <span class="font-medium">
                                            {{ $user->created_at ? $user->created_at->format('d.m.Y') : '—' }}
                                        </span>
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">
                                        Добавлено оборудования:
                                        <span class="font-medium text-blue-600">{{ $user->equipments_count ?? 0 }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Всего оборудования</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $user->equipments_count ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Работает</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $user->equipments_working_count ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L4.316 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Требует ремонта</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $user->equipments_repair_count ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Новое</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $user->equipments_new_count ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Stats -->
                </div>
            </div>
        </div>
    </div>

    <!-- History Section -->
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">История добавленного оборудования</h3>
            <p class="text-sm text-gray-500">Оборудование, добавленное или управляемое этим пользователем</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-4">
                @forelse($user->equipments as $equipment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-200 cursor-pointer hover:border-blue-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $equipment->name }}</h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $equipment->status_label ?? 'Новое' }}
                                        </span>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span>Инв. №: {{ $equipment->inventory_number }}</span>
                                            <span>•</span>
                                            <span>Сер. №: {{ $equipment->serial_number ?? 'Не указан' }}</span>
                                        </div>
                                        <div class="text-sm text-blue-600 font-medium">
                                            CPU: {{ $equipment->cpu ?? '-' }} • RAM: {{ $equipment->ram ?? '-' }}
                                        </div>
                                        <div class="flex items-center space-x-1 text-sm text-gray-500">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                            </svg>
                                            <span>{{ $equipment->room_label ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                </svg>
                                {{ $equipment->created_at ? $equipment->created_at->format('d.m.Y') : '-' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-8">Нет добавленного оборудования</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
