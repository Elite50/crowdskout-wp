<h1>Crowdskout</h1>
<div class="wrap">
	<?php if (!get_option('access_token')) : ?>
	<h1 class="login-logo"></h1>
	<form class="cskt_connect" method="POST" action="">
		<input type="text" name="cskt_email" class="cskt_email" placeholder="email" required/>
		<input type="password" name="cskt_password" class="cskt_password" placeholder="password" required/>
		<input type="submit" name="submit" value="Login"/>
		<div id="submit_response"></div>
	</form>

	<form id="cskt_oauth" method="POST" action="">
		<label>Choose account</label>
		<select id="cskt_accounts" name="cskt_account">
		</select>
		<input type="submit" name="submit" value="connect" />
	</form>
	<?php endif; ?>

</div>