<?php

namespace BestProject\Helper;

/**
 * Process patterns.
 */
class PatternHelper
{

    public static function getPatternById(int $id, bool $filter = true): ?string
    {
        $post = get_post($id);

        if( $filter ) {
            return apply_filters('the_content', $post->post_content);
        }

        return $post->post_content;
    }
}

