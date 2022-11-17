<?php

namespace BestProject\NavWalker;

use Walker_Nav_Menu;

/**
 * Bootstrap 5 menu walker for Wordpress themes.
 *
 * @package BestProject\Menu\Walker
 */
class Bootstrap5NavWalker extends Walker_Nav_Menu
{

    public function start_lvl(&$output, $depth = 0, $args = null): void
    {
        $output.= '<ul class="dropdown-menu">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null): void
    {
        $output.= '</ul>';
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
            $classes[] = 'dropdown';
            $anchor_attributes['class'].= ' dropdown-toggle';
            $anchor_attributes += [
                'data-toggle' => 'dropdown',
                'id' => 'menu-item-dropdown-'.$item->ID,
                'role' => 'button',
                'aria-haspopup' => 'true',
                'aria-expanded' => 'false'
            ];
        }

        // Prepare item ID attribute
        $item_id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );

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

        // Render item
        $output_item = '<li '.$this->getAttributesString($item_attributes).'>';
        $output_item.=
            '<a '.$this->getAttributesString($anchor_attributes).'>'.
                $args->link_before . $title . $args->link_after.
            '</a>';

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

}