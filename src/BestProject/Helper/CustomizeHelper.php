<?php

namespace BestProject\Helper;

use WP_Customize_Manager;

/**
 * Theme customize helper.
 */
class CustomizeHelper
{

    /**
     * If this is customize view, add customizer data attribute to identify settings.
     *
     * @param   string  $name
     *
     * @return void
     */
    public static function edit(string $name): void
    {
        if( !array_key_exists('customize_theme', $_GET) || !is_user_logged_in() ) {
            return;
        }
        ?> data-customize="<?php echo $name?>"<?php
    }

    /**
     * Add a setting edit link to customize view for selected setting name.
     *
     * @param   WP_Customize_Manager  $customizeManager Customizer instance.
     * @param   string                $name Name of the setting.
     *
     * @return void
     */
    public static function addSelectiveRefresh(WP_Customize_Manager $customizeManager, string $name): void
    {
        $customizeManager->selective_refresh->add_partial($name, [
            'selector' => '[data-customize="'.$name.'"]',
        ]);
    }

}