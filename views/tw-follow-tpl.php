<a href="#" id="cs-tw-follow" data-action="cs_tw_follow_click">Follow Us on Twitter</a>
<script>
    (function($) {
        $("#cs-tw-follow").click(function(e) {
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