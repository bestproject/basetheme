<?php


/**
 * @var array $args
 */
extract($args, EXTR_OVERWRITE);

$pages =  paginate_links(
    [
        'before_page_number' => '',
        'mid_size'           => 3,
        'end_size'           => 3,
        'prev_text'          => '<i class="fas fa-angle-left" aria-hidden="false"></i>',
        'next_text'          => '<i class="fas fa-angle-right" aria-hidden="false"></i>',
        'type'=> 'array'
    ]
);

if( !is_array($pages) || $pages === [] ) {
    return;
}
?>
<nav aria-label="<?php echo __('Pages navigation', 'basetheme') ?>">
    <ul class="pagination align-items-center justify-content-center my-3 my-md-5">
        <?php foreach( $pages as $page ): ?>
            <?php if( stripos($page, 'current')!==false ): ?>
                <li class="page-item active">
                    <?php echo str_ireplace('page-numbers','page-numbers page-link', $page) ?>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <?php echo str_ireplace('page-numbers','page-numbers page-link', $page) ?>
                </li>
            <?php endif ?>
        <?php endforeach ?>
    </ul>
</nav>
