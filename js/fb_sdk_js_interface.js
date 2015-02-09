// Facebook App Helper Functions
(function($) {
    cskt.fbHandlers = function () {
        console.log('welcome to facebook park');
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
                console.log('Please log into this app ' + response.name);
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
            console.log('like');
            document.cookie = "FBLike=true;path=/;expires=Fri, 31 Dec 9999 23:59:59 GMT;max-age=157680000";
        });

        //Unlikes the page
        FB.Event.subscribe('edge.remove', function (href, widget) {
            console.log('unlike');
            document.cookie = "FBLike=false;path=/;expires=Fri, 31 Dec 9999 23:59:59 GMT;max-age=157680000";
        });

        //Send or Share The Page
        FB.Event.subscribe('message.send', function (href, widget) {
            console.log('share');
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