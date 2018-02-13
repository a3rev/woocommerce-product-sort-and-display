<?php
/**
 * Plugin Uninstall
 *
 * Uninstalling deletes options, tables, and pages.
 *
 */
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();

$plugin_key = 'wc_psad';

// Delete Google Font
delete_option( $plugin_key . '_google_api_key' . '_enable' );
delete_transient( $plugin_key . '_google_api_key' . '_status' );
delete_option( $plugin_key . '_google_font_list' );

if ( get_option( $plugin_key . '_clean_on_deletion' ) == 1 ) {
	delete_option( $plugin_key . '_google_api_key' );
	delete_option( $plugin_key . '_toggle_box_open' );
	delete_option( $plugin_key . '-custom-boxes' );

	delete_metadata( 'user', 0,  $plugin_key . '-' . 'plugin_framework_global_box' . '-' . 'opened', '', true );

    delete_option('psad_shop_page_enable');
    delete_option('psad_category_page_enable');
    delete_option('psad_tag_page_enable');
    delete_option('psad_shop_enable_product_showing_count');
    delete_option('psad_cat_enable_product_showing_count');
    delete_option('psad_shop_category_per_page');
    delete_option('psad_category_per_page');
    delete_option('psad_shop_product_per_page');
    delete_option('psad_product_per_page');
    delete_option('psad_category_product_nosub_per_page');
    delete_option('psad_tag_product_per_page');
    delete_option('psad_top_product_per_page');
    delete_option('psad_shop_product_show_type');
    delete_option('psad_product_show_type');
    delete_option('psad_tag_product_show_type');
    delete_option('psad_seperator_enable');
    delete_option('psad_seperator_border');
    delete_option('psad_seperator_border_width');
    delete_option('psad_seperator_border_style');
    delete_option('psad_seperator_border_color');
    delete_option('psad_seperator_padding_tb');
    delete_option('psad_endless_scroll_category_shop');
    delete_option('psad_endless_scroll_category_shop_tyle');
    delete_option('psad_endless_scroll_category');
    delete_option('psad_endless_scroll_category_tyle');
    delete_option('psad_endless_scroll_tag');
    delete_option('psad_endless_scroll_tag_tyle');

    // Delete Endless Scroll Style Shop Page
    delete_option('psad_es_shop_bt_type');
    delete_option('psad_es_shop_bt_align');
    delete_option('psad_es_shop_bt_text');
    delete_option('psad_es_shop_bt_bg');
    delete_option('psad_es_shop_bt_bg_from');
    delete_option('psad_es_shop_bt_bg_to');
    delete_option('psad_es_shop_bt_border_width');
    delete_option('psad_es_shop_bt_border_style');
    delete_option('psad_es_shop_bt_border_color');
    delete_option('psad_es_shop_bt_rounded');
    delete_option('psad_es_shop_bt_font_family');
    delete_option('psad_es_shop_bt_font_size');
    delete_option('psad_es_shop_bt_font_style');
    delete_option('psad_es_shop_bt_font_color');
    delete_option('psad_es_shop_bt_class');
    delete_option('psad_es_shop_link_align');
    delete_option('psad_es_shop_link_text');
    delete_option('psad_es_shop_link_font_family');
    delete_option('psad_es_shop_link_font_size');
    delete_option('psad_es_shop_link_font_style');
    delete_option('psad_es_shop_link_font_color');
    delete_option('psad_es_shop_link_font_hover_color');

    delete_option('psad_es_shop_bt_border');
    delete_option('psad_es_shop_bt_font');
    delete_option('psad_es_shop_link_font');

    // Delete Endless Scroll Style Category Page
    delete_option('psad_es_category_bt_type');
    delete_option('psad_es_category_bt_align');
    delete_option('psad_es_category_bt_text');
    delete_option('psad_es_category_bt_bg');
    delete_option('psad_es_category_bt_bg_from');
    delete_option('psad_es_category_bt_bg_to');
    delete_option('psad_es_category_bt_border_width');
    delete_option('psad_es_category_bt_border_style');
    delete_option('psad_es_category_bt_border_color');
    delete_option('psad_es_category_bt_rounded');
    delete_option('psad_es_category_bt_font_family');
    delete_option('psad_es_category_bt_font_size');
    delete_option('psad_es_category_bt_font_style');
    delete_option('psad_es_category_bt_font_color');
    delete_option('psad_es_category_bt_class');
    delete_option('psad_es_category_link_align');
    delete_option('psad_es_category_link_text');
    delete_option('psad_es_category_link_font_family');
    delete_option('psad_es_category_link_font_size');
    delete_option('psad_es_category_link_font_style');
    delete_option('psad_es_category_link_font_color');
    delete_option('psad_es_category_link_font_hover_color');

    delete_option('psad_es_category_bt_border');
    delete_option('psad_es_category_bt_font');
    delete_option('psad_es_category_link_font');

    // Delete View All Products Style
    delete_option('psad_es_category_item_bt_type');
    delete_option('psad_es_category_item_bt_position');
    delete_option('psad_es_category_item_bt_align');
    delete_option('psad_es_category_item_bt_text');
    delete_option('psad_es_category_item_bt_bg');
    delete_option('psad_es_category_item_bt_bg_from');
    delete_option('psad_es_category_item_bt_bg_to');
    delete_option('psad_es_category_item_bt_border_width');
    delete_option('psad_es_category_item_bt_border_style');
    delete_option('psad_es_category_item_bt_border_color');
    delete_option('psad_es_category_item_bt_rounded');
    delete_option('psad_es_category_item_bt_font_family');
    delete_option('psad_es_category_item_bt_font_size');
    delete_option('psad_es_category_item_bt_font_style');
    delete_option('psad_es_category_item_bt_font_color');
    delete_option('psad_es_category_item_bt_class');
    delete_option('psad_es_category_item_link_align');
    delete_option('psad_es_category_item_link_text');
    delete_option('psad_es_category_item_link_font_family');
    delete_option('psad_es_category_item_link_font_size');
    delete_option('psad_es_category_item_link_font_style');
    delete_option('psad_es_category_item_link_font_color');
    delete_option('psad_es_category_item_link_font_hover_color');
    delete_option('psad_count_meta_view_all_parent_products_align');

    delete_option('psad_es_category_item_bt_border');
    delete_option('psad_es_category_item_bt_font');
    delete_option('psad_es_category_item_link_font');

    // Delete Endless Scroll Style for Products
    delete_option('psad_es_products_bt_type');
    delete_option('psad_es_products_bt_align');
    delete_option('psad_es_products_bt_text');
    delete_option('psad_es_tag_products_bt_text');
    delete_option('psad_es_products_bt_bg');
    delete_option('psad_es_products_bt_bg_from');
    delete_option('psad_es_products_bt_bg_to');
    delete_option('psad_es_products_bt_border_width');
    delete_option('psad_es_products_bt_border_style');
    delete_option('psad_es_products_bt_border_color');
    delete_option('psad_es_products_bt_rounded');
    delete_option('psad_es_products_bt_font_family');
    delete_option('psad_es_products_bt_font_size');
    delete_option('psad_es_products_bt_font_style');
    delete_option('psad_es_products_bt_font_color');
    delete_option('psad_es_products_bt_class');
    delete_option('psad_es_products_link_align');
    delete_option('psad_es_products_link_text');
    delete_option('psad_es_tag_products_link_text');
    delete_option('psad_es_products_link_font_family');
    delete_option('psad_es_products_link_font_size');
    delete_option('psad_es_products_link_font_style');
    delete_option('psad_es_products_link_font_color');
    delete_option('psad_es_products_link_font_hover_color');

    delete_option('psad_es_products_bt_border');
    delete_option('psad_es_products_bt_font');
    delete_option('psad_es_products_link_font');

    // Delete Count Meta Styling
    delete_option('psad_count_meta_font_family');
    delete_option('psad_count_meta_font_size');
    delete_option('psad_count_meta_font_style');
    delete_option('psad_count_meta_font_color');
    delete_option('psad_count_meta_font');

    delete_post_meta_by_key('_psad_onsale_order');
    delete_post_meta_by_key('_psad_featured_order');

    delete_option( $plugin_key . '_clean_on_deletion');

}

// Delete the queries cached
global $wpdb;

$wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%a3_shop_cat%' ) );
$wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%a3_shop_cat_products%' ) );

$wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%a3_s_cat%' ) );
$wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%a3_s_p_cat_%' ) );

