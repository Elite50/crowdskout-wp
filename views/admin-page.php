
<h2>Crowdskout Settings</h2>
<div class="wrap">
	<?php if (get_option('access_token')) : ?>
		<h5>This site is connected to your Crowdskout account</h5>
		<form method="POST" action="" class="cskt_disconnect">
			<table class="form-table">
				<tr>
					<th scope="row">
						<input type="submit" name="disconnect-submit" value="Disconnect" class="button button-primary"/>
					</th>
					<td>
						<p class="description">Click here if you wish to disconnect from Crowdskout</p>
					</td>
				</tr>
			</table>
		</form>
	<?php endif; ?>
	<?php if (!get_option('access_token')) : ?>
	<form method="POST" action="" class="cskt_login">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="cskt_email">Crowdskout Email</label>
					</th>
					<td>
						<input type="text" name="cskt_email" class="cskt_email" placeholder="email" required/>
						<p class="description">Enter email address associated with your Crowdskout account</p>
					</td>
				</tr>
			</tbody>
			<tbody>
			<tr>
				<th scope="row">
					<label for="cskt_password">Crowdskout Password</label>
				</th>
				<td>
					<input type="password" name="cskt_password" class="cskt_password" placeholder="password" required/>
					<p class="description">Enter password associated with your Crowdskout account</p>
				</td>
			</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="login-submit" value="Login" class="button button-primary"/>
		</p>
		<div id="submit_response"></div>
	</form>

	<form method="POST" action="" id="cskt_connect">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="cskt_accounts">Crowdskout Client</label>
					</th>
					<td>
						<select id="cskt_accounts" name="cskt_account">
						</select>
						<p class="description">Choose which Crowdskout Client account to connect to this wordpress site.</p>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="connect-submit" value="Connect" class="button button-primary"/>
		</p>
	</form>
	<?php endif; ?>
</div>