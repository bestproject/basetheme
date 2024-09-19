<?php

namespace BaseTheme\Action;


use BestProject\Helper\AssetsHelper;
use BestProject\Helper\ThemeHelper;
use BaseTheme\Constants;
use Exception;
use JsonException;

/**
 * Methods running on admin_init action.
 *
 * @package BaseTheme\Action
 */
final class admin_init
{

    /**
     * Register editor css style.
     *
     * @throws Exception
     */
    public static function registerEditorStyles(): void
    {
        add_theme_support( 'editor-styles' );
        add_theme_support( 'customize-selective-refresh-widgets' );
        add_editor_style(AssetsHelper::getAssetUrl('wp-content/themes/'.ThemeHelper::getTheme().'/assets/build/editor-styles.css'));
        add_editor_style(Constants::FONTS_URL);
    }

    /**
     * @throws JsonException
     */
    public static function syncPatterns(): void
    {
        $theme_name = (string)wp_get_theme();

        // Check each pattern
        $root = get_template_directory().'/patterns';
        foreach (glob($root . '/*.json') as $path) {

            $filename = pathinfo($path, PATHINFO_FILENAME);
            $pattern_file = $root.'/'.$filename.'.php';

            if( !is_file($pattern_file) || filemtime($path) > filemtime($pattern_file) ) {
                $details = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
                $title = $details['title'];
                $content = $details['content'];
                $slug = strtolower($theme_name.'/'.$filename);

                $buffer = '<?php'.PHP_EOL;
                $buffer.= '/**'.PHP_EOL;
                $buffer.= " * Title: $title".PHP_EOL;
                $buffer.= " * Slug: $slug".PHP_EOL;
                $buffer.= " * Categories: $theme_name".PHP_EOL;
                $buffer.= ' */'.PHP_EOL;
                $buffer.= '?>'.PHP_EOL;
                $buffer.= $content;

                file_put_contents($pattern_file, $buffer);
            }
        }
    }


}