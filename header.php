<?php
$body_class_suffix = '';
if( is_front_page() ) {
    $body_class_suffix.=' front-page';
} else {
    $body_class_suffix.=' subpage';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php echo get_theme_mod('code_head_top','') ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="white">
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="white">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php wp_head(); ?>
    <?php echo get_theme_mod('code_head_bottom','') ?>
</head>

<body <?php body_class($body_class_suffix) ?>>
<?php echo get_theme_mod('code_body_top','') ?>
<?php wp_body_open(); ?>
<?php get_template_part('template-parts/navbar') ?>