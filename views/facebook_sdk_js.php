<?php
/** Initializes Facebook javascripts */
	$facebookAppId = get_option('cskt_facebook_app_id');
	$facebookAppSecret = get_option('cskt_facebook_app_secret');
	if (is_numeric($facebookAppId) && is_string($facebookAppSecret) && 0 !== (int) $facebookAppId && 0 !== $facebookAppSecret) {
    ?>
		<div id="fb-root"></div>
		<script>
			window.fbAsyncInit = function() {
			        FB.init({
		            appId      : <?php echo $facebookAppId; ?>,
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