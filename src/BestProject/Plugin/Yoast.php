<?php

namespace BestProject\Plugin;

/**
 * YoastSEO plugin hooks.
 */
class Yoast
{
    public static function changeBreadcrumbSeparator(): string
    {
        return '<i class="breadcrumb-separator mx-2" aria-hidden="true">/</i>';
    }

    public static function addParentPages(array $links): array
    {
        if( is_singular() ) {
            $post = get_post();
            if(is_post_type_hierarchical($post->post_type)) {
                $parents = [];
                $last = $post;

                while($last->post_parent) {
                    $last = get_post($last->post_parent);
                    array_unshift($parents, [
                        'text' => $last->post_title,
                        'url' => get_permalink($last),
                        'id' => $last->ID,
                    ]);
                }

                array_splice($links, count($links)-1, 0, $parents);
            }
        }

        return $links;
    }

}