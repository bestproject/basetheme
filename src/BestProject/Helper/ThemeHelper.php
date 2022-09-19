<?php

namespace BestProject\Helper;

use Exception;

/**
 * Theme helper.
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

}