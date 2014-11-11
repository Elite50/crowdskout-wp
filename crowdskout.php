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

/**
* Now our required files
*/

// Util functions for dev
require_once CSKT_PLUGIN_SERVER_ROOT . '/utils/logger.php';

// Reponsible for generating the settings page
require_once CSKT_PLUGIN_SERVER_ROOT . '/admin/admin-page.php';

/**
* add the plugin's js and css
*/
// add all scripts and styles through this function
add_action( 'wp_enqueue_scripts', 'cskt_add_scripts' );
function cskt_add_scripts() {
    wp_enqueue_script( 'jquery' ); // loads jQuery's pre-registered (by Wordpress) script(s) into the plugin
    if (!WP_DEBUG) { // use minified scripts and styles if not in debug mode, for example on live site, as opposed to dev site.
        $flag = '.min';
        // js
        wp_enqueue_script('master' . $flag . '.js', plugins_url() . "/crowdskout-wp/js/cskt-email" . $flag . ".js", array('jquery'), '', true );
    } else { // in debug, use unminified files
        $flag = '';
        // js
        wp_enqueue_script('livereload.js', "//localhost:1337/livereload.js", array('jquery'), '', true);
        wp_enqueue_script('scripts.js', plugins_url() . "/crowdskout-wp/js/scripts.js", array('jquery'), '', true );
        //wp_enqueue_script('facebook_sdk_js.php', plugins_url() . "/crowdskout-wp/js/third_party_scripts/facebook_sdk_js.php", array('scripts.js'), '', true );
    }
}

// Function to grab users ip address even getting around proxies
function get_ip() {
    //Just get the headers if we can or else use the SERVER global
    if ( function_exists( 'apache_request_headers' ) ) {
        $headers = apache_request_headers();
    } else {
        $headers = $_SERVER;
    }
    //Get the forwarded IP if it exists (X-Forwarded-For is the server header set by the proxy to pass through the IP address of the end user).  Validate the IP
    if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
        $the_ip = $headers['X-Forwarded-For'];
    } elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
        $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
    } else {
        $the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
    }
    return $the_ip;
}

//// function for adding crowdskout's ajax calls to the admin-ajax.php file
//add_action('wp_enqueue_scripts', 'cs_localize_ajax');
//function cs_localize_ajax() {
//    wp_localize_script( 'jquery', 'cs_ajax', array('url' => admin_url( 'admin-ajax.php' )));
//}

/**
 * The main function that takes our javascript and
 * adds it to the footer of the application for tracking.
 */
if (!function_exists('cskt_add_analytics_js')) {
	function cskt_add_analytics_js() {
		$sourceId = get_option('cskt_source_id');
        $clientId = get_option('cskt_client_id');
		
        if (is_numeric($sourceId) && 0 !== (int) $sourceId) {
			require CSKT_PLUGIN_SERVER_ROOT . '/views/footer-js.php';
		}
	}
	add_action('wp_footer', 'cskt_add_analytics_js');
}

//if (!function_exists('cskt_add_facebook_sdk')) {
//    function cskt_add_facebook_sdk() {
//        $facebookId = get_option('cskt_facebook_app_id');
//        $facebookSecret = get_option('cskt_facebook_app_secret');
//
//
//        if (is_numeric($facebookId) && 0 !== (int)$facebookId) {
//            require CSKT_PLUGIN_SERVER_ROOT . '/views/facebook_sdk_js.php';
//        }
//    }
//    add_action('wp_head', 'cskt_add_facebook_sdk');
//}

/**
 * REGISTER SHORTCODES
 */

// register email shortcode
add_shortcode('cs_email', 'email_shortcode');
function email_shortcode($atts, $content = null) {
    ob_start();

    // Attributes
    extract ( shortcode_atts (
        array('name' => 'false',), $atts )
    );

    if ($name == 'true') { $name_checkbox = true; }
    else { $name_checkbox = false; }

    require CSKT_PLUGIN_SERVER_ROOT . '/views/email-tpl.php';
    return ob_get_clean();
}

//// register facebook like shortcodes
//add_shortcode('cs_fb_like', 'cs_like_handler');
//function cs_like_handler($attrs, $content = null) {
//    ob_start();
//    require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-like-tpl.php';
//    return ob_get_clean();
//}
//
//// register facebook share shortcodes
//add_shortcode('cs_fb_share', 'cs_fb_share_handler');
//function cs_fb_share_handler($attrs, $content = null) {
//    ob_start();
//    require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-share-tpl.php';
//    return ob_get_clean();
//}
//
//// register twitter follow shortcodes
//add_shortcode('cs_tw_follow', 'cs_tw_follow_handler');
//function cs_tw_follow_handler($attrs, $content = null) {
//    ob_start();
//    require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-follow-tpl.php';
//    return ob_get_clean();
//}
//
//// register twitter share shortcodes
//add_shortcode('cs_tw_share', 'cs_tw_share_handler');
//function cs_tw_share_handler($attrs, $content = null) {
//    ob_start();
//    require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-share-tpl.php';
//    return ob_get_clean();
//}

/**
 * REGISTER CROWDSKOUT WIDGET
 */
class cskt_widget extends WP_Widget {

    // Construct widget
    function __construct() {
        parent:: __construct(
          'cskt_widget',
          __('Crowdskout Newsletter Signup', 'cskt_widget_domain'),
          array('description' => __('Send Newsletter Signups to your Crowdskout app', 'cskt_widget_domain'),)
        );
    }

    // Widget's front-end display
    function widget ($args, $instance) {

        extract( $args );

        $name_checkbox = $instance['name_checkbox'] ? true : false;

        echo $before_widget;

        if ( ! empty( $instance['title']  ) ) {
            echo $before_title . apply_filters( 'widget_title', $instance['title'] ). $after_title;
        }

//        $this->widget_title = apply_filters('widget_title', $instance['title'] );

//        $this->facebook_id = $instance['app_id'];
//        $this->facebook_username = $instance['page_name'];
//        $this->facebook_width = $instance['width'];
//        $this->facebook_show_faces = ($instance['show_faces'] == "1" ? "true" : "false");
//        $this->facebook_stream = ($instance['show_stream'] == "1" ? "true" : "false");
//        $this->facebook_header = ($instance['show_header'] == "1" ? "true" : "false");
//
//        add_action('wp_footer', array(&$this,'add_js'));

        require CSKT_PLUGIN_SERVER_ROOT . '/views/email-tpl.php';
//        require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-like-tpl.php';
//        require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-share-tpl.php';
//        require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-follow-tpl.php';
//        require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-share-tpl.php';

        echo $after_widget;
    }

    // sanitize widget, take the user settings and save them
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['name_checkbox'] = $new_instance['name_checkbox'];
        return $instance;
    }

    // Widget's back-end, Appearance->Widgets
    public function form( $instance ) {

        if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ]; }
        else { $title = __( '', 'cskt_widget_domain' ); }

        if ( isset ( $instance[ 'name_checkbox' ] ) ) { $name_checkbox = true; }
        else { $name_checkbox = false; }

        ?>
            <?php require CSKT_PLUGIN_SERVER_ROOT . '/views/cskt-widget-backend.php'; ?>
        <?php

    }
}

// call the crowdskout widget class
add_action( 'widgets_init', function(){
    register_widget( 'cskt_widget' );
});

//// AJAX HANDLERS for the facebook like widget and shortcode
//add_action('wp_ajax_cs_like_click', 'cs_like_click_handler');
//add_action('wp_ajax_no_priv_cs_like_click', 'cs_like_click_handler');
//
////TODO: Add nonce check
////TODO: Send to crowdskout
//function cs_like_click_handler() {
//    $_POST['csid'] = $_COOKIE['csid'];
//    echo json_encode($_POST);
//    exit();
//}