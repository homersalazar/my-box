@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-2 md:gap-5 w-full">
        <h1 class="font-semibold texl-xl sm:text-2xl text-white dark:text-gray-900">Overview Storage</h1>
        <div class="flex flex-row gap-2 md:gap-5">
            <div class="flex flex-row w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 gap-3 lg:gap-5">
                <div class="flex justify-center w-10 md:w-14 bg-red-600 p-3 rounded-xl">
                    <i class="fa-solid fa-image text-white text-lg md:text-2xl"></i>
                </div>
                <div class="flex flex-col">
                    <p class="lg:text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Image</p>
                    <p class="font-normal text-gray-500 dark:text-gray-400">0 items</p>
                </div>
            </div>

            <div class="flex flex-row w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 gap-3 lg:gap-5">
                <div class="flex justify-center w-10 md:w-14 bg-yellow-600 p-3 rounded-xl">
                    <i class="fa-solid fa-file text-white text-lg md:text-2xl"></i>
                </div>
                <div class="flex flex-col">
                    <p class="lg:text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Documents</p>
                    <p class="font-normal text-gray-500 dark:text-gray-400">0 items</p>
                </div>
            </div>
        </div>
    </div>
@endsection
