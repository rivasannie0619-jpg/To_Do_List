<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">

            {{-- LEFT SIDE: Branding --}}
            <div class="hidden lg:flex lg:w-1/2 bg-gray-900 relative overflow-hidden flex-col justify-between p-12">
                <div class="relative z-10">
                    <a href="/" class="flex items-center gap-2 text-white">
                        <x-application-logo class="w-10 h-10 fill-current text-white" />
                        <span class="text-lg font-semibold">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <div class="relative z-10">
                    <h1 class="text-4xl font-bold text-white leading-tight mb-4">
                        Organize your day,<br>one task at a time.
                    </h1>
                    <p class="text-gray-400 text-lg">
                        Track the status, priority, and deadline of everything you need to do — all in one place.
                    </p>
                </div>

                <div class="relative z-10 text-gray-500 text-sm">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                </div>

                {{-- Decorative background shapes --}}
                <div class="absolute -top-20 -right-20 w-96 h-96 bg-gray-800 rounded-full opacity-50"></div>
                <div class="absolute bottom-0 -left-10 w-72 h-72 bg-gray-800 rounded-full opacity-30"></div>
            </div>

            {{-- RIGHT SIDE: Form --}}
            <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-50 p-6 sm:p-12">
                <div class="w-full max-w-sm">

                    {{-- Logo, mobile only --}}
                    <div class="flex justify-center lg:hidden mb-8">
                        <a href="/">
                            <x-application-logo class="w-16 h-16 fill-current text-gray-800" />
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>