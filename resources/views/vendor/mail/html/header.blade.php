@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img
                src="https://fs-thb03.getcourse.ru/fileservice/file/thumbnail/h/13466f741221f7be4c6975413c43c18f.png/s/f1200x/a/755389/sc/5"
                class="logo"
                alt="{{ __(config('app.name')) }} Logo">
            <div>
            {{ $slot }}
            </div>
        </a>
    </td>
</tr>
