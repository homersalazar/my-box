@extends('layouts.app')

@section('content')
    <div class="flex flex-row gap-5 justify-center items-center w-full h-screen max-sm:px-5 ">
        <form method="POST" action="{{ route('account.login') }}" class="mx-auto w-full md:w-[320px]">
            @csrf
            <div class="text-center mb-5">
                <i class="fa-solid text-blue-700 text-5xl fa-box-archive px-2"></i>
                <span class="self-center text-5xl font-bold sm:text-5xl whitespace-nowrap">MyBox</span>
            </div>
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                    Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="me@example.com"
                    required
                />
            </div>
            <div class="mb-5">
                <label
                    for="password"
                    class="block mb-2 text-sm font-medium text-gray-900"
                >
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required
                />
            </div>
            <button
                type="submit"
                class="mb-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
                Login
            </button>
            <div class="mb-5 text-center">
                <p class="text-sm font-light text-gray-500">
                    Don't have an account? <a href="{{ route('account.signup') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Sign up</a>
                </p>
            </div>
        </form>
    </div>
@endsection
