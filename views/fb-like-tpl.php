<a href="#" id="cs-fb-like" data-action="cs_fb_like_click">Like Us on Facebook</a>
<script>
	(function($) {
		$("#cs-fb-like").click(function(e) {
			e.preventDefault();
			var clickData = $(this).data();
			$.ajax({
				url: cs_ajax.url,
				type: 'POST',
				data: clickData
			}).success(function(response) {
				console.log(response);
			});
		});
	})(jQuery)
</script>