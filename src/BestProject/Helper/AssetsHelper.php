<?php

namespace BestProject\Helper;

use BestProject\Helper\ThemeHelper;
use Exception;
use RuntimeException;

/**
 * Vite Assets management helper.
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
        $entrypoints = self::getEntryPoints();

        // If there is anything from this entrypoint
        if (array_key_exists($name, $entrypoints)) {

            $entrypoint = &$entrypoints[$name];

            self::importAsset($entrypoint['file'], $defer);
        }
    }

    /**
     * @throws Exception
     */
    private static function importAsset(string $name, bool $defer = false): void
    {
        $manifest = self::getManifest();

        if( array_key_exists($name, $manifest) ) {
            $asset = $manifest[$name];

            if( !empty($asset['imports']) ) {
                foreach($asset['imports'] as $script) {
                    self::importAsset($script, $defer);
                }
            }

            if( !empty($asset['css']) ) {
                foreach($asset['css'] as $stylesheet) {
                    self::importAsset($stylesheet, $defer);
                }
            }

            if( str_ends_with($name, '.js') ) {
                self::enqueueJavaScript($name, $asset['file'], $defer);

//                $handle = pathinfo($name, PATHINFO_FILENAME);
//                wp_enqueue_script($handle, self::getAssetUrl($asset['file']), [], null, $defer ? ['strategy'=>'defer'] : true);
            }

            if( str_ends_with($name, '.css') ) {
                $handle = pathinfo($name, PATHINFO_FILENAME);

                if( !$defer ) {
                    wp_enqueue_style($handle, self::getAssetUrl($asset['file']), [], null);
                } else {
                    self::enqueueDeferredStyle(self::getAssetUrl($asset['file']));
                }
            }
        } else {

            if( str_ends_with($name, '.js') ) {
                self::enqueueJavaScript($name, $name, $defer);
//                $handle = pathinfo($name, PATHINFO_FILENAME);
//                wp_enqueue_script($handle, self::getAssetUrl($name), [], null, $defer ? ['strategy'=>'defer'] : true);
            }

            if( str_ends_with($name, '.css') ) {
                $handle = pathinfo($name, PATHINFO_FILENAME);

                if( !$defer ) {
                    wp_enqueue_style($handle, self::getAssetUrl($name), [], null);
                } else {
                    self::enqueueDeferredStyle(self::getAssetUrl($name));
                }
            }

        }
    }

    private static function enqueueJavaScript(string $handle, string $file, bool $defer = false): void
    {
        $handle = pathinfo($handle, PATHINFO_FILENAME);
        wp_enqueue_script($handle, self::getAssetUrl($file), [], null, $defer ? ['strategy'=>'defer'] : true);
        add_filter('script_loader_tag', static function($html, $script_handle) use ($handle) {
            if ($script_handle===$handle) {
                return str_ireplace(" src=", ' type=\'module\' src=', $html);
            }

            return $html;
        }, 10,2);
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
        add_filter('style_loader_tag', static function($html, $style_handle) use ($handle) {
            if ($style_handle===$handle) {
                return str_ireplace(" media='all'", ' media=\'none\' onLoad=\'this.media="all"\'', $html).'<noscript>'.PHP_EOL.$html.'</noscript>'.PHP_EOL;
            }

            return $html;
        }, 10,2);
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
            $manifest = self::getManifest();

            foreach( $manifest as $file => $entrypoint ) {
                if( $entrypoint['isEntry'] ?? false) {
                    static::$entrypointsCache[$entrypoint['name']] = $entrypoint;
                }
            }
        }

        return static::$entrypointsCache;
    }

    private static function getImports(array $entry): array
    {
        $imports = [];

        if( !empty($entry['imports']) ) {
            $imports = [...$imports, ...array_map(static fn($name) => pathinfo($name, PATHINFO_FILENAME), $entry['imports'])];
        }

        if( !empty($entry['css']) ) {
            $imports = [...$imports, ...array_map(static fn($name) => pathinfo($name, PATHINFO_FILENAME), $entry['css'])];
        }

        return $imports;
    }

    /**
     * Get asset url using manifest.json build by webpack in /templates/THEME_NAME/assets/build.
     *
     * @param   string  $file      Internal URL (eg. templates/test/assets/build/theme.css)
     *
     * @return string
     *
     * @throws Exception
     */
    public static function getAssetUrl(string $file): string
    {
        $manifest    = static::getManifest();

        foreach($manifest as $key => $details) {
            if( !array_key_exists('names', $details) && !array_key_exists('file', $details) ) {
                continue;
            }

            if( array_key_exists('names', $details) && in_array($file, $details['names'], true) ) {
                return '/wp-content/themes/' . ThemeHelper::getTheme() . '/assets/' . $details['file'];
            }

            if( array_key_exists('src', $details) && $details['src']===$file ) {
                return '/wp-content/themes/' . ThemeHelper::getTheme() . '/assets/' . $details['file'];
            }
        }

        return '/wp-content/themes/' . ThemeHelper::getTheme() . '/assets/' . $file;
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
    private static function getManifest(): array
    {
        if (static::$manifestCache === []) {
            $manifest_file = '/' . ThemeHelper::getTheme() . '/assets/.vite/manifest.json';
            $manifest_path = get_theme_root() . $manifest_file;

            static::$manifestCache = [];
            if (file_exists($manifest_path)) {
                static::$manifestCache = json_decode(file_get_contents($manifest_path), true, 512, JSON_THROW_ON_ERROR);

                foreach(static::$manifestCache as $key => $asset) {
                    if( array_key_exists('name', $asset) ) {
                        static::$manifestCache[ $asset['name'] ] = $asset;
                    }

                    if( array_key_exists('names', $asset) ) {
                        array_walk($asset['names'], static function($name) use ($asset){
                            static::$manifestCache[ $name ] = $asset;
                        });
                    }

                    if( array_key_exists('file', $asset) ) {
                        static::$manifestCache[ $asset['file'] ] = $asset;
                    }

                    if( array_key_exists('src', $asset) ) {
                        static::$manifestCache[ $asset['src'] ] = $asset;
                    }
                }

            } else {
                throw new RuntimeException("File /wp-content/themes{$manifest_file} not found. Build theme assets 'npm run prod'");
            }
        }

        return static::$manifestCache;
    }

}
