<?php
    /**
     * Plugin Name: Crowdskout
     * Plugin URI: http://crowdskout.com
     * Description: Adds Crowdskout analytics to your site
     * Version: 1.2.2
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
	define('LOCAL_BACKEND', 'http://loc.cs-back.com'); // Will
	define('LOCAL_BACKEND_2', 'http://dev.api.crowdskout.com'); // George
	define('CSKT_BACKEND', 'https://api.crowdskout.com');
	if (WP_DEBUG) {
		$GLOBALS['backend'] = constant( "LOCAL_BACKEND" );
		define('cskt_client_id', 'r1NALiNIJN4qFCZoL6ThgarZUXuBhSVpDcDf9Ga');
		define('cskt_client_secret', 'v2tVxJI9rkbUJlm5yE1pdXnr5YSgVIE6swwJPn3');
		// if using local backend 2
//		define('cskt_client_id', 'abcd');
//		define('cskt_client_secret', 'DPdANFHSZkukp82NB9yFLlX3ivF8LDys');
	} else {
		$GLOBALS['backend'] = constant( "CSKT_BACKEND" );
		define('cskt_client_id', 'r1NALiNIJN4qFCZoL6ThgarZUXuBhSVpDcDf9Ga');
		define('cskt_client_secret', 'v2tVxJI9rkbUJlm5yE1pdXnr5YSgVIE6swwJPn3');
	}

	// javascript debug var
	add_action( 'wp_head', function () {
		echo '<script>var WP_DEBUG = ';
		echo ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) ? 'true' : 'false';
		echo ';</script>';
	} );

	if (WP_DEBUG) {
	    require_once CSKT_PLUGIN_SERVER_ROOT . '/utils/logger.php'; // util functions for dev
	}
    require_once CSKT_PLUGIN_SERVER_ROOT . '/admin/admin-page.php'; // generates settings page
    //TODO these are commented out b/c they dont really work anymore.  Next step is to build the forms interface and
    // set up the end point for the forms, surveys and quizes to be added through.
    //require_once CSKT_PLUGIN_SERVER_ROOT . '/widget.php';
    //require_once CSKT_PLUGIN_SERVER_ROOT . '/shortcode.php';
    require_once CSKT_PLUGIN_SERVER_ROOT . '/topics.php';

    /** include the WP_Http class */
    if( !class_exists( 'WP_Http' ) )
        include_once( ABSPATH . WPINC. '/class-http.php' );

    /** add crowdskout scripts and styles */
    if (!function_exists('cskt_add_scripts')) {
        add_action( 'wp_enqueue_scripts', 'cskt_add_scripts' );
        function cskt_add_scripts() {
            if (!WP_DEBUG) {
                $flag = '.min';
            } else {
                $flag = '';
                wp_enqueue_script('livereload.js', "//localhost:1337/livereload.js", array('jquery'), '', true);
            }
	        //TODO this is commented out since it is part of the forms, surveys and quizes module that has not been
	        // built yet.
//            wp_enqueue_script('forms_js_interface' . $flag . '.js', plugins_url() .
//                                                                     "/crowdskout-wp/js/forms_js_interface" . $flag . ".js", array('jquery'), '', true );
        }
    }

	if (!function_exists('cskt_add_admin_scripts')) {
		add_action( 'admin_enqueue_scripts', 'mn_add_admin_scripts' );
		function mn_add_admin_scripts() {
			if (!WP_DEBUG) {
				$flag = '.min';
			} else {
				$flag = '';
			}
			wp_enqueue_script('admin_scripts' . $flag . ".js", plugins_url() . "/crowdskout-wp/js/scripts_admin" . $flag . ".js", array('jquery'), '', true);
			if (isset($_GET['page']) && $_GET['page'] == 'crowdskout') {
				wp_enqueue_style( 'styles', plugins_url() . '/crowdskout-wp/css/styles_admin.css', '', false, '' );
			}
		}
	}

    /**
     * The main function that takes cskts javascript and
     * adds it to the footer of the application for tracking.
     */
    if (!function_exists('cskt_add_analytics_js')) {
	    add_action('wp_footer', 'cskt_add_analytics_js');
        function cskt_add_analytics_js() {
	        if (get_option('cskt_access_token')) {

		        $action  = $GLOBALS['backend'] . "/oauth/tracking";
				$auth = "Bearer " . get_option('cskt_access_token');
				$args = array(
					'headers' => array (
						"Authorization" => $auth
					)
				);

				$response = wp_remote_get($action, $args);

		        $substr=strchr($response['body'], "source");
		        $exploded = explode('"', $substr);

		        $keys = array();
		        $values = array();
		        foreach ($exploded as $explodedItem) {
			        if (preg_match('!\d+!', $explodedItem)) {
				        preg_match_all('!\d+!', $explodedItem, $matches);
				        array_push($values, $matches[0][0]);
			        } else {
				        array_push($keys, $explodedItem);
			        }
		        }

		        for ($x=0; $x<sizeof($keys);$x++) {
			        if ($keys[$x] == "source" && !get_option('cskt_source_id')) {
				        add_option('cskt_source_id', $values[$x]);
			        }
			        if ($keys[$x] == "client" && !get_option('cskt_client_id')) {
				        add_option('cskt_client_id', $values[$x]);
			        }
			        if ($keys[$x] == "organization" && !get_option('cskt_organization_id')) {
				        add_option('cskt_organization_id', $values[$x]);
			        }
		        }

		        require CSKT_PLUGIN_SERVER_ROOT . '/views/footer-js.php';
	        }
        }
    }

	if (!function_exists('cskt_oauth_connect')) {
		add_action('init', 'cskt_oauth_connect');
		function cskt_oauth_connect() {

			class OAuthConnect {

				private $cskt_access_token;

				public function __construct() {

					if(isset($_POST["connect-submit"]) && current_user_can('install_plugins')) {

						$action = $GLOBALS['backend'] . "/oauth/access_token";
						$body = array(
							'body' => array (
								'grant_type' => 'password',
								'password' => $_POST["cskt_password"],
								'username' => $_POST["cskt_account"],
								'client_id' => cskt_client_id,
								'client_secret' => cskt_client_secret
							)
						);

						// get access code from cskt
						$response = wp_remote_post($action, $body);
						$exploded = explode('"', $response['body']);

						for ($i=0; $i < sizeof($exploded); ++$i) {
							if ($exploded[$i] = 'cskt_access_token') {
								// send at to db
								add_option('cskt_access_token', $exploded[$i+3]);
								break;
							}
						}
					}
				}

				// public function to securely get the private access token
				public function getAccessToken() {
					return $this->cskt_access_token;
				}

			}

			class OAuthDisconnect {
				// if connecting to cskt
				public function __construct() {
					if(isset($_POST["disconnect-submit"]) && current_user_can('install_plugins')) {
						delete_option('cskt_access_token');
						delete_option('cskt_source_id');
						delete_option('cskt_client_id');
						delete_option('cskt_organization_id');
					}
				}
			}

			if (get_option('cskt_access_token')) {
				$oauth = new OAuthDisconnect();
			} else {
				$oauth = new OAuthConnect();
			}
		}
	}