<?php
/**
 * Register Activation Hook
 */
update_option('wc_psad_plugin', 'wc_psad');

function wc_psad_install()
{
    global $wpdb;

    global $wc_psad_admin_init;

    WC_PSAD_Functions::auto_create_order_keys_all_products();
    update_option('wc_psad_lite_version', '1.8.0');
    delete_metadata( 'user', 0, $wc_psad_admin_init->plugin_name . '-' . 'psad_plugin_framework_box' . '-' . 'opened', '', true );

    // Remove house keeping option of another version
    delete_option('psad_clean_on_deletion');

    update_option('wc_psad_just_installed', true);
}

function psad_init()
{
    if (get_option('wc_psad_just_installed')) {
        delete_option('wc_psad_just_installed');

        // Set Settings Default from Admin Init
        global $wc_psad_admin_init;
        $wc_psad_admin_init->set_default_settings();

        // Build sass
        global $wc_psad_less;
        $wc_psad_less->plugin_build_sass();

        wp_redirect(admin_url('admin.php?page=wc-sort-display', 'relative'));
        exit;
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
global $wc_psad_admin_init;
$wc_psad_admin_init->init();

// Add upgrade notice to Dashboard pages
add_filter( $wc_psad_admin_init->plugin_name . '_plugin_extension_boxes', array( $wc_psad_settings_hook, 'plugin_extension_box' ) );

// Add extra link on left of Deactivate link on Plugin manager page
add_action( 'plugin_action_links_' . WC_PSAD_NAME, array( $wc_psad_settings_hook, 'settings_plugin_links' ) );

// Update Onsale order and Featured order value
add_action('save_post', array('WC_PSAD_Functions', 'update_orders_value'), 101, 2);

// Add custom options Onsale and Featured into woocommerce default sort dropdown
add_filter( 'woocommerce_catalog_orderby', array( 'WC_PSAD_Functions', 'add_custom_options_sort' ), 101 );

// Update orderby query for custom sort
add_filter( 'woocommerce_get_catalog_ordering_args', array( 'WC_PSAD_Functions', 'change_orderby_query' ), 101 );

// Check upgrade functions
add_action('init', 'psad_upgrade_plugin');
function psad_upgrade_plugin()
{
    if (version_compare(get_option('wc_psad_lite_version'), '1.0.2') === -1) {
        update_option('wc_psad_lite_version', '1.0.2');
        WC_PSAD_Functions::upgrade_version_1_0_2();
    }

    if (version_compare(get_option('wc_psad_lite_version'), '1.1.0') === -1) {
        update_option('wc_psad_lite_version', '1.1.0');

        // Build sass
        global $wc_psad_less;
        $wc_psad_less->plugin_build_sass();
    }

    if ( version_compare( get_option( 'wc_psad_lite_version') , '1.3.2' ) === -1 ) {
        update_option('wc_psad_lite_version', '1.3.2');

        global $wpdb;

        $wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%psad_shop_categories_query%' ) );
        $wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%psad_shop_list_products_category%' ) );
    }

    if ( version_compare( get_option( 'wc_psad_lite_version') , '1.5.0', '<' ) ) {
        update_option('wc_psad_lite_version', '1.5.0');
        WC_PSAD_Functions::auto_create_order_keys_all_products();
    }

    // Upgrade to 1.5.1
    if ( version_compare(get_option('wc_psad_lite_version'), '1.5.1') === -1 ) {
        update_option('wc_psad_lite_version', '1.5.1');
        update_option('wc_sort_display_style_version', time() );
    }

    // Upgrade to 1.5.3
    if ( version_compare(get_option('wc_psad_lite_version'), '1.5.3') === -1 ) {
        update_option('wc_psad_lite_version', '1.5.3');
        WC_PSAD_Functions::flush_cached();
    }

    update_option('wc_psad_lite_version', '1.8.0');
}
?>