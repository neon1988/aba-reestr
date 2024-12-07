@props(['bag' => 'default'])

@if ($errors->{$bag}->any())
    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-lg">
        <ul>
            @foreach ($errors->{$bag}->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
