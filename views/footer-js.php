<script>
    (function(l,o,v,e) { l.ownerid = <?php echo $sourceId; ?>;l.clientid = <?php echo $clientId; ?>;a=o.getElementsByTagName(v)[0];b=o.createElement(v);b.src=e;a.parentNode.insertBefore(b,a);})(window, document, 'script', 'https://staging-api.crowdskout.com/analytics.js');
    (function(){function e(){var e=jQuery('[data-cs="true"]');for(var t=0;t<e.length;t++){new Crowdskout.CSForm(e[t],{success:function(e){jQuery(e).find(".messages").css("opacity",0).text("Thanks for signing up for the newsletter!").animate({opacity:1},400);jQuery(e).find('input[type="text"]').hide();jQuery(e).find('input[type="submit"]').hide()},error:function(e){jQuery(e.form).find(".messages").css("opacity",0).text("There was an error submitting your email, please try again.").animate({opacity:1},{queue:false},400).delay(2e3).animate({opacity:0},600);jQuery(e.form).find('input[type="submit"]').removeAttr("disabled");jQuery(e.form).find('input[type="text"]').removeAttr("disabled")},beforeSubmit:function(e){jQuery(e).find('input[type="submit"]').attr("disabled","disabled");jQuery(e).find('input[type="text"]').attr("disabled","disabled")}},{})}}if(!window.Crowdskout){var t="https://staging-api.crowdskout.com";var n=document.getElementsByTagName("head")[0];var r=document.createElement("script");r.src=t+"/forms.js";r.onload=function(){e()};n.appendChild(r)}else{e()}})()
</script>
<?php
// unminified init functions and forms.js loader
//    (function() {
//        function init() {
//            var forms = jQuery('[data-cs="true"]');
//            for (var i = 0; i < forms.length; i++) {
//                new Crowdskout.CSForm(forms[i], {
//                    success: function(data) {
//                        jQuery(data).find('.messages').css('opacity', 0).text("Thanks for signing up for the newsletter!").animate({opacity:1}, 400);
//                        jQuery(data).find('input[type="text"]').hide();
//                        jQuery(data).find('input[type="submit"]').hide();
//                    },
//
//                    error: function(data) {
//                        jQuery(data.form).find('.messages').css('opacity', 0).text("There was an error submitting your email, please try again.").animate({opacity:1},{queue:false}, 400).delay(2000).animate({opacity:0}, 600);
//                        jQuery(data.form).find('input[type="submit"]').removeAttr('disabled');
//                        jQuery(data.form).find('input[type="text"]').removeAttr('disabled');
//                    },
//
//                    beforeSubmit: function(data) {
//                        jQuery(data).find('input[type="submit"]').attr("disabled", "disabled");
//                        jQuery(data).find('input[type="text"]').attr("disabled", "disabled");
//                    }
//                },{
//
//                });
//
//            }
//        }
//
//        if(!window.Crowdskout) {
//            var host = 'https://staging-api.crowdskout.com';
//            var head = document.getElementsByTagName('head')[0];
//            var script = document.createElement('script');
//            script.src = host + '/forms.js';
//            script.onload = function() {
//                init();
//            };
//            head.appendChild(script);
//        } else {
//            init();
//        }
//    })();
?>