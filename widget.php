<?php
    class CSKT_Widget extends WP_Widget {

        /**
         * construct
         */
        public function __construct() {
            parent:: __construct(
                'CSKT_Widget',
                __('Crowdskout Newsletter Signup', 'cskt_widget_domain'),
                array('description' => __('Send Newsletter Sign-ups to your Crowdskout app', 'cskt_widget_domain'),)
            );
        }

        /**
         * @param array $args
         * @param array $instance
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
         * @param array $new_instance
         * @param array $old_instance
         * @return array
         */
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['name_checkbox'] = $new_instance['name_checkbox'];
            return $instance;
        }

        /**
         * @param array $instance
         * @return string|void
         */
        public function form( $instance ) {

            if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ]; }
            else { $title = __( '', 'cskt_widget_domain' ); }
            if ( isset ( $instance[ 'name_checkbox' ] ) ) { $name_checkbox = true; }
            else { $name_checkbox = false; }

            require CSKT_PLUGIN_SERVER_ROOT . '/views/cskt-widget-backend.php';
        }
    }

    /**
     * register
     */
    if (!function_exists('register_cskt_widget')) {
        function register_cskt_widget() {
            register_widget('CSKT_Widget');
        }
        add_action( 'widgets_init', 'register_cskt_widget' );
    }