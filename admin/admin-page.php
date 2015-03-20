<?php
/**
 * This contains all the settings and functions necessary to create the admin page
 */
if (!function_exists('cskt_submenu_page')) {
	/**
	 * Creates our admin page for us (1. Create a function that contains the menu-building code)
	 */
	function cskt_menu_register() {
		add_options_page('Crowdskout', 'Crowdskout', 'manage_options', 'crowdskout', 'cskt_admin_page_generator');
	}

	/**
	 * 2. Register the above function using the admin_menu action hook.
	 */
	add_action('admin_menu', 'cskt_menu_register');
}

if (!function_exists('cskt_add_settings')) {
	/**
	 * Registering our settings
	 */
	function cskt_add_settings() {
        /**
         * Registering the actual values
         */

		/**
         * Registering sections
         */

        /**
         * Registering fields
         */

	}
	add_action('admin_init', 'cskt_add_settings');
}

require CSKT_PLUGIN_SERVER_ROOT . '/admin/sanitization.php';
require CSKT_PLUGIN_SERVER_ROOT . '/admin/explanations.php';
require CSKT_PLUGIN_SERVER_ROOT . '/admin/fields.php';

if (!function_exists('cskt_admin_page_generator')) {
	/**
	 * Is responsible for generating and creating the markup for the page.
	 * 3. Create the HTML output for the page (screen) displayed when the menu item is clicked
	 */
	function cskt_admin_page_generator() {
		require CSKT_PLUGIN_SERVER_ROOT . '/views/admin-page.php';
	}
}