<?php

namespace BestProject\PostType;

final class Post {

    public static function registerHideSidebarLink(): void
    {
        add_action( 'admin_menu',  [self::class, 'hideSidebarLink'] );
    }

    public static function hideSidebarLink(): void
    {
        remove_menu_page( 'edit.php' );
    }

    public static function registerHideAdminBarLink(): void
    {
        add_action( 'admin_bar_menu',  [self::class, 'hideAdminBarLink'], 999 );
    }

    public static function hideAdminBarLink($wp_admin_bar): void
    {
        $wp_admin_bar->remove_node( 'new-post' );
    }

}