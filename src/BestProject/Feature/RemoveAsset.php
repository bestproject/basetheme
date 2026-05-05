<?php

namespace BestProject\Feature;

/**
 * Ability to remove assets included by plugins and core.
 */
final class RemoveAsset
{
	protected static array $excludedScripts = [];
	protected static array $excludedStyles = [];

	public static function removeScript(string $handle): void
	{
		self::$excludedScripts[] = $handle;

		if( !has_filter( 'script_loader_tag', [ self::class, 'removeScriptCallback' ] ) ){
			add_filter( 'script_loader_tag', [ self::class, 'removeScriptCallback' ], 999, 2 );
		}
	}

	public static function removeScriptCallback($tag, $handle): string
	{
		if (in_array($handle, self::$excludedScripts, true)) {
			return '';
		}

		return $tag;
	}
	public static function removeStyle(string $handle): void
	{
		self::$excludedStyles[] = $handle;

		if( !has_filter( 'style_loader_tag', [ self::class, 'removeStyleCallback' ] ) ){
			add_filter( 'style_loader_tag', [ self::class, 'removeStyleCallback' ], 999, 2 );
		}
	}

	public static function removeStyleCallback($tag, $handle): string
	{
		if (in_array($handle, self::$excludedStyles, true)) {
			return '';
		}

		return $tag;
	}
}