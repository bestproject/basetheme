<?php

use BaseTheme\Action\after_setup_theme;
use BaseTheme\Action\customize_register;
use BaseTheme\Action\init;
use BaseTheme\Action\widgets_init;
use BaseTheme\Action\wp_enqueue_scripts;
use BaseTheme\Action\wp_footer;

require_once __DIR__ . '/vendor/autoload.php';

// Theme setup
add_action('after_setup_theme', [after_setup_theme::class, 'registerTheme']);
add_action('after_setup_theme', [after_setup_theme::class, 'registerMenus']);
add_action('after_setup_theme', [after_setup_theme::class, 'registerEditorStyles']);
add_action('after_setup_theme', [after_setup_theme::class, 'registerThumbnailSizes']);

// Customizer
add_action('customize_register', [customize_register::class, 'logo']);
add_action('customize_register', [customize_register::class, 'additionalCode']);
add_action('customize_register', [customize_register::class, 'header']);

// Init
add_action('init', [init::class, 'registerPostSupport']);
add_action('init', [init::class, 'registerPropertiesPostType']);
add_action('widgets_init', [widgets_init::class, 'registerSidebars']);

// Theme assets
add_action('wp_enqueue_scripts', [wp_enqueue_scripts::class, 'theme']);

// Theme functions
//add_action('wp_footer', [wp_footer::class, 'stickyMenu']);

// Disable feeds
add_action('do_feed', 'wpb_disable_feed', 1);
add_action('do_feed_rdf', 'wpb_disable_feed', 1);
add_action('do_feed_rss', 'wpb_disable_feed', 1);
add_action('do_feed_rss2', 'wpb_disable_feed', 1);
add_action('do_feed_atom', 'wpb_disable_feed', 1);
add_action('do_feed_rss2_comments', 'wpb_disable_feed', 1);
add_action('do_feed_atom_comments', 'wpb_disable_feed', 1);
