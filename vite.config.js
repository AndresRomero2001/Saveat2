import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true, // Clears old build files to prevent conflicts
        rollupOptions: {
            input: {
                main: 'resources/js/app.js', // Main entry point
            },
        },
    },
});
