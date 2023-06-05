const Encore = require('@symfony/webpack-encore');
const path = require('path');

const templateName = path.basename(__dirname);

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

let themeAssets = [
    './.dev/scss/index.scss',
    './.dev/js/theme.js',
]
if( Encore.isDev() ) {
    themeAssets = themeAssets.concat(['./.dev/scss/dev.scss']);
    themeAssets = themeAssets.concat(['./.dev/js/dev.js']);
}

// Template front-end build configuration
Encore
    .setOutputPath('assets/build')
    .setPublicPath('/wp-content/themes/'+templateName+'/assets/build')
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSassLoader()
    .enableVersioning(Encore.isProduction())
    .enableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    .configureBabel((config) => {
        config.plugins.push("@babel/plugin-proposal-class-properties")
    }, {
        includeNodeModules: ['swiper','dom7','ssr-window'],
        useBuiltIns: 'usage',
        corejs: 3,
    })
    .autoProvidejQuery()
    .enablePostCssLoader()
    .addExternals({
        jquery: 'jQuery',
        wp: 'wp'
    })
    .addEntry('theme',
        themeAssets
    )
    .addEntry('backtotop', [
        './.dev/js/backtotop.js'
    ])
    .addEntry('lightbox', [
        './.dev/js/lightbox.js'
    ])
    .addStyleEntry('editor-styles', [
        './.dev/scss/editor-styles.scss'
    ])
    .addStyleEntry('fontawesome', [
        './.dev/scss/fontawesome.scss'
    ])
    .copyFiles({
        from: './.dev/images',
        to: '[name].[contenthash].[ext]'
    })
    .configureFilenames({
        css: '[name]-[contenthash].css',
        js: '[name]-[contenthash].js'
    });

const ThemeConfig = Encore.getWebpackConfig();
ThemeConfig.name = 'Theme';

// Export configurations
module.exports = [ThemeConfig];
