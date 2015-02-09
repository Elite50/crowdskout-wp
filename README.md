#The Crowdskout WordPress Plugin

Easily add the Crowdskout analytics suite to any WordPress site.

## Description ##

With a simple installation, this plugin adds [Crowdskout](http://crowdskout.com)'s Analytics Suite to your WordPress site.  This includes pageview ingestion into your Crowdskout account with tags and categories tracking along with pageview tracking.  The installation also includes Crowdskout track-able newsletter sign-up forms and Crowdskout track-able Facebook and Twitter like and share buttons, all done through the addition of widgets and shortcodes.  With these buttons and forms on your site, likes, shares, tweets, follows and newsletter sign-ups will all be sent to your Crowdskout account. 

### Crowdskout Pageview Analytics ###
After entering in the appropriate client details, pageviews with categories and tags will be automatically tracked by the plugin.

### Crowdskout Newsletter ###
Crowdskout-tracked newsletter sign-up forms can be added to your WordPress site via shortcodes and widgets. Widgets can be added through WordPress' drag and drop interface. 

To add a Crowdskout Newsletter shortcode, enter `[cskt_newsletter]` into the post text area where you want the form to appear.  To add a name field to the shortcode, enter `[cskt_newsletter name=true]`.  Any sign-ups done through these widgets or shortcodes will send email and name (optional) to the Crowdskout platform.

### Crowdskout Facebook Like Button ###
Crowdskout-tracked Facebook like buttons can be added to your WordPress site via shortcodes and widgets along with all the options that come with a normal facebook like button.  Widgets can be added through WordPress' drag and drop interface.

To add the Crowdskout Facebook Like button shortcode, enter `[cskt_fb_like]` into the post text area where you want the button to appear.  There are several options you can set to your button including pagename, width, layout, action, show_faces, share and comments.  You can add these options by writing them in the shortcode like so: `[cskt_fb_like pagename='' width='' layout='' action='' show_faces='' share='' comments='']`.  They can be in any order, with however many options you do or do not want to add, with no commas separating the arguments and no quotes around the argument's values.  If you just enter `[cskt_fb_like]` then the default values will set it so a simple facebook like button is displayed.  See below for a complete example with all arguments. 
 
* pagename : The pagename should be your company's facebook page url, i.e. https://www.facebook.com/Crowdskout.  If you want, you can enter that value once on the Crowdskout settings page, which is located under the Settings tab.  If you set it here, the pagename of your shortcode and widget will always take this value unless you enter a different one in the shortcode (or widget) itself like so: `[cskt_fb_like pagename=https://www.facebook.com/Crowdskout]`
* width : The default for width has no value, which means the facebook button will take up the space that its provided.  You can change it to any pixel value you want by adding `[cskt_fb_like width=300]`. When users try to put another button next to / on the same line as the like button they would logically type, `[cskt_fb_like][cskt_fb_share]`.  However, users may notice that this puts the share button on the next line.  This is because by default the facebook like button takes up the entire row that it is provided.  To avoid this issue, change the width to the desired pixel value.  Note that this is generally only the case for the facebook like button.  All other buttons do not take up the entire row, but just the width of the button itself.   
* layout : The default layout is button, which is just the facebook like button without a counter.  Other options include standard (says something like "this many other people like this on facebook"), box_count (count number above the button) and button_count (count number to the side of the button).  To change the value write, `[cskt_fb_like layout=standard]`
* action : The default action type is like.  The other option is recommend, and honestly I don't know what the difference is between the two.  I think with one of them you die, so be careful.  To change the value write `[cskt_fb_like action=recommend]`
* show_faces : The default show_faces value is false.  If the visitor is logged onto facebook and they have friends who also like your site, and show_faces is set to true, the profile pics of that person's friends will be displayed below the button. To change the value write `[cskt_fb_like show_faces=true]`
* share : The default share value is false.  If you set the share value to true, it will put a share button right next to the like button.  To do so write `[cskt_fb_like share=true]`
* comments : The default comments value is true.  This means that when the button is clicked a comments pop up pox will appear under the button that the user can make a comment along with their post.  If you do not wish for the user to have this capability simple change it by writing `[cskt_fb_like comments=false]`.  I recommend this since this popup window often has problems with being cut off, so if you wish to use it do test it out first.

here is a complete example: `[cskt_fb_like pagename=https://www.facebook.com/Crowdskout width=300 layout=button action=like show_faces=false share=false comments=true]`

### Crowdskout Facebook Share Button ###
Crowdskout-tracked Facebook share buttons can be added to your WordPress site via shortcodes and widgets along with all the options that come with a normal facebook share button.  Widgets can be added through WordPress' drag and drop interface.

* pagename
* layout

### Crowdskout Twitter Follow Button ###
Crowdskout-tracked Twitter follow buttons can be added to your WordPress site via shortcodes and widgets along with all the options that come with a normal twitter follow button.  Widgets can be added through WordPress' drag and drop interface.

* user
* show_username
* size
* show_count

### Crowdskout Twitter Tweet Button ###
Crowdskout-tracked Twitter share buttons can be added to your WordPress site via shortcodes and widgets along with all the options that come with a normal twitter tweet button.  Widgets can be added through WordPress' drag and drop interface.

* url
* text
* via
* size
* show_count
* recommend
* hashtag

## Installation and Setup##
* Login to the Crowdskout platform, and navigate to Settings > Web Site and note the Source ID and Client ID.
* Now login to the WordPress backend, and navigate to Settings > Crowdskout. Once you enter your Source ID and Client ID here and save, your page views will automatically start tracking and newsletter sign-ups will be ingested to the Crowdskout platform.

## Changelog ##

### 1.3 ###
* Facebook and Twitter widgets
* Facebook and Twitter shortcodes

### 1.2 ###
* Categories and Tags integrated into pageview tracking

### 1.1 ###
* Newsletter widget
* Newsletter shortcode

### 1.0 ###
* Initial version
