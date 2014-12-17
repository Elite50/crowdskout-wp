<?php
	class CSKT_Widget_Interface {

		private $cskt_widget_factory;

		public function __construct() {
			$this->cskt_widget_factory = new CSKT_Widget_Factory();
		}

		public function cskt_get_inputs( $inputs ) {
			return $this->cskt_widget_factory->cskt_get_inputs( $inputs );
		}
	}

	abstract class CSKT_Build_Module {

		private $parts;

		public function __construct( $parts ) {
			$this->parts = $parts;
		}

		abstract public function cskt_get_parts();
	}


	class CSKT_Widget_Factory {

		public function cskt_get_inputs( $inputs ) {

			if (in_array('newsletter', $inputs )) {
				$cskt_widget->$newsletter_mod = new $module('newsletter');
			} elseif (in_array('facebook_like', $inputs)) {
				$cskt_widget->$facebook_like_mod = new $module('facebook_like');
			} elseif (in_array('facebook_share', $inputs)) {
				$cskt_widget->$facebook_share_mod = new $module('facebook_share');
			} elseif (in_array('twitter_follow', $inputs)) {
				$cskt_widget->$twitter_follow_mod = new $module('twitter_follow');
			} elseif (in_array('twitter_share', $inputs)) {
				$cskt_widget->$twitter_share_mod = new $module('twitter_share');
			}
			return $cskt_widget;
		}
	}

    class CSKT_Widget extends WP_Widget {

        /**
         * construct crowdskout widget extended from the wordpress widget.
         * Gets called automatically on register of CSKT_Widget.
         */
        public function __construct() {
            parent:: __construct(
                'CSKT_Widget',
                __('Crowdskout Widget', 'cskt_widget_domain'),
                array('description' => __('Crowdskout integrated newsletter and social media interactions.', 'cskt_widget_domain'),)
            );
        }

        /**
         * @param array $args -> arguments
         * @param array $instance -> database values
         */
        public function widget ($args, $instance) {

            $name_checkbox = $instance['name_checkbox'] ? true : false;
            if ( ! empty( $instance['title']  ) ) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
            }

            echo $args['before_widget'];
            require CSKT_PLUGIN_SERVER_ROOT . '/views/email-tpl.php';
            echo $args['after_widget'];
        }

        /**
         * @param array $new_instance -> values to be saved
         * @param array $old_instance -> previously saved values from db.
         * @return array -> updated safe values to be saved
         */
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

//	        $instance[ 'nl_checkbox' ] = $new_instance[ 'nl_checkbox' ];
//	        $instance[ 'fb_like_checkbox' ] = $new_instance[ 'fb_like_checkbox' ];
//	        $instance[ 'fb_share_checkbox' ] = $new_instance[ 'fb_share_checkbox' ];
//	        $instance[ 'tw_follow_checkbox' ] = $new_instance[ 'tw_follow_checkbox' ];
//	        $instance[ 'tw_share_checkbox' ] = $new_instance[ 'tw_share_checkbox' ];

            $instance['name_checkbox'] = $new_instance['name_checkbox'];
            return $instance;
        }

        /**
         * @param array $instance -> previously saved values from db
         * @return string|void
         */
        public function form( $instance ) {

            if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ]; }
            else { $title = __( '', 'cskt_widget_domain' ); }

	        if ( isset( $instance[ 'nl_checkbox' ] ) ) { $nl_checkbox = true; }
	        else { $nl_checkbox = false; }
	        if ( isset( $instance[ 'fb_like_checkbox' ] ) ) { $fb_like_checkbox = true; }
	        else { $fb_like_checkbox = false; }
	        if ( isset( $instance[ 'fb_share_checkbox' ] ) ) { $fb_share_checkbox = true; }
	        else { $fb_share_checkbox = false; }
	        if ( isset( $instance[ 'tw_follow_checkbox' ] ) ) { $tw_follow_checkbox = true; }
	        else { $tw_follow_checkbox = false; }
	        if ( isset( $instance[ 'tw_share_checkbox' ] ) ) { $tw_share_checkbox = true; }
	        else { $tw_share_checkbox = false; }

            if ( isset ( $instance[ 'name_checkbox' ] ) ) { $name_checkbox = true; }
            else { $name_checkbox = false; }

            require CSKT_PLUGIN_SERVER_ROOT . '/views/cskt-widget-backend.php';
        }
    }

    /**
     * register cskt_widget
     */
    if (!function_exists('register_cskt_widget')) {
        function register_cskt_widget() {
            register_widget('CSKT_Widget');
        }
        add_action( 'widgets_init', 'register_cskt_widget' );
    }