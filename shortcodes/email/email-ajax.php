<?php

add_action('wp_ajax_cs_email_submit', 'cs_email_submit_handler');
add_action('wp_ajax_no_priv_cs_email_submit', 'cs_email_submit_handler');

//TODO: Add nonce check
//TODO: Send to crowdskout
function cs_email_submit_handler() {
	if(!wp_verify_nonce($_REQUEST['email_submit_nonce'], 'email_submit')) {
		$result = array('success' => false);
		echo json_encode($result);
		exit();
	}
	$result = array('success' => true);
	echo json_encode($result);
	exit();
}