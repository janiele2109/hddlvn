﻿=== Breadcrumb NavXT ===
Contributors: mtekk, hakre
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=FD5XEU783BR8U&lc=US&item_name=Breadcrumb%20NavXT%20Donation&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: breadcrumb, breadcrumbs, trail, navigation, menu, widget
Requires at least: 4.4
Tested up to: 4.6
Stable tag: 5.5.1
License: GPLv2 or later
Adds breadcrumb navigation showing the visitor's path to their current location.

== Description ==

Breadcrumb NavXT, the successor to the popular WordPress plugin Breadcrumb Navigation XT, was written from the ground up to be better than its ancestor. This plugin generates locational breadcrumb trails for your WordPress powered blog or website. These breadcrumb trails are highly customizable to suit the needs of just about any website running WordPress. The Administrative interface makes setting options easy, while a direct class access is available for theme developers and more adventurous users.

= PHP Requirements =
Breadcrumb NavXT 5.2 and newer require PHP5.3
Breadcrumb NavXT 5.1.1 and older require PHP5.2

= Features (non-exhaustive) =
* RDFa format Schema.org BreadcrumbList compatible breadcrumb generation.
* Extensive breadcrumb customization control via a settings page with appropriate default values for most use cases.
* Network admin settings page for managing breadcrumb settings for all subsites with [configurable global priority](http://mtekk.us/archives/guides/controlling-breadcrumb-navxt-settings-from-the-network-settings-page/ "Go to the article on configuring the network settings priority.").
* Built in WordPress Widget.
* Extensible via OOP and provided [actions](http://mtekk.us/code/breadcrumb-navxt/breadcrumb-navxt-doc/2/#action_reference "Go to the Breadcrumb NavXT Documentation's action reference.") and [filters](http://mtekk.us/code/breadcrumb-navxt/breadcrumb-navxt-doc/2/#filter_reference "Go to the Breadcrumb NavXT Documentation's filter reference.").
* WPML compatible (enhanced compatibility with WPML extensions plugin).
* Polylang compatible (enhanced compatibility with Polylang extensions plugin).
* bbPress compatible (enhanced compatibility with bbPress extensions plugin).
* BuddyPress compatible (enhanced compatibility with BuddyPress extensions plugin).

= Translations =

Breadcrumb NavXT now supports WordPress.org language packs. Want to translate Breadcrumb NavXT? Visit [Breadcrumb NavXT's WordPress.org translation project](https://translate.wordpress.org/projects/wp-plugins/breadcrumb-navxt/).

== Installation ==
Open the appropriate file for your theme (typically header.php). This can be done within WordPress’ administration panel through Presentation > Theme Editor or through your favorite text editor. Place the following code where you want the breadcrumb trail to appear.
`<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
    <?php if(function_exists('bcn_display'))
    {
        bcn_display();
    }?>
</div>`
Save the file (upload if applicable). Now you should have a breadcrumb trail on your WordPress powered site. To customize the breadcrumb trail you may edit the default values for the options in the administrative interface. This is located in your administration panel under Settings > Breadcrumb NavXT.

Please visit [Breadcrumb NavXT's Documentation](http://mtekk.us/code/breadcrumb-navxt/breadcrumb-navxt-doc/ "Go to Breadcrumb NavXT's Documentation.") page for more information.

== Screenshots ==
1. This screenshot shows 5 different examples of breadcrumbs generated by Breadcrumb NavXT
2. A screenshot of the General tab of the settings page
3. A screenshot of the Post Types tab of the settings page
4. A screenshot of the Taxonomies tab of the settings page
5. A screenshot of the Miscellaneous tab of the settings page
6. A screenshot of the Settings Import/Export/Reset form under the Help menu

== Changelog ==

= 5.5.1 =
Release date: August 13th, 2016

* Bug fix: Fixed issue in `bcn_breadcrumb_trail::find_type()` that identified pages as posts, causing the erroneous inclusion of the post root in the breadcrumb trail for pages. 

= 5.5.0 =
Release date: August 12th, 2016

* Behavior change: Internal mechanics to handle post parents as the hierarchy for a post (of any post type) has changed to use 'BCN_POST_PARENT' rather than 'page' for the taxonomy_type.
* Behavior change: Internal mechanics to handle dates as the hierarchy for a post (of any post type) has changed to use 'BCN_DATE' rather than 'date' for the taxonomy_type.
* Behavior change: Taxonomy term hierarchy selection logic in `bcn_breadcrumb_trail::pick_post_term()` has changed to picking the deepest known child of the first hierarchy found in the list of terms returned by `get_the_terms()` rather than the first term with a child.
* New feature: Added support for referer influenced taxonomy selection for a post's (any post type) breadcrumb trail.
* New feature: Added `translate` and `lang` as valid attributes for tags within breadcrumb templates.
* New feature: Added `srcset` and `sizes` as valid attributes for `img` tags within breadcrumb templates.
* New feature: Added `itemprop` as a valid attribute for the `meta` tags within breadcrumb templates.
* Bug fix: Fixed various issues caused by other plugins/themes modifying the `$post` global.
* Bug fix: Fixed issue where WPML Extensions would cause a CPT without a set root page to use the Post post type's root page.

= 5.4.0 =
Release date: March 15th, 2016

* Behavior change: Migrated to new adminKit version, some functions previously in the admin classes are now handled upstream.
* New feature: Added `bcn_post_terms` filter to `bcn_breadcrumb_trail::post_terms()` to control the terms included in a non-hierarchical term breadcrumb for a post.
* New feature: Added `bcn_add_post_type_arg` filter to `bcn_breadcrumb_trail::maybe_add_post_type_arg()` to control when the post_type argument is added to URLs for archives.
* New feature: Added `bcn_pick_post_term` filter to `bcn_breadcrumb_trail::post_hierarchy()` to allow overriding Breadcrumb NavXT’s default term selection behavior.
* Bug fix: Fixed issue with untranslatable title on the settings page.
* Bug fix: Cleanup of several trivial differences between `bcn_admin` and `bcn_network_admin`.
* Bug fix: Fixed improper display of “Your settings are out of date. Migrate now.” message on fresh installs.
* Bug fix: Clarified verbiage in regards to the paged breadcrumb.
* Bug fix: Added translation wrappers for date format strings in `bcn_breadcrumb_trail::do_archive_by_date()`.
* Bug fix: Fixed issue where `bcn_breadcrumb_trail::is_builtin()` would cause PHP warnings when the passed in post type was not an actual post type.
* Bug fix: Fixed issue that would cause a PHP error if `WP_Widget` is unavailable.

= 5.3.1 =
Release date: December 14th, 2015

* Bug fix: Fixed alignment issue of the main content of the settings page on WordPress 4.4.
* Bug fix: Fixed error caused by options upgrading not re-establishing new settings.
* Bug fix: Fixed PHP error caused by `bcn_breadcrumb_trail::get_type_string_query_var()` returning an array when the post_type query variable is an array.

= 5.3.0 =
Release date: November 12th, 2015

* Behavior change: Breadcrumb NavXT will no longer default to setting the root page for CPTs.
* Behavior change: Breadcrumb NavXT will no longer inject a breadcrumb for a CPT archive page if a root page is set for that CPT.
* Behavior change: Breadcrumb NavXT now defaults to `BCN_SETTINGS_USE_LOCAL` rather than `BCN_SETTINGS_USE_NETWORK` if all of the `BCN_SETTINGS_*` globals are not defined.
* Behavior change: The included widget now supports RDFA style, Schema.org BreadcrumbList format rather than the deprecated Google Breadcrumbs format.
* Behavior change: Default settings for breadcrumb templates now conform to RDFA style, Schema.org BreadcrumbList format rather than the deprecated Google Breadcrumbs format.
* New feature: Added `bcn_widget_display_trail` action to enhance the included widget’s extensibility.
* New feature: Added `bcn_widget_display_types` action to enhance the included widget’s extensibility.
* New feature: The plugin uninstaller has been re-factored, includes support for uninstalling in PHP5.2.
* New feature: Unit tests added for all non-deprecated features in bcn_breadcrumb.
* New feature: Unit tests added for the uninstaller.
* New feature: Date based hierarchies are now available for CPTs.
* New feature: Date archives restricted by CPT are now supported.
* New feature: Taxonomy archives restricted by CPT are now supported.
* Bug fix: Fixed issue where the multibyte supplicant functions were not always being included due to WordPress shipping with its own subset of theses functions.
* Bug fix: Fixed issue where on an archive for a post type the archive breadcrumb would appear twice.

= 5.2.2 =
Release date: June 1st, 2015

* Bug fix: Fixed issue where the current item would use a built in default template rather than the breadcrumb template in the settings.
* Bug fix: Updated currently distributed translations set and list to match the current set of translations that achieve the 90% completeness threshold for inclusion.
* Bug fix: Fixed issue where a PHP warning would be displayed when BCN_SETTINGS_USE_NETWORK is defined.

= 5.2.1 =
Release date: May 25th, 2015

* Bug fix: Added additional checks for empty URLs and templates within `bcn_breadcrumb` to prevent various bugs when empty URLs and/or templates are passed in.
* Bug fix: Move away from building URLs for search breadcrumbs and instead using `get_search_link()` to fix support for pretty permalinks.
* Bug fix: Fixed issue where media items (attachments) that have not been attached to a post yet would cause an incorrect breadcrumb trail to be generated.
* Bug fix: Fixed issue where attachments of the front page would cause PHP Warnings.
* Bug fix: Fixed issue where attachments of the front page would have duplicate breadcrumbs for the home page.
* Bug fix: Fixed issue where attachments of pages would have an extraneous breadcrumb relating to the page for posts.
* Bug fix: Fixed issue with the text domain/domain path in the plugin header.

= 5.2.0 =
Release date: January 9th, 2015

* Deprecated: The Max Breadcrumb Length setting has been deprecated in favor of [using CSS styling to perform the length limiting](http://mtekk.us/archives/guides/trimming-breadcrumb-title-lengths-with-css/ "Go to the article presenting how to shorten the breadcrumb title length using CSS").
* Behavior change: The archive page for a post type is now generated for the top ancestor post rather than for the current page when "post parent" is used as the post's hierarchy.
* Behavior change: Now requires PHP5.3 or newer.
* New feature: Added `bcn_type_archive_post_type` filter.
* New feature: Settings depending on another setting to be enabled are disabled when the dependency setting is disabled.
* New feature: More descriptive messages on settings saving (notify user on success, failure, and no changes to save).
* Bug fix: Fixed awkward wording in the settings page for post hierarchy settings.
* Bug fix: Fixed missed default templates for post formats when all taxonomy settings had the tax_ prefix added in 5.1.
* Bug fix: Fixed bulk of compatibility issues with bbPress.

= 5.1.1 =
Release date: July 29th, 2014

* Bug fix: Fixed issue where attachments and their parents have the same link when 'link current item' is enabled.
* Bug fix: Pass the same parameters into the widget title and (pre) text filters as the default WordPress widgets.
* Bug fix: Fixed issue where PHP warnings would be thrown on author pages for authors that do not have any posts.
* Bug fix: Reduced severity of `$post` global not being of type `WP_Post`, will silently exit on non-WP_DEBUG enabled sites.

= 5.1.0 =
Release date: June 9th, 2014

* Behavior change: `bcn_breadcrumb_trail::do_post()` now expects to be passed in a valid WP_Post object.
* Behavior change: `breadcrumb_navxt::version` changed to a constant to allow uninstantiated access of the plugin version.
* New feature: Support Google's RDFa Breadcrumbs microformat by default.
* New feature: Added `bcn_opts_update_prebk` filter.
* Bug fix: Validate HTML5 options on tab traversal.
* Bug fix: Fixed issue where the settings importer parsed the version string incorrectly.
* Bug fix: Added 'typeof' to list of valid HTML tag attributes.
* Bug fix: Prefixed all taxonomies with 'tax_' to prevent name collisions.
* Bug fix: Added ID to Post and Taxonomy Term Elements in `bcn_breadcrumb_trail::do_root()` as is done everywhere else.
* Bug fix: Fixed issue with `bcn_breadcrumb_trail::do_author()` returning the incorrect user under some circumstances.
* Bug fix: Fixed issue where saving twice on a tab in the settings page would cause the next page load to open the general tab rather than the current tab.
* Bug fix: Added bcn_breadcrumb_template filter back into `bcn_breadcrumb::set_template()`, was a regression in 5.0 from 4.4.
* Bug fix: Fixed issue where the included widget did not check against default settings, causing PHP Warnings to show up on the frontend under some circumstances.
* Bug fix: Fixed issue where we didn't handle `WP_POST::has_archive` correctly when it was a string, causing issues with CPTs generated by some plugins.
* Bug fix: Fixed issue where the default taxonomy selected for a CPT could be a non-public taxonomy.
* Bug fix: Attachments get their own title within the settings page now.
* Bug fix: Filter the title and pre text in the widget.

= 5.0.1 = 
Release date: December 31st, 2013

* Behavior Change: Notify multisite users when settings may be overridden by the network settings and vice versa.
* Bug fix: Updated tab style to match WordPress 3.8 look and feel.
* Bug fix: Fixed issue where `bcn_breadcrumb_trail::display_list()` would produce multiple instances of the class attribute.
* Bug fix: Fixed several issues with the uninstaller.

= 5.0.0 =
Release date: November 20th, 2013

* Behavior Change: Moved `bcn_breadcrumb_trail::trail` to `bcn_breadcrumb_trail::breadcrumbs`
* Behavior Change: When WordPress is in multisite/network mode, the settings set in the network settings page take priority over subsite settings.
* New feature: Added `bcn_breadcrumb_trail_object` filter.
* New feature: Added `bcn_li_attributes` filter.
* New feature: Added `bcn_breadcrumb_types` filter.
* New feature: Added Network Admin Settings page.
* New feature: Added `xmlns:v` and `property` to the valid tag attributes.
* Bug fix: The current_item breadcrumb for search results should result in a valid HTTPS link when appropriate.

== Upgrade Notice ==

= 5.5.0 =
This version requires PHP5.3 or newer. This version introduces contextually aware taxonomy selection for post hierarchies.

= 5.4.0 =
This version requires PHP5.3 or newer. This version introduces three new filters: `bcn_post_terms`, `bcn_add_post_type_arg`, and `bcn_pick_post_term`.

= 5.3.0 =
This version requires PHP5.3 or newer. This version adds in support for post type restricted archives (date and taxonomy).