<a href="#" id="cs-fb-like" data-action="cs_fb_like_click">Like Us on Facebook</a>

<!--<div class="fb-like-box"-->
<!--     data-href="http://www.facebook.com/--><?php //echo $this->facebook_username; ?><!--"-->
<!--     data-width="--><?php //echo $this->facebook_width; ?><!--"-->
<!--     data-show-faces="--><?php //echo $this->facebook_show_faces; ?><!--"-->
<!--     data-stream="--><?php //echo $this->facebook_stream; ?><!--"-->
<!--     data-header="--><?php //echo $this->facebook_header; ?><!--">-->
<!--</div>-->

<script>
	(function($) {
		$("#cs-fb-like").click(function(e) {
			e.preventDefault();
            console.log('facebook like');
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