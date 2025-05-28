<?php

use BaseTheme\Action\admin_init;
use BaseTheme\Action\after_setup_theme;
use BaseTheme\Action\customize_register;
use BaseTheme\Action\init;
use BaseTheme\Action\widgets_init;
use BaseTheme\Action\wp_enqueue_scripts;
use BaseTheme\Action\wp_footer;
use BaseTheme\Action\wp_head;
use BaseTheme\Block\Style\Spacer as SpacerStyles;
use BaseTheme\Block\Bootstrap;
use BaseTheme\Action\wp_default_scripts;
use BaseTheme\Action\enqueue_block_assets;
use BestProject\Feature\Comments as CommentsFeature;
use BestProject\Feature\MenuIcon as MenuIconFeature;
use BestProject\Feature\Updates as UpdatesFeature;
use BestProject\NavWalker\Bootstrap5NavWalker;
use BestProject\NavWalker\OffcanvasNavWalker;
use BestProject\Plugin\ContactForm7;
use BestProject\Plugin\Yoast;

require_once __DIR__ . '/vendor/autoload.php';

// Theme setup
add_action('after_setup_theme', [after_setup_theme::class, 'registerTheme']);
add_action('after_setup_theme', [after_setup_theme::class, 'registerMenus']);
add_action('after_setup_theme', [after_setup_theme::class, 'registerEditorStyles']);
add_action('after_setup_theme', [after_setup_theme::class, 'registerThumbnailSizes']);

// Customizer
add_action('customize_register', [customize_register::class, 'logo']);
add_action('customize_register', [customize_register::class, 'additionalCode']);

// Init
add_action('init', [init::class, 'registerPostSupport']);
add_action('init', [init::class, 'registerThemePatternsCategory']);
add_action('widgets_init', [widgets_init::class, 'registerSidebars']);
add_action('admin_init', [admin_init::class, 'registerEditorStyles']);
add_action('admin_init', [admin_init::class, 'syncPatterns']);

// Theme assets
add_action('wp_head', [wp_head::class, 'preload']);
add_action('wp_enqueue_scripts', [wp_enqueue_scripts::class, 'theme']);
add_action('wp_default_scripts', [wp_default_scripts::class, 'removeJQueryMigrate']);
add_action('enqueue_block_assets', [enqueue_block_assets::class, 'editor']);

// Theme functions
//add_action('wp_footer', [wp_footer::class, 'stickyMenu']);

// Filters
add_filter('nav_menu_submenu_css_class', [OffcanvasNavWalker::class, 'nav_menu_submenu_css_class'], 10, 3);
add_filter('nav_menu_submenu_attributes', [OffcanvasNavWalker::class, 'nav_menu_submenu_attributes'], 10, 3);
add_filter('nav_menu_submenu_css_class', [Bootstrap5NavWalker::class, 'nav_menu_submenu_css_class'], 10, 3);
add_filter('nav_menu_submenu_attributes', [Bootstrap5NavWalker::class, 'nav_menu_submenu_attributes'], 10, 3);

// Block (Register your custom block)
add_action('init', [Bootstrap::class, 'register']);

// Block styles (Register your custom block styles)
add_action('init', [SpacerStyles::class, 'register']);

// Disable feeds
add_action('do_feed', 'wpb_disable_feed', 1);
add_action('do_feed_rdf', 'wpb_disable_feed', 1);
add_action('do_feed_rss', 'wpb_disable_feed', 1);
add_action('do_feed_rss2', 'wpb_disable_feed', 1);
add_action('do_feed_atom', 'wpb_disable_feed', 1);
add_action('do_feed_rss2_comments', 'wpb_disable_feed', 1);
add_action('do_feed_atom_comments', 'wpb_disable_feed', 1);

// plugins
add_filter('wpcf7_form_tag', [ContactForm7::class, 'addBootstrapAttributes'], 10, 2);
add_filter('wpseo_breadcrumb_separator', [Yoast::class, 'changeBreadcrumbSeparator'], 10);
add_filter('wpseo_breadcrumb_links', [Yoast::class, 'addParentPages'], 10);

// Features
//UpdatesFeature::disableThemeUpdates();
CommentsFeature::disable();
MenuIconFeature::enable();