<?php

namespace BestProject\NavWalker;

use Walker_Nav_Menu;

/**
 * Bootstrap 5 menu walker for WordPress themes.
 *
 * @package BestProject\Menu\Walker
 */
class Bootstrap5NavWalker extends Walker_Nav_Menu
{

    private static int $submenu_counter = 0;
    private static int $parent_counter = 0;

    protected static function getMenuPrefix(object $args): string
    {
        return "nav-{$args->theme_location}-item-".self::$parent_counter;
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0): void
    {
        // Prepare item classes
        $classes = ['nav-item','item-'.$item->ID];
        $classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );
        array_push($classes, ...$item->classes);

        // Prepare attributes
        $item_attributes = [];
        $anchor_attributes = [
            'class' => 'nav-link',
            'href' => $item->url ?? '',
            'target' => $item->target,
        ];

        // If this is a dropdown, prepare attributes and classes
        if(in_array('menu-item-has-children', $classes, true)) {

            self::$parent_counter++;

            $classes[] = 'dropdown';
            $anchor_attributes['class'].= ' dropdown-toggle';
            $anchor_attributes += [
                'data-bs-toggle' => 'dropdown',
                'id' => self::getMenuPrefix($args).'-'.self::$parent_counter,
                'aria-controls' => self::getMenuPrefix($args).'-dropdown',
                'data-bs-target' => "#".self::getMenuPrefix($args).'-dropdown',
                'role' => 'button',
                'aria-haspopup' => 'true',
                'aria-expanded' => 'false'
            ];
        }

        // Prepare item ID attribute
        $item_id = apply_filters( 'nav_menu_item_id', '', $item, $args, $depth );

        // Process anchor attributes
        $anchor_attributes = apply_filters( 'nav_menu_link_attributes', $anchor_attributes, $item, $args, $depth );

        // Prepare item title
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        // If item id is prepared, set the attribute
        if( !empty($item_id) ) {
            $item_attributes['id'] = $item_id;
        }

        // If there are item classes to set, set
        if( !empty($classes) ) {
            $item_attributes['class'] = implode(' ',$classes);
        }

        // Check if this is current page
        if( $item->current ) {
            $anchor_attributes['class'] .= ' active';
        }

        $badge = '';
        if( trim($item->attr_title)!=='' ) {
            $badge = '<span class="badge bg-primary text-white ms-3 fw-light">'.$item->attr_title.'</span>';
        }

        // Render item
        $output_item = '<li '.$this->getAttributesString($item_attributes).'>';
        $output_item.=
            '<a '.$this->getAttributesString($anchor_attributes).'>'.
            $args->link_before . '<span class="nav-link-text">'.$title.'</span>' . $badge . $args->link_after.
            '</a>';

        if( trim($item->post_content)!=='' ) {
            $output_item.= '<p class="font-sm text-muted px-4 mt-n2 mb-0">'.$item->post_content.'</p>';
        }

        $output .= apply_filters( 'walker_nav_menu_start_el', $output_item, $item, $depth, $args );
    }

    public function end_el(&$output, $item, $depth = 0, $args = null): void
    {
        $output.= '</li>';
    }

    /**
     * Render element attributes to a string.
     *
     * @param   array  $attributes  Attributes array
     *
     * @return string
     */
    protected function getAttributesString(array $attributes): string
    {
        foreach( $attributes as $key=>$value ){
            $attributes[$key] = $key.'="'.$value.'"';
        }

        return trim(implode(' ', $attributes));
    }

    public static function nav_menu_submenu_css_class(array $classes, object $args, int $depth): array
    {
        if( $args->walker instanceof self) {
            $classes[] = 'dropdown-menu';
        }

        return $classes;
    }

    public static function nav_menu_submenu_attributes(array $attributes, object $args, int $depth): array
    {
        if( $args->walker instanceof self) {
            self::$submenu_counter++;

            $attributes['id'] = self::getMenuPrefix($args).'-dropdown';
        }
        return $attributes;
    }

}