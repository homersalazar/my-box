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
                {{ $slot }}
            </div>
            <p class="font-normal text-xs text-gray-700">
                {{ round($size / (1024 * 1024), 2) . " MB" }}
            </p>
        </div>
    </div>
