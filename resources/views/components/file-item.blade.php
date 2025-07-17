@props(['id', 'name', 'path'])
    <div class="max-w-xs bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="pt-5 px-5">
            @php
                $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $file = storage_path('app/public/uploads/' . $path);
                $size = filesize($file);

                if (in_array($extension, ['jpeg', 'jpg', 'png', 'webp'])) {
                    $display = '<img class="rounded-xl h-32 md:h-42 w-full" src="' . asset('storage/uploads/' . $path) . '" alt="' . $name . '" />';
                } elseif (in_array($extension, ['doc', 'docx'])) {
                    $display = '
                        <span class="rounded-xl h-32 md:h-42 w-full bg-gray-900 flex items-center justify-center">
                            <i class="fa-solid fa-file-word text-white text-6xl"></i>
                        </span>';
                } elseif ($extension === 'pdf') {
                    $display = '
                        <span class="rounded-xl h-32 md:h-42 w-full bg-red-600 flex items-center justify-center">
                            <i class="fa-solid fa-file-pdf text-white text-6xl"></i>
                        </span>';
                } elseif ($extension === 'xlx' || $extension === 'xlsx ') {
                    $display = '
                        <span class="rounded-xl h-32 md:h-42 w-full bg-red-600 flex items-center justify-center">
                            <i class="fa-solid fa-file-excel text-white text-6xl"></i>
                        </span>';
                } else {
                    $display = '
                        <span class="rounded-xl h-32 md:h-42 w-full bg-gray-400 flex items-center justify-center">
                            <i class="fa-solid fa-file text-white text-6xl"></i>
                        </span>';
                }
            @endphp

            {!! $display !!}
        </div>
        <div class="p-4">
            <div class="flex flex-row justify-between">
                <h5 class="font-bold tracking-tight text-gray-900">{{ $name }}</h5>
                <button id="fileDropdownButton" data-dropdown-toggle="{{ $id }}}}" class="text-white focus:ring-4 focus:outline-none focus:ring-transparent hover:bg-gray-500 font-medium rounded-full text-sm px-3.5 py-2 text-center inline-flex items-center" type="button">
                    <i class="fa-solid fa-ellipsis-vertical text-gray-700"></i>
                </button>

                <!-- File menu -->
                <div id="{{ $id }}}}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="fileDropdownButton">
                        <li>
                            <div class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fa-solid fa-eye"></i> Preview
                            </div>
                        </li>
                        <li>
                            <hr class="text-sm text-gray-700 hover:bg-gray-100">
                        </li>
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
            <p class="font-normal text-xs text-gray-700">
                {{ round($size / (1024 * 1024), 2) . " MB" }}
            </p>
        </div>
    </div>
