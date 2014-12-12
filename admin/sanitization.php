<?php
/** These are the settings that sanitize our various option values */
if (!function_exists('cskt_sanitize_integer')) {
	/** Checks for integer values */
	function cskt_sanitize_integer($in) {
		return is_numeric($in) ? (int) $in : 0;
	}
}