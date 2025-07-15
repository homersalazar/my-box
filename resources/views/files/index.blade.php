@extends('layouts.app')

@section('content')
    @include('components.create-folder-modal')

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
                        <div data-modal-target="create-folder-modal" data-modal-toggle="create-folder-modal" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                            <i class="fa-solid fa-folder-plus"></i>&nbsp; New Folder
                        </div>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                            <i class="fa-solid fa-file-arrow-up"></i>&nbsp; File Upload
                        </a>
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
            <x-folder-item
                :title="'testing'"
                :id="1"
            />

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
    <script>
        // Function to toggle folder visibility
        const viewToggle = () => {
            const tableView = document.getElementById("tableView");
            const listView = document.getElementById("listView");
            const cardDiv = document.getElementById("cardDiv");
            const tableDiv = document.getElementById("tableDiv");

            // Toggle hidden class to switch views
            tableView.classList.toggle("hidden");
            listView.classList.toggle("hidden");

            cardDiv.classList.toggle("hidden");
            tableDiv.classList.toggle("hidden");
        }
    </script>
@endsection
