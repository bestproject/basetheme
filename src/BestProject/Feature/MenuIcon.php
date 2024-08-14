<?php

namespace BestProject\Feature;

/**
 * Menu icon feature.
 */
class MenuIcon
{
    public static function enable(): void
    {
        add_action('wp_nav_menu_item_custom_fields', [self::class, 'addCustomField'], 10, 2);
        add_action('wp_update_nav_menu_item', [self::class, 'save'], 10, 2);
        add_action('nav_menu_item_title', [self::class, 'show'], 10, 2);
    }

    public static function addCustomField($item_id, $item): void
    {
        $menu_item_icon_class = get_post_meta( $item_id, '_menu_item_icon', true );
        ?>
        <div style="clear: both;">
            <span class="description"><?php _e( "Icon class", 'bestproject' ); ?></span><br />
            <input type="hidden" class="nav-menu-id" value="<?php echo $item_id ;?>" />
            <div class="logged-input-holder">
                <input type="text" name="menu_item_icon[<?php echo $item_id ;?>]" id="menu-item-icon-<?php echo $item_id ;?>" value="<?php echo esc_attr( $menu_item_icon_class ); ?>" />
            </div>
        </div>
        <?php
    }

    public static function save($menu_id, $menu_item_db_id ): void
    {
        if ( isset( $_POST['menu_item_icon'][$menu_item_db_id]  ) ) {
            $sanitized_data = sanitize_text_field( $_POST['menu_item_icon'][$menu_item_db_id] );
            update_post_meta( $menu_item_db_id, '_menu_item_icon', $sanitized_data );
        } else {
            delete_post_meta( $menu_item_db_id, '_menu_item_icon' );
        }
    }

    public static function show($title, $item): string
    {
        if( is_object( $item ) && isset( $item->ID ) ) {
            $menu_item_icon = get_post_meta( $item->ID, '_menu_item_icon', true );
            if ( ! empty( $menu_item_icon ) ) {
                $aria_title = trim(strip_tags($title));
                $title = '<i class="'.$menu_item_icon.'" aria-hidden="true" title="'.esc_attr($aria_title).'"></i>';
                $title.= '<span class="d-inline-block d-xl-none ms-2" aria-hidden="true">'.$aria_title.'</span>';
                $title.= '<span class="visually-hidden">'.$aria_title.'</span>';
            }
        }

        return $title;
    }
}