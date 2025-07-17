@props(['title', 'id'])

<div class="block max-w-xs p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100">
    <div class="flex flex-row items-center justify-between">
        <h5 class="text-base font-bold tracking-tight text-gray-900">
            <i class="fa-solid fa-folder text-gray-900"></i> {{ $title }}
        </h5>

        <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider-{{ $id }}" class="text-white focus:ring-4 focus:outline-none focus:ring-transparent hover:bg-gray-500 font-medium rounded-full text-sm px-3.5 py-2 text-center inline-flex items-center" type="button">
            <i class="fa-solid fa-ellipsis-vertical text-gray-700"></i>
        </button>
    </div>
</div>
