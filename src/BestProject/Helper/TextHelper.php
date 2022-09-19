<?php

namespace BestProject\Helper;

/**
 * Text processing helper class.
 */
class TextHelper
{
    /**
     * Split text into parts as equal as possible and adds an "i" tag with the breakpoint class.
     *
     * @param string $text Text to split.
     * @param int $lines    Numer of lines to display.
     * @param string $breakpoint_class  A class that will be used to split the words
     *
     * @return string
     */
    public static function split(string $text, int $lines, string $breakpoint_class = 'd-none d-lg-block'): string
    {
        $length = strlen($text);
        $part_minimum_length = ceil($length/$lines);
        $parts = explode(' ', $text);
        $parts_count = count($parts);
        $html = '';

        $line_length = 0;
        for($i=0,$word=$parts[$i]; $i<$parts_count; $i++, $word=$parts[$i]) {

            // No short signs at line end
            if( strlen($word)<3 ) {
                $html.= $word."&nbsp;";
                $line_length += strlen("$word ");
                continue;
            }


            // If this line exceeds max length, break it
            if( $line_length+strlen($word)>=$part_minimum_length ) {
                $html.=$word.' <i aria-hidden="true" class="'.$breakpoint_class.'"></i>';
                $line_length = 0;
            } else {
                $html.= $word.' ';
                $line_length += strlen("$word ");
            }
        }

        return $html;
    }
}