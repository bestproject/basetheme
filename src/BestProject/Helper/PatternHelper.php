<?php

namespace BestProject\Helper;

/**
 * Process patterns.
 */
class PatternHelper
{

    public static function getPatternById(int $id, bool $filter = true, string $container_class = ''): ?string
    {
        if( !$id ) {
            return '';
        }

        $post = get_post($id);

        $content= $post->post_content;

        if( $filter ) {
            $content = apply_filters('the_content', $content);
        }

        if( !empty($content) && !empty($container_class) ) {
            $content = '<div class="' . $container_class . '">' . $content . '</div>';
        }

        return $content;
    }
}

