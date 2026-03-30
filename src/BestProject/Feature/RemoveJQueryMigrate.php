<?php

namespace BestProject\Feature;

/**
 * Remove jQuery migrate.
 */
class RemoveJQueryMigrate
{
    public static function register(): void
    {
        add_action( 'wp_default_scripts', static function ( $scripts ) {
            if ( ! empty( $scripts->registered['jquery'] )&&  !is_admin() ) {
                $scripts->registered['jquery']->deps = array_diff(
                    $scripts->registered['jquery']->deps,
                    [ 'jquery-migrate' ]
                );
            }
        }, 10, 1 );
    }
}