<?php

namespace BaseTheme\Action;

/**
 * Init action.
 */
class init
{

    /**
     * Change post support options.
     */
    public static function registerPostSupport(): void
    {
        add_theme_support('post-thumbnails', ['post', 'page']);
        add_post_type_support('page', 'excerpt');
    }
}