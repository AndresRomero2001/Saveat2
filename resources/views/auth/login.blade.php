<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- inicia sesion titulos -->
        <h1 class="text-xl font-bold mb-8">Iniciar sesión</h1>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 " name="remember">
                <span class="ms-2 text-sm text-gray-600 ">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-8">
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Navigation Links -->
        <div class="flex items-center justify-end mt-6 text-sm space-x-6">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-gray-600 hover:text-gray-900 underline">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900 underline">
                {{ __('Create account') }}
            </a>
        </div>
    </form>
</x-guest-layout>
