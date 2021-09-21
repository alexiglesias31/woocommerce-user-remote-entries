<?php

/**
 * WoocommerceUserRemoteEntries Functions
 */

defined('ABSPATH') || exit;

/**
 * Get template part.
 *
 * @param string $slug
 * @param string $name Optional. Default ''.
 */
if (!function_exists('wcure_get_template_part')) {
	function wcure_get_template_part($slug, $atts = array())
	{
		$template = '';

		// Look in %theme_dir/template_path/slug.php
		$template = locate_template(WCURE()->template_path() . $slug . '.php');

		// Get default template from plugin
		if (empty($template) && file_exists(WCURE()->get_asset_path('/templates/' . $slug . '.php'))) {
			$template = WCURE()->get_asset_path('templates/' . $slug . '.php');
		}

		// Allow 3rd party plugins to filter template file from their plugin.
		$template = apply_filters('wcure_get_template_part', $template, $slug, $atts);

		if (!empty($template)) {
			wcure_get_template($template, $atts);
		}
	}
}

/**
 * Get template.
 *
 * @param string $template
 * @param string $args Optional. Default array().
 */
if (!function_exists('wcure_get_template')) {
	function wcure_get_template($template, $template_args = array())
	{
		if ($template_args && is_array($template_args)) {
			extract($template_args);
		}
		require $template;
	}
}

/**
 * Insert an element into an array after a specified key
 * 
 * @param array $array
 * @param array (key => value) $new_item The new item to be inserted array
 * @param mixed $array_key The new item will be inserted before $array_key 
 */
if (!function_exists('wcure_array_insert_before')) {
	function wcure_array_insert_before($array, $new_item, $array_key = '')
	{
		$position = array_search($array_key, array_keys($array));
		if ($position) {
			$new_array = array_slice($array, 0, $position, true);
			$new_array += $new_item;
			$new_array += array_slice($array, $position, count($array) - $position, true);
		} else {
			$new_array = $array;
			$new_array += $new_item;
		}

		return $new_array;
	}
}
