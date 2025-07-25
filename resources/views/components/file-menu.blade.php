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
            <div
                data-modal-target="shareFileModal"
                data-modal-toggle="shareFileModal"
                class="block px-4 py-2 hover:bg-gray-200"
                onclick="share_file('{{ $id }}')"
            >
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

{{-- Preview --}}
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

{{-- Share Modal --}}
<x-modal id="shareFileModal" title="Share" form="shareFileForm" action="Share" size="max-w-2xl">
    <form action="{{ route('shares.share_file') }}" method="POST" class="space-y-4" id="shareFileForm">
        @csrf
        <div class="mb-4">
            <input type="text" id="sharedFileId" name="shared_file_id">
            <input type="text" id="selectedUserIds" name="selected_user_ids" />

            <label for="shareFile" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Search Users</label>
            <input
                type="text"
                name="shareFile"
                id="shareFile"
                autocomplete="off"
                placeholder="Type to search users..."
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            >
        </div>
        <div class="relative mb-5 z-10">
            <div id="shareFileList"></div>
        </div>
        <div id="selectedUsers" class="mt-2 flex flex-wrap gap-2"></div>
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

    var selectedUserIds = [];

    var share_file = id => {
        $('#sharedFileId').val(id);
        // Reset the share modal state
        selectedUserIds = [];
        $('#selectedUsers').empty();
        $('#selectedUserIds').val('');
        $('#shareFile').val('');
        $('#shareFileList').fadeOut().html('');
    }

    function selectUser(userId, userName) {
        userId = parseInt(userId);
        if (!selectedUserIds.includes(userId)) {
            selectedUserIds.push(userId);

            // Add to DOM
            $('#selectedUsers').append(`
                <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full flex items-center gap-1">
                    ${userName}
                    <button type="button" class="remove-user" data-id="${userId}">&times;</button>
                </span>
            `);

            // Update hidden input
            $('#selectedUserIds').val(selectedUserIds.join(','));
        }

        // Clear input and hide list
        $('#shareFile').val('');
        $('#shareFileList').fadeOut(300, function() {
            $(this).html('');
        });
    }

    $(document).ready(function () {
        const shareFileList = $('#shareFileList');
        const shareFileInput = $('#shareFile');

        // Search input listener
        shareFileInput.on('input', function () {
            const query = $(this).val().trim();
            const _token = $('input[name="_token"]').val();

            if (query === '') {
                shareFileList.fadeOut().html('');
                return;
            }

            $.ajax({
                url: "{{ route('files.autocomplete') }}",
                method: "POST",
                data: { query, _token },
                success: function (data) {
                    if (data.trim() !== '') {
                        shareFileList.fadeIn().html(data);
                    } else {
                        shareFileList.fadeOut().html('');
                    }
                },
                error: function () {
                    shareFileList.fadeOut().html('');
                }
            });
        });

        // Handle user selection from dropdown
        $(document).on('click', '#shareFileList li', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Execute the onclick function if it exists
            const onclickAttr = $(this).attr('onclick');
            if (onclickAttr) {
                eval(onclickAttr);
            }
        });

        // Remove user from selected list
        $(document).on('click', '.remove-user', function () {
            const userId = parseInt($(this).data('id'));
            selectedUserIds = selectedUserIds.filter(id => id !== userId);
            $(this).parent().remove();
            $('#selectedUserIds').val(selectedUserIds.join(','));
        });

        // Hide list on outside click
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#shareFile, #shareFileList').length) {
                shareFileList.fadeOut().html('');
            }
        });

        // Hide list when input loses focus (with delay for click processing)
        shareFileInput.on('blur', function() {
            setTimeout(() => {
                if (!shareFileList.is(':hover')) {
                    shareFileList.fadeOut().html('');
                }
            }, 200);
        });
    });
</script>
