<?php

use BestProject\Helper\CustomizeHelper;
use BestProject\Helper\MediaHelper;
use BestProject\NavWalker\Bootstrap5NavWalker;
use BestProject\NavWalker\OffcanvasNavWalker;

$logo = get_option('logo');
$logo_media_id = attachment_url_to_postid($logo);
if( is_int($logo_media_id) ) {
    $logo = wp_get_attachment_image_src($logo_media_id);
}
?>
<header class="position-relative">
    <div class="navbar navbar-light navbar-expand-xl" id="nav">
        <div class="container">
            <a class="navbar-brand mr-0 mr-lg-60" href="<?php echo get_home_url() ?>"<?php CustomizeHelper::edit('logo'); ?>>
                <?php if ($logo_media_id): ?>
                    <?php echo MediaHelper::getImageTag($logo_media_id, ['alt' => get_bloginfo('name').' - '.__('Logo', 'basetheme'), 'class'=>'navbar-brand-logo']) ?>
                <?php else: ?>
                    <?php bloginfo('name') ?>
                <?php endif ?>
            </a>
            
            <?php if (has_nav_menu('mainmenu')): ?>

                <div id="main-navigation" class="flex-grow-0 d-none d-xl-flex justify-content-xl-end">
                    <?php wp_nav_menu([
                        'theme_location' => 'mainmenu',
                        'container'      => false,
                        'depth'          => 2,
                        'menu_class'     => 'navbar-nav nav',
                        'menu_id'        => 'mainmenu-desktop',
                        'walker'         => new Bootstrap5NavWalker()
                    ]) ?>
                </div>

                <button class="btn btn-outline-primary main-navigation-toggle d-flex d-xl-none align-items-center" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvas-navigation" aria-controls="offcanvas-navigation" aria-expanded="false"
                        aria-label="<?php echo __('Toggle navigation', 'basetheme') ?>"
                        id="main-navigation-toggle"
                >
                    <i class="fas fa-bars" aria-hidden="true"></i><span class="visually-hidden"><?php echo __('Menu', 'basetheme') ?></span>
                </button>

                <div class="offcanvas offcanvas-end d-xl-none" tabindex="-1" id="offcanvas-navigation" aria-labelledby="offcanvas-navigation-toggle">
                    <div class="offcanvas-header px-3 py-3 d-flex justify-content-between border-bottom mb-3">
                        <h4 class="h5 ms-3 mb-0"><?php echo __('Menu', 'basetheme') ?></h4>
                        <button data-bs-dismiss="offcanvas" class="btn btn-outline-primary btn-sm p-3 offcanvas-navigation-toggle d-flex align-items-center" aria-label="<?php echo __('Close') ?>">
                            <i class="fas fa-times" aria-hidden="true"><span></span></i><span class="visually-hidden" aria-hidden="true"><?php echo __('Close menu', 'basetheme') ?></span>
                        </button>
                    </div>
                    <div class="offcanvas-body px-3 px-lg-7 pt-0 pb-3 pb-lg-50">
                        <?php wp_nav_menu([
                            'theme_location' => 'mainmenu',
                            'container'      => false,
                            'depth'             => 2,
                            'menu_class'     => 'nav flex-column nav-offcanvas',
                            'menu_id'        => 'mainmenu-mobile',
                            'walker'         => new OffcanvasNavWalker()
                        ]) ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</header>