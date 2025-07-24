@props(['id', 'prefix' => '', 'name', 'path'])
<div
    id="{{ $prefix }}fileDropdownMenu{{ $row->id }}"
    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg border shadow-md w-44"
>
    @php
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $fullPath = asset('/storage/uploads/' . $path);

    @endphp

    <ul class="py-2 text-sm text-gray-700 cursor-pointer" aria-labelledby="{{ $prefix }}fileDropdownButton{{ $row->id }}">
        <li>
            @if (in_array($extension, ['jpeg', 'jpg', 'png', 'webp']))
                <div
                    class="block px-4 py-2 hover:bg-gray-200"
                    data-modal-target="previewImageModal"
                    data-modal-toggle="previewImageModal"
                    onclick="updateImagePreview('{{ $fullPath }}', '{{ $name }}')"
                >
                    <i class="fa-solid fa-eye"></i> Preview
                </div>
            @elseif ($extension === 'pdf')
                <a href="{{ $fullPath }}" target="_blank" class="block px-4 py-2 hover:bg-gray-200">
                    <i class="fa-solid fa-eye"></i> Preview
                </a>
            @endif
        </li>
        <li>
            <hr class="text-sm text-gray-700 hover:bg-gray-200">
        </li>
        <li>
            <a href="{{ $fullPath }}" download class="block px-4 py-2 hover:bg-gray-200">
                <i class="fa-solid fa-download"></i> Download
            </a>
        </li>
        <li>
            <div
                data-modal-target="editFileModal"
                data-modal-toggle="editFileModal"
                onclick="rename_file('{{ $id }}', '{{ $name }}')"
                class="block px-4 py-2 hover:bg-gray-200"
            >
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

<x-modal id="previewImageModal" title="Preview" form="" action="" size="max-w-full">
    <div class="flex justify-center items-center">
        <img id="previewImageTag" src="" alt="" class="max-h-[80vh]">
    </div>
</x-modal>

{{-- Rename --}}
<x-modal id="editFileModal" title="Rename" form="editFileForm" action="Update" size="max-w-2xl">
    <form method="POST" id="editFileForm">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="edit_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File Name</label>
            <input
                type="text"
                id="edit_file"
                name="edit_file"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required
            >
        </div>
    </form>
</x-modal>

<script>
    if (typeof updateImagePreview === "undefined") {
        var updateImagePreview = function (src, name) {
            const img = document.getElementById('previewImageTag');
            img.src = src;
            img.alt = name;
        }
    }

    if (typeof rename_file === "undefined") {
        var rename_file = function (id, file_name) {
            document.getElementById('edit_file').value = file_name;

            $("#editFileForm").off("submit").on("submit", function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    url: `/files/rename_file/${id}`,
                    method: "POST",
                    data: formData,
                    success: function (data) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => window.location.reload());
                    },
                    error: function (error) {
                        console.error('Error update event:', error);
                        Swal.fire({
                            title: "Error!",
                            text: "An error occurred while updating the event.",
                            icon: "error"
                        });
                    }
                });
            });
        }
    }
</script>
