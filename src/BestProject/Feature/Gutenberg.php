<?php

namespace BestProject\Feature;

/**
 * Update features.
 */
class Gutenberg
{
    public static function disableBlockEditor($restrict_posts = []): void
    {
        add_filter( 'use_block_editor_for_post', function($use_block_editor, $post) use ($restrict_posts) {

            if( $restrict_posts===[] ) {
                return false;
            }

            if( in_array($post->post_type, $restrict_posts, true) ) {
                return false;
            }

            return $use_block_editor;

        }, 10, 2 );
    }
}