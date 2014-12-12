// Facebook App Helper Functions
(function($) {
    cskt.fbHandlers = function () {
        console.log('welcome to jurasic park');
        // Here we run a very simple test of the Graph API after login is
        // successful.  See statusChangeCallback() for when this call is made.
        function testAPI() {
            //console.log('Welcome!  Fetching your information.... ');
            FB.api('/me', function (response) {
                console.log('Successful login for: ' + response.name);
                document.getElementById('status').innerHTML =
                    'Thanks for logging in, ' + response.name + '!';
            });
        }

        // This is called with the results from from FB.getLoginStatus().
        function statusChangeCallback(response) {
            console.log('statusChangeCallback');
            console.log(response);
            // The response object is returned with a status field that lets the
            // app know the current login status of the person.
            // Full docs on the response object can be found in the documentation
            // for FB.getLoginStatus().
            if (response.status === 'connected') {
                // Logged into your app and Facebook.
                console.log('User is logged into your app and Facebook');
                testAPI();
            } else if (response.status === 'not_authorized') {
                // The person is logged into Facebook, but not your app.
                console.log('logged into Facebook, but not your app');
                //document.getElementById('status').innerHTML = 'Please log ' +
                //    'into this app.';
            } else {
                console.log('not logged into Facebook, so not sure if they are logged into this app or not.');
                // The person is not logged into Facebook, so we're not sure if
                // they are logged into this app or not.
                //document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook.';
            }
        }

        // This function is called when someone finishes with the Login
        // Button.  See the onlogin handler attached to it in the sample
        // code below.
        function checkLoginState() {
            console.log("checkLoginState called");
            FB.getLoginStatus(function (response) {
                statusChangeCallback(response);
            });
        }

        // // reload on infinite scroll new article load

        // Now that we've initialized the JavaScript SDK, we call
        // FB.getLoginStatus().  This function gets the state of the
        // person visiting this page and can return one of three states to
        // the callback you provide.  They can be:
        //
        // 1. Logged into your app ('connected')
        // 2. Logged into Facebook, but not your app ('not_authorized')
        // 3. Not logged into Facebook and can't tell if they are logged into
        //    your app or not.
        //
        // These three cases are handled in the callback function.
        FB.getLoginStatus(function (response) {
            console.log('getLoginStatus called');
            statusChangeCallback(response);
        });

        //// Google Analytics and Facebook - listen for a Like, Unlike, or Share, and sends the event to Google Analytics.
        //// Like the page
        FB.Event.subscribe('edge.create', function (href, widget) {

            // WHICH GA event (since the action is facebook like, that is always the which event)
            var currentPage = jQuery(document).attr('title');
            if (jQuery("body").hasClass('single')) {
                currentPage = jQuery('.entry-title').html()
            }
            ga('send', 'social', 'Facebook', 'Like', currentPage); // tracking as social events
            ga('send', 'event', 'Facebook', 'Like', currentPage); // tracking as general events

            // WHERE GA event
            var pageLocation = jQuery(widget).data("ga_whereevent_category");
            if (pageLocation == null) {
                pageLocation = 'unknown';
            }
            var eventLocation = pageLocation + '-' + window.userDevice;
            ga('send', 'social', 'Facebook', 'Like', eventLocation);
            ga('send', 'event', 'Facebook', 'Like', eventLocation);

            // GA WHAT event
            // if on article page
            if (jQuery("body").hasClass('single')) {
                var pageType = jQuery('article').find('.top-tag').html();
            } else if (jQuery("body").hasClass('home')) {
                var pageType = 'home';
            } else {
                var pageType = jQuery('body').find('h1').first().text();
            }
            ga('send', 'social', 'Facebook', 'Like', pageType);
            ga('send', 'event', 'Facebook', 'Like', pageType);

            document.cookie = "FBLike=true;path=/;expires=Fri, 31 Dec 9999 23:59:59 GMT;max-age=157680000";
        });

        //Unlikes the page
        FB.Event.subscribe('edge.remove', function (href, widget) {

            // GA WHICH event (since the action is facebook unlike, that is always the which event)
            var currentPage = jQuery(document).attr('title');
            ga('send', 'social', 'Facebook', 'UnLike', currentPage);
            ga('send', 'event', 'Facebook', 'UnLike', currentPage);

            // GA WHERE event
            var pageLocation = jQuery(widget).data("ga_whereevent_category");
            if (pageLocation == null) {
                pageLocation = 'unknown';
            }
            var eventLocation = pageLocation + '-' + window.userDevice;
            ga('send', 'social', 'Facebook', 'UnLike', eventLocation);
            ga('send', 'event', 'Facebook', 'UnLike', eventLocation);

            // GA WHAT event
            // if on article page
            if (jQuery("body").hasClass('single')) {
                var pageType = jQuery('article').find('.top-tag').html();
            } else if (jQuery("body").hasClass('home')) {
                var pageType = 'home';
            } else {
                var pageType = jQuery('body').find('h1').first().text();
            }
            ga('send', 'social', 'Facebook', 'UnLike', pageType);
            ga('send', 'event', 'Facebook', 'UnLike', pageType);

            document.cookie = "FBLike=false;path=/;expires=Fri, 31 Dec 9999 23:59:59 GMT;max-age=157680000";
        });

        //Send or Share The Page
        FB.Event.subscribe('message.send', function (href, widget) {

            // GA WHICH event (since the action is facebook share, that is always the which event)
            var currentPage = jQuery(document).attr('title');
            ga('send', 'social', 'Facebook', 'Share', currentPage);
            ga('send', 'event', 'Facebook', 'Share', currentPage);

            // GA WHERE event
            var pageLocation = jQuery(widget).data("ga_whereevent_category");
            if (pageLocation == null) {
                //console.log("error: you have set up a facebook like button without setting the ga pageLocation");
                pageLocation = 'unknown';
            }
            var eventLocation = pageLocation + '-' + window.userDevice;
            ga('send', 'social', 'Facebook', 'Share', eventLocation);
            ga('send', 'event', 'Facebook', 'Share', eventLocation);

            // GA WHAT event
            // if on article page
            if (jQuery("body").hasClass('single')) {
                var pageType = jQuery('article').find('.top-tag').html();
            } else if (jQuery("body").hasClass('home')) {
                var pageType = 'home';
            } else {
                var pageType = jQuery('body').find('h1').first().text();
            }
            ga('send', 'social', 'Facebook', 'Share', pageType);
            ga('send', 'event', 'Facebook', 'Share', pageType);

            document.cookie = "FBShare=true;path=/;expires=Fri, 31 Dec 9999 23:59:59 GMT;max-age=157680000";
        });

        //Facebook Comments
        //FB.Event.subscribe('comment.create', function(href, widget) {
        //    var currentPage = jQuery(document).attr('title');
        //});

        function fb_login() {

            FB.login(function (response) {

                if (response.authResponse) {
                    console.log('Welcome!  Fetching your information.... ');
                    console.log(response); // dump complete info
                    access_token = response.authResponse.accessToken; //get access token
                    user_id = response.authResponse.userID; //get FB UID
                    console.log(user_id);
                    FB.api('/me', function (response) {
                        user_email = response.email; //get user email
                        // you can store this data into your database
                        console.log(user_email);
                        console.log(response);
                        console.log(response.authResponse);
                    });
                    document.cookie = "FBSignup=true;path=/;expires=Fri, 31 Dec 9999 23:59:59 GMT;max-age=157680000";
                } else {
                    //user hit cancel button
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, {scope: 'publish_stream,email'});
        }
    }
})(jQuery);