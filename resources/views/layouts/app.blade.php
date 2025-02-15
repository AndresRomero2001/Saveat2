<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#ffffff">

        <title>{{ config('app.name', 'Saveat') }}</title>

        <!-- PWA  -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Saveat">
        <link rel="apple-touch-icon" href="{{ asset('app-icons/icon-152x152.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')

        @livewireStyles

        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('app-icons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('app-icons/favicon-16x16.png') }}">
    </head>
    <body class="font-sans antialiased">
        <!-- Mobile Content -->
        <div class="min-h-screen bg-gray-100 sm:hidden pb-16">
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>

            <!-- Bottom Navigation -->
            @include('layouts.bottom-navigation')
        </div>

        <!-- Desktop/Tablet Message -->
        <div class="min-h-screen bg-gray-100 hidden sm:block">
            <x-only-mobile-msg />
        </div>

        @livewireScripts

        <!-- PWA Service Worker Registration -->
        <script>
            @if(config('app.env') === 'local')
                // Unregister service worker in development
                if ('serviceWorker' in navigator) {
                    navigator.serviceWorker.getRegistrations().then(function(registrations) {
                        for(let registration of registrations) {
                            registration.unregister();
                        }
                    });
                }
            @else
                // Register service worker in production
                if ('serviceWorker' in navigator) {
                    window.addEventListener('load', function() {
                        navigator.serviceWorker.register('/sw.js')
                            .then(function(registration) {
                                console.log('ServiceWorker registration successful');
                            })
                            .catch(function(err) {
                                console.log('ServiceWorker registration failed: ', err);
                            });
                    });
                }
            @endif
        </script>
    </body>

    @stack('scripts')
</html>
