<?php

namespace BestProject\Feature;

/**
 * Update features.
 */
class Updates
{
    public static function disableThemeUpdates(): void
    {
        add_action('wp_loaded', static function () {
            remove_action('load-update-core.php', 'wp_update_themes');
            add_filter('pre_site_transient_update_themes', '__return_null');
        });
    }
}