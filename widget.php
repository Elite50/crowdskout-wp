<?php
    class CSKT_Widget extends WP_Widget {

        /**
         * construct crowdskout widget extended from the wordpress widget.
         * Gets called automatically on register of CSKT_Widget.
         */
        public function __construct() {
            parent:: __construct(
                'CSKT_Widget',
                __('Crowdskout Widget', 'cskt_widget_domain'),
                array('description' => __('Send site newsletter sign-ups and social media interactions to your Crowdskout app for data analytics, segmentation and marketing.', 'cskt_widget_domain'),)
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