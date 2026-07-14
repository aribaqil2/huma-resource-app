<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>

            {{-- logo login --}}
            <a href="/">
                <svg class="w-20 h-20 fill-current text-gray-500" viewBox="0 0 100 100"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M30 25H55C66 25 70 32 70 40C70 48 64 52 55 52H42V75" fill="none" stroke="currentColor"
                        stroke-width="8" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M42 52L68 75" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M50 25C40 25 30 35 30 50C30 65 40 75 50 75" fill="none" stroke="currentColor"
                        stroke-width="8" stroke-linecap="round" />
                </svg>
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
