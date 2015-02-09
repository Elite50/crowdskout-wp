(function($) {
    cskt.twHandlers = function () {
        console.log('welcome to twitter park');

        function cskt_tweet (event) {
            if (!(event)) return;
            console.log("Tweet");
        }

        function cskt_follow (event) {
            if (!(event)) return;
            console.log("Follow");
            var followed_user_id = event.data.user_id;
            var followed_screen_name = event.data.screen_name;
            console.log("Followed User ID: "+followed_user_id );
            console.log("Followed Screen Name: "+followed_screen_name );
            console.log(event.target);
        }

        function cskt_unfollow (event) {
            console.log("unfollow");
        }

        function cskt_retweet (event) {
            if (!(event)) return;
            console.log("Retweet");
            var retweeted_tweet_id = event.data.source_tweet_id;
            console.log("ReTweet successful for tweet ID: "+event.data.source_tweet_id);
        }

        twttr.events.bind('tweet', cskt_tweet);
        twttr.events.bind('follow', cskt_follow);
        twttr.events.bind('unfollow', cskt_unfollow);
        twttr.events.bind('retweet', cskt_retweet);
    }
})(jQuery);