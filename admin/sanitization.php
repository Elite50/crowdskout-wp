<?php
/**
 * These are the settings that sanitize our various option values
 */
if (!function_exists('cdskt_sanitize_integer')) {
	// Checks for integer values
	function cdskt_sanitize_integer($in) {
		return is_numeric($in) ? (int) $in : 0;
	}
}