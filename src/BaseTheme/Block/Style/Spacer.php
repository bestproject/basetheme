<?php

namespace BaseTheme\Block\Style;

use BestProject\AutoRegister;

/**
 * Custom Spacer block styles
 */
class Spacer extends AutoRegister
{
    public static function styles(): void
    {
        register_block_style('core/spacer', [
            'name' => 'sm',
            'label' => __('SM', 'bestproject'),
        ]);
        register_block_style('core/spacer', [
            'name' => 'md',
            'label' => __('MD', 'bestproject'),
        ]);
        register_block_style('core/spacer', [
            'name' => 'lg',
            'label' => __('LG', 'bestproject'),
        ]);
        register_block_style('core/spacer', [
            'name' => 'xl',
            'label' => __('XL', 'bestproject'),
        ]);
    }

}