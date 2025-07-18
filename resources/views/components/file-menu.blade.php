@props(['id', 'prefix' => ''])
    <div
        id="{{ $prefix }}fileDropdownMenu{{ $row->id }}"
        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44"
    >
        <ul class="py-2 text-sm text-gray-700 cursor-pointer" aria-labelledby="{{ $prefix }}fileDropdownButton{{ $row->id }}">
            <li>
                <div class="block px-4 py-2 hover:bg-gray-200">
                    <i class="fa-solid fa-eye"></i> Preview
                </div>
            </li>
            <li>
                <hr class="text-sm text-gray-700 hover:bg-gray-200">
            </li>
            <li>
                <div class="block px-4 py-2 hover:bg-gray-200">
                    <i class="fa-solid fa-download"></i> Download
                </div>
            </li>
            <li>
                <div class="block px-4 py-2 hover:bg-gray-200">
                    <i class="fa-solid fa-pen-to-square"></i> Rename
                </div>
            </li>
            <li>
                <hr class="text-sm text-gray-700 hover:bg-gray-200">
            </li>
            <li>
                <div class="block px-4 py-2 hover:bg-gray-200">
                    <i class="fa-solid fa-user-plus"></i> Share
                </div>
            </li>
            <li>
                <div class="block px-4 py-2 hover:bg-gray-200">
                    <i class="fa-solid fa-folder-open"></i> Organize
                </div>
            </li>
            <li>
                <div class="block px-4 py-2 hover:bg-gray-200">
                    <i class="fa-solid fa-circle-info"></i> Folder Info
                </div>
            </li>
            <li>
                <hr class="text-sm text-gray-700 hover:bg-gray-200">
            </li>
            <li>
                <div class="block px-4 py-2 hover:bg-gray-200">
                    <i class="fa-solid fa-trash-can"></i> Move to Trash
                </div>
            </li>
        </ul>
    </div>

