=== Project Panorama Lite ===
Contributors: Ross Johnson
Tags: project, management, project management, basecamp, status, client, admin, intranet
Requires at least: 3.5.0
Tested up to: 3.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Keep clients happy by communicating project status and progress in a visual way. Project Panorama is a simple and effective alternative to basecamp and other project management software.

== Description ==

Project Status is a WordPress project management plugin designed to keep your clients and team in the loop. Each project can be configured to display overall project status, store documents, identify task and task completion, have phases and phase progress.

= Tested on =
* Mac Firefox 	:)
* Mac Safari 	:)
* Mac Chrome	:)
* PC Firefox	:)
* PC IE9/10/11	:)
* PC IE8 - Not great, but usable

= Website =
http://www.projectpanorama.com

= Documentation =
http://www.projectpanorama.com/docs

= Bug Submission and Forum Support =
http://www.projectpanorama.com/forums
http://www.projectpanorama.com/support

== Installation ==

1. Upload 'project-panorama-lite' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click on the new menu item "Projects" and create your first project!
4. You can now visit and share the project with clients
5. Embed projects into pages and posts using the embed code [project_status id="<post_id>"] which can be found on the project listing page

== Screenshots ==

1. Identify major milestones and visually track progress of your project
2. Record project start and end dates, keep documents in a single location
3. Keep track of all project progress on the backend
4. Use shortcodes to embed projects into your theme (entire projects or portions)
5. Example progress shortcode

== Shortcodes ==

http://www.projectpanorama.com/docs/shortcodes/

== Frequently Asked Questions ==

http://www.projectpanorama.com/docs/common-issues/

= Q. I have a question =
A. Chances are, someone else has asked it. Check out the support forum at: 
http://www.projectpanorama.com/forums

= Q. I'm getting 404 errors on my projects or other plugins

First Try going to settings > permalinks and resaving your permalinks
If that doesn't work, there is probably another plugin thats conflicting with Panorama. You can try editing the /project-panorama/lib/data_model.php file and removing line 56 that says "flush_rewrite_rules();" - Then resave your permalinks.

= Q. Logging into a project redirects me to another page
  A. This happens when you have another plugin that alters standard login redirects, often a ticketing system or other "project management like" plugin. You will need to have the author of that plugin help you remove the global user redirect.

== Credit ==

Project Panorama is powered by Advanced Custom Fields and the Advanced Custom Field Repeater Addon. Advanced Custom Field Repeater Addon may not be removed, distributed or sold without purchase from Advanced Custom Fields (http://www.advancedcustomfields.com). 

== Changelog ==

= 1.2.1.7 =
* Official Project Panorama Lite release, forked from Panorama Premium