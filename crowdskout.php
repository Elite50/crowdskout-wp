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

    require_once CSKT_PLUGIN_SERVER_ROOT . '/utils/logger.php'; /** util functions for dev */
    require_once CSKT_PLUGIN_SERVER_ROOT . '/admin/admin-page.php'; /** generates settings page */
    require_once CSKT_PLUGIN_SERVER_ROOT . '/widget.php';
    require_once CSKT_PLUGIN_SERVER_ROOT . '/shortcode.php';

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
            wp_enqueue_script('forms_js_interface' . $flag . '.js', plugins_url() . "/crowdskout-wp/js/forms_js_interface" . $flag . ".js", array('jquery'), '', true );
        }
    }

    class CSKT_Request {
        public $url = "";
        public $topics = "";
    }

    /** Add topics to crowdskout database */
    if (!function_exists('cskt_request_function')) {
        function cskt_request_function() {

            function cskt_request_action($type) {

                /** construct the HTTP request object to send to crowdskout database */
                $tags = explode(',', strip_tags(get_the_tag_list('', ',')));
                $cats = explode(',', strip_tags(get_the_category_list(',', '', get_the_ID())));
                $cskt_request = new CSKT_Request();
                $cskt_request->url = get_permalink();
                $cskt_request->topics = array_filter(array_merge($cats, $tags)); /** merge cats and tags filtering out empty entries */
                $cskt_request = json_encode($cskt_request);

                /** Send Request to the Crowdskout Database */
                $cskt_api_host = "https://private-ef7b0-crowdskoutbackend.apiary-mock.com/pages/topics";
                $request = new WP_Http;
                $result = $request->request($cskt_api_host, array('method' => $type, 'headers' => array('Content-Type' => 'application/json'), 'body' => $cskt_request));
//                _log($result);

                add_post_meta(get_the_ID(), 'cskt_db_entry', 'true');
            }

            /** function to determine if user on the edit post page on the back end */
            function is_edit_page($new_edit = null){
                global $pagenow;

                /** make sure we are on the backend */
                if (!is_admin()) return false;

                /** make sure user is editing a post as opposed to creating a new one */
                if($new_edit == "edit")
                    return in_array( $pagenow, array( 'post.php',  ) );
                elseif($new_edit == "new") /** check for new post page */
                    return in_array( $pagenow, array( 'post-new.php' ) );
                else /** check for either new or edit */
                    return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
            }

            /** When should I send a request to the cs DB? */
            $in_db = get_post_meta(get_the_ID(), 'cskt_db_entry', 'true');
            /** if user is on a single post page and the post is not in cskt's database */
            if (is_single() && !($in_db)) {
                cskt_request_action('POST');
            }
            /** if user is on an edit post page and ... */
            if (is_edit_page()) {
                /** they updated a post that is already in cskt's db, update the cskt db entry with PUT request */
                if ($in_db) {
                    cskt_request_action('PUT');
                } /** they update a post that is not already in the cskt db */
                else {
                    if (!($in_db)) {
                        cskt_request_action('POST');
                    }
                }
            }
        }

        /** hook cskt_request_action into the wordpress site */
        add_action('wp_head', 'cskt_request_function'); /** hook in after page's header */
        add_action('publish_post', 'cskt_request_function'); /** hook in after post has been saved */
    }

    /**
     * The main function that takes cskts javascript and
     * adds it to the footer of the application for tracking.
     */
    if (!function_exists('cskt_add_analytics_js')) {

        function cskt_add_analytics_js() {
            require CSKT_PLUGIN_SERVER_ROOT . '/views/footer-js.php';
        }
    }
    add_action('wp_footer', 'cskt_add_analytics_js');