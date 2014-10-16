<?php
/**
 * Contains all the callback functions for admin fields
 */
if (!function_exists('cdskt_input_number')) {
	// Displays an input field that only takes numeric values
	function cdskt_input_number($args) {
		$name = $args['name'];
		$value = get_option($name);
		require CSKT_PLUGIN_SERVER_ROOT . '/partials/input-number.php';
	}
}