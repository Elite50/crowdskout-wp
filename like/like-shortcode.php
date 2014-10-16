<?php
require CSKT_PLUGIN_SERVER_ROOT . '/like/like-ajax.php';

add_shortcode('cs_like', 'cs_like_handler');

function cs_like_handler($attrs, $content = null) {
	ob_start();
	require CSKT_PLUGIN_SERVER_ROOT . '/like/like-tpl.php';
	return ob_get_clean();
}