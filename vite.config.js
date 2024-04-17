import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
// import reactRefresh from '@vitejs/plugin-react-refresh';

export default defineConfig({
    plugins: [
        react(),
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '192.168.56.33',
        mimetype: 'text/html',
        watch: {
            usePolling: true,
        },
    },
});
