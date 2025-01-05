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

        <!-- Mobile Content -->
        <div class="min-h-screen bg-gray-primary-dark sm:hidden pb-16">

            <div class="min-h-screen flex flex-col justify-center items-center mx-4">
                <div class="mb-2">
                    <img src="{{ asset('app-icons/logo-sin-fondo.png') }}" alt="Saveat" class="w-24 h-24">
                </div>

                <div class="flex flex-col items-center mb-10">
                    <h1 class="text-4xl font-bold  text-white">Saveat</h1>
                    <p class="text-md text-white">Guarda, clasifica y busca tus restaurantes</p>
                </div>

                <div class="w-full px-8 py-12 bg-white shadow-md overflow-hidden rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Desktop/Tablet Message -->
        <div class="min-h-screen bg-gray-100 hidden sm:block">
            <x-only-mobile-msg />
        </div>
    </body>
</html>
