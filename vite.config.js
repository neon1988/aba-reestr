import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/images/logo_118.png',
                'resources/images/logo_236.png',
                'resources/images/logo_1200.png',
                'resources/images/IBAO_CEU_Provider.png',
                'resources/images/materials.jpg',
                'resources/images/supervisia.jpg',
                'resources/images/forums.jpg',
            ],
            refresh: true,
        })
    ],
});
