<?php

if( !function_exists('yoast_breadcrumb') ) {
    return;
}
?>
<div class="my-0">
    <?php
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<div class="yoast-breadcrumbs">','</div>' );
    }
    ?>
</div>
