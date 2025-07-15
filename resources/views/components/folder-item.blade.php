@props(['title', 'id'])

<div id="folderDiv" class="grid grid-cols-2 lg:grid-cols-4 gap-2">
    <div class="block max-w-xs p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100">
        <div class="flex flex-row items-center justify-between">
            <h5 class="text-base font-bold tracking-tight text-gray-900">
                <i class="fa-solid fa-folder text-gray-900"></i> {{ $title }}
            </h5>

            <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider-{{ $id }}" class="text-white focus:ring-4 focus:outline-none focus:ring-transparent hover:bg-gray-500 font-medium rounded-full text-sm px-3.5 py-2 text-center inline-flex items-center" type="button">
                <i class="fa-solid fa-ellipsis-vertical text-gray-700"></i>
            </button>

            <!-- Folder menu -->
            <div id="dropdownDivider-{{ $id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDividerButton">
                    <li>
                        <div class="block px-4 py-2 hover:bg-gray-100">
                            <i class="fa-solid fa-download"></i> Download
                        </div>
                    </li>
                    <li>
                        <div class="block px-4 py-2 hover:bg-gray-100">
                            <i class="fa-solid fa-pen-to-square"></i> Rename
                        </div>
                    </li>
                    <li>
                        <hr class="text-sm text-gray-700 hover:bg-gray-100">
                    </li>
                    <li>
                        <div class="block px-4 py-2 hover:bg-gray-100">
                            <i class="fa-solid fa-user-plus"></i> Share
                        </div>
                    </li>
                    <li>
                        <div class="block px-4 py-2 hover:bg-gray-100">
                            <i class="fa-solid fa-folder-open"></i> Organize
                        </div>
                    </li>
                    <li>
                        <div class="block px-4 py-2 hover:bg-gray-100">
                            <i class="fa-solid fa-circle-info"></i> Folder Info
                        </div>
                    </li>
                    <li>
                        <hr class="text-sm text-gray-700 hover:bg-gray-100">
                    </li>
                    <li>
                        <div class="block px-4 py-2 hover:bg-gray-100">
                            <i class="fa-solid fa-trash-can"></i> Move to Trash
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
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
</script>
