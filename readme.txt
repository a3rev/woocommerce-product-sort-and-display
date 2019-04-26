=== WooCommerce Product Sort and Display ===

Contributors: a3rev, nguyencongtuan
Tags: WooCommerce, WooCommerce Shop Page, WooCommerce Products, WooCommerce Product Display, WooCommerce Product sort.
Requires at least: 4.5
Tested up to: 5.2.0
Stable tag: 1.8.6
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Create a true Supermarket shopping experience. Sort and show products on Shop page by category - auto show On Sale or Featured first, Endless Scroll.

== DESCRIPTION ==

Walk into any shop, Supermarket or Department store and what do you see - products organized and grouped in aisle and areas. 'Walk' into any WooCommerce store page and what does your customer / client see - an almost entirely random display of products sorted mostly by date of publishing.

That has always seemed crazy to us. What shop owner would just keep stacking new stock at the front of all the other stock in their shop in any order. None is the answer! So why is that exactly what all of our virtual WooCommerce stores do?

We decided to build a plugin that would fix that. With WooCommerce Product Sort and Display installed you can do the following:

* Sort products to show by category on shop page.
* Sort category order on shop page by drag and drop.
* Set the number of products to show per category on the shop page with link to view all.
* If Parent Category has no products attached to it - will show products from the Parents Child Categories.
* Option to switch Product Categories ON | OFF for display on shop page.
* Set to auto show all current 'On Sale' products first in each category on the shop page.
* Set to auto show all 'featured' products in each category on the shop page.
* Activate Endless scroll feature for your shop page.
* Select Auto Endless Scroll or Scroll on Click.
* Set how many category group of products show before pagination or endless scroll loads.
* Intelligent Navigation shows customers the total number of products in the category they are viewing with a link to view all.
* Endless Scroll feature (option) for seamless customer scrolling through the entire shop page makes for quick and very easy shop browsing.

= 2 NEW PRODUCT SORT FEATURES =

* Auto show any 'On Sale' products first in the Category View on shop page.
* Auto show any 'featured' products first in the category view.

= INTELLIGENT BROWSING =

* Show the current number of products being viewed and total products in Category.
* 'No more product to view' message when all products are showing.

= VISUAL SEPARATOR =

* Add a visual separator between each Product Category group of products.
* Style the separator with in plugin style options - no coding
* Set padding in px above and below the separator.

= PREMIUM VERSION =

The Premium version of this plugin is for those who want Sort and Display applied to their stores Product Category and Product Tag pages. It has ALL the features of this Free version - Apply Sort and Display to the shop page - plus these advanced features:

* Apply Sort and display to the entire store - Product Category and Product Tags pages
* Show Sub Categories with products on their Parent Category page.
* Set the number of products to show in parent and each child category
* Set Parent Cat to show no products - just show Child cats and products.
* If parent Category has no products because all products are in the child categories set to show child cats with products
* Custom Sort Featured and On Sale is added to WooCommerce Sort features for Category and Tags pages
* Endless Scroll feature for Product Category and Product tag pages
* Apply all settings globally from the admin dashboard with individual setting on each category e.g. Sort type, number of products to show

View details here on the [a3rev.com](http://a3rev.com/shop/woocommerce-product-sort-and-display/) site

= CONTRIBUTE =

When you download WooCommerce Product Sort and Display, you join our the a3rev Software community. Regardless of if you are a WordPress beginner or experienced developer if you are interested in contributing to the future development of WooCommerce Product Sort and Display or any of our other plugins on Github head over to the WooCommerce Product Sort and Display[GitHub Repository](https://github.com/a3rev/woocommerce-product-sort-and-display) to find out how you can contribute.

Want to add a new language to WooCommerce Product Sort and Display! You can contribute via [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/woocommerce-product-sort-and-display)

== Installation ==

= Minimum Requirements =

* WordPress 4.5
* WooCommerce 2.7 and later.
* PHP version 5.5 or greater
* MySQL version 5.5 or greater

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't even need to leave your web browser. To do an automatic install of WooCommerce Product Sort and Display, log in to your WordPress admin panel, navigate to the Plugins menu and click Add New. Search WooCommerce Product Sort and Display. Click install.

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your web server via your favourite FTP application.

1. Download the plugin zip file from WordPress to your computer and unzip it
2. Using an FTP program, or your hosting control panel, upload the unzipped plugin folder to your WordPress installations wp-content/plugins/ directory.
3. Activate the plugin from the Plugins menu within the WordPress admin.


== Screenshots ==

1. Show products by category on the WooCommerce Shop page.
2. Use new Sort types to show your most important products where they should be - first up
3. If your theme does not support endless scroll - activate the plugins Endless Scroll feature.


== Usage ==

1. Install and activate the plugin

2. On WordPress Amin page go to WooCommerce menu > Sort & Display menu

3. Settings Tab - Turn Endless Scroll on for your shop page.

4. Endless Scroll - active on Shop Page.

5. Go to Products menu > Categories menu - drop and drag product categories in the order you want them to display on the shop page.

6. Visual ON | OFF switch on each category. Switch OFF any product category that you do not want to show on the shop page 

7. Enjoy endlessly tweaking your store page product layout.


== Frequently Asked Questions ==

= When can I use this plugin? =

On any WordPress install that has the WooCommerce plugin installed and activated.


== Changelog ==

= 1.8.6 - 2019/04/26 =
* This maintenance update is tweaks for compatibility with WordPress 5.2.0 and WooCommerce 3.6.0 major new versions whilst maintaining backward compatibility  
* Tweak - Test for compatibility with WordPress 5.2.0
* Tweak - Test for compatibility with WooCommerce 3.6.2
* Tweak - Add filter to post_clauses for sort type On Sale with connect to new lookup table database of WC 3.6.0
* Tweak - Update get_woocommerce_term_meta to get_term_meta to work with WooCommerce 3.6.0
* Tweak - Update update_woocommerce_term_meta  to update_term_meta to work with WooCommerce 3.6.0
* Tweak – Maintain backward compatibility to WooCommerce version 3.5.0

= 1.8.5 - 2018/12/26 =
* This maintenance update is for compatibility with WordPress 5.0.2, WooCommerce 3.5.3 and PHP 7.3. It also includes performance updates to the plugin framework.
* Tweak - Test for compatibility with WordPress 5.0.2 and WordPress 4.9.9
* Tweak - Test for compatibility with WooCommerce 3.5.3
* Tweak - Create new structure for future development of Gutenberg Blocks
* Framework - Performance improvement.  Replace wp_remote_fopen  with file_get_contents for get web fonts
* Framework - Performance improvement. Define new variable `is_load_google_fonts` if admin does not require to load google fonts
* Credit - Props to Derek for alerting us to the framework google fonts performance issue
* Framework - Register style name for dynamic style of plugin for use with Gutenberg block
* Framework - Update Modal script and style to version 4.1.1
* Framework - Update a3rev Plugin Framework to version 2.1.0
* Framework - Test and update for compatibility with PHP 7.3

= 1.8.4 - 2018/05/26 =
* This maintenance update is for compatibility with WordPress 4.9.6 and WooCommerce 3.4.0 and the new GDPR compliance requirements for users in the EU 
* Tweak - Test for compatibility with WooCommerce 3.4.0
* Tweak - Test for compatibility with WordPress 4.9.6
* Tweak - Check for any issues with GDPR compliance. None Found
* Framework - Update a3rev Plugin Framework to version 2.0.3

= 1.8.3 - 2018/02/13 =
* Maintenance Update. Under the bonnet tweaks to keep your plugin running smoothly and is the foundation for new features to be developed this year 
* Framework - Update a3rev Plugin Framework to version 2.0.2
* Framework - Add Framework version for all style and script files
* Tweak - Update for full compatibility with a3rev Dashboard plugin
* Tweak - Update WooCommerce Display Settings URL the new WooCommerce Customizer menu URL
* Tweak  Change h1 tag for category names to h2 tags from theme. Using h1 tags not good for SEO
* Fixed - Update frontend so that shop and category pages can show properly on WC 3.3.0
* Tweak - Test for compatibility with WordPress 4.9.4
* Tweak - Test for compatibility with WooCommerce 3.3.1

= 1.8.2 - 2017/10/13 =
* Tweak - Tested for compatibility with WooCommerce 3.2.0
* Tweak - Tested for compatibility with WordPress 4.8.2
* Tweak - Added support for the new WC 'tested up to' feature to show this plugin has been tested compatible with WC updates

= 1.8.1 - 2017/08/15 =
* Tweak - Tested for compatibility with WordPress 4.8.1
* Tweak - Tested for compatibility with WooCommerce 3.1.1
* Fix - Change field name from ID to id so that the Product Categories ON | OFf button can show on the Product categories table

= 1.8.0 - 2017/06/07 =
* Feature - Launched WooCommerce Product Sort & Display public Repository
* Tweak - Tested for compatibility with WordPress major version 4.8.0
* Tweak - tested for compatibility with WooCommerce version 3.0.7
* Tweak - Include bootstrap modal script into plugin framework
* Tweak - Update a3rev plugin framework to latest version

= 1.7.6 - 2017/04/22 =
* Tweak - Tested for full compatibility with WooCommerce version 3.0.4
* Tweak - Tested for full compatibility with WordPress version 4.7.4
* Tweak - Change call direct to Product properties with new function that are defined on WC v3.0
* Tweak - Called action for save data of plugin after WC data is saved on new WC 3.0 CRUD
* Tweak - Change priority for save_post action so that it is called after WooCommerce save the product data, to get the correct data on WC v3.0
* Tweak - Update query for get products are featured from term instead of product meta on new WC v3.0
* Tweak - Update query to get outofstock products from term instead of product meta on new WC v3.0
* Tweak - Get outofstock from term instead of product meta on new WC v3.0
* Tweak - Update query to get products that are exclude from catalog from term instead of product meta on new WC v3.0

= 1.7.5 - 2017/03/07 =
* Tweak - Change global $$variable to global ${$variable} for compatibility with PHP 7.0
* Tweak - Update a3 Revolution to a3rev Software on plugins description
* Tweak - Added Settings link to plugins description on plugins menu
* Tweak - Tested for full compatibility with WordPress version 4.7.3
* Tweak - Tested for full compatibility with WooCommerce version 2.6.14

= 1.7.4 - 2016/11/29 =
* Tweak - Update order by for Featured and On Sale sort options. Sort by Featured or On Sale first, then display balance in date published order instead of Alphabetically  
* Tweak - Tested for full compatibility with WooCommerce version 2.6.8
* Credit - Thanks to Eitan Shavit for the balance sort by date published instead of Alphabetically suggestion

= 1.7.3 - 2016/11/09 =
* Tweak - Change old action name from 'a3rev_head' to 'responsi_head' for compatibility with Responsi Framework
* Tweak - Change old function name to checked from 'add_responsi_pagination_theme' to 'responsi_add_pagination_links' for compatibility with Responsi Framework
* Tweak - Update script for compatibility with Responsi Framework

= 1.7.2 - 2016/11/08 =
* Fix - Update plugin style for product card display properly in mobile

= 1.7.1 - 2016/10/28 =
* Tweak - Define new 'Ajax Multi Submit' control type with Progress Bar showing and Statistic for plugin framework
* Tweak - Define new 'Ajax Submit' control type with Progress Bar showing for plugin framework
* Tweak - Update plugin framework styles and scripts support for new 'Ajax Submit' and 'Ajax Multi Submit' control type
* Tweak - Update text domain for full support of translation with new name for translate file is 'woocommerce-product-sort-and-display.po'
* Tweak - Tested for full compatibility with WordPress version 4.6.1
* Tweak - Tested for full compatibility with WooCommerce version 2.6.7
* Fix - Headers already sent warning. Delete trailing spaces at bottom of php file

= 1.7.0 - 2016/08/22 =
* Feature - Add new option to set ON | OFF for Category display on shop page.
* Tweak - Added ON | OFF Shop Page switch to the Product > Category page Table
* Tweak - Tested for full compatibility with WooCommerce version 2.6.4
* Tweak - Tested for full compatibility with WordPress version 4.6.0

= 1.6.0 - 2016/07/18 =
* Feature - Added 'Line Height' option into Typography control of plugin framework
* Tweak - Update select type of plugin framework for support group options
* Tweak - Update plugin framework style for support 'Line Height' option of Typography control
* Tweak - Update Typography Preview script for apply 'Line Height' value to Preview box
* Tweak - Update the generate_font_css() function with new 'Line Height' option

= 1.5.5 - 2016/07/01 =
* Tweak - Tested for full compatibility with WooCommerce version 2.6.3
* Tweak - Tested for full compatibility with WordPress version 4.5.3

= 1.5.4 - 2016/06/20 =
* Tweak - Tested for full compatibility with WooCommerce major version 2.6.0
* Tweak - Tested for full compatibility with WooCommerce version 2.6.1
* Tweak - Tested for  full compatibility with WordPress version 4.5.2

= 1.5.3 - 2016/04/09 =
* Dev - Define 'generate_transient_name' function for generate transient name support many parameters
* Tweak - Change transient name to new transient name support many parameters so that on WordPress 4.4 have change on limited characters for transient name from 45 characters to 172 characters
* Tweak - Parse many parameters to transient name for create the cached have exactly data than before
* Fix - Update DB Query Cached option for work compatibility with Product Filter widget
* Credit - Thanks to bobu for notifying about the WooCommerce Price Filter conflict and access to the site to see the bug and create a fix

= 1.5.2 - 2016/04/05 =
* Tweak - Register fontawesome in plugin framework with style name is 'font-awesome-styles'
* Tweak - Update plugin framework to latest version
* Tweak - Tested for full compatibility with WordPress major version 4.5

= 1.5.1 - 2016/03/11 =
* Tweak - Saved the time number into database for one time customize style and Save change on the Plugin Settings
* Tweak - Replace version number by time number for dynamic style file are generated by Sass to solve the issue get cache file on CDN server
* Tweak - Define new 'strip_methods' argument for Uploader type, allow strip http/https or no
* Tweak - Tested for full compatibility with WooCommerce version 2.5.0
* Tweak - Tested for full compatibility with WordPress version 4.4.2
* Fix - Update 'loop_shop_per_page' filter so that the number of products displayed on Product category pages is changed by 3rd party plugin instead filtering the number set from WordPress Settings > Reading number of posts to show on archive pages
* Credit - Thanks to Mattias art-scope.org for notifying us about the category page filter issue and access to his site to find and fix

= 1.5.0 - 2016/01/22 =
* Feature - Define new 'Background Colour' type on plugin framework with ON | OFF switch to disable background or enable it
* Feature - Define new function - hextorgb() - for convert hex colour to rgb colour on plugin framework
* Feature - Define new function - generate_background_color_css() - for export background style code on plugin framework that is used to make custom style
* Tweak - Tested for full compatibility with WooCommerce version 2.5.0
* Tweak - Tested for full compatibility with WordPress version 4.4.1
* Tweak - Update core style and script of plugin framework for support Background Colour type
* Tweak - Update plugin framework to latest version
* Tweak - Updated required WordPress version to 4.1 for full compatibility with WooCommerce plugin
* Tweak - Change check upgrade function from hook tag 'plugins_loaded' to 'init' to use the core function of WooCommerce
* Tweak - Update sort by Featured and On Sale, if have 2 or more products are Featured or On Sale then continue sort by price Low to High
* Fixed - Sync PSAD featured key when product is set as featured product via Featured icon on Product List
* Fixed - Hide ordering dropdown on Shop Page when StoreFront theme is used, for full compatibility with StoreFront theme

= 1.4.1 - 2015/12/19 =
* Tweak - Tested for full compatibility with WordPress major version 4.4
* Tweak - Tested for full compatibility with WooCommerce version 2.4.12
* Tweak - Update plugin activation and auto Upgrade script for integration with new Responsi Premium Pack plugin
* Tweak - Change old Uploader to New UI of Uploader with Backbone and Underscore from WordPress
* Tweak - Update the uploader script to save the Attachment ID and work with New Uploader
* Tweak - Change call action from 'wp_head' to 'wp_enqueue_scripts' and use 'wp_enqueue_style' function to load dynamic style for better compatibity with minify feature of caching plugins
* Tweak - Change call action from  'wp_head' to 'wp_enqueue_scripts' to load  google fonts
* Tweak - Updated a3 Plugin Framework to the latest version

= 1.4.0 - 2015/09/16 =
* Feature - Support all sort options of WooCommerce Settings for show products on Shop Page
* Feature - Hook into 'woocommerce_default_catalog_orderby_options' filter tag for add 'Sort by On Sale' and 'Sort by Featured' options into Default Product Sort setting of WooCommerce
* Feature - Still show 'Sort by On Sale' and 'Sort by Featured' from sort dropdown on Shop Page and Category Page when the disabled Sort & Display for Shop Page or Category Page from Plugin Settings
* Tweak - Change the default sort from 'Recent' to new WooCommerce version 2.4.0 'Custom ordering + Name' with backward compatibility
* Tweak - Update the transient name with addition 'orderby' and 'order' with make transient name for list products cached
* Tweak - Tested for full compatibility with WordPress Version 4.3.1
* Fix - Pagination show duplicated on Category page

= 1.3.5 - 2015/08/20 =
* Tweak - include new CSSMin lib from https://github.com/tubalmartin/YUI-CSS-compressor-PHP-port into plugin framework instead of old CSSMin lib from http://code.google.com/p/cssmin/ , to avoid conflict with plugins or themes that have CSSMin lib
* Tweak - make __construct() function for 'Compile_Less_Sass' class instead of using a method with the same name as the class for compatibility on WP 4.3 and is deprecated on PHP4
* Tweak - change class name from 'lessc' to 'a3_lessc' so that it does not conflict with plugins or themes that have another Lessc lib
* Tweak - Plugin Framework DB query optimization. Refactored settings_get_option call for dynamic style elements, example typography, border, border_styles, border_corner, box_shadow
* Tweak - Tested for full compatibility with WooCommerce Version 2.4.4
* Tweak - Tested for full compatibility with WordPress major version 4.3.0
* Fix - Make __construct() function for 'WC_PSAD' class instead of using a method with the same name as the class for compatibility on WP 4.3 and is deprecated on PHP4
* Fix - Update the plugin framework for setup correct default settings on first installed
* Fix - Update the plugin framework for reset to correct default settings when hit on 'Reset Settings' button on each settings tab

= 1.3.4 - 2015/07/30 =
* Tweak - Removed all Premium Version settings boxes from that admin panels
* Tweak - Removed all Premium Version settings boxes from Product Category create and edit pages
* Tweak - Removed Pro Version setting boxes description from the Plugin Framework setting box
* Tweak - Added Premium Version feature description to bottom of a3 framework setting box with SHOW | HIDE switch
* Tweak - Updated the images in admin panel sidebar
* Tweak - Tested for full compatibility with WooCommerce version 2.3.13
* Tweak - Tested for full compatibility with WordPress version 4.2.3
* Fix - Updated orderby = meta_value_num to meta_value_num date to ensure when Featured or On Sale sort is used that other products in the category show in resent order after the Feature or On Sale products.

= 1.3.3 - 2015/07/21 =
* Tweak - Defined new trigger for when items are loaded by endless scroll

= 1.3.2 - 2015/07/07 =
* Tweak - Add DB queries cached for WordPress roles for compatibility with sites that have pre-set product views based on user roles
* Tweak - Shortened cached names when appended with role name it does not exceed the 45 characters for cached name. See reference here http://codex.wordpress.org/Function_Reference/set_transient

= 1.3.1 - 2015/07/04 =
* Tweak - Hook 'dont_show_categories_on_shop' into 'woocommerce_product_subcategories_args' tag for not show subcategories on Shop page
* Tweak - Hook 'dont_show_product_on_shop' into 'woocommerce_before_shop_loop' with priority 41 for not show products on Shop page
* Fix - Shop page showing Products above categories when Sort and Display is activated

= 1.3.0 - 2015/07/03 =
* Feature - Major performance upgrade with optimized database queries and in plugin caching
* Feature - Add new DB Query Cache settings box with option to switch caching ON | OFF and manual clear cache
* Feature - Add caching for shop page product categories and products queries
* Tweak - Hook to filter 'woocommerce_product_subcategories_args' tag to remove duplicate the queries to database
* Tweak - Check and just called queries from Shop page in Responsi Framework

= 1.2.1 - 2015/06/17 =
* Tweak - Check if a3_admin_ui_script_params is defined to save status of settings box
* Tweak - Added call 'admin_localize_printed_scripts' on setting panel page to avoid conflicts with other plugins built on a3 Plugin framework

= 1.2.0 - 2015/06/16 =
* Feature - Plugin framework Mobile First focus upgrade
* Feature - Massive improvement in admin UI and UX in PC, tablet and mobile browsers
* Feature - Introducing opening and closing Setting Boxes on admin panels.
* Feature - Added Plugin Framework Customization settings. Control how the admin panel settings show when editing.
* Feature - New interface has allowed us to do away with the 5 sub menus on the admin panel
* Feature - Includes a script to automatically combine sub category tables into the Tabs main table when upgrading
* Feature - Added Option to set Google Fonts API key to directly access latest fonts and font updates from Google
* Feature - Pro Version setting boxes have a green background colour and are sorted to the bottom of each admin panel
* Feature - Added full support for Right to Left RTL layout on plugins admin dashboard.
* Feature - Added a 260px wide images to the right sidebar for support forum link, Documentation links.
* Tweak - Updated a lot of admin panel Description and Help text
* Tweak - Tested for full compatibility with WooCommerce Version 2.3.11
* Fix - Check 'request_filesystem_credentials' function, if it does not exists then require the core php lib file from WP where it is defined

= 1.1.8 - 2015/06/04 =
* Tweak - Tested for full compatibility with WooCommerce Version 2.3.10
* Tweak - Security Hardening. Removed all php file_put_contents functions in the plugin framework and replace with the WP_Filesystem API
* Tweak - Security Hardening. Removed all php file_get_contents functions in the plugin framework and replace with the WP_Filesystem API

= 1.1.7 - 2015/05/30 =
* Tweak - Tested for full compatibility with WordPress Version 4.2.2
* Tweak - Tested and Tweaked for full compatibility with WooCommerce Version 2.3.9
* Tweak - Changed Permission 777 to 755 for style folder inside the uploads folder
* Tweak - Chmod 644 for dynamic style and .less files from uploads folder
* Fix - Update url of dynamic stylesheet in uploads folder to the format //domain.com/ so it's always is correct when loaded as http or https
* Fix - Sass compile path not saving on windows xampp

= 1.1.6 - 2015/04/23 =
* Fix - Move the output of <code>add_query_arg()</code> into <code>esc_url()</code> function to fix the XSS vulnerability identified in WordPress 4.1.2 security upgrade

= 1.1.5 - 2015/04/21 =
* Tweak - Tested and Tweaked for full compatibility with WordPress Version 4.2.0
* Tweak - Tested and Tweaked for full compatibility with WooCommerce Version 2.3.8
* Tweak - Update style of plugin framework. Removed the [data-icon] selector to prevent conflict with other plugins that have font awesome icons

= 1.1.4 - 2015/03/19 =
* Tweak - Tested and Tweaked for full compatibility with WooCommerce Version 2.3.7
* Tweak - Tested and Tweaked for full compatibility with WordPress Version 4.1.1

= 1.1.3 - 2015/02/13 =
* Tweak - Maintenance update for full compatibility with WooCommerce major version release 2.3.0 with backward compatibility to WC 2.2.0
* Tweak - Tested fully compatible with WooCommerce just released version 2.3.3
* Tweak - Changed WP_CONTENT_DIR to WP_PLUGIN_DIR. When an admin sets a custom WordPress file structure then it can get the correct path of plugin

= 1.1.2 - 2014/12/24 =
* Tweak - Added support for product card image lazy load when [a3 Lazy Load plugin](https://wordpress.org/plugins/a3-lazy-load/) is installed.
* Tweak - Updated plugin to be 100% compatible with WooCommerce Version 2.2.10
* Tweak - Tested 100% compatible with WordPress Version 4.1
* Tweak - Added link to a3 Lazy Load and a3 Portfolio plugins on admin dashboard yellow sidebar.
* Fix - Infinite scroll bug on URLs that end with -#

= 1.1.1 - 2014/09/12 =
* Tweak - Tested 100% compatible with WooCommerce 2.2.2
* Tweak - Tested 100% compatible with WordPress Version 4.0
* Tweak - Added WordPress plugin icon
* Fix - Changed __DIR__ to dirname( __FILE__ ) for Sass script so that on some server __DIR___ is not defined

= 1.1.0 - 2014/09/04 =
* Feature - Converted all front end CSS #dynamic {stylesheets} to Sass #dynamic {stylesheets} for faster loading.
* Feature - Convert all back end CSS to Sass.
* Tweak - Tested 100% compatible with WooCommerce Version 2.2 and backwards to version 2.1
* Tweak - use wc_get_product() function instead of get_product() function when site is using WooCommerce Version 2.2
* Tweak - Updated google font face in plugin framework.

= 1.0.5.3 - 2014/07/18 =
* Tweak - Update to Product Category create and edit page Sort and display settings in line with Pro version new features for synch.
* Tweak - On Product category create and edit pages One Level Up Display settings now always show even when Sort and display features are OFF.

= 1.0.5.2 - 2014/07/16 =
* Tweak - Added ON | OFF button for Sort and Display Pro Version feature activation on product category pages
* Tweak - On Product category create and edit pages set switch to OFF to hide Pro settings for better UI.

= 1.0.5.1 - 2014/07/03 =
* Tweak - Updated plugins description and dashboard text for details about plugin upgrade version.
* Tweak - Checked for full compatibility with WooCommerce Version 2.1.12

= 1.0.5 - 2014/06/26 =
* Feature - When Parent Category has no products on Shop page, set to show products from the Parents Child Cats.
* Feature - Added Empty Parent Categories feature ON | OFF switch for Shop Page.
* Tweak - Updated admin pages help text links to WooCommerce admin panel which have changed in recent updates.
* Tweak - Updated chosen js script to latest version 1.1.0 on the a3rev Plugin Framework
* Tweak - Tested 100% compatible with WooCommerce version 2.1.11
* Fix - Pagination link breaking. Added str_replace( 'page/'.$page , '', pagination_link ); to trip page/[number]

= 1.0.4.3 - 2014/05/29 =
* Tweak - Updated the plugins wordpress.org description.
* Tweak - Updated the plugins admin panel yellow sidebar text.

= 1.0.4.2 - 2014/05/28 =
* Tweak - Added remove_all_filters('mce_external_plugins'); before call to wp_editor to remove extension scripts from other plugins.
* Tweak - Updated Framework help text font for consistency.
* Tweak - Changed add_filter( 'gettext', array( $this, 'change_button_text' ), null, 2 ); to add_filter( 'gettext', array( $this, 'change_button_text' ), null, 3 );
* Tweak - Update change_button_text() function from ( $original == 'Insert into Post' ) to ( is_admin() && $original === 'Insert into Post' )
* Tweak : Added support for placeholder feature for input, email , password , text area types
* Tweak - Tested 100% compatible with WooCommerce Version 2.1.9
* Tweak - Tested 100% compatible with WordPress Version 3.9.1

= 1.0.4.1 - 2014/04/14 =
* Tweak - Tested and updated for full WordPress version 3.9 compatibility.
* Tweak - Updated Masonry script to work with WP 3.9 with backward compatibility to WP v 3.7

= 1.0.4 - 2014/01/27 =
* Feature - Upgraded for 100% compatibility with WooCommerce Version 2.1 with backward compatibility to Version 2.0
* Feature - Added all required code so plugin can work with WooCommerce Version 2.1 refactored code.
* Tweak - All switch text to show as Uppercase.
* Tweak - Added description text to the top of each Pro Version yellow border section
* Tweak - Tested for compatibility with WordPress version 3.8.1
* Tweak - Full WP_DEBUG ran, all uncaught exceptions, errors, warnings, notices and php strict standard notices fixed.

= 1.0.3 - 2013/12/20 =
* Feature - a3rev Plugin Framework admin interface upgraded to 100% Compatibility with WordPress v3.8.0 with backward compatibility.
* Feature - a3rev framework 100% mobile and tablet responsive, portrait and landscape viewing.
* Tweak - Upgraded dashboard switch and slider to Vector based display that shows when WordPress version 3.8.0 is activated.
* Tweak - Upgraded all plugin .jpg icons and images to Vector based display for full compatibility with new WordPress version.
* Tweak - Yellow sidebar on Pro Version Menus does not show in Mobile screens to optimize admin panel screen space.
* Tweak - Tested 100% compatible with WP 3.8.0
* Fix - Upgraded array_textareas type for Padding, Margin settings on the a3rev plugin framework

= 1.0.2 - 2013/11/28 =
* Feature - Upgraded the plugin to the newly developed a3rev admin Framework with app style interface.
* Feature - Admin panel Conditional logic and intuitive triggers. When setting is ON corresponding settings appear, OFF and they don't show.
* Tweak - Moved admin from WooCommerce settings tab onto the WooCommerce menu items under the menu name Sort and Display.
* Tweak - Sort & Display menus item tabs, Settings | Endless Scroll | View All & Count
* Tweak - Endless Scroll tab has 3 sub menu items, Shop Page Scroll | Category Page Scroll | Parent Cat & Tag Page Scroll
* Tweak - View All & Count has 2 sub menu items, View All Products | Count Meta
* Tweak - New admin UI features check boxes replaced by switches, some dropdowns replaced by sliders.
* Tweak - Tested 100% compatible with WordPress 3.7.1
* Tweak - Tested 100% compatible with WooCommerce 2.0.20
* Fix - Fix - $args->slug depreciated in WordPress 3.7, replace with $request = unserialize( $args['body']['request'] ); $request->slug
* Fix - Plugins admin script and style not loading in Firefox with SSL on admin. Stripped http// and https// protocols so browser will use the protocol that the page was loaded with.
* Fix - Full WP_DEBUG and all uncaught exceptions, errors, notifications and warnings fixed.

= 1.0.1 - 2013/09/03 =
* Tweak - Updated some prefixes to a3rev_ for compatibility with the a3revFramework.
* Tweak - Tested for full compatibility with WordPress v3.6.0
* Fix - Replaced get_pagenum_link() function with add_query_arg() function. Endless scroll not loading pages on sites with SSL redirects from https to http on shop and archive pages.

= 1.0.0 - 2013/07/23 =
* First working release


== Upgrade Notice ==

= 1.8.5 =
This maintenance update is for compatibility with WordPress 5.0.2, WooCommerce 3.5.3 and PHP 7.3. It also includes performance updates to the plugin framework.

= 1.8.4 =
Maintenance Update. Compatibility with WooCommerce 3.4.0, WordPress 4.9.6 and the new GDPR compliance requirements for users in the EU

= 1.8.3 =
Maintenance Update. This version updates the Plugin Framework to v 2.0.2, adds full compatibility with a3rev Dashboard, WordPress v 4.9.4 and WooCoomerce v 3.3.1

= 1.8.2 =
Maintenance Upgrade. Tweaks for compatibility with WooCommerce 3.2.0 and WordPress 4.8.2

= 1.8.1 =
Maintenance Update. 1 bug fix plus compatibility with WooCommerce version 3.1.1 and WordPress version 4.8.1

= 1.8.0 =
Feature Update. 2 code tweaks for compatibility with WordPress major version 4.8.0 and WooCommerce version 3.0.7 plus launch of public Github repo for source code

= 1.7.6 =
Maintenance Update. 7 code updates for compatibility with WooCommerce Version 3.0.4 backward to 2.6.0 and WordPress 4.7.4

= 1.7.5 =
Maintenance Update. 3 code tweaks for compatibility with WordPress v 4.7.4, WooCommerce v 2.6.14 and PHP 7.0 global variable

= 1.7.4 =
Maintenance Update. 1 sort order tweak plus full compatibility with WooCommerce version 2.6.8

= 1.7.3 =
Maintenance Update. 3 code tweaks for compatibility with Responsi Framework

= 1.7.2 =
Maintenance Update. 1 blog card display on mobile bug fix

= 1.7.1 =
Maintenance Update. 4 code tweaks and 1 bug fix for full compatibility with WooCommerce 2.6.7 and WordPress 4.6.1

= 1.7.0 =
Feature Upgrade. Added the option to turn Product Categories ON | OFF on shop page plus full compatibility with WordPress 4.6.0 and WooCommerce 2.6.4

= 1.6.0 =
Feature Upgrade. Added option to set line height to the dynamic font editor

= 1.5.5 =
Maintenance Update. Tweak and tested for full compatibility with WooCommerce version 2.6.3 and WordPress version 4.5.3

= 1.5.4 =
Maintenance Update. Update now for full compatibility with WooCommerce version 2.6.1 amd WordPress version 4.5.2

= 1.5.3 =
Maintenance Update. 2 code tweaks and 1 bug fix to resolve conflict with WooCommerce Price Filter Widget

= 1.5.2 =
Maintenance Update. 2 tweaks for full compatibility with upcoming major WordPress version 4.5.0

= 1.5.1 =
Maintenance Update. 1 Bug fix 3 code tweaks for full compatibility with WooCommerce v 2.5.4 and WordPress v 4.4.2

= 1.5.0 =
Major Upgrade for full compatibility with WooCommerce v2.5 with backward compatibility to v2.1 - 3 new features, 5 major code Tweaks and 2 bug fixes

= 1.4.1 =
Maintenance Update. 6 code tweaks for full compatibility with WordPress major version 4.4 and WooCommerce version 2.4.12

= 1.4.0 =
Feature Upgrade. 3 new features including support for all WC sort options for Shop page plus for new WC default sort plus 1 bug fix. Also full compatibility with WordPress version 4.3.1

= 1.3.5 =
Major Maintenance Upgrade. 6 Code Tweaks plus 3 bug fixes for full compatibility with WordPress v 4.3.0 and WooCommerce v 2.4.4

= 1.3.4 =
Maintenance Upgrade. One custom sort Featured and On Sale bug fix plus Removed all Pro Version setting boxes from admin panels. Tweak for full compatibility with WooCommerce Version 2.3.13 and WP 4.2.3

= 1.3.3 =
Maintenance Upgrade. 1 tweak for full compatibility with plugins or themes have use masonry scripts

= 1.3.2 =
Maintenance Upgrade. 2 tweaks for full compatibility with plugins that have pre-set product views based on roles. Example product price

= 1.3.1 =
Maintenance Upgrade. 2 x code tweaks to fix bug on shop page display that was in yesterday version 1.3.0 feature release

= 1.3.0 =
Feature Upgrade. Major performance upgrade with optimized database queries and in-plugin caching

= 1.2.1 =
Maintenance Upgrade. 2 code Tweaks for new a3 Plugin Framework released in version 1.2.0

= 1.2.0 =
Major Feature Upgrade. Massive admin panel UI and UX upgrade. Includes 8 new features, 1 bug fix plus full compatibility with WooCommerce Version 2.3.11

= 1.1.8 =
Important Maintenance Upgrade. 2 x major a3rev Plugin Framework Security Hardening Tweaks plus full compatibility with WooCommerce 2.3.10

= 1.1.7 =
Maintenance Upgrade. 2 bugs fix and 2 security Tweaks, full compatibility with WordPress 4.2.2 and WooCommerce 2.3.9

= 1.1.6 =
Important Security Patch! - please run this update now. Fixes XSS vulnerability declared and patched in WordPress Security update v 4.1.2

= 1.1.5 =
Maintenance upgrade. Code tweaks for full compatibility with WordPress 4.2.0 and WooCommerce 2.3.8

= 1.1.4 =
Upgrade now for full compatibility with WooCommerce Version 2.3.7 and WordPress version 4.1.1

= 1.1.3 =
Upgrade now for full compatibility with WooCommerce major version release 2.3.0 with backward compatibility to WooCommerce v 2.2.0

= 1.1.2 =
Upgrade now for Infinite Scroll bug fix, plus support for a3 Lazy Load and full compatibility with WooCommerce 2.2.10 and WordPress 4.1

= 1.1.1 =
Upgrade now for full 1 Sass bug fix and full compatibility with WooCommerce Version 2.2.2 and WordPress 4.0

= 1.1.0 =
Major version upgrade. Full front end and back end conversion to Sass and Tweaks for full compatibility with soon to be released WooCommerce 2.2

= 1.0.5.3 =
Minor version upgrade to keep the Lite Version in synch with Pro version upgrade.

= 1.0.5.2 =
Minor version upgrade. Improved Product Cat create and edit pages UI for lite version users.

= 1.0.5.1 =
Update your plugin now for tweaks for full compatibility with WooCommerce Version 2.1.12

= 1.0.5 =
Upgrade now for 2 New Features, 2 framework code tweaks, 1 bug fix and full compatibility with WooCommerce version 2.1.11

= 1.0.4.3 =
Minor version update - missed 2 tweaks from yesterdays version 1.0.4.2 release.

= 1.0.4.2 =
Update now for 5 Framework code tweaks and full compatibility with WooCommerce version 2.1.9 and WordPress version 3.9.1

= 1.0.4.1 =
Important Upgrade! Upgrade now for full compatibility with WordPress version 3.9 and backwards to WP v3.7

= 1.0.4 =
Upgrade now for full compatibility with WooCommerce Version 2.1 and WordPress version 3.8.1. Includes full backward compatibly with WooCommerce versions 2.0 to 2.0.20.

= 1.0.3 =
Upgrade now for full a3rev Plugin Framework compatibility with WordPress version 3.8.0 and backwards. New admin interface full mobile and tablet responsive display.

= 1.0.2 =
Upgrade your plugin now to the new a3rev plugin framework and intuitive app style admin interface plus 6 associated tweaks and 3 bug fixes and full compatibility with WP 3.7.1 and Woocommerce 2.0.20.

= 1.0.1 =
Upgrade now for a page load bug fix on sites the have SSL