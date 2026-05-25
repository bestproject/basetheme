<?php

namespace BestProject\PostType;

final class Post
{

    public static function remove(): void
    {
        add_action('admin_menu', static function () {
            remove_menu_page('edit.php');
        });
        add_action('admin_bar_menu', static function ($wp_admin_bar) {
            $wp_admin_bar->remove_node('new-post');
        }, 999);
        add_filter('wpseo_sitemap_exclude_post_type', static function ($value, $post_type) {
            return $post_type === 'post' ? false : $value;
        }, 10, 2);
    }
}