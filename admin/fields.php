<?php
/**
 * Contains all the callback functions for admin fields
 */
if (!function_exists('cskt_input_number')) {
	/** Displays an input field that only takes numeric values */
	function cskt_input_number($args) {
		$name = $args['name'];
		$value = get_option($name);
		require CSKT_PLUGIN_SERVER_ROOT . '/views/input-number.php';
	}
}

if (!function_exists('cskt_input_string')) {
	/** Displays an input field that only takes numeric values */
	function cskt_input_string($args) {
		$name = $args['name'];
		$value = get_option($name);
		require CSKT_PLUGIN_SERVER_ROOT . '/views/input-string.php';
	}
}