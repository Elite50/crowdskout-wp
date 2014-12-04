#The Crowdskout WordPress Plugin

Easily add the Crowdskout analytics suite to any WordPress site.

## Description ##

With a simple installation, this plugin adds [Crowdskout](http://crowdskout.com)'s Analytics JavaScript to the footer of any WordPress site; and, with the 1.1 build, additional functionality for Crowdskout track-able newsletter sign-up widgets and shortcodes.  After entering a source ID which can be found in the Crowdskout admin area (see Installation section for finding your source ID), all page views in your site will be ingested for analysis with the Crowdskout platform.  After entering your Crowdskout client ID, also found in the Crowdskout admin area (see Installation section for where to find this as well), Crowdskout newsletter tracking will be activated.  Crowdskout-tracked newsletter sign-up forms can be added to your WordPress site via shortcodes and widgets.  The Crowdskout Newsletter widget can be found under Appearance->Widgets.  Simply drag and drop to the area of your site you wish to display the widget.  To add a Crowdskout Newsletter shortcode, enter [cskt_newsletter] into the post text area where you want the form to appear.  To add a name field to the shortcode, enter [cskt_newsletter name=true].  Any newsletter sign-ups done through these widgets or shortcodes will send email and name (optional) to the Crowdskout platform.

## Installation ##

* Login to the Crowdskout platform, and navigate to Settings > Web Site and note the Source ID and Client ID.
* Now login to the WordPress backend, and navigate to Settings > Crowdskout. Once you enter your Source ID and Client ID here and save, your page views will automatically start tracking and newsletter sign-ups will be ingested to the Crowdskout platform.

## Changelog ##

### 1.1 ###
* Newsletter widget
* Newsletter shortcode

### 1.0 ###
* Initial version