<?php

namespace BestProject\Customize\Control;

use WP_Customize_Control;
use WP_Post;
use WP_Query;

final class Post_Customize_Control extends WP_Customize_Control
{

    public $type = 'posts';

    public $post_type = 'post';

    public function render_content(): void
    {

        ?>
        <div class="image_checkbox_control">

            <?php if( !empty( $this->label ) ) { ?>
                <span class="customize-control-title" id="<?php echo esc_attr( $this->id ) ?>__label"><?php echo esc_html( $this->label ); ?></span>
            <?php } ?>

            <?php if( !empty( $this->description ) ) { ?>
                <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php } ?>

            <?php $options = $this->getOptions() ?>

            <?php $selected = (int)$this->value(); ?>
            <select id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" class="posts_customize_control" <?php $this->link(); ?> aria-labelledby="<?php echo esc_attr( $this->id ) ?>__label">
                <option value=""><?php echo __('- Select -', 'bestproject') ?></option>
                <?php foreach ( $options as $key => $post ) {
                    /**
                     * @var WP_Post $post
                     */
                ?>
                    <option value="<?php echo $post->ID ?>" <?php echo ($selected===$post->ID ? 'selected="':'') ?>>
                        <?php echo $post->post_title ?>
                    </option>
                <?php	} ?>
            </select>
        </div>
        <?php
    }

    private function getOptions(): array
    {
        $args = [
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => -1,
            'fields'              => 'id,post_title',
            'post_type'           => $this->post_type,
            'post_status'         => 'publish',
            'orderby' => 'post_title',
            'order' => 'ASC',
        ];

        return (new WP_Query(
            $args
        ))->get_posts();
    }
}