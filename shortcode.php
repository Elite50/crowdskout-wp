<?php
    add_shortcode('cskt_newsletter', 'cskt_newsletter_handler');
    /**
     * @param $atts
     * @param null $content
     * @return string
     */
    function cskt_newsletter_handler($atts, $content = null) {

        ob_start();

        /**
         * Attributes
         */
        $attr = shortcode_atts( array('name' => 'false'), $atts);
        if ($attr['name'] == 'true') {
            $name_checkbox = true;
        } else {
            $name_checkbox = false;
        }

        require CSKT_PLUGIN_SERVER_ROOT . '/views/email-tpl.php';

        return ob_get_clean();
    }