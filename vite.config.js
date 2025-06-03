import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { glob } from 'glob';

// Получаем все изображения из папки и подпапок
const imageFiles = glob.sync('resources/images/**/*.{png,jpg,jpeg,gif,svg}', { nodir: true });

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...imageFiles, // Добавляем все найденные изображения
            ],
            refresh: true,
        })
    ],
});
