<form id="cs-email-form">
	<?php wp_nonce_field('email_submit', 'email_submit_nonce'); ?>
	<input type="text" placeholder="Enter email">
	<input type="hidden" name="action" value="cs_email_submit">
	<input type="submit" value="Submit">	
</form>

<script>
(function($) {
	$('#cs-email-form').submit(function(e) {
		e.preventDefault();
		var formData = $(this).serialize();
		$.ajax({
			url: cs_ajax.url,
			data: $(this).serialize(),
			type: "POST"
		}).success(function(response) {
			console.log(response);
		});
	});
})(jQuery)
</script>