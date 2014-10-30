<a href="#" id="cs-fb-share" data-action="cs_fb_share_click">Share this on Facebook</a>
<script>
    (function($) {
        $("#cs-fb-share").click(function(e) {
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