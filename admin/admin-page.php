<?php
/**
 * This contains all the settings and functions necessary to create the admin page
 */
if (!function_exists('cdskt_submenu_page')) {
	/**
	 * Creates our admin page for us
	 */
	function cdskt_menu_register() {
		add_options_page('Crowdskout', 'Crowdskout', 'manage_options', 'crowdskout', 'cdskt_admin_page_generator');
	}
	add_action('admin_menu', 'cdskt_menu_register');
}

if (!function_exists('cdskt_admin_page_generator')) {
	/**
	 * Is reponsible for generating and creating the markup for the page
	 */
	function cdskt_admin_page_generator() {
		require CDSKT_PLUGIN_SERVER_ROOT . '/partials/admin-page.php';
	}
}