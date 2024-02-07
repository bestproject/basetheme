<?php

namespace BaseTheme\Block\Style;

use BestProject\AutoRegister;

/**
 * Custom Spacer block styles
 */
class Spacer extends AutoRegister
{

    /**
     * A gray link button with underline.
     *
     * @return void
     */
    public static function link(): void
    {
        register_block_style('core/spacer', [
            'name' => 'sm',
            'label' => __('SM', 'basetheme'),
        ]);
        register_block_style('core/spacer', [
            'name' => 'md',
            'label' => __('MD', 'basetheme'),
        ]);
        register_block_style('core/spacer', [
            'name' => 'lg',
            'label' => __('LG', 'basetheme'),
        ]);
        register_block_style('core/spacer', [
            'name' => 'xl',
            'label' => __('XL', 'basetheme'),
        ]);
    }

}