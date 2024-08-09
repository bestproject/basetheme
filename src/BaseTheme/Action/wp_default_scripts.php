<?php

namespace BaseTheme\Action;

use WP_Scripts;

/**
 * Methods to bind to wp_default_scripts action.
 *
 * @package BaseTheme\Action
 */
final class wp_default_scripts
{
    /**
     * Remove jQuery migrate.
     */
    public static function removeJQueryMigrate(WP_Scripts $scripts): void
    {
        if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
            $script = $scripts->registered['jquery'];

            // Check whether the script has any dependencies
            if ( $script->deps ) {
                $script->deps = array_diff( $script->deps, ['jquery-migrate']);
            }
        }
    }

}