<form class="cskt-email-form" data="cs_true" data-type="email">
	<?php wp_nonce_field('email_submit', 'email_submit_nonce'); ?>
	<input type="text" name="signup-email" placeholder="Enter email">
	<input type="hidden" name="action" value="cskt_email_submit">
	<input type="submit" value="Submit">
    <p class="signup-response"></p>
</form>