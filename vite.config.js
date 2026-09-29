import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({

    server: {
        host: '0.0.0.0', // Autorise les connexions externes
        hmr: {
            host: 'qascd-195-83-154-230.a.free.pinggy.link', // Ton URL Pinggy
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
