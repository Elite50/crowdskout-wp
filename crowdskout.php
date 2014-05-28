<?php
/**
 * Plugin Name: Crowdskout
 * Plugin URI: http://crowdskout.com
 * Description: Adds Crowdskout analytics to your site
 * Version: 1.0
 * Author: George Yates III
 * Author URI: http://georgeyatesiii.com
 * License: GPL2
 * 
 * 
 * Copyright 2014  George Yates III  (email : me@georgeyatesiii.com)
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Let's define our constants
 */
define('CDSKT_PLUGIN_SERVER_ROOT', __DIR__);

if (!function_exists('cdskt_add_analytics_js')) {
	/**
	 * The main function that takes our javascript and
	 * adds it to the footer of the application for tracking.
	 */
	function cdsks_add_analytics_js() {
		$sourceId = 0; // @TODO
		require CDSKT_PLUGIN_SERVER_ROOT . '/partials/footer-js.php';
	}
	add_action('wp_footer', 'cdsks_add_analytics_js');
}

if (!function_exists('cdskt_add_settings')) {
	/**
	 * Registering our settings
	 */
	function cdskt_add_settings() {
		register_setting('cdskt_plugin', 'sourceId', 'sanitize_owner_id');

	}
	add_action('admin_init', 'cdskt_add_settings');
}

require_once CDSKT_PLUGIN_SERVER_ROOT . '/admin/admin-page.php';