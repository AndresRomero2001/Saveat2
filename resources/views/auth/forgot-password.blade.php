<x-guest-layout>
    <div class="mb-6 text-sm text-gray-600">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Simplemente indícanos tu correo electrónico y te enviaremos un enlace para restablecer la contraseña.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-8">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button>
                {{ __('Enviar enlace de recuperación') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Navigation Links -->
    <div class="flex items-center justify-end mt-8 text-sm space-x-6">
        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 underline">
            {{ __('Iniciar sesión') }}
        </a>
        <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900 underline">
            {{ __('Crear cuenta') }}
        </a>
    </div>
</x-guest-layout>
