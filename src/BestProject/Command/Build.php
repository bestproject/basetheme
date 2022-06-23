<?php

namespace BestProject\Command;

use Composer\Script\Event;
use Exception;

/**
 * WordPress Base theme build command for Composer.
 *
 * @package     BestProject\Command
 *
 * @since       1.0
 */
class Build
{

    /**
     * Theme name. eg. basetheme
     *
     * @var string
     *
     * @since 1.0
     */
    protected string $name;

    /**
     * Template base directory. eg. /var/www/example.com/wp-content/themes/basetheme
     *
     * @var string
     *
     * @since 1.0
     */
    protected string $base;

    /**
     * System root directory. eg. /var/www/example.com
     *
     * @var string
     *
     * @since 1.0
     */
    protected string $root;

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
        $this->base      = dirname(__DIR__, 3);
        $this->root      = dirname($this->base, 3);
        $this->name      = basename($this->base);
        $this->namespace = ucfirst($this->name);

        // If template can't be build
        if (!$this->canBuild()) {
            $this->write("You are trying to build without changing template name. Change /wp-content/themes/basetheme to /wp-content/themes/YOUR_THEME_NAME and try again.");
        } else {

            $this->buildTheme();
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
        return (strtolower($this->name) !== 'basetheme');
    }

    /**
     * Write line to console.
     *
     * @param   string  $text  Text.
     *
     * @since 2.0
     */
    public function write(string $text): void
    {
        echo $text . PHP_EOL;
    }

    /**
     * Build template.
     *
     * @since 2.0
     */
    protected function buildTheme(): void
    {
        $this->write("Building theme ...");

        // Run build task
        $success = true;
        try {
            $this->prepareBaseFiles();
            $this->prepareLibraries();
            $this->prepareTemplateParts();

        } catch (Exception $e) {
            $success = false;
            $this->write("Error while building theme: " . $e->getMessage());
        }

        // Template build is successful
        if ($success) {
            $this->write("Finish.");
        }

    }

    /**
     * Replace strings in selected file.
     *
     * @param   string  $path     Path of a file.
     * @param   array   $strings  String to replace in key=>value pattern.
     *
     * @return void
     */
    protected function replaceInFile(string $path, array $strings): void
    {
        $buff = file_get_contents($path);
        foreach ($strings as $search => $replace) {
            $buff = str_replace($search, $replace, $buff);
        }
        file_put_contents($path, $buff);
    }

    /**
     * Prepare a theme base files.
     *
     * @since 1.0
     */
    public function prepareBaseFiles(): void
    {
        $this->write("Preparing theme base files ...");

        $strings = [
            "'basetheme'"                     => "'$this->name'",
            "Text Domain: basetheme"          => "Text Domain: " . strtolower($this->name),
            "Theme Name: Basetheme"           => "Theme Name: " . ucfirst($this->name),
            '"basetheme"'                     => '"' . $this->name . '"',
            '"name": "bestproject/basetheme"' => '"name": "bestproject/' . strtolower($this->name) . '"',
            'use BaseTheme'                   => 'use ' . $this->namespace,
        ];

        // Replace in files
        foreach (glob($this->base . '/*.*') as $path) {
            $this->replaceInFile($path, $strings);
        }

    }

    /**
     * Prepare a theme libraries files.
     *
     * @since 1.0
     */
    public function prepareLibraries(): void
    {
        $this->write("Preparing libraries files ...");

        $strings = [
            "'basetheme'"           => "'$this->name'",
            'namespace BaseTheme\\' => "namespace $this->namespace\\",
            '@package BaseTheme\\'  => "@package $this->namespace\\",
            'use BaseTheme'         => "use $this->namespace",
            "'basetheme-google-fonts'"         => "'{$this->name}-google-fonts'",
        ];

        // Replace in files
        foreach (glob($this->base . '/src/BaseTheme/Action/*.php') as $path) {
            $this->replaceInFile($path, $strings);
        }

        // Rename namespace directory
        rename($this->base . '/src/BaseTheme', $this->base . '/src/'.$this->namespace);

    }

    /**
     * Prepare theme template-parts files.
     *
     * @since 1.0
     */
    public function prepareTemplateParts(): void
    {
        $this->write("Preparing theme template-parts files. ...");

        $strings = [
            "'basetheme'"           => "'$this->name'",
            'use BaseTheme'         => "use $this->namespace",
        ];

        // Replace in files
        foreach (glob($this->base . '/template-parts/*.php') as $path) {
            $this->replaceInFile($path, $strings);
        }
    }

    /**
     * Execute the builder.
     *
     * @since 1.0
     */
    public static function execute(Event $e): void
    {
        $instance = new self();
    }

}