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
        wp_enqueue_script('master.js', plugins_url() . "/crowdskout-wp/js/master.js", array('jquery'), '', true );
    }
    // css
    wp_enqueue_style('shortcodes' . $flag . '.css', plugins_url() . '/crowdskout-wp/shortcodes/shortcodes' . $flag . '.css');

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

// function for adding crowdskout's ajax calls to the admin-ajax.php file
add_action('wp_enqueue_scripts', 'cs_localize_ajax');
function cs_localize_ajax() {
    wp_localize_script( 'jquery', 'cs_ajax', array('url' => admin_url( 'admin-ajax.php' )));
}

/**
 * The main function that takes our javascript and
 * adds it to the footer of the application for tracking.
 */
if (!function_exists('cskt_add_analytics_js')) {
	function cskt_add_analytics_js() {
		$sourceId = get_option('cskt_source_id');
		
        if (is_numeric($sourceId) && 0 !== (int) $sourceId) {
			require CSKT_PLUGIN_SERVER_ROOT . '/views/footer-js.php';
		}
	}
	add_action('wp_footer', 'cskt_add_analytics_js');
}

/**
 * REGISTER SHORTCODES
 */

// register email shortcode
add_shortcode('cs_email', 'email_shortcode');
function email_shortcode($atts, $content = null) {
    ob_start();
    require CSKT_PLUGIN_SERVER_ROOT . '/views/email-tpl.php';
    return ob_get_clean();
}

// register facebook like shortcodes
add_shortcode('cs_fb_like', 'cs_like_handler');
function cs_like_handler($attrs, $content = null) {
    ob_start();
    require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-like-tpl.php';
    return ob_get_clean();
}

// register facebook share shortcodes
add_shortcode('cs_fb_share', 'cs_fb_share_handler');
function cs_fb_share_handler($attrs, $content = null) {
    ob_start();
    require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-share-tpl.php';
    return ob_get_clean();
}

// register twitter follow shortcodes
add_shortcode('cs_tw_follow', 'cs_tw_follow_handler');
function cs_tw_follow_handler($attrs, $content = null) {
    ob_start();
    require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-follow-tpl.php';
    return ob_get_clean();
}

// register twitter share shortcodes
add_shortcode('cs_tw_share', 'cs_tw_share_handler');
function cs_tw_share_handler($attrs, $content = null) {
    ob_start();
    require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-share-tpl.php';
    return ob_get_clean();
}

/**
 * REGISTER WIDGETS
 */

// EMAIL WIDGET
class cskt_email_widget extends WP_Widget {

    // create the widget object
    function __construct() {
        parent:: __construct(
        // Base ID
            'cskt_email_widget',
            // Name that appears in wordpress
            __('Crowdskout Newsletter', 'cskt_email_widget_domain'),
            // Description
            array('description' => __('Send Newsletter signups to your Crowdskout app', 'cskt_email_widget_domain'),)
        );
    }

    // Widget's front-end, output the contents of the widget
    public function widget ($args, $instance) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        require CSKT_PLUGIN_SERVER_ROOT . '/views/email-tpl.php';
        echo $args['after_widget'];
    }

    // Widget's back-end, Appearance->Widgets
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( '', 'cskt_email_widget_domain' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}
// register email widget
add_action( 'widgets_init', function(){
    register_widget( 'cskt_email_widget' );
});

// FACEBOOK LIKE WIDGET
class cskt_fb_like_widget extends WP_Widget {

    // create the widget object
    function __construct() {
        parent:: __construct(
        // Base ID
            'cskt_fb_like_widget',
            // Name that appears in wordpress
            __('Crowdskout Facebook Like Button', 'cskt_fb_like_widget_domain'),
            // Description
            array('description' => __('Send Facebook Likes to your Crowdskout app', 'cskt_fb_like_widget_domain'),)
        );
    }

    // Widget's front-end, output the contents of the widget
    public function widget ($args, $instance) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-like-tpl.php';
        echo $args['after_widget'];
    }

    // Widget's back-end, Appearance->Widgets
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( '', 'cskt_fb_like_widget_domain' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}
// register fb like widget
add_action( 'widgets_init', function(){
    register_widget( 'cskt_fb_like_widget' );
});

// TWITTER FOLLOW WIDGET
class cskt_tw_follow_widget extends WP_Widget {

    // create the widget object
    function __construct() {
        parent:: __construct(
        // Base ID
            'cskt_tw_follow_widget',
            // Name that appears in wordpress
            __('Crowdskout Twitter Follow Button', 'cskt_email_widget_domain'),
            // Description
            array('description' => __('Send Twitter follows to your Crowdskout app', 'cskt_tw_follow_widget_domain'),)
        );
    }

    // Widget's front-end, output the contents of the widget
    public function widget ($args, $instance) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-follow-tpl.php';
        echo $args['after_widget'];
    }

    // Widget's back-end, Appearance->Widgets
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( '', 'cskt_tw_follow_widget_domain' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}
// register email widget
add_action( 'widgets_init', function(){
    register_widget( 'cskt_tw_follow_widget' );
});

// FACEBOOK SHARE WIDGET
class cskt_fb_share_widget extends WP_Widget {

    // create the widget object
    function __construct() {
        parent:: __construct(
        // Base ID
            'cskt_fb_share_widget',
            // Name that appears in wordpress
            __('Crowdskout Facebook Share Button', 'cskt_fb_share_widget_domain'),
            // Description
            array('description' => __('Send Facebook Shares to your Crowdskout app', 'cskt_fb_share_widget_domain'),)
        );
    }

    // Widget's front-end, output the contents of the widget
    public function widget ($args, $instance) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-share-tpl.php';
        echo $args['after_widget'];
    }

    // Widget's back-end, Appearance->Widgets
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( '', 'cskt_fb_share_widget_domain' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}
// register fb share widget
add_action( 'widgets_init', function(){
    register_widget( 'cskt_fb_share_widget' );
});

// TWITTER SHARE WIDGET
class cskt_tw_share_widget extends WP_Widget {

    // create the widget object
    function __construct() {
        parent:: __construct(
        // Base ID
            'cskt_tw_share_widget',
            // Name that appears in wordpress
            __('Crowdskout Twitter Share Button', 'cskt_tw_share_widget_domain'),
            // Description
            array('description' => __('Send Twitter Shares to your Crowdskout app', 'cskt_tw_share_widget_domain'),)
        );
    }

    // Widget's front-end, output the contents of the widget
    public function widget ($args, $instance) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-share-tpl.php';
        echo $args['after_widget'];
    }

    // Widget's back-end, Appearance->Widgets
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( '', 'cskt_tw-share_widget_domain' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}
// register tw share widget
add_action( 'widgets_init', function(){
    register_widget( 'cskt_tw_share_widget' );
});

/**
 * AJAX HANDLERS
 */

// Ajax handlers for the newsletter widget and shortcode
add_action('wp_ajax_cskt_email_submit', 'cskt_email_submit_handler');
add_action('wp_ajax_no_priv_cskt_email_submit', 'cskt_email_submit_handler');

function cskt_email_submit_handler() {
    // get the meta data
    $email = $_REQUEST['signup-email'];
    $ip = get_ip();
    $csid = $_COOKIE['csid'];

    //error check
    if(!wp_verify_nonce($_REQUEST['email_submit_nonce'], 'email_submit')) {
        $status = 'error';
        $message = 'something went wrong, please try again';
        $result = array('status' => $status, 'message' => $message);
        echo json_encode($result);
        exit();
    }

    if (empty($email)) {
        $status = 'error';
        $message = "You did not enter an email address!";
    } else if(!preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $email)){ //validate email address - check if is a valid email address
        $status = "error";
        $message = "You have entered an invalid email address!";
    } else {
        $status = 'success';
        $message = "Thanks for your email!  You've been signed up for the newsletter.";
    }

    // send json object back to client side!
    $result = array(
        'status' => $status,
        'message' => $message
    );
    echo json_encode($result);


    // Send data to crowdskout on success
    if ($status == 'success') {
        //TODO: Send to crowdskout
    }

    exit();
}

// AJAX HANDLERS for the facebook like widget and shortcode
add_action('wp_ajax_cs_like_click', 'cs_like_click_handler');
add_action('wp_ajax_no_priv_cs_like_click', 'cs_like_click_handler');

//TODO: Add nonce check
//TODO: Send to crowdskout
function cs_like_click_handler() {
    $_POST['csid'] = $_COOKIE['csid'];
    echo json_encode($_POST);
    exit();
}