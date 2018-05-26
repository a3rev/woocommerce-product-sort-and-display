<?php
/*
Plugin Name: WooCommerce Product Sort and Display LITE
Description: Take control of your WooCommerce Shop random product display with WooCommerce Show Products by Category. Sort and show products on Shop page by category with 'On Sale' or 'Featured' products showing first. Products showing and total products per category count for intelligent viewing.
Version: 1.8.4
Requires at least: 4.5
Tested up to: 4.9.6
Author: a3rev Software
Author URI: https://a3rev.com/
Text Domain: woocommerce-product-sort-and-display
Domain Path: /languages
WC requires at least: 2.0.0
WC tested up to: 3.4.0
License: This software is under commercial license and copyright to A3 Revolution Software Development team

	WooCommerce Show Products By Categories. Plugin for the WooCommerce shopping Cart.
	Copyright© 2011 A3 Revolution Software Development team

	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/
?>
<?php
define( 'WC_PSAD_FILE_PATH', dirname(__FILE__) );
define( 'WC_PSAD_DIR_NAME', basename(WC_PSAD_FILE_PATH) );
define( 'WC_PSAD_FOLDER', dirname(plugin_basename(__FILE__)) );
define( 'WC_PSAD_URL', untrailingslashit(plugins_url('/', __FILE__)) );
define( 'WC_PSAD_DIR', WP_PLUGIN_DIR . '/' . WC_PSAD_FOLDER );
define( 'WC_PSAD_NAME', plugin_basename(__FILE__));
define( 'WC_PSAD_TEMPLATE_PATH', WC_PSAD_FILE_PATH . '/templates' );
define( 'WC_PSAD_IMAGES_URL', WC_PSAD_URL . '/assets/images' );
define( 'WC_PSAD_JS_URL', WC_PSAD_URL . '/assets/js' );
define( 'WC_PSAD_CSS_URL', WC_PSAD_URL . '/assets/css' );
if (!defined("WC_PSAD_AUTHOR_URI")) define("WC_PSAD_AUTHOR_URI", "http://a3rev.com/shop/woocommerce-product-sort-and-display/");

define( 'WC_PSAD_KEY', 'wc_psad' );
define( 'WC_PSAD_VERSION',  '1.8.4' );

/**
 * Load Localisation files.
 *
 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
 *
 * Locales found in:
 * 		- WP_LANG_DIR/woocommerce-product-sort-and-display/woocommerce-product-sort-and-display-LOCALE.mo
 * 	 	- WP_LANG_DIR/plugins/woocommerce-product-sort-and-display-LOCALE.mo
 * 	 	- /wp-content/plugins/woocommerce-product-sort-and-display/languages/woocommerce-product-sort-and-display-LOCALE.mo (which if not found falls back to)
 */
function wc_psad_plugin_textdomain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-product-sort-and-display' );

	load_textdomain( 'woocommerce-product-sort-and-display', WP_LANG_DIR . '/woocommerce-product-sort-and-display/woocommerce-product-sort-and-display-' . $locale . '.mo' );
	load_plugin_textdomain( 'woocommerce-product-sort-and-display', false, WC_PSAD_FOLDER . '/languages/' );
}

include ('admin/admin-ui.php');
include ('admin/admin-interface.php');

include ('admin/admin-pages/admin-sort-display-page.php');

include ('admin/admin-init.php');
include ('admin/less/sass.php');

include 'classes/class-wc-psad.php';
include 'classes/class-wc-psad-functions.php';
include 'classes/class-wc-psad-admin-hook.php';

include 'admin/wc-psad-init.php';

/**
 * Call when the plugin is activated
 */
register_activation_hook(__FILE__, 'wc_psad_install');

?>