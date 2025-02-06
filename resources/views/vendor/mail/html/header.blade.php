@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ Vite::asset('resources/images/logo_118.png') }}"
                 alt="{{ config('app.name') }}" style="width:50px; height: 50px; margin-bottom: 10px"/>
            <div>
            {{ $slot }}
            </div>
        </a>
    </td>
</tr>
