import Encore  from '@symfony/webpack-encore';
import { basename } from 'node:path';

const templateName = basename(import.meta.dirname);

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

let themeAssets = [
    './.dev/scss/index.scss',
    './.dev/js/theme.js',
]
if( Encore.isDev() ) {
    themeAssets = themeAssets.concat(['./.dev/scss/dev.scss']);
}

// Template front-end build configuration
Encore.setOutputPath('assets/build')
    .setPublicPath('/wp-content/themes/' + templateName + '/assets/build')
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSassLoader((options) => {
        options.sassOptions = {
            silenceDeprecations: [
                'import',
                'color-functions',
                'global-builtin',
                'legacy-js-api',
                'if-function',
            ],
        };
    })
    .enableVersioning(Encore.isProduction())
    .enableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    .configureBabel((config) => {}, {})
    .configureJsMinimizerPlugin((options) => {
        options.terserOptions = {
            output: {
                comments: false,
            },
            compress: {
                drop_console: true,
            },
        };
    })
    .configureCssMinimizerPlugin((options, MinimizerPlugin) => {
        options.minify = MinimizerPlugin.lightningCssMinify;
    })
    .configureImageRule({
        type: 'asset',
        maxSize: 5 * 1024, // use data URI when image size over the maxSize in kb
    })
    .autoProvidejQuery()
    .addExternals({
        jquery: 'window jQuery',
        wp: 'window wp',
    })

    .addEntry('theme', themeAssets)
    .addEntry('backtotop', ['./.dev/js/backtotop.js'])
    .addEntry('lightbox', ['./.dev/js/lightbox.js', './.dev/scss/lightbox.scss'])
    .addEntry('swiper', ['./.dev/js/swiper.js', './.dev/scss/swiper.scss'])
    .addStyleEntry('editor-styles', ['./.dev/scss/editor-styles.scss'])
    .addStyleEntry('fonts', ['./.dev/scss/fonts.scss'])

    .copyFiles({
        from: './.dev/images',
        to: '[name].[contenthash].[ext]',
    })
    .configureFilenames({
        css: '[name]-[contenthash].css',
        js: '[name]-[contenthash].js',
    });

const ThemeConfig = Encore.getWebpackConfig();
ThemeConfig.name = 'Theme';

// Export configurations
export default ThemeConfig;
