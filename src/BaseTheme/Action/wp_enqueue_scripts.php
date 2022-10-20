<?php

namespace BaseTheme\Action;

use BestProject\Helper\AssetsHelper;
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
        AssetsHelper::enqueueDeferredStyle('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap', 'google-fonts');
    }

}