<?php

use BestProject\NavWalker\Bootstrap5NavWalker;

$logo = get_option('logo');
$logo_media_id = attachment_url_to_postid($logo);
if( is_int($logo_media_id) ) {
    $logo = wp_get_attachment_image_src($logo_media_id);
}
?>
<header class="position-relative">
    <div class="navbar navbar-light navbar-expand-xl" id="nav">
        <div class="container">
            <a class="navbar-brand mr-0 mr-lg-60" href="<?php echo get_home_url() ?>">
                <?php if (is_string($logo) && $logo !== ''): ?>
                    <img src="<?php echo $logo ?>" class="navbar-brand-logo" alt="<?php bloginfo('name') ?> - <?php echo __('Logo', 'basetheme') ?>">
                <?php elseif( is_array($logo) && $logo!==[] ): ?>
                    <img src="<?php echo $logo[0] ?>" width="<?php echo $logo[1] ?>" height="<?php echo $logo[2] ?>" class="navbar-brand-logo" alt="<?php bloginfo('name') ?> - <?php echo __('Logo', 'basetheme') ?>">
                <?php else: ?>
                    <?php bloginfo('name') ?>
                <?php endif ?>
            </a>
            
            <?php if (has_nav_menu('mainmenu')): ?>
                <button class="navbar-toggler mr-3" type="button" data-bs-toggle="collapse"
                        data-bs-target="#main-navigation" aria-controls="main-navigation" aria-expanded="false"
                        aria-label="<?php echo __('Toggle navigation', 'basetheme') ?>">
                    <i class="fas fa-bars" aria-hidden="true"></i>
                </button>

                <div id="main-navigation" class="collapse navbar-collapse justify-content-lg-end">
                    <?php wp_nav_menu([
                        'theme_location' => 'mainmenu',
                        'container'      => false,
                        'menu_class'     => 'navbar-nav nav',
                        'walker'         => new Bootstrap5NavWalker()
                    ]) ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</header>