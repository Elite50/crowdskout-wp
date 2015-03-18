#The Crowdskout WordPress Plugin

Easily add the Crowdskout analytics suite to any WordPress site.

## Description ##

With a simple installation, this plugin adds [Crowdskout](http://crowdskout.com)'s Analytics JavaScript to the footer of any WordPress site, Crowdskout track-able newsletter sign-up widgets and shortcodes, and with the 1.2 build, tags and categories tracking is integrated into pageviews.

### Crowdskout Pageview Analytics ###
After entering in the appropriate client details, pageviews with categories and tags will be automatically tracked by the plugin.

### Crowdskout Newsletter ###
Crowdskout-tracked newsletter sign-up forms can be added to your WordPress site via shortcodes and widgets. Widgets can be added through WordPress' drag and drop interface. 

To add a Crowdskout Newsletter shortcode, enter `[cskt_newsletter]` into the post text area where you want the form to appear.  To add a name field to the shortcode, enter `[cskt_newsletter name=true]`.  Any sign-ups done through these widgets or shortcodes will send email and name (optional) to the Crowdskout platform.

## Installation ##

* Login to the Crowdskout platform, and navigate to Settings > Web Site and note the Source ID and Client ID.
* Now login to the WordPress backend, and navigate to Settings > Crowdskout. Once you enter your Source ID and Client ID here and save, your page views will automatically start tracking and newsletter sign-ups will be ingested to the Crowdskout platform.

## Changelog ##

### 1.2.2 ###
* Fixed a bug in PHP 5.3 support

### 1.2.1 ###
* Fixed a bug in the Crowdskout API URL

### 1.2 ###
* Categories and Tags integrated into pageview tracking

### 1.1 ###
* Newsletter widget
* Newsletter shortcode

### 1.0 ###
* Initial version
