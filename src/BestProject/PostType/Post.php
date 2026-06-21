<?php

namespace BestProject\PostType;

final class Post
{

    public const string POST_TYPE = 'post';

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

    public static function get_the_archive_title(string $title, string $original, string $prefix): string
    {
        if( get_post_type()===self::POST_TYPE ) {

            if( get_option('show_on_front') ==='page' && get_option('page_for_posts')>0 ) {
                return get_the_title( get_option('page_for_posts') );
            }

            return $title;
        }

        return $title;
    }
}