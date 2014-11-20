<?php
/**
 * These are our functions that define and explain the various areas above.
 */
if (!function_exists('cskt_pageview_explain')) {
	/**
	 * The explanation for the settings we need for pageview tracking.
	 */
	function cskt_pageview_explain() {
		_e('The settings we need to start tracking your pageviews.', 'crowdskout');
	}
}

if (!function_exists('cskt_social_media_explain')) {
    /**
     * The explanation for the settings we need for social media tracking.
     */
    function cskt_social_media_explain() {
        _e('The settings we need to start tracking your social media interactions', 'crowdskout');
    }
}