<?php
	/** Initializes Facebook SDK */
	$fbAppId = get_option('cskt_facebook_app_id');
	$fbAppSecret = get_option('cskt_facebook_app_secret');
	if (is_numeric($fbAppId) && is_string($fbAppSecret) && 0 !== (int) $fbAppId && 0 !== $fbAppSecret) {
    ?>
		<div id="fb-root"></div>
		<script>
			window.fbAsyncInit = function() {
				FB.init({
					appId      : <?php echo $fbAppId; ?>,
					xfbml      : true,
					version    : 'v2.2'
				});
				cskt.fbHandlers();
			};
		    (function(d, s, id){
		        var js, fjs = d.getElementsByTagName(s)[0];
		        if (d.getElementById(id)) {return;}
		        js = d.createElement(s); js.id = id;
		        js.src = "//connect.facebook.net/en_US/sdk.js";
		        fjs.parentNode.insertBefore(js, fjs);
		    }(document, 'script', 'facebook-jssdk'));
		</script>
	<?php }
?>