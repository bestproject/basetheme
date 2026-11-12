<?php

namespace BestProject\Block;

use Exception;

/**
 * Custom Boostrap blocks for WordPress.
 */
class BootstrapCollection
{
    /**
     * @throws Exception
     */
    public static function register(): void
    {
        wp_register_block_types_from_metadata_collection(
            dirname(__DIR__, 3) . '/blocks/wp',
            dirname(__DIR__, 3) . '/blocks/wp/blocks-manifest.php'
        );


        wp_set_script_translations( 'bootstrap-container-editor-script', 'bestproject', get_theme_file_path(  ) . '/languages/' );
        wp_set_script_translations( 'bootstrap-row-editor-script', 'bestproject', get_theme_file_path(  ) . '/languages/' );
        wp_set_script_translations( 'bootstrap-column-editor-script', 'bestproject', get_theme_file_path(  ) . '/languages/' );
    }
}