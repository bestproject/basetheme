<?php

/**
 * @var array $args
 */

use BestProject\Helper\PatternHelper;
use BestProject\NavWalker\Bootstrap5NavWalker;

extract($args, EXTR_OVERWRITE);

?>
<?php echo PatternHelper::getPatternById((int)get_theme_mod('patterns_footer', 0), true, 'footer-pattern'); ?>
<footer>
    <div class="container d-flex flex-column flex-md-row flex-wrap align-items-center justify-content-between">
        <p class="mb-0 copyrights text-muted">
            &copy;&nbsp;<?php echo date('Y') ?>&nbsp;<?php echo get_theme_mod('copyrights', get_bloginfo('name', 'display')) ?>
        </p>

        <p class="mb-0 designed-by text-muted">
            <?php echo __('Designed by', 'basetheme') ?>: <a href="#" target="_blank"><?php echo __('Designer', 'basetheme') ?></a>
        </p>

        <?php if( has_nav_menu('footermenu') ): ?>
            <?php wp_nav_menu([
                'theme_location' => 'footermenu',
                'container'      => false,
                'depth'          => 1,
                'menu_class'     => 'nav flex-row flex-wrap',
                'menu_id'        => 'footer-menu',
                'walker'         => new Bootstrap5NavWalker()
            ]) ?>
        <?php endif ?>

    </div>
</footer>
