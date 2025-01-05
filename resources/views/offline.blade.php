<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Offline') }}
        </h2>
    </x-slot>
        <div class="p-6 text-center">

            <img
                src="{{ asset('app-icons/no-wifi.svg') }}"
                alt="No internet connection"
                class="w-24 h-24 mx-auto mb-6 text-gray-600"
            >
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                {{ __('No hay conexión a internet') }}
            </h2>
            <p class="text-gray-600">
                {{ __('Por favor, comprueba tu conexión e inténtalo de nuevo.') }}
            </p>
        </div>
</x-guest-layout>
