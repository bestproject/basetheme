<?php

namespace BestProject\Customize\Control;

use WP_Block_Patterns_Registry;
use WP_Customize_Control;
use WP_Post;

final class Pattern_Customize_Control extends WP_Customize_Control
{

    public $type = 'pattern';

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
            <select id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" class="pattern_customize_control" <?php $this->link(); ?> aria-labelledby="<?php echo esc_attr( $this->id ) ?>__label">
                <?php foreach ( $options as $key => $pattern ) { ?>
                    <option value="<?php echo esc_attr($pattern) ?>" <?php echo ($selected===$pattern) ?>>
                        <?php echo $pattern ?>
                    </option>
                <?php	} ?>
            </select>
        </div>
        <?php
    }

    private function getOptions(): array
    {
        $patterns  = WP_Block_Patterns_Registry::get_instance()->get_all_registered();

        return array_map(
            static function ( array $pattern ) {
                return $pattern['name'];
            },
            $patterns
        );
    }
}