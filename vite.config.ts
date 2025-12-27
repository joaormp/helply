import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.tsx',
            ],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
    build: {
        // Force new hash on every build for cache busting
        rollupOptions: {
            output: {
                entryFileNames: `assets/[name]-[hash].js`,
                chunkFileNames: `assets/[name]-[hash].js`,
                assetFileNames: `assets/[name]-[hash].[ext]`
            }
        },
        // Generate manifest in the root of build directory (not .vite subdirectory)
        manifest: 'manifest.json',
        // Output to public/build
        outDir: 'public/build',
        // Generate source maps for debugging
        sourcemap: false,
    },
    server: {
        // Disable caching in dev mode
        headers: {
            'Cache-Control': 'no-store',
        },
    },
});
