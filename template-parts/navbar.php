<?php

use BestProject\NavWalker\Bootstrap5NavWalker;

?>
<header class="position-relative">
    <div class="navbar navbar-light navbar-expand-xl" id="nav">
        <div class="container">
            <a class="navbar-brand mr-0 mr-lg-60" href="<?php echo get_home_url() ?>">
                <?php if (get_option('logo') !== ''): ?>
                    <img src="<?php echo get_option('logo') ?>" class="logo-light" alt="<?php bloginfo('name') ?> - <?php echo __('Logo', 'basetheme') ?>">
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