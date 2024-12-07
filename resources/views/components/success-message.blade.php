@if (session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-lg">
        <p>{{ session('success') }}</p>
    </div>
@endif
