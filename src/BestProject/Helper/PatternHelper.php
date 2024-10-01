<?php

namespace BestProject\Helper;

/**
 * Process patterns.
 */
class PatternHelper
{

    public static function getPatternById(int $id): ?string
    {
        return apply_filters('the_content', get_post($id)->post_content);
    }
}

