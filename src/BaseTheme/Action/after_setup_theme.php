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

        add_theme_support( 'editor-color-palette', [
            [
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
                    'name'      => __( 'Extra Small', 'bestproject'),
                    'size'      => "0.5rem",
                    'slug'      => 'xs'
                ],
                [
                    'name'      => __( 'Small', 'bestproject'),
                    'size'      => "0.875rem",
                    'slug'      => 'small'
                ],
                [
                    'name'      => __( 'Normal', 'bestproject'),
                    'size'      => "1rem",
                    'slug'      => 'medium'
                ],
                [
                    'name'      => __( 'Medium', 'bestproject'),
                    'size'      => "1.25rem",
                    'slug'      => 'medium'
                ],
                [
                    'name'      => __( 'Large', 'bestproject'),
                    'size'      => "1.5rem",
                    'slug'      => 'large'
                ],
                [
                    'name'      => __( 'Extra Large', 'bestproject'),
                    'size'      => "2.5rem",
                    'slug'      => 'x-large'
                ],
            ]
        );

        // Load theme translation domain
        load_theme_textdomain('basetheme');
        load_theme_textdomain('bestproject', dirname(__DIR__, 3).'/language/bestproject');
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
    }

}