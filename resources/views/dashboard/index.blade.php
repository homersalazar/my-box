@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-2 md:gap-5 w-full">

        <h1 class="font-semibold texl-xl sm:text-2xl text-white dark:text-gray-900">Overview Storage</h1>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 md:gap-5">
            <div class="flex flex-row w-full p-2.5 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 gap-3 lg:gap-5">
                <div class="flex justify-center w-10 md:w-12 bg-red-600 p-3 rounded-xl">
                    <i class="fa-solid fa-image text-white text-lg md:text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <p class="lg:text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Image</p>
                    <p class="font-normal text-gray-500 dark:text-gray-400">0 items</p>
                </div>
            </div>

            <div class="flex flex-row w-full p-2.5 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 gap-3 lg:gap-5">
                <div class="flex justify-center w-10 md:w-12 bg-yellow-600 p-3 rounded-xl">
                    <i class="fa-solid fa-file text-white text-lg md:text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <p class="lg:text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Documents</p>
                    <p class="font-normal text-gray-500 dark:text-gray-400">0 items</p>
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
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        <i class="fa-solid fa-folder-plus"></i>&nbsp; New Folder
                    </a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        <i class="fa-solid fa-file-arrow-up"></i>&nbsp; File Upload
                    </a>
                </li>
            </x-dropdown>
        </div>

        <div id="cardDiv" class="flex flex-col gap-2 md:gap-5 w-full">
            {{-- Folder toggle button --}}
            <label class="text-lg md:text-xl font-bold max-w-xs" onclick="folderToggle()">Folder
                <i class="fa-solid fa-angle-down" id="folderOpen"></i>
                <i class="fa-solid fa-angle-up hidden" id="folderClose"></i>
            </label>

            {{-- Folder list --}}
            <div id="folderDiv" class="grid grid-cols-2 lg:grid-cols-4 gap-2">
                <div class="block max-w-xs p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="flex flex-row items-center justify-between">
                        <h5 class="text-base font-bold tracking-tight text-gray-900 dark:text-white">
                            <i class="fa-solid fa-folder text-gray-900 dark:text-white"></i> Noteworthy technology
                        </h5>

                        <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider" class="text-white focus:ring-4 focus:outline-none focus:ring-transparent hover:bg-gray-500 font-medium rounded-full text-sm px-3.5 py-2 text-center inline-flex items-center" type="button">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>

                        <!-- Folder menu -->
                        <div id="dropdownDivider" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                                <li>
                                    <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <i class="fa-solid fa-download"></i> Download
                                    </div>
                                </li>
                                <li>
                                    <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <i class="fa-solid fa-pen-to-square"></i> Rename
                                    </div>
                                </li>
                                <li>
                                    <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                </li>
                                <li>
                                    <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <i class="fa-solid fa-user-plus"></i> Share
                                    </div>
                                </li>
                                <li>
                                    <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <i class="fa-solid fa-folder-open"></i> Organize
                                    </div>
                                </li>
                                <li>
                                    <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <i class="fa-solid fa-circle-info"></i> Folder Info
                                    </div>
                                </li>
                                <li>
                                    <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                </li>
                                <li>
                                    <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <i class="fa-solid fa-trash-can"></i> Move to Trash
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- File toggle button --}}
            <label class="text-lg md:text-xl font-bold max-w-xs" onclick="fileToggle()">Files
                <i class="fa-solid fa-angle-down" id="fileOpen"></i>
                <i class="fa-solid fa-angle-up hidden" id="fileClose"></i>
            </label>

            {{-- File list --}}
            <div id="fileDiv" class="grid grid-cols-2 lg:grid-cols-5 gap-2">
                <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="pt-5 px-5">
                        <img class="rounded-xl h-32 md:h-42 w-full" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Image_created_with_a_mobile_phone.png/1024px-Image_created_with_a_mobile_phone.png" alt="" />
                    </div>
                    <div class="p-4">
                        <div class="flex flex-row justify-between">
                            <h5 class="font-bold tracking-tight text-gray-900 dark:text-white">2021</h5>
                            <button id="fileDropdownButton" data-dropdown-toggle="fileDropdownDivider" class="text-white focus:ring-4 focus:outline-none focus:ring-transparent hover:bg-gray-500 font-medium rounded-full text-sm px-3.5 py-2 text-center inline-flex items-center" type="button">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>

                            <!-- File menu -->
                            <div id="fileDropdownDivider" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="fileDropdownButton">
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-eye"></i> Preview
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-download"></i> Download
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-pen-to-square"></i> Rename
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-user-plus"></i> Share
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-folder-open"></i> Organize
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-circle-info"></i> Folder Info
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-trash-can"></i> Move to Trash
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <p class="font-normal text-xs text-gray-700 dark:text-gray-400">0 MB</p>
                    </div>
                </div>

                <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="pt-5 px-5">
                        <span class="rounded-xl h-32 md:h-42 w-full bg-gray-900 dark:bg-gray-700 flex items-center justify-center">
                            <i class="fa-solid fa-file-word text-white text-6xl"></i>
                        </span>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-row justify-between">
                            <h5 class="font-bold tracking-tight text-gray-900 dark:text-white">2021</h5>
                            <button id="fileDropdownButton" data-dropdown-toggle="fileDropdownDivider" class="text-white focus:ring-4 focus:outline-none focus:ring-transparent hover:bg-gray-500 font-medium rounded-full text-sm px-3.5 py-2 text-center inline-flex items-center" type="button">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>

                            <!-- File menu -->
                            <div id="fileDropdownDivider" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="fileDropdownButton">
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-eye"></i> Preview
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-download"></i> Download
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-pen-to-square"></i> Rename
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-user-plus"></i> Share
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-folder-open"></i> Organize
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-circle-info"></i> Folder Info
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-trash-can"></i> Move to Trash
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <p class="font-normal text-xs text-gray-700 dark:text-gray-400">0 MB</p>
                    </div>
                </div>

                <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="pt-5 px-5">
                        <span class="rounded-xl h-32 md:h-42 w-full bg-gray-900 dark:bg-gray-700 flex items-center justify-center">
                            <i class="fa-solid fa-file-excel text-white text-6xl"></i>
                        </span>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-row justify-between">
                            <h5 class="font-bold tracking-tight text-gray-900 dark:text-white">2021</h5>
                            <button id="fileDropdownButton" data-dropdown-toggle="fileDropdownDivider" class="text-white focus:ring-4 focus:outline-none focus:ring-transparent hover:bg-gray-500 font-medium rounded-full text-sm px-3.5 py-2 text-center inline-flex items-center" type="button">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>

                            <!-- File menu -->
                            <div id="fileDropdownDivider" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="fileDropdownButton">
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-eye"></i> Preview
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-download"></i> Download
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-pen-to-square"></i> Rename
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-user-plus"></i> Share
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-folder-open"></i> Organize
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-circle-info"></i> Folder Info
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-trash-can"></i> Move to Trash
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <p class="font-normal text-xs text-gray-700 dark:text-gray-400">0 MB</p>
                    </div>
                </div>

                <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="pt-5 px-5">
                        <span class="rounded-xl h-32 md:h-42 w-full bg-gray-900 dark:bg-gray-700 flex items-center justify-center">
                            <i class="fa-solid fa-file-pdf text-white text-6xl"></i>
                        </span>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-row justify-between">
                            <h5 class="font-bold tracking-tight text-gray-900 dark:text-white">2021</h5>
                            <button id="fileDropdownButton" data-dropdown-toggle="fileDropdownDivider" class="text-white focus:ring-4 focus:outline-none focus:ring-transparent hover:bg-gray-500 font-medium rounded-full text-sm px-3.5 py-2 text-center inline-flex items-center" type="button">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>

                            <!-- File menu -->
                            <div id="fileDropdownDivider" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="fileDropdownButton">
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-eye"></i> Preview
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-download"></i> Download
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-pen-to-square"></i> Rename
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-user-plus"></i> Share
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-folder-open"></i> Organize
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-circle-info"></i> Folder Info
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    </li>
                                    <li>
                                        <div class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <i class="fa-solid fa-trash-can"></i> Move to Trash
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <p class="font-normal text-xs text-gray-700 dark:text-gray-400">0 MB</p>
                    </div>
                </div>

            </div>
        </div>

        <div id="tableDiv" class="relative overflow-x-auto hidden">
            <table id="dataTable" class="w-full text-sm">
                <thead class="text-xs">
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Size
                        </th>
                        <th>
                            Owner
                        </th>
                        <th>
                            Last Modified
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Apple MacBook Pro 17"
                        </td>
                        <td>
                            Silver
                        </td>
                        <td>
                            Laptop
                        </td>
                        <td>
                            $2999
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

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

        const folderToggle = () => {
            const folderDiv = document.getElementById("folderDiv");
            const folderOpen = document.getElementById("folderOpen");
            const folderClose = document.getElementById("folderClose");

            // Toggle hidden class to show/hide
            folderDiv.classList.toggle("hidden");

            // Toggle icons
            folderOpen.classList.toggle("hidden");
            folderClose.classList.toggle("hidden");
        }

        const fileToggle = () => {
            const fileDiv = document.getElementById("fileDiv");
            const fileOpen = document.getElementById("fileOpen");
            const fileClose = document.getElementById("fileClose");

            // Toggle hidden class to show/hide
            fileDiv.classList.toggle("hidden");

            // Toggle icons
            fileOpen.classList.toggle("hidden");
            fileClose.classList.toggle("hidden");
        }
    </script>

@endsection
