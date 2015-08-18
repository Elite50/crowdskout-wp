jQuery(document).ready(function($) {

    /* ------------------------------------------------
     Connect to Crowdskout Account through settings page
     ------------------------------------------------ */

    $('.cskt_login').on('submit', function(e) {
        // stop from submit
        e.preventDefault();

        // declare vars
        var csktPassword = $('.cskt_password').val();
        var csktEmail = $('.cskt_email').val();

        $("#cskt_connect").append( '<input type="hidden" name="cskt_password" value="' + csktPassword + '"/>' );

        var form = $(this);
        var formMethod = form.attr('method'); // method to send data (post method)
        var formData = {
            email: csktEmail,
            password: csktPassword
        };
        if (window.location.hostname == "csplug.com") { // then you are in dev and use local cskt server for testing
            var formUrl = "http://loc.cs-back.com/login"; // URL to send our data to
        } else {
            var formUrl = "https://api.crowdskout.com/login";
        }
        var responseMsg = $('#submit_response', this);

        //show response message - waiting
        responseMsg.hide().addClass('response_waiting').fadeIn(1000);

        // submit data to server
        $.ajax({
            url: formUrl,
            type: formMethod,
            data: formData,
            success: function(data){ // callback function called if ajax returns success
                // vars
                var responseData = $.parseJSON(data);
                console.log(responseData);
                var newResponse = 'response_success';

                for (i=0; i < responseData.data.length; i++) {
                    if (responseData.data[i].userLevel == "Administrator") {
                        $( "#cskt_accounts" ).append( '<option value="' + responseData.data[i].id + ':' + csktEmail + '">' + responseData.data[i].name + '</option>' );
                    }
                }
                // show response message
                form.fadeOut(1000,function(){
                    $("#cskt_connect").fadeIn(1000,function(){

                    });
                });
            },
            error: function(data){
                // vars
                var newResponse = 'response_error';

                responseMsg.fadeOut(1500,function(){
                    $(this).removeClass('response_waiting').addClass(newResponse).fadeIn(1000,function(){
                        setTimeout(function(){
                            //responseMsg.fadeOut(500,function(){
                            //    $(this).removeClass(newResponse);
                            //});
                        },2000);
                    });
                });
            }
        });

        //prevent form from submitting
        return false;
    });

});