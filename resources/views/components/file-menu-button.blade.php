@props(['id', 'prefix' => ''])

<button
    id="{{ $prefix }}fileDropdownButton{{ $id }}"
    data-dropdown-toggle="{{ $prefix }}fileDropdownMenu{{ $id }}"
    class="text-white focus:ring-4 focus:outline-none focus:ring-transparent hover:bg-gray-500 font-medium rounded-full text-sm px-3.5 py-2 text-center inline-flex items-center"
    type="button"
>
    <i class="fa-solid fa-ellipsis-vertical text-gray-700"></i>
</button>

