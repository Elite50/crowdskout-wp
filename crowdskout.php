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


/**
 * Let's define our constants
 */
define('CSKT_PLUGIN_SERVER_ROOT', __DIR__);
define('TO_SHORTCODES_DIR', plugins_url() . '/crowdskout-wp/shortcodes');

// add all scripts and styles through this function
add_action( 'wp_enqueue_scripts', 'cskt_add_scripts' );
function cskt_add_scripts() {
    wp_enqueue_script( 'jquery' ); // loads jQuery's pre-registered (by Wordpress) script(s) into the plugin
    if (!WP_DEBUG) { // use minified scripts and styles if not in debug mode, for example on live site, as opposed to dev site.
        $flag = '.min';
        // js
        wp_enqueue_script('shortcodes' . $flag . '.js', TO_SHORTCODES_DIR . "/shortcodes" . $flag . ".js", array('jquery'), '', true );
    } else { // in debug, use unminified files
        $flag = '';
        // js
        wp_enqueue_script('livereload.js', "//localhost:1337/livereload.js", array('jquery'), '', true);
        wp_enqueue_script('cskt-email.js', TO_SHORTCODES_DIR . "/email/cskt-email.js", array('jquery'), '', true );
    }
    // css
    wp_enqueue_style('shortcodes' . $flag . '.css', plugins_url() . '/crowdskout-wp/shortcodes/shortcodes' . $flag . '.css');

}

//Logger
require_once CSKT_PLUGIN_SERVER_ROOT . '/utils/logger.php';

if (!function_exists('cskt_add_analytics_js')) {
	/**
	 * The main function that takes our javascript and
	 * adds it to the footer of the application for tracking.
	 */
	function cskt_add_analytics_js() {
		$sourceId = get_option('cskt_source_id');

		if (is_numeric($sourceId) && 0 !== (int) $sourceId) {
			require CSKT_PLUGIN_SERVER_ROOT . '/partials/footer-js.php';
		}
	}
	add_action('wp_footer', 'cskt_add_analytics_js');
}

add_action('wp_enqueue_scripts', 'cs_localize_ajax');
function cs_localize_ajax() {
	wp_localize_script( 'jquery', 'cs_ajax', array('url' => admin_url( 'admin-ajax.php' )));
}

// Reponsible for generating the settings page
require_once CSKT_PLUGIN_SERVER_ROOT . '/admin/admin-page.php';
require_once CSKT_PLUGIN_SERVER_ROOT . '/shortcodes/shortcodes.php';

