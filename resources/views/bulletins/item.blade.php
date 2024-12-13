<div class="w-full mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden mb-4">
    <div class="p-4 flex items-center">
        @isset ($item->creator->photo)
        <img
            class="h-12 w-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700"
            src="{{ $item->creator->photo->url }}"
            alt="User avatar">
        @endisset
        <div class="ml-4">
            <h2 class="text-gray-800 dark:text-white font-semibold">{{ $item->creator->full_name }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $item->created_at }}</p>
        </div>
    </div>
    <div class="px-4 pt-2 pb-6">
        <p class="text-gray-600 dark:text-gray-300 whitespace-pre-wrap">{{ $item->text }}</p>
    </div>
</div>