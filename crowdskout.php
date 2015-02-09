<?php
    /**
     * Plugin Name: Crowdskout
     * Plugin URI: http://crowdskout.com
     * Description: Adds Crowdskout analytics to your site
     * Version: 1.0
     * Author: George Yates III
     * Author URI: http://georgeyatesiii.com
     * Text Domain: crowdskout
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

    define('CSKT_PLUGIN_SERVER_ROOT', __DIR__);

    require_once CSKT_PLUGIN_SERVER_ROOT . '/utils/logger.php'; // util functions for dev
    require_once CSKT_PLUGIN_SERVER_ROOT . '/admin/admin-page.php'; // generates settings page
    require_once CSKT_PLUGIN_SERVER_ROOT . '/widget.php';
    require_once CSKT_PLUGIN_SERVER_ROOT . '/shortcode.php';
    require_once CSKT_PLUGIN_SERVER_ROOT . '/topics.php';

    /** include the WP_Http class for http requests */
    if( !class_exists( 'WP_Http' ) )
        include_once( ABSPATH . WPINC. '/class-http.php' );

	CSKT_Shortcode_Factory::create('cskt_newsletter');
	CSKT_Shortcode_Factory::create('cskt_fb_like');
	CSKT_Shortcode_Factory::create('cskt_fb_share');
	CSKT_Shortcode_Factory::create('cskt_tw_follow');
	CSKT_Shortcode_Factory::create('cskt_tw_share');

	/** functions to add crowdskout scripts and styles */
	if (!function_exists('cskt_debug')) {
		/**
		 * @return string for $flag variable in scripts functions
		 */
		function cskt_debug() {
			if ( ! WP_DEBUG ) {
				return '.min';
			} else {
				wp_enqueue_script( 'livereload.js', "//localhost:1337/livereload.js", array( 'jquery' ), '', true );
				return '';
			}
		}
	}

    if (!function_exists('cskt_add_scripts')) {
        add_action( 'wp_enqueue_scripts', 'cskt_add_scripts' );
        function cskt_add_scripts() {
	        $flag = cskt_debug();
	        wp_enqueue_script('cskt', plugins_url() . '/crowdskout-wp/js/cskt' . $flag . '.js', array('jquery'), '', true );
            wp_enqueue_script('forms_js_interface', plugins_url() . '/crowdskout-wp/js/forms_js_interface' . $flag . '.js', array('jquery'), '', true );
            wp_enqueue_script('fb_sdk_js_interface', plugins_url() . '/crowdskout-wp/js/fb_sdk_js_interface' . $flag . '.js', array('cskt'), '', true );
            wp_enqueue_script('tw_sdk_js_interface', plugins_url() . '/crowdskout-wp/js/tw_sdk_js_interface' . $flag . '.js', array('cskt'), '', true );
	        wp_enqueue_style('cskt_css', plugins_url() . '/crowdskout-wp/css/cskt.css');
        }
    }

	if (!function_exists('cskt_add_admin_scripts')) {
		add_action( 'admin_enqueue_scripts', 'cskt_add_admin_scripts' );
		function cskt_add_admin_scripts() {
			$flag = cskt_debug();
			wp_enqueue_script('cskt_admin', plugins_url() . '/crowdskout-wp/js/cskt_admin' . $flag . '.js', array('jquery','jquery-ui-sortable'), '', true);
			wp_enqueue_script('accordionmenu', plugins_url() . '/crowdskout-wp/js/cskt-accordionmenu' . $flag . '.js', array('cskt_admin'), '', true);
			wp_enqueue_style('cskt_admin_css', plugins_url() . '/crowdskout-wp/css/cskt.css');
		}
	}

	/**
	 * function that adds 3rd party facebook js to page
	 */
	if (!function_exists('cskt_add_fb_js')) {
		add_action('wp_footer', 'cskt_add_fb_js');
		function cskt_add_fb_js() {
			require CSKT_PLUGIN_SERVER_ROOT . '/views/facebook_sdk_js.php';
		}
	}
	if (!function_exists('cskt_add_tw_js')) {
		add_action('wp_footer', 'cskt_add_tw_js');
		function cskt_add_tw_js() {
			require CSKT_PLUGIN_SERVER_ROOT . '/views/twitter_sdk_js.php';
		}
	}

	/**
	 * The main function that takes cskt's analytics javascript and
	 * adds it to the footer of the application for tracking.
	 */
	if (!function_exists('cskt_add_analytics_js')) {
		add_action('wp_footer', 'cskt_add_analytics_js');
		function cskt_add_analytics_js() {
			require CSKT_PLUGIN_SERVER_ROOT . '/views/footer-js.php';
		}
	}