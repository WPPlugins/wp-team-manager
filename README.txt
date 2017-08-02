=== WordPress Team Manager ===
Contributors: maidulcu
Donate link: http://www.dynamicweblab.com/
Tags: team manager, team management,teams,shortcode,member,vcard
Requires at least: 3.5
Tested up to: 4.5
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin will display team or staff members using short code on your post or page. You can display team members picture,social links,vcard etc.

== Description ==

This plugin will display team or staff members using short code on your post or page. You can display team members picture,social links,vcard and other info.

Features:

* List and Grid view to display team members.
* Display member details page.
* Different Image Shapes.
* Different Image Size.
* Limit number of team member to display.
* Control member display order.
* Display selected team member.
* Exclude members for the list.
* Shortcode generator.
* Layout edit option.
* Custom CSS option.
 
Contributors:
[Mike Jordan](http://profiles.wordpress.org/thaicloud/)

For help contact me on [Dynamicweblab.com](http://www.dynamicweblab.com/)

== Installation ==

1. Upload `wp-team-manager` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. A new tab Team will be available on the wordpress admin section

== Frequently Asked Questions ==

= Where is the short code ? =

You can create shortcode generator under Team menu or use this default short code 
[team_manager category='0' orderby='menu_order' limit='0' post__in='' exclude='' layout='grid' image_layout='rounded' image_size='thumbnail'] 

= How can i disable the details member link on the image ? =

You can disable it on the team manager settings page.

= Where i can see the team member id ? =

You can see the id on the id column on the team memebers list.

= How can i change the image size of the team member? =

Team manager list all the image size on the wordpress.To change default image sizes you can do them on the Settings>media

= How can i edit the details team member page file? =

Copy single.php from wp-team-manager/templates to your-theme-folder/team_template folder and do your changes there.

== Screenshots ==

1. Add new member 
2. Add new group
3. Shortcode Generator
4. Settings page
5. List view
6. Grid view

== Changelog ==

= 1.1 =
* Fix Fatal error: Cannot redeclare class RW_Meta_Box bug

= 1.2 =
* Add email field on team member page
* Add featured image support

= 1.3 =
* Add image size support 

= 1.4 =
* Fix wrong placement of shortcode

= 1.5 =
* Fix some bug

= 1.5.1 =
* Fix order bug

= 1.5.2 =
* Remove some notice

= 1.5.3 =
* Clean up some code

= 1.5.4 =
* Link open on new window option is added on settings page

= 1.5.5 =
* Translation text is updated

= 1.5.6 =
* Make compatable with qTranslate plugin and clean up coding

= 1.5.7 =
* Added design layout option on setting page.
* Show selected member only using shortcode.
* Improved UI design.

= 1.5.8 =
* Fix Design layout bug

= 1.5.9 =
* Fix <br> tag bug

= 1.6.0 =
* Fix open in new window bug for website link
* Added ID column on the team manager tab

= 1.6.1 =
* Enable team member search
* Add team member details page
* Disable single team member view settings option
* Add language support
* Add telephone hyperlink

= 1.6.2 =
* Fix team member search white screen bug

= 1.6.3 =
* Make compatible up to wordpess 4.5
* Fix translation bug

= 1.6.4 =
* Add Instagram
* Update css for mobile devices
* Fix some style issue
* Fix translation bug

= 1.6.5 =
* Fix shortcode not working on text widget bug