import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/registre.css', // Fitxer que uses a la vista
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        cors: true,
        hmr: {
            host: 'localhost',
        },
    },
});