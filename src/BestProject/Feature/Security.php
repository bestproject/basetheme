<?php

namespace BestProject\Feature;

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

}