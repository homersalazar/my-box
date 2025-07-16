@extends('layouts.app')

@section('content')
    @include('components.create-folder-modal')
    @include('components.create-file-modal')
    <div class="flex flex-col gap-5 w-full">
        <div class="flex flex-row justify-between gap-2">
            <h1 class="font-semibold texl-xl sm:text-2xl text-white">
                My Files
            </h1>
            <div class="flex flex-row">
                <x-button onclick="viewToggle()" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
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
        </div>

        <div id="cardDiv" class="flex flex-col gap-2 md:gap-5 w-full">
            {{-- Folder toggle button --}}
            <label class="text-lg md:text-xl font-bold max-w-xs" onclick="folderToggle()">Folder
                <i class="fa-solid fa-angle-down" id="folderOpen"></i>
                <i class="fa-solid fa-angle-up hidden" id="folderClose"></i>
            </label>

            {{-- Folder Item --}}
            <div id="folderDiv" class="grid grid-cols-2 lg:grid-cols-4 gap-2">
                @foreach($folders as $row)
                    <x-folder-item :title="$row->folder_name" :id="$row->id"/>
                @endforeach
            </div>

            {{-- File toggle button --}}
            <label class="text-lg md:text-xl font-bold max-w-xs" onclick="fileToggle()">Files
                <i class="fa-solid fa-angle-down" id="fileOpen"></i>
                <i class="fa-solid fa-angle-up hidden" id="fileClose"></i>
            </label>

            {{-- File Item --}}
            <x-file-item/>
        </div>

        {{-- Table View --}}
        <x-table-view />
    </div>
@endsection
