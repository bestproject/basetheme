<?php

namespace BestProject\Helper;

/**
 * Cookies helper class.
 */
class CookieHelper
{

    /**
     * Get cookie or return default value.
     *
     * @param   string  $name       Name of a cookie.
     * @param   mixed   $default    Default value.
     *
     * @return mixed
     */
    public static function get(string $name, mixed $default): mixed
    {
        if (!array_key_exists($name, $_COOKIE)) {
            return $default;
        }

        return $_COOKIE[$name];
    }

}