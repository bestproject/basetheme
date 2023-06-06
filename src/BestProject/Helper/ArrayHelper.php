<?php

namespace BestProject\Helper;

/**
 * Process arrays.
 */
class ArrayHelper
{

    /**
     * Convert HTMl associative array to HTMl attributes string.
     *
     * @param   array  $data    Associative array to convert.
     *
     * @return string   Returns class="test" data-day="today" for ["class"=>"test", "data-day"=>"today"] array
     */
    public static function toAttributes(array $data): string
    {
        if( $data===[] ) {
            return '';
        }

        $attribs = [];

        array_walk($data, static function($value, $key) use(&$attribs) {
            if( $value===true ) {
                $attribs[] = $key;
            } else {
                $attribs[] = $key.'="'.addslashes((string)$value).'"';
            }
        });

        return implode(' ', $attribs);
    }
}

