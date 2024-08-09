<?php

namespace BaseTheme\Block;

/**
 * Custom Boostrap blocks for WordPress.
 */
class Bootstrap
{
    public static function register(): void
    {
        register_block_type(get_template_directory() . '/blocks/wp/container');
        register_block_type(get_template_directory() . '/blocks/wp/row');
        register_block_type(get_template_directory() . '/blocks/wp/column');
    }
}