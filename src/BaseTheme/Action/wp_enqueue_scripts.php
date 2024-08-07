<?php

namespace BaseTheme\Action;

use BaseTheme\Constants;
use BestProject\Helper\AssetsHelper;
use BestProject\Helper\ThemeHelper;
use Exception;

/**
 * Methods to bind to wp_enqueue_scripts action.
 *
 * @package BaseTheme\Action
 */
final class wp_enqueue_scripts
{
    /**
     * Process theme styles and external resources.
     *
     * @throws Exception
     */
    public static function theme(): void
    {
        // Theme assets
        AssetsHelper::addEntryPointAssets('theme');

        // Lightbox
        AssetsHelper::addEntryPointAssets('lightbox', true);

        // FontAwesome
        AssetsHelper::addEntryPointAssets('fontawesome', true);

        // Register and enqueue fonts
        AssetsHelper::enqueueDeferredStyle(AssetsHelper::getAssetUrl('wp-content/themes/'.ThemeHelper::getTheme().'/assets/build/fonts.css'), 'fonts');
    }

}