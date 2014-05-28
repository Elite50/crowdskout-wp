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

if (!function_exists('cdskt_add_settings')) {
	/**
	 * Registering our settings
	 */
	function cdskt_add_settings() {
		// Registering the actual values
		register_setting('cdskt_plugin', 'cdskt_source_id', 'cdskt_sanitize_integer');

		// Registering sections
		add_settings_section('cdskt_pageviews', 'Pageview Tracking', 'cdskt_pageview_explain', 'crowdskout');		

		// Registering fields
		add_settings_field('cdskt_source_id', 'Source ID', 'cdskt_input_number', 'crowdskout', 'cdskt_pageviews', array(
			'name' => 'cdskt_source_id'
		));
	}
	add_action('admin_init', 'cdskt_add_settings');
}

require CDSKT_PLUGIN_SERVER_ROOT . '/admin/sanitization.php';
require CDSKT_PLUGIN_SERVER_ROOT . '/admin/explanations.php';
require CDSKT_PLUGIN_SERVER_ROOT . '/admin/fields.php';

if (!function_exists('cdskt_admin_page_generator')) {
	/**
	 * Is reponsible for generating and creating the markup for the page
	 */
	function cdskt_admin_page_generator() {
		require CDSKT_PLUGIN_SERVER_ROOT . '/partials/admin-page.php';
	}
}