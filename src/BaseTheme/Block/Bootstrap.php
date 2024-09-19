<?php

namespace BaseTheme\Block;

use Exception;

/**
 * Custom Boostrap blocks for WordPress.
 */
class Bootstrap
{
    /**
     * @throws Exception
     */
    public static function register(): void
    {
        self::registerBlock(get_template_directory() . '/blocks/wp/container');
        self::registerBlock(get_template_directory() . '/blocks/wp/row');
        self::registerBlock(get_template_directory() . '/blocks/wp/column');
    }

    /**
     * @throws Exception
     */
    private static function registerBlock(string $path): void {
        if( is_dir($path) ) {
            register_block_type($path);
        } else {
            throw new \RuntimeException('Block ' . $path . ' does not exist.');
        }
    }
}