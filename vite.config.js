import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { builtinModules } from 'module';
import i18n from 'laravel-vue-i18n/vite';

const allExternal = [
    ...builtinModules,
    ...builtinModules.map((m) => `node:${m}`)
]

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        i18n()
    ],
    build: {
        rollupOptions: {
            external: ['fsevents', ...allExternal]
        }
    },
    optimizeDeps: { exclude: ['fsevents'], }
});
