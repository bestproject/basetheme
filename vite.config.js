import { resolve, basename } from 'path'
import { defineConfig } from 'vite'

export default defineConfig(({mode})=>{

    return {
        base: '/wp-content/themes/'+basename(__dirname)+'/assets',
        root: resolve(__dirname, '.'),
        build: {
            emptyOutDir: true,
            outDir: 'assets',
            assetsDir: 'build',
            chunkSizeWarningLimit: 500,
            assetsInlineLimit: 1024*3,
            manifest: true,
            sourcemap: mode === 'development',
            cssMinify: mode !== 'development',
            minify: mode !== 'development',
            rolldownOptions: {
                input: [
                    '.dev/js/backtotop.js',
                    '.dev/js/dev.js',
                    '.dev/js/editor.js',
                    '.dev/js/lightbox.js',
                    '.dev/js/theme.js',
                    '.dev/scss/editor-styles.scss',
                    '.dev/scss/fonts.scss',
                ],
                external: ['jquery', 'wp'],
                output: {
                    globals: {
                        jquery: 'jQuery',
                        wp: 'wp',
                    },
                },
            }
        },
        css: {
            preprocessorOptions: {
                scss: {
                    silenceDeprecations: [
                        'import',
                        'color-functions',
                        'global-builtin',
                        'legacy-js-api',
                        'if-function'
                    ],
                },
            },
        },
        resolve: {
            alias: {
                '~bootstrap': resolve(__dirname, 'node_modules/bootstrap'),
                '~@fortawesome': resolve(__dirname, 'node_modules/@fortawesome'),
                '~@fontsource': resolve(__dirname, 'node_modules/@fontsource'),
            }
        }
    }
})
