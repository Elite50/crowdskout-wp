(function($) {
    $('.cskt-email-form').submit(function(e) {
        e.preventDefault();
        // declare vars
        var formData = $(this).serialize(),
        responseMsg = $('.signup-response', this);

        //show response message - waiting
        responseMsg.hide()
            .addClass('response-waiting')
            .text('Please Wait...')
            .fadeIn(200);

        $.ajax({
            url: cs_ajax.url,
            data: $(this).serialize(),
            type: "POST",
            success:function(response) {
                // vars
                console.log(response);
                var responseData = jQuery.parseJSON(response),
                    newResponse = '';

                // response conditional
                switch(responseData.status) {
                    case 'error':
                            newResponse = 'response-error';
                        break;
                    case 'success':
                            newResponse = 'response-success';
                        break;
                }

                // show response message
                responseMsg.fadeOut(200,function(){
                    $(this).removeClass('response-waiting')
                        .addClass(newResponse)
                        .text(responseData.message)
                        .fadeIn(200, function(){
                        //set timeout to hide response message
                            setTimeout(function(){
                                responseMsg.fadeOut(200,function(){
                                    $(this).removeClass(newResponse).empty().removeAttr('style');
                                });
                            },3000);
                        });
                });
            }
        });
    
    //prevent form from submitting
    return false;

    });

})(jQuery)