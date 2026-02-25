<?php

namespace BestProject\Feature;

use WP_Post;

/**
 * Navigation link class feature.
 */
class MenuLinkClass
{
    public static function enable(): void
    {
        add_action('wp_nav_menu_item_custom_fields', [self::class, 'addCustomField'], 10, 2);
        add_action('wp_update_nav_menu_item', [self::class, 'save'], 10, 2);
        add_filter('nav_menu_link_attributes', [self::class, 'show'], 10, 4);
    }

    public static function addCustomField($item_id, $item): void
    {
        $menu_item_link_class_class = get_post_meta( $item_id, '_menu_item_link_class', true );
        ?>
        <p style="clear: both;">
            <span class="description"><?php _e( "Link class", 'bestproject' ); ?></span><br />
            <input type="hidden" class="nav-menu-id" value="<?php echo $item_id ;?>" />
        <div class="logged-input-holder">
            <input type="text" name="menu_item_link_class[<?php echo $item_id ;?>]" id="menu-item-link-class-<?php echo $item_id ;?>" value="<?php echo esc_attr( $menu_item_link_class_class ); ?>" />
        </div>
        </p>
        <?php
    }

    public static function save($menu_id, $menu_item_db_id ): void
    {
        if ( isset( $_POST['menu_item_link_class'][$menu_item_db_id]  ) ) {
            $sanitized_data = sanitize_text_field( $_POST['menu_item_link_class'][$menu_item_db_id] );
            update_post_meta( $menu_item_db_id, '_menu_item_link_class', $sanitized_data );
        } else {
            delete_post_meta( $menu_item_db_id, '_menu_item_link_class' );
        }
    }

    public static function show($atts, WP_Post $menu_item, $args, $depth): array
    {
        if( isset( $menu_item->ID ) ) {
            $menu_item_link_class = get_post_meta( $menu_item->ID, '_menu_item_link_class', true );

            if ( !empty( $menu_item_link_class ) ) {
                $atts['class'] .= ' '.$menu_item_link_class;
            }
        }

        return $atts;
    }
}