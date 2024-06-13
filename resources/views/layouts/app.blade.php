<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} | {{ $title ?? '' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-custom1 antialiased  bg-custom-with-opacity pb-1">
        <div class="min-h-screen ">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

        </div>

        <footer class="bg-lime-300 rounded-lg shadow m-4 z-0">
            {{-- <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-center"> --}}
            <div class="w-full mx-auto max-w-screen-xl p-4 flex items-center justify-center">
                <span class="text-sm text-indigo-950 text-center">© 2024 <a href="/dashboard"
                        class="hover:underline">eSportXPert</a>. All Rights Reserved.
                </span>
                {{-- <ul
                    class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">About</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Contact</a>
                    </li>
                </ul> --}}
            </div>
        </footer>

        <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
        <script src="../path/to/flowbite/dist/datepicker.js"></script>

    </body>

</html>
