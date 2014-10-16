<?php

add_action('wp_ajax_cs_email_submit', 'cs_email_submit_handler');

//TODO: Add nonce check
//TODO: Send to crowdskout
function cs_email_submit_handler() {
	$result = array('success' => true);
	echo json_encode($result);
	exit();
}