import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/layout.css', // 共通
                'resources/css/home.css',   // ホーム用
                'resources/css/book.css',   // 書籍用
                'resources/js/app.js','resources/css/app.css'   // もとからあったもの
            ],
            refresh: true,
        }),
    ],
});
