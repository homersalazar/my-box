@extends('layouts.app')

@section('content')
    @include('components.create-file-modal')

    <div class="flex flex-col gap-2 md:gap-5 w-full">
        <h1 class="font-semibold texl-xl sm:text-2xl text-white dark:text-gray-900">Overview Storage</h1>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 md:gap-5">
            <div class="flex flex-row w-full p-2.5 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 gap-3 lg:gap-5">
                <div class="flex justify-center w-10 md:w-12 bg-red-600 p-3 rounded-xl">
                    <i class="fa-solid fa-image text-white text-lg md:text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <p class="lg:text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Image</p>
                    <p class="font-normal text-gray-500 dark:text-gray-400">
                        {{ $images <= 1 ? $images . ' item' : $images . ' items' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-row w-full p-2.5 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 gap-3 lg:gap-5">
                <div class="flex justify-center w-10 md:w-12 bg-yellow-600 p-3 rounded-xl">
                    <i class="fa-solid fa-file text-white text-lg md:text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <p class="lg:text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Documents</p>
                    <p class="font-normal text-gray-500 dark:text-gray-400">{{ $docs }} items</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <x-button onclick="viewToggle()" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                <i class="fa-solid fa-table-cells-large text-lg me-2" id="tableView"></i>
                <i class="fa-solid fa-list text-lg me-2 hidden" id="listView"></i>
                View
            </x-button>

            <x-dropdown
                title='<i class="fa-solid fa-plus me-2 text-lg"></i> Create'
                buttonId="actionsBtn"
                dropdownId="actionsDropdown"
            >
                <li>
                    <x-new-folder-button />
                </li>
                <li>
                    <x-upload-file-button />
                </li>
            </x-dropdown>
        </div>

        <div id="cardDiv" class="flex flex-col gap-2 md:gap-5 w-full">
            {{-- Folder toggle button --}}
            <label class="text-lg md:text-xl font-bold max-w-xs" onclick="folderToggle()">Folder
                <i class="fa-solid fa-angle-down" id="folderOpen"></i>
                <i class="fa-solid fa-angle-up hidden" id="folderClose"></i>
            </label>

            {{-- Folder Item --}}
            <div id="folderDiv" class="flex flex-col gap-5 w-full">
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-2">
                    @forelse ($folders as $row)
                        <x-folder-item :title="$row->folder_name" :id="$row->id"/>
                    @empty
                        <p>No folder found.</p>
                    @endforelse
                </div>
            </div>

            {{-- File toggle button --}}
            <label class="text-lg md:text-xl font-bold max-w-xs" onclick="fileToggle()">Files
                <i class="fa-solid fa-angle-down" id="fileOpen"></i>
                <i class="fa-solid fa-angle-up hidden" id="fileClose"></i>
            </label>

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
                        <p>No file found.</p>
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
                    $bytes = filesize($file);
                    if ($bytes === 0) {
                        $file_size = '0 Bytes';
                    }

                    $k = 1024;
                    $sizes = ['Bytes', 'KB', 'MB', 'GB'];

                    $i = floor(log($bytes, $k));
                    $file_size = round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
                    if (in_array($extension, ['jpeg', 'jpg', 'png', 'webp'])) {
                        $display = '<i class="fa-solid fa-image text-gray-600 text-lg"></i>';
                    } elseif (in_array($extension, ['doc', 'docx'])) {
                        $display = '<i class="fa-solid fa-file-word text-blue-600 text-lg"></i>';
                    } elseif ($extension === 'pdf') {
                        $display = '<i class="fa-solid fa-file-pdf text-red-600 text-lg"></i>';
                    } elseif ($extension === 'xls' || $extension === 'xlsx') {
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
                    <td>{{ $file_size }}</td>
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
