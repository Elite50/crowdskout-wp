<a href="#" id="cs-like" data-action="cs_like_click">Like this</a>
<script>
	(function($) {
		$("#cs-like").click(function(e) {
			e.preventDefault();
			var clickData = $(this).data();
			$.ajax({
				url: ajax.url,
				type: 'POST',
				data: clickData
			}).success(function(response) {
				console.log(response);
			});
		});
	})(jQuery)
</script>