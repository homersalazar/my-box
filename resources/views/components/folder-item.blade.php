@props(['title', 'id'])

<div class="block max-w-xs p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100">
    <div class="flex flex-row items-center justify-between">
        <h5 class="text-base font-bold tracking-tight text-gray-900">
            <i class="fa-solid fa-folder text-gray-900"></i> {{ $title }}
        </h5>

        <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider-{{ $id }}" class="text-white focus:ring-4 focus:outline-none focus:ring-transparent hover:bg-gray-200 font-medium rounded-full text-sm px-3.5 py-2 text-center inline-flex items-center" type="button">
            <i class="fa-solid fa-ellipsis-vertical text-gray-700"></i>
        </button>
    </div>
</div>

<!-- Folder menu -->
<div id="dropdownDivider-{{ $id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
    <ul class="py-2 text-sm text-gray-700 cursor-pointer" aria-labelledby="dropdownDividerButton">
        <li>
            <a href="{{ route('files.show_folder', $id) }}" class="block px-4 py-2 hover:bg-gray-200">
                <i class="fa-solid fa-eye"></i> Open
            </a>
        </li>
        <li>
            <a href="{{ route('files.download_folder', $id) }}" class="block px-4 py-2 hover:bg-gray-200">
                <i class="fa-solid fa-download"></i> Download
            </a>
        </li>
        <li>
            <div
                data-modal-target="editFolderModal"
                data-modal-toggle="editFolderModal"
                onclick="rename_folder('{{ $id }}', '{{ $title }}')"
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

{{-- Create --}}
<x-modal id="create-folder-modal" title="Create folder" form="createFolderForm" action="Create">
    <form action="{{ route('files.create_folder') }}" method="POST" class="space-y-4" id="createFolderForm">
        @csrf
        <div class="mb-4">
            <label for="folderName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Folder Name</label>
            <input
                type="text"
                id="folderName"
                name="folder_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter folder name"
                value="Untitled folder"
                required
            >
        </div>
    </form>
</x-modal>

{{-- Rename --}}
<x-modal id="editFolderModal" title="Rename" form="editFolderForm" action="Update">
    <form method="POST" id="editFolderForm">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="edit_folder" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Folder Name</label>
            <input
                type="text"
                id="edit_folder"
                name="folder_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter folder name"
                value="Untitled folder"
                required
            >
        </div>
    </form>
</x-modal>

<script>
    const rename_folder = (id, folder_name) => {
        document.getElementById('edit_folder').value = folder_name;

        $("#editFolderForm").off("submit").on("submit", function (e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: `/files/rename_folder/${id}`,
                method:"POST",
                data: formData,
                success:function(data){
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    }).then((result) => {
                        window.location.reload();
                    });
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
</script>
