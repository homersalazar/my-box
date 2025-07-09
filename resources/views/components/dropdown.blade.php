@props([
    'buttonId' => 'dropdownDefaultButton',
    'dropdownId' => 'dropdown',
    'title' => 'Create'
])

<div class="relative inline-block text-left">
    <button id="{{ $buttonId }}" data-dropdown-toggle="{{ $dropdownId }}" data-dropdown-placement="left" type="button"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        {!! $title !!}
    </button>

    <div id="{{ $dropdownId }}"
        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 absolute mt-2">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="{{ $buttonId }}">
            {{ $slot }}
        </ul>
    </div>
</div>
