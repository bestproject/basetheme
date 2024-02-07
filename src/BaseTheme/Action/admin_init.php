<?php

namespace BaseTheme\Action;


use BestProject\Helper\AssetsHelper;
use BestProject\Helper\ThemeHelper;
use BaseTheme\Constants;
use Exception;

/**
 * Methods running on admin_init action.
 *
 * @package BaseTheme\Action
 */
final class admin_init
{

    /**
     * Register editor css style.
     *
     * @throws Exception
     */
    public static function registerEditorStyles(): void
    {
        add_theme_support( 'editor-styles' );
        add_theme_support( 'customize-selective-refresh-widgets' );
        add_editor_style(AssetsHelper::getAssetUrl('wp-content/themes/'.ThemeHelper::getTheme().'/assets/build/editor-styles.css'));
        add_editor_style(Constants::FONTS_URL);
    }

}