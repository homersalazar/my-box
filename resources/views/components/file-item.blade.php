@props(['id', 'name', 'path'])
    <div class="max-w-xs bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
        <div class="pt-5 px-5">
            @php
                $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $file = storage_path('app/public/uploads/' . $path);
                $bytes = filesize($file);

                if ($bytes === 0) {
                    $file_size = '0 Bytes';
                }

                $k = 1024;
                $sizes = ['Bytes', 'KB', 'MB', 'GB'];

                $i = floor(log($bytes, $k));
                $file_size = round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];

                if (in_array($extension, ['jpeg', 'jpg', 'png', 'webp'])) {
                    $display = '<img class="rounded-xl h-32 md:h-42 w-full object-contain" src="' . asset('storage/uploads/' . $path) . '" alt="' . $name . '" />';
                } elseif (in_array($extension, ['doc', 'docx'])) {
                    $display = '
                        <span class="rounded-xl h-32 md:h-42 w-full bg-gray-100 flex items-center justify-center">
                            <i class="fa-solid fa-file-word text-blue-500 text-6xl"></i>
                        </span>';
                } elseif ($extension === 'pdf') {
                    $display = '
                        <span class="rounded-xl h-32 md:h-42 w-full bg-gray-100 flex items-center justify-center">
                            <i class="fa-solid fa-file-pdf text-red-500 text-6xl"></i>
                        </span>';
                } elseif ($extension === 'xls' || $extension === 'xlsx') {
                    $display = '
                        <span class="rounded-xl h-32 md:h-42 w-full flex items-center justify-center bg-gray-100">
                            <i class="fa-solid fa-file-excel text-green-600 text-6xl"></i>
                        </span>';
                } else {
                    $display = '
                        <span class="rounded-xl h-32 md:h-42 w-full bg-gray-100 flex items-center justify-center">
                            <i class="fa-solid fa-file text-gray-600 text-6xl"></i>
                        </span>';
                }
            @endphp

            {!! $display !!}
        </div>
        <div class="p-4">
            <div class="flex flex-row justify-between gap-2">
                <h5 class="font-bold tracking-tight text-gray-900">{{ $name }}</h5>
                <div>
                    {{ $slot }}
                </div>
            </div>
            <p class="font-normal text-xs text-gray-700">
                {{ $file_size }}
            </p>
        </div>
    </div>
