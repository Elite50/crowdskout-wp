<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Crowdskout</h2>
	<form method="post" action="options.php">
		<?php settings_fields('cskt_plugin'); ?>
		<?php do_settings_sections('crowdskout'); ?>
		<?php submit_button(); ?>
	</form>
</div>