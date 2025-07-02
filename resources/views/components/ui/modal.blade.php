<div x-data="{ show: @entangle($attributes->wire('model')) }" x-show="show"
    class="fixed inset-0 flex items-center justify-center z-50"
    style="background: rgba(38, 50, 56, 0.12);" x-cloak>
    <div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-2xl shadow-lg w-full max-w-md mx-2 border border-gray-100 dark:border-gray-700 animate-fade-in']) }}>
        <div class="px-7 pt-7 pb-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ $title ?? '' }}
                </h3>
                <button @click="show = false" {{ $closeClick ?? '' }}
                    class="text-gray-400 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 text-2xl font-bold transition leading-none focus:outline-none">&times;
                </button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
