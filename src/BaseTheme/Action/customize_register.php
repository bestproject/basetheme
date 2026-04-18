<?php

namespace BaseTheme\Action;

use BestProject\Customize\Control\Pattern_Customize_Control;
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
            'label' => __('Logo image', 'bestproject'),
            'section' => 'title_tagline',
            'settings' => 'logo',
        ]));

        // Copyrights
        $customize->add_setting('copyrights', [
            'default'     => '',
            'transport'   => 'refresh',
        ]);
        $customize->add_control('copyrights', [
            'type' => 'textarea',
            'label' => __('Copyrights note', 'bestproject'),
            'description' => __('Default will be used if empty', 'bestproject'),
            'section' => 'title_tagline',
            'settings' => 'copyrights'
        ]);

    }
    /**
     * Register patterns sections.
     *
     * @param   WP_Customize_Manager  $customize
     */
    public static function patterns(WP_Customize_Manager $customize): void
    {

        // Section
        $customize->add_section('patterns', [
            'title' => __( 'Patterns', 'bestproject'),
        ]);

        // Fields
        $customize->add_setting('patterns_footer', [
            'default'     => '',
            'transport'   => 'refresh',
        ]);
        $customize->add_control(new Pattern_Customize_Control($customize, 'patterns_footer', [
            'label' => __('Footer', 'bestproject'),
            'section' => 'patterns',
            'settings' => 'patterns_footer',
            'placeholder' => _x('No footer', 'customizer', 'bestproject'),
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
            'title' => __( 'Additional code', 'bestproject'),
        ]);

        // Fields
        $customize->add_setting('code_head_top', [
            'default'     => '',
            'transport'   => 'refresh',
        ]);
        $customize->add_control('code_head_top', [
            'type' => 'textarea',
            'label' => __('After &lt;head&gt;', 'bestproject'),
            'section' => 'additional-code',
            'settings' => 'code_head_top'
        ]);

        $customize->add_setting('code_head_bottom', [
            'default'     => '',
            'transport'   => 'refresh',
        ]);
        $customize->add_control('code_head_bottom', [
            'type' => 'textarea',
            'label' => __('Before &lt;/head&gt;', 'bestproject'),
            'section' => 'additional-code',
            'settings' => 'code_head_bottom'
        ]);
        $customize->add_setting('code_body_top', [
            'default'     => '',
            'transport'   => 'refresh',
        ]);
        $customize->add_control('code_body_top', [
            'type' => 'textarea',
            'label' => __('After &lt;body&gt;', 'bestproject'),
            'section' => 'additional-code',
            'settings' => 'code_body_top'
        ]);

        $customize->add_setting('code_body_bottom', [
            'default'     => '',
            'transport'   => 'refresh',
        ]);
        $customize->add_control('code_body_bottom', [
            'type' => 'textarea',
            'label' => __('Before &lt;/body&gt;', 'bestproject'),
            'section' => 'additional-code',
            'settings' => 'code_body_bottom'
        ]);

    }

}