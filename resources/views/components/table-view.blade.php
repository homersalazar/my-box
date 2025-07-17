@props(['headers'])

<div id="tableDiv" class="relative overflow-x-auto h-full hidden">
    <table id="dataTable" class="w-full text-sm">
        <thead class="text-xs">
            <tr>
                @foreach ($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>

