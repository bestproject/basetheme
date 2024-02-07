<?php get_header() ?>
<?php while(have_posts()): the_post(); ?>
    <?php echo apply_filters('the_content', get_the_content()) ?>
<?php endwhile ?>
<?php get_footer() ?>