(function() {
    function e() {
        var e = jQuery('[data-cs="true"]');
        for (var t = 0; t < e.length; t++) {
            new Crowdskout.CSForm(e[t], {
                success: function(e) {
                    jQuery(e).find(".messages").css("opacity", 0).text("Thanks for signing up for the newsletter!").animate({
                        opacity: 1
                    }, 400);
                    jQuery(e).find('input[type="text"]').hide();
                    jQuery(e).find('input[type="submit"]').hide()
                },
                error: function(e) {
                    jQuery(e.form).find(".messages").css("opacity", 0).text("There was an error submitting your email, please try again.").animate({
                        opacity: 1
                    }, {
                        queue: false
                    }, 400).delay(2e3).animate({
                        opacity: 0
                    }, 600);
                    jQuery(e.form).find('input[type="submit"]').removeAttr("disabled");
                    jQuery(e.form).find('input[type="text"]').removeAttr("disabled")
                },
                beforeSubmit: function(e) {
                    jQuery(e).find('input[type="submit"]').attr("disabled", "disabled");
                    jQuery(e).find('input[type="text"]').attr("disabled", "disabled")
                }
            }, {})
        }
    }
    if (!window.Crowdskout) {
        if (WP_DEBUG) {
          var t = "http://loc.cs-back.com";
        } else {
          t = 'https://api.crowdskout.com'
        }
        var n = document.getElementsByTagName("head")[0];
        var r = document.createElement("script");
        r.src = t + "/forms.js";
        r.onload = function() {
            e()
        };
        n.appendChild(r)
    } else {
        e()
    }
})();
