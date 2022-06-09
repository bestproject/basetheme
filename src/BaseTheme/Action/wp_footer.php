<?php

namespace BaseTheme\Action;

/**
 * Register methods called at wp_footer action.
 *
 * @package BaseTheme\Action
 */
final class wp_footer
{

    /**
     * Add `scrolled` class to navbar element on scroll.
     */
    public static function stickyMenu(): void
    {
        ?>
        <script>
            jQuery(function ($) {
                $('#nav').classOnScroll(15);
            });
        </script>
        <?php
    }
}