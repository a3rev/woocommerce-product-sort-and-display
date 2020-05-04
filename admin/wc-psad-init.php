<?php
/**
 * Register Activation Hook
 */

use A3Rev\WCPSAD;
function wc_psad_install()
{
    global $wpdb;

    WCPSAD\Functions::auto_create_order_keys_all_products();
    update_option('wc_psad_lite_version', WC_PSAD_VERSION );
    delete_metadata( 'user', 0, $GLOBALS[WC_PSAD_PREFIX.'admin_init']->plugin_name . '-' . 'psad_plugin_framework_box' . '-' . 'opened', '', true );

    // Remove house keeping option of another version
    delete_option($GLOBALS[WC_PSAD_PREFIX.'admin_init']->plugin_name . '_clean_on_deletion');

    update_option('wc_psad_just_installed', true);
}

function psad_init()
{
    if (get_option('wc_psad_just_installed')) {
        delete_option('wc_psad_just_installed');

        // Set Settings Default from Admin Init
        $GLOBALS[WC_PSAD_PREFIX.'admin_init']->set_default_settings();

        // Build sass
        $GLOBALS[WC_PSAD_PREFIX.'less']->plugin_build_sass();
    }

    wc_psad_plugin_textdomain();
}

global $wc_psad_settings_hook;

// Add language
add_action('init', 'psad_init');

// Add custom style to dashboard
add_action( 'admin_enqueue_scripts', array( $wc_psad_settings_hook, 'a3_wp_admin' ) );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array( $wc_psad_settings_hook, 'plugin_extra_links' ), 10, 2 );

// Need to call Admin Init to show Admin UI
$GLOBALS[WC_PSAD_PREFIX.'admin_init']->init();

// Add upgrade notice to Dashboard pages
add_filter( $GLOBALS[WC_PSAD_PREFIX.'admin_init']->plugin_name . '_plugin_extension_boxes', array( $wc_psad_settings_hook, 'plugin_extension_box' ) );

// Add extra link on left of Deactivate link on Plugin manager page
add_action( 'plugin_action_links_' . WC_PSAD_NAME, array( $wc_psad_settings_hook, 'settings_plugin_links' ) );

// Update Onsale order and Featured order value
add_action( 'save_post', array( '\A3Rev\WCPSAD\Functions', 'update_orders_value' ), 101, 2 );

// Add custom options Onsale and Featured into woocommerce default sort dropdown
add_filter( 'woocommerce_catalog_orderby', array( '\A3Rev\WCPSAD\Functions', 'add_custom_options_sort' ), 101 );

// Update orderby query for custom sort
add_filter( 'woocommerce_get_catalog_ordering_args', array( '\A3Rev\WCPSAD\Functions', 'change_orderby_query' ), 101 );

// Check upgrade functions
add_action('init', 'psad_upgrade_plugin');
function psad_upgrade_plugin()
{
    if (version_compare(get_option('wc_psad_lite_version'), '1.0.2') === -1) {
        update_option('wc_psad_lite_version', '1.0.2');
        WCPSAD\Functions::upgrade_version_1_0_2();
    }

    if (version_compare(get_option('wc_psad_lite_version'), '1.1.0') === -1) {
        update_option('wc_psad_lite_version', '1.1.0');

        // Build sass
        $GLOBALS[WC_PSAD_PREFIX.'less']->plugin_build_sass();
    }

    if ( version_compare( get_option( 'wc_psad_lite_version') , '1.3.2' ) === -1 ) {
        update_option('wc_psad_lite_version', '1.3.2');

        global $wpdb;

        $wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%psad_shop_categories_query%' ) );
        $wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%psad_shop_list_products_category%' ) );
    }

    if ( version_compare( get_option( 'wc_psad_lite_version') , '1.5.0', '<' ) ) {
        update_option('wc_psad_lite_version', '1.5.0');
        WCPSAD\Functions::auto_create_order_keys_all_products();
    }

    // Upgrade to 1.5.1
    if ( version_compare(get_option('wc_psad_lite_version'), '1.5.1') === -1 ) {
        update_option('wc_psad_lite_version', '1.5.1');
        update_option('wc_sort_display_style_version', time() );
    }

    // Upgrade to 1.5.3
    if ( version_compare(get_option('wc_psad_lite_version'), '1.5.3') === -1 ) {
        update_option('wc_psad_lite_version', '1.5.3');
        WCPSAD\Functions::flush_cached();
    }

    // Upgrade to 2.0.2
    if ( version_compare(get_option('wc_psad_lite_version'), '2.0.2') === -1 ) {
        update_option('wc_psad_lite_version', '2.0.2');
        WCPSAD\Functions::flush_cached();
    }

    update_option('wc_psad_lite_version', WC_PSAD_VERSION );
}
