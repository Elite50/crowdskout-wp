<?php
    class cskt_widget extends WP_Widget {

        //construct
        function __construct() {
            parent:: __construct(
                'cskt_widget',
                __('Crowdskout Newsletter Signup', 'cskt_widget_domain'),
                array('description' => __('Send Newsletter Signups to your Crowdskout app', 'cskt_widget_domain'),)
            );
        }

        //front
        function widget ($args, $instance) {

            extract( $args );
            $name_checkbox = $instance['name_checkbox'] ? true : false;
            if ( ! empty( $instance['title']  ) ) {
                echo $before_title . apply_filters( 'widget_title', $instance['title'] ). $after_title;
            }

            echo $before_widget;
            require CSKT_PLUGIN_SERVER_ROOT . '/views/email-tpl.php';
            echo $after_widget;
        }

        //save instance
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['name_checkbox'] = $new_instance['name_checkbox'];
            return $instance;
        }

        //back
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

    //register
    if (!function_exists('cskt_widget')) {
        function register_cskt_widget() {
            register_widget('cskt_widget');
        }
        add_action( 'widgets_init', 'register_cskt_widget' );
    }