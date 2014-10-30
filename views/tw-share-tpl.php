<a href="#" id="cs-tw-share" data-action="cs_tw_share_click">Share this on Twitter</a>
<script>
    (function($) {
        $("#cs-tw-share").click(function(e) {
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