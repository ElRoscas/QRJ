import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/index.css',
                'resources/css/registre.css',
                'resources/css/menu_admin.css',
                'resources/css/menu_user.css',
                'resources/css/control_convidats.css',
                'resources/css/control_usuaris.css',
                'resources/css/info_user.css',
                'resources/css/graduacio.css',
                'resources/css/esdeveniments.css',
                'resources/css/crear_esdeveniments.css',
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