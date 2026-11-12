<?php

namespace BestProject\Feature;

use WP_Error;

readonly class Security
{

    public static function disableXmlrpc(): void
    {
        add_filter('xmlrpc_enabled', '__return_false');
    }

    public static function disableFileEditing(): void
    {
        define('DISALLOW_FILE_EDIT', true);
    }

    public static function disablePublicUsersRestApiAccess(): void
    {
        add_filter('rest_endpoints', static function ($endpoints) {

            if (is_user_logged_in()){
                return $endpoints;
            }

            if (isset($endpoints['/wp/v2/users']))
            {
                unset($endpoints['/wp/v2/users']);
            }

            if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)']))
            {
                unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
            }

            return $endpoints;
        });
    }

    public static function disablePublicRestApiAccess(): void
    {

        /**
         * Disable JSON API for unauthenticated users
         */
        add_filter('rest_authentication_errors', function ($result) {
            // If a previous authentication check was applied,
            // pass that result along without modification.
            if (true === $result || is_wp_error($result))
            {
                return $result;
            }

            // No authentication has been performed yet, so fail the authentication.
            if (!is_user_logged_in())
            {
                return new WP_Error(
                    'rest_not_logged_in',
                    __('You are not currently logged in.'),
                    array('status' => 401)
                );
            }

            return $result;
        });
    }

    public static function disableRestApiAccess(): void
    {
        add_filter('rest_authentication_errors', static function ($errors) {

            // if there is already an error, just return it
            if (is_wp_error($errors))
            {
                return $errors;
            }

            // return WP_Error object
            return new WP_Error('no_rest_api_sorry', 'REST API not allowed', ['status' => 401]);
        });
    }

}