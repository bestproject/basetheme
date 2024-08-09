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

        // Load theme translation domain
        load_theme_textdomain('basetheme');
    }

    /**
     * Register menu positions.
     */
    public static function registerMenus(): void
    {
        register_nav_menus([
            'mainmenu' => __('Main menu', 'basetheme'),
            'footermenu' => __('Footer', 'basetheme'),
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
        add_image_size( 'thumbnail', 150,  150, true); // 300 pixels wide (and unlimited height)
        add_image_size( 'medium', 960,  540, true); // 300 pixels wide (and unlimited height)
        add_image_size( 'large', 2304, 1296, true ); // (cropped)
    }

}