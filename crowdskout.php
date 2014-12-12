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
	        wp_enqueue_script('cskt' . $flag . '.js', plugins_url() . "/crowdskout-wp/js/cskt" . $flag . ".js", array('jquery'), '', true );
            wp_enqueue_script('forms_js_interface' . $flag . '.js', plugins_url() . "/crowdskout-wp/js/forms_js_interface" . $flag . ".js", array('jquery'), '', true );
            wp_enqueue_script('fb_sdk_js_interface' . $flag . '.js', plugins_url() . "/crowdskout-wp/js/fb_sdk_js_interface" . $flag . ".js", array('jquery'), '', true );
        }
    }

    class CSKT_Request {
	    public $url;
	    public $topics;

	    const CS_API_URL = 'https://api.crowdskout.com/pages/topics';

	    public function __construct() {
		    $this->url = get_permalink();

		    $tags = explode(',', strip_tags(get_the_tag_list('', ',')));
		    $cats = explode(',', strip_tags(get_the_category_list(',', '', get_the_ID())));
		    $this->topics = array_filter( array_merge( $cats, $tags ) );
		    /** merge cats and tags filtering out empty entries */
	    }

	    /**
	     * @return array|WP_Error
	     */
	    public function updateTopics()
	    {
		    $this->updatePostMeta(get_the_ID());
		    return $this->makeRequest(self::CS_API_URL, 'PUT');
	    }

	    /**
	     * @return array|WP_Error
	     */
	    public function newTopics()
	    {
		    $this->updatePostMeta(get_the_ID());
		    return $this->makeRequest(self::CS_API_URL, 'POST');
	    }

	    /**
	     * function to determine if user on the edit post page on the back end
	     *
	     * @param \WP_Post $pagenow
	     *
	     * @return bool
	     */
	    public static function isEditPage($pagenow)
	    {
		    /** make sure we are on the backend */
		    if (!is_admin()) {
			    return false;
		    }

		    /** make sure user is editing a post as opposed to creating a new one */
		    return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
	    }

	    /**
	     * @param int $id
	     *
	     * @return bool|int
	     */
	    protected function updatePostMeta($id)
	    {
		    return add_post_meta($id, 'cskt_db_entry', 'true');
	    }

	    /**
	     * @param string $crowdskoutUrl
	     * @param string $type
	     *
	     * @return array|WP_Error
	     */
	    protected function makeRequest($crowdskoutUrl, $type)
	    {
		    $cskt_request = json_encode([
			    'url' => $this->url,
			    'topics' => $this->topics,
		    ]);

		    /** Send Request to the Crowdskout Database */
		    $cskt_api_host = $crowdskoutUrl;
		    $request = new WP_Http;
		    $result = $request->request($cskt_api_host, array('method' => $type, 'headers' => array('Content-Type' => 'application/json'), 'body' => $cskt_request, 'timeout' => apply_filters( 'http_request_timeout', 1 ), 'blocking' => false));

		    return $result;
	    }
    }

    // Add topics to crowdskout database
    if (!function_exists('cskt_request_function')) {
        function cskt_request_function() {
	        global $pagenow;
			$csktRequest = new CSKT_Request;

            // When should I send a request to the cs DB?
            $in_db = get_post_meta(get_the_ID(), 'cskt_db_entry', true);
            if ((is_single() || CSKT_Request::isEditPage($pagenow)) && !($in_db)) { // if user is on a single post page and the post is not in cskt's database
	            $csktRequest->newTopics();
            } elseif (CSKT_Request::isEditPage($pagenow) && $in_db) { // if user is on an edit post page and they updated a post that is already in cskt's db, update the cskt db entry with PUT request
	            $csktRequest->updateTopics();
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

	if (!function_exists('cskt_add_fb_js')) {
		function cskt_add_fb_js() {
			require CSKT_PLUGIN_SERVER_ROOT . '/views/facebook_sdk_js.php';
		}
	}
	add_action('wp_footer', 'cskt_add_fb_js');