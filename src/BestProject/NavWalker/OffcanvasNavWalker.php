<?php

namespace BestProject\NavWalker;

use Walker_Nav_Menu;

/**
 * Bootstrap 5 menu walker for WordPress themes.
 *
 * @package BestProject\Menu\Walker
 */
class OffcanvasNavWalker extends Walker_Nav_Menu
{

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

        if( $anchor_attributes['target']==='' ) {
            unset($anchor_attributes['target']);
        }

        // If this is a dropdown, prepare attributes and classes
        if(in_array('menu-item-has-children', $classes, true)) {
            $classes[] = 'dropdown';
            $anchor_attributes['class'].= ' ';
            $anchor_attributes += [
                'data-bs-toggle' => 'dropdown',
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

        $badge = '';
        if( trim($item->post_content)!=='' && str_word_count($item->post_content)<3 ) {
            $badge = '<span class="badge bg-primary text-white ms-3 fw-light">'.$item->post_content.'</span>';
        }

        // Render item
        $output_item = '<li '.$this->getAttributesString($item_attributes).'>';
        $output_item.=
            '<a '.$this->getAttributesString($anchor_attributes).'>'.
                $args->link_before . '<span class="nav-link-text">'.$title.'</span>' . $badge . $args->link_after.
            '</a>';

        if(in_array('menu-item-has-children', $classes, true)) {
            $output_item.= '<ul class="dropdown-menu px-3 px-md-5 px-lg-50 pb-md-3 pb-lg-50 mb-3 mb-md-0" id="menu-item-'.$item->ID.'-dropdown"><div class="offcanvas-header d-none d-md-block px-3 px-md-7 py-3 py-md-30 py-lg-50" aria-hidden="true"><div class="pt-md-30 pt-lg-50 mb-lg-2"></div></div>';
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

}