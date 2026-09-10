<?php

namespace BaseTheme\Action;

use BestProject\Helper\AssetsHelper;
use BestProject\Helper\ThemeHelper;

/**
 * Methods running on after_setup_theme action.
 *
 * @package BaseTheme\Action
 */
final class after_setup_theme
{

    /**
     * Register theme support.
     */
    public static function registerTheme(): void
    {

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * This theme does not use a hard-coded <title> tag in the document head,
         * WordPress will provide it for us.
         */

        add_theme_support( 'title-tag' );
        add_theme_support( 'excerpt' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'disable-custom-colors' );
        add_theme_support( 'disable-custom-gradients' );
        add_theme_support( 'disable-custom-font-sizes' );
        remove_theme_support( 'editor-gradient-presets' );
        remove_theme_support( 'core-block-patterns' );

        add_theme_support( 'editor-color-palette', [
            [
                'name'  => __( 'Primary Subtle', 'bestproject'),
                'slug'  => 'primary-subtle',
                'color'	=> '#cfe2ff',
            ],[
                'name'  => __( 'Primary', 'bestproject'),
                'slug'  => 'primary',
                'color'	=> '#0d6efd',
            ],[
                'name'  => __( 'Secondary', 'bestproject'),
                'slug'  => 'secondary',
                'color'	=> '#6c757d',
            ],[
                'name'  => __( 'White', 'bestproject'),
                'slug'  => 'white',
                'color'	=> '#fff',
            ],[
                'name'  => __( 'Light', 'bestproject'),
                'slug'  => 'light',
                'color'	=> '#f8f9fa',
            ],[
                'name'  => __( 'Dark', 'bestproject'),
                'slug'  => 'dark',
                'color'	=> '#212529',
            ],[
                'name'  => __( 'Black', 'bestproject'),
                'slug'  => 'black',
                'color'	=> '#000',
            ],
        ]);

        add_theme_support(
            'editor-font-sizes',
            [
                [
                    'name'      => "H1",
                    'size'      => "3.375rem",
                    'slug'      => '1'
                ],
                [
                    'name'      => "H2",
                    'size'      => "3rem",
                    'slug'      => '2'
                ],
                [
                    'name'      => "H3",
                    'size'      => "2.25rem",
                    'slug'      => '3'
                ],
                [
                    'name'      => "H4",
                    'size'      => "1.5rem",
                    'slug'      => '4'
                ],
                [
                    'name'      => "H5",
                    'size'      => "1.125rem",
                    'slug'      => '5'
                ],
                [
                    'name'      => __( 'Normal', 'bestproject'),
                    'size'      => "1rem",
                    'slug'      => 'normal'
                ],
                [
                    'name'      => __( 'Small', 'bestproject'),
                    'size'      => "0.875rem",
                    'slug'      => 'sm'
                ],
                [
                    'name'      => __( 'Extra Small', 'bestproject'),
                    'size'      => "0.75rem",
                    'slug'      => 'xs'
                ],
            ]
        );

        // Load theme translation domain
        load_textdomain('basetheme', dirname(__DIR__, 3).'/languages/basetheme-pl_PL.mo');
        load_textdomain('bestproject', dirname(__DIR__, 3).'/languages/bestproject-pl_PL.mo');
    }

    /**
     * Register menu positions.
     */
    public static function registerMenus(): void
    {
        register_nav_menus([
            'mainmenu' => __('Main menu', 'bestproject'),
            'footermenu' => __('Footer', 'bestproject'),
        ]);
    }

    /**
     * Register editor styles.
     *
     * @throws \Exception
     */
    public static function registerEditorStyles(): void
    {
        add_theme_support( 'editor-styles' );
        $editor_style = AssetsHelper::getAssetUrl('editor-styles.css', true);
        add_editor_style(str_ireplace('wp-content/themes/'.ThemeHelper::getTheme().'/','', $editor_style));
    }

    /**
     * Register theme thumbnail sizes.
     *
     * @return void
     */
    public static function registerThumbnailSizes(): void
    {
        remove_image_size('2048x2048');
        remove_image_size('1536x1536');

        add_image_size( 'thumbnail', 150,  150, true); // 300 pixels wide (and unlimited height)
        add_image_size( 'medium', 960,  540, true); // 300 pixels wide (and unlimited height)
        add_image_size( 'large', 2304, 1296, true ); // (cropped)
    }

    public static function afterSwitchTheme(): void
    {
        update_option( 'thumbnail_size_h', 150 );
        update_option( 'thumbnail_size_w', 150 );
        update_option( 'medium_size_h', 960 );
        update_option( 'medium_size_w', 960 );
        update_option( 'large_size_h', 2048 );
        update_option( 'large_size_w', 2048 );

        self::loadSampleData();
    }

    private static function loadSampleData(): void
    {
        // Check if typography post exists
        $typography_page_name = 'typography';
        $typography_path = dirname(__DIR__, 3).'/.sample-data/typography.html';

        if( !get_page_by_path( $typography_page_name ) && is_file($typography_path) ) {
            $post_data = [
                'post_title'   => 'Typography',
                'post_name'   => $typography_page_name,
                'post_content' => file_get_contents($typography_path),
                'post_status'  => 'private',
                'post_type'    => 'page',
            ];

            // Post doesn't exist, so load it from sample data
            wp_insert_post( $post_data );
        }
    }

}