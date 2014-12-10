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
        /**
         * Registering the actual values
         */
		register_setting('cskt_plugin', 'cskt_source_id', 'cskt_sanitize_integer');
        register_setting('cskt_plugin', 'cskt_client_id', 'cskt_sanitize_integer');
        register_setting('cskt_plugin', 'cskt_facebook_app_id');
        register_setting('cskt_plugin', 'cskt_facebook_app_secret');

		/**
         * Registering sections
         */
        add_settings_section('cskt_pageviews', 'Pageview Tracking', 'cskt_pageview_explain', 'crowdskout');
		add_settings_section('cskt_newsletter', 'Newsletter Tracking', 'cskt_newsletter_explain', 'crowdskout');

        /**
         * Registering fields
         */
		add_settings_field('cskt_source_id', 'Source ID', 'cskt_input_number', 'crowdskout', 'cskt_pageviews', array(
			'name' => 'cskt_source_id'
		));
        add_settings_field('cskt_client_id', 'Client ID', 'cskt_input_number', 'crowdskout', 'cskt_newsletter', array(
			'name' => 'cskt_client_id'
		));
        add_settings_field('cskt_facebook_app_id', 'Facebook App ID', 'cskt_input_number', 'crowdskout', 'cskt_social_media', array(
			'name' => 'cskt_facebook_app_id'
		));
        add_settings_field('cskt_facebook_app_secret', 'Facebook App Secret', 'cskt_input_number', 'crowdskout', 'cskt_social_media', array(
			'name' => 'cskt_facebook_app_secret'
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