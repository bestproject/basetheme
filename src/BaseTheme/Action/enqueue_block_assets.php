<?php

namespace BaseTheme\Action;

use BestProject\Helper\AssetsHelper;
use Exception;

/**
 * Methods running on enqueue_block_editor_assets action.
 *
 * @package BaseTheme\Action
 */
final class enqueue_block_assets
{
    /**
     * Process editor styles and external resources.
     *
     * @throws Exception
     */
    public static function editor(): void
    {
        if( !is_admin() ) {
            return;
        }

        // Register and enqueue fonts
        wp_enqueue_style(
            'current-theme-fonts',
            AssetsHelper::getAssetUrl('fonts.css', true),
            [],
            AssetsHelper::getAssetVersion('fonts.css', true),
        );
    }
}