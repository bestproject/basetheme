<?php

namespace BaseTheme\Action;

use WP_Customize_Manager;
use WP_Customize_Image_Control;

/**
 * Methods to register on customize_register action.
 *
 * @package BaseTheme\Action
 */
final class customize_register
{

    /**
     * Register logo sections.
     *
     * @param   WP_Customize_Manager  $customize
     */
    public static function logo(WP_Customize_Manager $customize): void
    {

        // Logo
        $customize->add_setting('logo', [
            'type' => 'option'
        ]);

        $customize->add_control( new WP_Customize_Image_Control( $customize, 'logo', [
            'label' => __('Logo image', 'basetheme'),
            'section' => 'title_tagline',
            'settings' => 'logo',
        ]));

    }

    /**
     * Register controls for additional code section.
     *
     * @param   WP_Customize_Manager  $customize
     */
    public static function additionalCode(WP_Customize_Manager $customize): void
    {
        // Section
        $customize->add_section('additional-code', [
            'title' => __( 'Additional code', 'basetheme'),
        ]);

        // Fields
        $customize->add_setting('code_head_top', [
            'default'     => '',
            'transport'   => 'refresh',
        ]);
        $customize->add_control('code_head_top', [
            'type' => 'textarea',
            'label' => __('After &lt;head&gt;', 'basetheme'),
            'section' => 'additional-code',
            'settings' => 'code_head_top'
        ]);

        $customize->add_setting('code_head_bottom', [
            'default'     => '',
            'transport'   => 'refresh',
        ]);
        $customize->add_control('code_head_bottom', [
            'type' => 'textarea',
            'label' => __('Before &lt;/head&gt;', 'basetheme'),
            'section' => 'additional-code',
            'settings' => 'code_head_bottom'
        ]);
        $customize->add_setting('code_body_top', [
            'default'     => '',
            'transport'   => 'refresh',
        ]);
        $customize->add_control('code_body_top', [
            'type' => 'textarea',
            'label' => __('After &lt;body&gt;', 'basetheme'),
            'section' => 'additional-code',
            'settings' => 'code_body_top'
        ]);

        $customize->add_setting('code_body_bottom', [
            'default'     => '',
            'transport'   => 'refresh',
        ]);
        $customize->add_control('code_body_bottom', [
            'type' => 'textarea',
            'label' => __('Before &lt;/body&gt;', 'basetheme'),
            'section' => 'additional-code',
            'settings' => 'code_body_bottom'
        ]);

    }

}