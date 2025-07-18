@extends('layouts.app')

@section('content')

    <div class="flex flex-col gap-5 w-full">
        <div class="flex flex-row justify-between gap-2">
            <h1 class="texl-xl sm:text-2xl">
                <span class="font-semibold">My Folder -</span> <span class="font-bold">{{ $folders->folder_name }}</span>
            </h1>
            <div class="flex flex-row">
                <x-button onclick="viewToggle()" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                    <i class="fa-solid fa-table-cells-large text-lg me-2" id="tableView"></i>
                    <i class="fa-solid fa-list text-lg me-2 hidden" id="listView"></i>
                    View
                </x-button>
            </div>
        </div>

        <div id="cardDiv" class="flex flex-col gap-2 md:gap-5 w-full">
            {{-- File Item --}}
            <div class="flex flex-col gap-5 w-full">
                <div id="fileDiv" class="grid grid-cols-2 lg:grid-cols-5 gap-2">
                    @forelse($files as $row)
                        <x-file-item
                            :id="$row->id"
                            :name="$row->file_name"
                            :path="$row->file_path"
                        >
                            @include('components.file-menu-button', ['id' => $row->id, 'prefix' => 'card-'])
                            @include('components.file-menu', ['id' => $row->id, 'prefix' => 'card-'])
                        </x-file-item>
                    @empty
                        <p>No data found.</p>
                    @endforelse
                </div>

                {{ $files->links() }}
            </div>
        </div>

        {{-- Table View --}}
        <x-table-view
            :headers="['', 'Name', 'Size', 'Owner', 'Last Modified', '']"
            :files="$files"
        >
            @forelse ($files as $row)
                @php
                    $extension = strtolower(pathinfo($row->file_name, PATHINFO_EXTENSION));
                    $file = storage_path('app/public/uploads/' . $row->file_path);
                    $size = filesize($file);

                    if (in_array($extension, ['jpeg', 'jpg', 'png', 'webp'])) {
                        $display = '<i class="fa-solid fa-image text-gray-600 text-lg"></i>';
                    } elseif (in_array($extension, ['doc', 'docx'])) {
                        $display = '<i class="fa-solid fa-file-word text-blue-600 text-lg"></i>';
                    } elseif ($extension === 'pdf') {
                        $display = '<i class="fa-solid fa-file-pdf text-red-600 text-lg"></i>';
                    } elseif ($extension === 'xlx' || $extension === 'xlsx ') {
                        $display = '<i class="fa-solid fa-file-excel text-green-600 text-lg"></i>';
                    } else {
                        $display = '<i class="fa-solid fa-file text-gray-600 text-lg"></i>';
                    }
                @endphp
                <tr class="border-b text-black dark:border-gray-700 border-gray-200 dark:hover:bg-gray-200">
                    <th scope="row" class="px-6 py-2 font-medium whitespace-nowrap dark:text-white">
                        {!! $display !!}
                    </th>
                    <td class="font-semibold">{{ $row->file_name }}</td>
                    <td>{{ round($size / (1024 * 1024), 2) . " MB" }}</td>
                    <td>me</td>
                    <td>
                        {{ \Carbon\Carbon::parse($row->updated_at)->format('F j, Y \a\t g:i A') }}
                    </td>
                    <td>
                        @include('components.file-menu-button', ['id' => $row->id, 'prefix' => 'table-'])
                    </td>
                </tr>
            @empty
                <tr class="border-b text-black dark:border-gray-700 border-gray-200 dark:hover:bg-gray-200">
                    <th colspan="8" scope="row" class="px-6 py-2 font-medium whitespace-nowrap text-center">
                        No data found.
                    </th>
                </tr>
            @endforelse
        </x-table-view>

        {{-- Render file-menus here for each row --}}
        @foreach ($files as $row)
            @include('components.file-menu', ['id' => $row->id, 'prefix' => 'table-'])
        @endforeach
    </div>
@endsection
