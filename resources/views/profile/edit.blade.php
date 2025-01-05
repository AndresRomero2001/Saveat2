<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="p-4 bg-white shadow rounded-lg" id="install-app-container" style="display: none;">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('Install App') }}
                    </h3>
                    <div class="mt-3">
                        <button
                            id="installButton"
                            class="inline-flex items-center px-4 py-2 bg-primary-blue border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-primary-blue-dark focus:bg-primary-blue-dark active:bg-primary-blue-dark focus:outline-none focus:ring-2 focus:ring-primary-blue focus:ring-offset-2 transition ease-in-out duration-150"
                            style="display: none;"
                        >
                            {{ __('Install Saveat') }}
                        </button>
                        <p id="installText" class="text-sm text-gray-600" style="display: none;">
                            {{ __('App already installed') }}
                        </p>
                        <p id="notAvailableText" class="text-sm text-gray-600" style="display: none;">
                            {{ __('Installation will be available when conditions are met') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    <livewire:default-filters />
                </div>
            </div>

            <div class="p-4 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.logout-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let deferredPrompt;
        const installAppContainer = document.getElementById('install-app-container');
        const installButton = document.getElementById('installButton');
        const installText = document.getElementById('installText');
        const notAvailableText = document.getElementById('notAvailableText');

        // If already in standalone mode, don't do anything
        if (window.matchMedia('(display-mode: standalone)').matches) {
            return;
        }

        // Only show install UI when beforeinstallprompt fires
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            // Show install UI
            installAppContainer.style.display = 'block';
            installButton.style.display = 'inline-flex';
        });

        installButton.addEventListener('click', async () => {
            if (!deferredPrompt) return;

            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            deferredPrompt = null;

            // Hide container after user makes a choice
            installAppContainer.style.display = 'none';
        });

        // Hide install UI if app gets installed
        window.addEventListener('appinstalled', () => {
            installAppContainer.style.display = 'none';
        });
    </script>
    @endpush
</x-app-layout>
