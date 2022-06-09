<?php

namespace BestProject\Customize\Control;

use WP_Customize_Control;

/**
 * Custom class for multiselect categories in customizer.
 *
 * @package BestProject\Customize\Control
 */
class Post_Categories_Control extends WP_Customize_Control
{

    /**
     * Control types.
     *
     * @var string
     */
    public $type = 'post-categories';

    /**
     * Categories dropdown args.
     *
     * @var bool|array
     */
    protected $dropdown_args = false;

    /**
     * Render customizer control
     */
    protected function render_content()
    {

        $defaults = [
            'show_option_all'   => '',
            'show_option_none'  => '',
            'orderby'           => 'name',
            'order'             => 'ASC',
            'show_count'        => true,
            'hide_empty'        => 1,
            'child_of'          => 0,
            'exclude'           => '',
            'echo'              => 1,
            'selected'          => [],
            'hierarchical'      => 0,
            'name'              => 'cat',
            'id'                => '',
            'class'             => 'postform',
            'depth'             => 0,
            'tab_index'         => 0,
            'taxonomy'          => 'category',
            'hide_if_empty'     => false,
            'option_none_value' => -1,
            'value_field'       => 'term_id',
            'required'          => false,
            'multiple'          => false,
        ];

        $parsed_args = wp_parse_args($this->dropdown_args, $defaults);

        $get_terms_args = $parsed_args;

        unset($get_terms_args['name']);

        $categories = get_terms($get_terms_args);

        $name     = esc_attr($parsed_args['name']);
        $class    = esc_attr($parsed_args['class']);
        $id       = $parsed_args['id'] ? esc_attr($parsed_args['id']) : $name;
        $required = $parsed_args['required'] ? 'required' : '';
        $multiple = $parsed_args['multiple'] ? 'multiple':'';
        $tab_index = $parsed_args['tab_index'];
        $tab_index_attribute = '';
        if ( (int) $tab_index > 0 ) {
            $tab_index_attribute = " tabindex=\"$tab_index\"";
        }

        $value = !is_array($parsed_args['selected']) ? [$parsed_args['selected']]: $parsed_args['selected'];
        array_walk($value, 'intval');

        $option_none_value = $parsed_args['option_none_value'];
        $show_option_none = apply_filters( 'list_cats', $parsed_args['show_option_none'], null );


        // Do not show if field is empty
        if( $parsed_args['hide_if_empty'] && empty( $categories ) ) {
            return;
        }

        if (!empty($this->label)) : ?>
            <label class="customize-control-title" for="<?php echo $id ?>">
                <?php echo esc_html($this->label); ?>
            </label>
        <?php endif;

        if (!empty($this->description)) :?>
            <span class="description customize-control-description">
                <?php echo $this->description; ?>
            </span>
        <?php endif; ?>

        <select name="<?php echo $name ?>" id="<?php echo $id ?>" class="<?php echo $class ?>" <?php echo $multiple ?> <?php echo $required ?> <?php echo $tab_index_attribute ?> <?php echo $this->get_link() ?> style="padding-top: 8px;">

            <?php if ( empty( $categories ) && ! $parsed_args['hide_if_empty'] && ! empty( $parsed_args['show_option_none'] ) ): ?>
                <option value="<?php echo esc_attr( $option_none_value ) ?>" selected="selected"><?php echo $show_option_none ?></option>
            <?php elseif( !empty($categories) ): ?>

                <?php if ( $parsed_args['show_option_all'] ):
                    $show_option_all = apply_filters( 'list_cats', $parsed_args['show_option_all'], null );
                    $selected        = ( '0' === (string) $parsed_args['selected'] ) ? " selected='selected'" : '';
                    ?>
                    <option value="0"<?php echo $selected ?>><?php echo $show_option_all ?></option>
                <?php endif ?>

                <?php if ( $parsed_args['show_option_none'] ):
                    $show_option_none = apply_filters( 'list_cats', $parsed_args['show_option_none'], null );
                    $selected         = selected( $option_none_value, $parsed_args['selected'], false );
                    ?>
                    <option value="<?php echo esc_attr($option_none_value) ?>"<?php echo $selected ?>><?php echo $show_option_none ?></option>
                <?php endif ?>

            <?php endif ?>

            <?php foreach($categories as $category): ?>
                <option value="<?php echo $category->term_id ?>" <?php if( in_array($category->term_id, $value, false) ): ?>selected="selected"<?php endif ?>>
                    <?php echo $category->name ?>
                    <?php if( $parsed_args['show_count'] ): ?>
                        (<?php echo (int)$category->count ?>)
                    <?php endif ?>
                </option>
            <?php endforeach ?>
        </select>

        <?php

    }
}