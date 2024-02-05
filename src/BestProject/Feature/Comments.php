<?php

namespace BestProject\Feature;

/**
 * Comments feature changes.
 */
class Comments
{

    public static function removePostSupport(): void
    {
        $post_types = get_post_types();
        foreach ($post_types as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    }

    public static function hideAdminMenu(): void
    {
        remove_menu_page('edit-comments.php');
    }

    public static function disable(): void
    {
        add_action('admin_init', [self::class, 'removePostSupport']);
        add_action('admin_menu', [self::class,'hideAdminMenu']);
        add_filter('comments_open', '__return_false', 20, 2);
        add_filter('pings_open', '__return_false', 20, 2);
    }
}