<?php

require CSKT_PLUGIN_SERVER_ROOT . '/email/email-ajax.php';

add_shortcode('cs_email', 'email_shortcode');

function email_shortcode($attrs, $content = null) {
	ob_start();
	require CSKT_PLUGIN_SERVER_ROOT . '/email/email-tpl.php';
	return ob_get_clean();
}