<a href="{{ route('centers.show', compact('center')) }}"
   class="bg-white p-4 sm:p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
    <x-image :url="optional($center->photo)->url"
             :alt="$center->name"
             width="500" height="500" quality="90"
             class="w-full h-24 object-cover rounded-lg mb-4" />
    <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ $center->name }}</h3>
    <p class="text-gray-600 mb-4">{{ __($center->country) }} {{ __($center->region) }} {{ __($center->city) }}</p>
    <p class="text-gray-600 mb-4">Юридическое название: {{ $center->legal_name }}</p>
</a>
