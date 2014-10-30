<?php
/**
 * This contains all the settings and functions necessary to create the admin page
 */
if (!function_exists('cskt_submenu_page')) {
	/**
	 * Creates our admin page for us
	 */
	function cskt_menu_register() {
		add_options_page('Crowdskout', 'Crowdskout', 'manage_options', 'crowdskout', 'cskt_admin_page_generator');
	}
	add_action('admin_menu', 'cskt_menu_register');
}

if (!function_exists('cskt_add_settings')) {
	/**
	 * Registering our settings
	 */
	function cskt_add_settings() {
		// Registering the actual values
		register_setting('cskt_plugin', 'cskt_source_id', 'cskt_sanitize_integer');

		// Registering sections
		add_settings_section('cskt_pageviews', 'Pageview Tracking', 'cskt_pageview_explain', 'crowdskout');

		// Registering fields
		add_settings_field('cskt_source_id', 'Source ID', 'cskt_input_number', 'crowdskout', 'cskt_pageviews', array(
			'name' => 'cskt_source_id'
		));
	}
	add_action('admin_init', 'cskt_add_settings');
}

require CSKT_PLUGIN_SERVER_ROOT . '/admin/sanitization.php';
require CSKT_PLUGIN_SERVER_ROOT . '/admin/explanations.php';
require CSKT_PLUGIN_SERVER_ROOT . '/admin/fields.php';

if (!function_exists('cskt_admin_page_generator')) {
	/**
	 * Is reponsible for generating and creating the markup for the page
	 */
	function cskt_admin_page_generator() {
		require CSKT_PLUGIN_SERVER_ROOT . '/views/admin-page.php';
	}
}