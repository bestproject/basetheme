<?php

namespace BestProject\Command;

use Composer\Script\Event;
use Exception;
use RuntimeException;

/**
 * WordPress Base theme build command for Composer.
 *
 * @package     BestProject\Command
 *
 * @since       1.0
 */
class Make
{

    /**
     * Theme name. eg. basetheme
     *
     * @var string
     *
     * @since 1.0
     */
    protected string $theme_name;

    /**
     * Template base directory. eg. /var/www/example.com/wp-content/themes/basetheme
     *
     * @var string
     *
     * @since 1.0
     */
    protected string $theme_path;

    /**
     * System root directory. eg. /var/www/example.com
     *
     * @var string
     *
     * @since 1.0
     */
    protected string $theme_root_path;

    /**
     * Template classes namespace.
     *
     * @var string
     *
     * @since 1.0
     */
    protected string $namespace;

    /**
     * Run all required methods to create new theme.
     *
     * @since  1.0
     */
    public function __construct()
    {

        // Get required directories
        $this->theme_path      = dirname(__DIR__, 3);
        $this->theme_root_path = dirname($this->theme_path, 3);
        $this->theme_name      = basename($this->theme_path);
        $this->namespace  = ucfirst($this->theme_name);

        // If template can't be build
        if (!$this->canBuild()) {
            $this->write("You are trying to build without changing template name. Change /wp-content/themes/basetheme to /wp-content/themes/YOUR_THEME_NAME and try again.");
        }

    }

    /**
     * Check if template can be build.
     *
     * @return bool
     *
     * @since 2.0
     */
    public function canBuild(): bool
    {
        return (strtolower($this->theme_name) !== 'basetheme');
    }

    /**
     * Write line to console.
     *
     * @param   string  $text  Text.
     *
     * @since 2.0
     */
    public static function write(string $text): void
    {
        echo $text . PHP_EOL;
    }

    /**
     * Execute the builder.
     *
     * @since 1.0
     */
    public static function execute(Event $e): void
    {
        $arguments = $e->getArguments();

        if( count($arguments)<2 ) {
            self::write("No command provided. Available commands are: block-style, plugin-style, component-style");
        }

        $instance = new self();

        $command = array_first($arguments);
        switch ($command) {
            case 'block-style':
                $instance->createBlockStyle(...array_slice($arguments, 1));
                break;
            case 'plugin-style':
            case 'extension-style':
                $instance->createPluginStyle(...array_slice($arguments, 1));
                break;
            case 'component-style':
                $instance->createComponentStyle(...array_slice($arguments, 1));
                break;
            default:
                self::write("Unknown command $command. Available commands are: block-style, plugin-style");
        }

    }

    private function createBlockStyle(string $block_name, string $class_name): void
    {

        $filename = $block_name;
        if ( str_contains($block_name, '/')) {
            $filename = substr($block_name, strpos($block_name, '/')+1);
        }

        if( empty($class_name) ) {
            $class_name = ucfirst($filename);
        }

        // Create scss file
        $stylesheet_file = "{$this->theme_path}/.dev/scss/components/block/_{$filename}.scss";
        if( !file_exists($stylesheet_file) ) {
            touch($stylesheet_file);

            // Add import in _theme.scss
            self::insertFileText(
                "//< Blocks",
                "@import 'components/block/{$filename}';",
                "{$this->theme_path}/.dev/scss/_theme.scss"
            );
        }

        // Create php class
        $class_file_path = "{$this->theme_path}/src/{$this->namespace}/Block/Style/{$class_name}.php";
        if( !file_exists($class_file_path) ) {
            $classCode = <<<CLASS_CODE
<?php

namespace {$this->namespace}\Block\Style;

use BestProject\AutoRegister;

/**
 * Custom {$block_name} block styles
 */
class {$class_name} extends AutoRegister
{

    public static function styles(): void
    {
        register_block_style('{$block_name}', [
            'name' => '',
            'label' => __('', '{$this->theme_name}'),
        ]);
    }
    
}
CLASS_CODE;
            file_put_contents($class_file_path, $classCode);

            // Add use in functions.php
            self::insertFileText(
                "//< Block styles use",
                "use {$this->namespace}\Block\Style\\{$class_name} as {$class_name}Styles;",
                "{$this->theme_path}/functions.php"
            );
            self::insertFileText(
                "//< Block styles registration",
                "add_action('init', [{$class_name}Styles::class, 'register']);",
                "{$this->theme_path}/functions.php"
            );
        }

    }

    private function createPluginStyle(string $plugin_name): void
    {

        $filename = $plugin_name;
        if ( str_contains($plugin_name, '/')) {
            $filename = substr($plugin_name, strpos($plugin_name, '/')+1);
        }

        // Create scss file
        $stylesheet_file = "{$this->theme_path}/.dev/scss/extensions/_{$filename}.scss";
        if( !file_exists($stylesheet_file) ) {
            touch($stylesheet_file);

            // Add import in _theme.scss
            self::insertFileText(
                "//< Plugins",
                "@import 'extensions/{$filename}';",
                "{$this->theme_path}/.dev/scss/_theme.scss"
            );
        }

    }

    private function createComponentStyle(string $component_name): void
    {

        $filename = $component_name;
        if ( str_contains($component_name, '/')) {
            $filename = substr($component_name, strpos($component_name, '/')+1);
        }

        // Create scss file
        $stylesheet_file = "{$this->theme_path}/.dev/scss/components/_{$filename}.scss";
        if( !file_exists($stylesheet_file) ) {
            touch($stylesheet_file);

            // Add import in _theme.scss
            self::insertFileText(
                "//< Components",
                "@import 'components/{$filename}';",
                "{$this->theme_path}/.dev/scss/_theme.scss"
            );
        }

    }

    public static function insertFileText(string $shortcode, string $text, string $file): void
    {
        if( !file_exists($file) ) {
            throw new RuntimeException("File $file doesn't exist!");
        }

        $buffer = file_get_contents($file);
        if( !str_contains($buffer, $shortcode) ) {
            throw new RuntimeException("Shortcode $shortcode wasn't found in $file!");
        }

        $buffer = substr_replace($buffer, $text."\n", strpos($buffer, $shortcode), 0);

        file_put_contents($file, $buffer);
    }

}