<?php

namespace BestProject\Helper;

use Exception;

/**
 * Template helper.
 *
 * @since 1.5.0
 */
abstract class ThemeHelper
{

	/**
	 * Current template name.
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private static string $template = '';

	/**
	 * Get current template name.
	 *
	 * @return string
	 *
	 * @throws Exception
	 *
	 * @since 1.0.0
	 */
	public static function getTheme(): string
	{
		if (static::$template === '')
		{
			static::$template = (string)wp_get_theme()->get_template();
		}

		return static::$template;
	}

    /**
     * Return phone number safe for use in tel: prefix of href attribute.
     *
     * @param   string  $phone
     *
     * @return string
     */
	public static function getPhoneAttrSafe(string $phone): string
    {
        return preg_replace('/[^0-9\-+]/', '', $phone);
    }

    /**
     * Bold the first word in sentence.
     *
     * @param   string  $text
     *
     * @return string
     */
    public static function boldFirst(string $text): string
    {
        $parts = explode(' ',$text);

        // Don't bold a single word
        if( count($parts)===1 ) {
            return $text;
        }

        $parts[0] = "<strong>{$parts[0]}</strong>";

        return implode(' ', $parts);
    }

    /**
     * Bold the first word in sentence.
     *
     * @param   string  $text
     *
     * @return string
     */
    public static function split2lines(string $text): string
    {
        $parts = explode(' ',$text);

        // Don't bold a single word
        $count = count($parts);
        if( $count===1 ) {
            return $text;
        }

        array_splice($parts, ceil($count/2), 0, ['<i class="d-none d-md-block"></i>']);

        return implode(' ', $parts);
    }

}