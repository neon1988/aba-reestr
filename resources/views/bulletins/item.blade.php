<div
    class="w-full mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden mb-4  hover:shadow-xl transition duration-300">
    <div class="p-4 flex items-center">
        <a href="{{ route('users.show', ['user' => $item->creator]) }}"
            class="h-12 w-12 rounded-full bg-gray-300 overflow-hidden flex items-center justify-center shrink-0 text-white font-bold">
            @if(isset($item->creator->photo))
                <x-image :url="$item->creator->photo->url"
                         :alt="$item->creator->fullName"
                         width="50" height="50" quality="90"
                         class="w-full h-full object-cover"/>
            @else
                <span>{{ $item->creator->nameInitials }}</span>
            @endif
        </a>
        <div class="ml-4">
            <a href="{{ route('users.show', ['user' => $item->creator]) }}">
                <h2 class="text-gray-800 dark:text-white font-semibold">{{ $item->creator->full_name }}</h2>
            </a>
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                <x-time :time="$item->created_at"/>
            </p>
        </div>
    </div>
    <div class="px-4 pt-2 pb-6">
        <p class="text-gray-600 dark:text-gray-300 whitespace-pre-wrap">{{ $item->text }}</p>
    </div>
</div>
