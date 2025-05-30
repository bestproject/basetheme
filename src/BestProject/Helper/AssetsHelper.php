<?php

namespace BestProject\Helper;

use Exception;
use RuntimeException;

/**
 * Assets management helper.
 */
abstract class AssetsHelper
{

    /**
     * Manifest cache avoiding multiple disc reads.
     *
     * @var array
     */
    private static array $manifestCache = [];


    /**
     * Entry points cache.
     *
     * @var array
     */
    private static array $entrypointsCache = [];

    /**
     * Include entry point assets from manifest file.
     *
     * @param   string  $name  Name of the entry point.
     *
     *
     * @throws Exception
     */
    public static function addEntryPointAssets(string $name, bool $defer = false): void
    {
        $entrypoints = self::getEntryPoints()['entrypoints'];

        // If there is anything from this entrypoint
        if (array_key_exists($name, $entrypoints)) {

            $entrypoint = $entrypoints[$name];

            // If there are js scripts in this entry point
            if (array_key_exists('js', $entrypoint)) {
                foreach ($entrypoint['js'] as $path) {

                    $asset_url = site_url().self::getAssetUrl($path);
                    wp_enqueue_script(pathinfo($path, PATHINFO_FILENAME), $asset_url, ['jquery'], false, true);

                    // Deffer the script
                    if( $defer ) {
                        add_filter('script_loader_tag', static function($html) use ($asset_url) {
                            if (stripos($html, $asset_url)!==false) {
                                return str_ireplace(' />', ' defer />', $html);
                            }

                            return $html;
                        }, 10,1);
                    }
                }
            }

            // If there are css styles in this entry point
            if (array_key_exists('css', $entrypoint)) {
                foreach ($entrypoint['css'] as $path) {

                    $asset_url = site_url().self::getAssetUrl($path);
                    wp_enqueue_style(pathinfo($path, PATHINFO_FILENAME), $asset_url);

                    // Deffer the stylesheet
                    if( $defer ) {
                        add_filter('style_loader_tag', static function($html) use ($asset_url) {
                            if (stripos($html, $asset_url)!==false) {
                                return str_ireplace(" media='all'", ' media=\'none\' onLoad=\'this.media="all"\'', $html).'<noscript>'.PHP_EOL.$html.'</noscript>'.PHP_EOL;
                            }

                            return $html;
                        }, 10,1);
                    }
                }
            }
        }
    }

    /**
     * Enqueue and deffer a stylesheet.
     *
     * @param   string  $asset_url  Asset URL.
     * @param   string  $handle     Handle name.
     *
     * @return void
     */
    public static function enqueueDeferredStyle(string $asset_url, string $handle = ''): void
    {

        // Create a handle if required
        if( empty($handle) ) {
            $handle = basename($asset_url);
        }

        // Enqueue a stylesheet
        wp_enqueue_style($handle, $asset_url, [], null);

        // Deffer the loading
        add_filter('style_loader_tag', static function($html) use ($handle) {
            if (stripos($html, $handle.'-css')!==false) {
                return str_ireplace(" media='all'", ' media=\'none\' onLoad=\'this.media="all"\'', $html).'<noscript>'.PHP_EOL.$html.'</noscript>'.PHP_EOL;
            }

            return $html;
        }, 10,1);
    }

    /**
     * Get entry points array.
     *
     * @return array
     * @throws Exception
     */
    public static function getEntryPoints(): array
    {
        if (static::$entrypointsCache === []) {
            $entrypoints_file = '/' . ThemeHelper::getTheme() . '/assets/build/entrypoints.json';
            $entrypoints_path = get_theme_root() . $entrypoints_file;
            if (file_exists($entrypoints_path)) {
                static::$entrypointsCache = json_decode(file_get_contents($entrypoints_path), true, 512,
                    JSON_THROW_ON_ERROR);
            } else {
                throw new RuntimeException("File /wp-content/themes{$entrypoints_file} not found. Build theme assets 'npm run prod'");
            }
        }

        return static::$entrypointsCache;
    }

    /**
     * Get asset url using manifest.json build by webpack in /templates/THEME_NAME/assets/build.
     *
     * @param   string  $url       Internal URL (eg. templates/test/assets/build/theme.css)
     * @param   bool    $relative  If $relative is set to TRUE $url will be treated as relative to theme assets url (eg. wp-content/themes/some_theme/assets/build will be added as a prefix to $url).
     *
     * @return string
     *
     * @throws Exception
     */
    public static function getAssetUrl(string $url, bool $relative = false): string
    {
        if ($relative) {
            $url = 'wp-content/themes/' . ThemeHelper::getTheme() . '/assets/build/' . ltrim($url, '/');
        }
        $public_url  = $url;
        $manifest    = static::getManifest();
        $relativeUrl = ltrim($url, '/');

        if (array_key_exists($relativeUrl, $manifest)) {
            $public_url = $manifest[$relativeUrl];
        }

        return $public_url;
    }



    /**
     * Get asset absolute path.
     *
     * @param   string  $url       Internal URL (eg. templates/test/assets/build/theme.css)
     * @param   bool    $relative  If $relative is set to TRUE $url will be treated as relative to theme assets url (eg. wp-content/themes/some_theme/assets/build will be added as a prefix to $url).
     *
     * @return string
     *
     * @throws Exception
     */
    public static function getAssetPath(string $url, bool $relative = false): string
    {
        return ABSPATH.ltrim(self::getAssetUrl($url, $relative), '/');
    }

    /**
     * Get asset version hash.
     *
     * @param   string  $url
     * @param   bool    $relative
     *
     * @return string
     * @throws Exception
     */
    public static function getAssetVersion(string $url, bool $relative = false): string
    {
        return crc32(self::getAssetUrl($url, $relative));
    }

    /**
     * Return manifest array.
     *
     * @return array
     *
     * @throws Exception
     */
    public static function getManifest(): array
    {
        if (static::$manifestCache === []) {
            $manifest_file = '/' . ThemeHelper::getTheme() . '/assets/build/manifest.json';
            $manifest_path = get_theme_root() . $manifest_file;

            static::$manifestCache = [];
            if (file_exists($manifest_path)) {
                static::$manifestCache = json_decode(file_get_contents($manifest_path), true, 512, JSON_THROW_ON_ERROR);
            } else {
                throw new RuntimeException("File /wp-content/themes{$manifest_file} not found. Build theme assets 'npm run prod'");
            }
        }

        return static::$manifestCache;
    }

}
