<?php

add_action('wp_ajax_cs_like_click', 'cs_like_click_handler');

//TODO: Add nonce check
//TODO: Send to crowdskout
function cs_like_click_handler() {
	$_POST['csid'] = $_COOKIE['csid'];
	echo json_encode($_POST);
	exit();
}