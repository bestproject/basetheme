<?php

namespace BestProject\Helper;

use Exception;

/**
 * Assets management helper.
 *
 * @since 1.0.0
 */
abstract class AssetsHelper
{

    /**
     * Manifest cache avoiding multiple disc reads.
     *
     * @var array
     *
     * @since 1.5.0
     */
    private static array $manifestCache = [];


    /**
     * Entry points cache.
     *
     * @var array
     *
     * @since 1.5.0
     */
    private static array $entrypointsCache = [];

    /**
     * Include entry point assets from manifest file.
     *
     * @param   string  $name  Name of the entry point.
     *
     *
     * @throws Exception
     * @since 1.0.0
     */
    public static function addEntryPointAssets(string $name): void
    {
        $entrypoints = self::getEntryPoints()['entrypoints'];

        // If there is anything from this entrypoint
        if (array_key_exists($name, $entrypoints)) {

            $entrypoint = $entrypoints[$name];

            // If there are js scripts in this entry point
            if (array_key_exists('js', $entrypoint)) {
                foreach ($entrypoint['js'] as $path) {
                    wp_enqueue_script(basename($path), self::getAssetUrl($path), ['jquery'], false, true);
                }
            }

            // If there are css styles in this entry point
            if (array_key_exists('css', $entrypoint)) {
                foreach ($entrypoint['css'] as $path) {
                    wp_enqueue_style(basename($path), self::getAssetUrl($path));
                }
            }
        }
    }

    /**
     * Get entry points array.
     *
     * @return array
     * @throws Exception
     *
     * @since 1.5
     */
    public static function getEntryPoints(): array
    {
        if (static::$entrypointsCache === []) {
            $entrypoints_path = get_theme_root() . '/' . ThemeHelper::getTheme() . '/assets/build/entrypoints.json';
            if (file_exists($entrypoints_path)) {
                static::$entrypointsCache = json_decode(file_get_contents($entrypoints_path), true, 512,
                    JSON_THROW_ON_ERROR);
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
     *
     * @since 1.0.0
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
     * Return manifest array.
     *
     * @return array
     *
     * @throws Exception
     *
     * @since 1.0.0
     */
    public static function getManifest(): array
    {
        if (static::$manifestCache === []) {
            $manifest_path = get_theme_root() . '/' . ThemeHelper::getTheme() . '/assets/build/manifest.json';

            static::$manifestCache = [];
            if (file_exists($manifest_path)) {
                static::$manifestCache = json_decode(file_get_contents($manifest_path), true, 512, JSON_THROW_ON_ERROR);
            }
        }

        return static::$manifestCache;
    }

}