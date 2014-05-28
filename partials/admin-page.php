<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Crowdskout</h2>
	<form method="post" action="options.php">
		<?php settings_fields(''); ?>
		<?php do_settings_sections(''); ?>
		<?php submit_button(); ?>
	</form>
</div>