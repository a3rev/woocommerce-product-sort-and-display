<?php
/**
 * WC_PSAD_Settings_Hook Class
 *
 * Class Function into WooCommerce plugin
 *
 * Table Of Contents
 * __construct()
 * psad_add_category_fields()
 * psad_edit_category_fields()
 * psad_category_fields_save()
 * a3_wp_admin()
 * plugin_extension()
 * plugin_extra_links()
 */

namespace A3Rev\WCPSAD;

class Admin_Hook
{
	
	public function __construct() {

		// Include script
		$this->include_script();

		// Add column on Product Categories Table
		add_filter( 'manage_edit-product_cat_columns', array( $this, 'product_cat_columns' ) );
		add_filter( 'manage_product_cat_custom_column', array( $this, 'product_cat_column' ), 10, 3 );

		// Include google fonts into header
		add_action( 'wp_enqueue_scripts', array( $this, 'add_google_fonts'), 9 );

		//Add sort into Settings of WC
		add_filter( 'woocommerce_default_catalog_orderby_options', array( $this, 'add_options_into_default_catalog_orderby') );

		// Update PSAD featured product via AJAX
		add_action('wp_ajax_woocommerce_feature_product', array( $this, 'feature_product' ), 1 );
		add_action('wp_ajax_nopriv_woocommerce_feature_product', array( $this, 'feature_product' ), 1 );
		
		// AJAX hide yellow message dontshow
		add_action('wp_ajax_psad_yellow_message_dontshow', array( $this, 'psad_yellow_message_dontshow' ) );
		add_action('wp_ajax_nopriv_psad_yellow_message_dontshow', array( $this, 'psad_yellow_message_dontshow' ) );
		
		// AJAX hide yellow message dismiss
		add_action('wp_ajax_psad_yellow_message_dismiss', array( $this, 'psad_yellow_message_dismiss' ) );
		add_action('wp_ajax_nopriv_psad_yellow_message_dismiss', array( $this, 'psad_yellow_message_dismiss' ) );
		
		if ( is_admin() ) {
			// AJAX update taxonomy
			add_action('wp_ajax_psad_update_product_cat_custom_meta', array( $this, 'psad_update_product_cat_custom_meta_ajax' ) );
			add_action('wp_ajax_nopriv_psad_update_product_cat_custom_meta', array( $this, 'psad_update_product_cat_custom_meta_ajax' ) );
		}
	}
	
	public function add_google_fonts() {
		global $wc_psad_fonts_face;
		$psad_es_shop_bt_font 				= get_option( 'psad_es_shop_bt_font' );
		$psad_es_shop_link_font 			= get_option( 'psad_es_shop_link_font' );
		$psad_es_category_item_bt_font 		= get_option( 'psad_es_category_item_bt_font' );
		$psad_es_category_item_link_font 	= get_option( 'psad_es_category_item_link_font' );
		$google_fonts = array( 
							$psad_es_shop_bt_font['face'], 
							$psad_es_shop_link_font['face'], 
							$psad_es_category_item_bt_font['face'],
							$psad_es_category_item_link_font['face'],
						);
						
		$google_fonts = apply_filters( 'wc_psad_google_fonts', $google_fonts );
		
		$wc_psad_fonts_face->generate_google_webfonts( $google_fonts );
	}

	/**
	 * Include script and style to show plugin framework for Category page.
	 *
	 */
	public function include_script( ) {
		if ( ! in_array( basename( $_SERVER['PHP_SELF'] ), array( 'edit-tags.php', 'term.php' ) ) ) return;
		if ( ! isset( $_REQUEST['taxonomy'] ) || ! in_array( $_REQUEST['taxonomy'], array( 'product_cat' ) ) ) return;

		if ( ! isset( $_SESSION ) ) {
			@session_start();
		}

		global $wc_psad_admin_interface;
		add_action( 'admin_footer', array( $wc_psad_admin_interface, 'admin_script_load' ) );
		add_action( 'admin_footer', array( $wc_psad_admin_interface, 'admin_css_load' ) );
		add_action( 'admin_footer', array( $this, 'include_custom_script' ) );
		add_action( 'admin_print_scripts', array( $wc_psad_admin_interface, 'admin_localize_printed_scripts' ), 5 );
        add_action( 'admin_print_footer_scripts', array( $wc_psad_admin_interface, 'admin_localize_printed_scripts' ), 5 );
	}

	public function include_custom_script() {
	?>
    	<script type="text/javascript">
		(function($) {

			$(document).ready(function() {

				$(document).on( "a3rev-ui-onoff_checkbox-switch", '.a3rev_panel_container_on_table_onoff', function( event, value, status ) {
					var tax_id = $(this).attr('data-id');
					if ( status == 'true' ) {
						var psad_shop_page = 1;
					} else {
						var psad_shop_page = 0;
					}

					var data = {
						action: 'psad_update_product_cat_custom_meta',
						tax_id: tax_id,
						psad_include_shop_page: psad_shop_page,
					};
					$.post(ajaxurl, data, function(response) {
						if( response == true || response == 'true'){
						}else{
						}
					});

				});
			});

		})(jQuery);
		</script>
    <?php
	}

	public function add_options_into_default_catalog_orderby( $default_catalog_orderby_options ) {
		$default_catalog_orderby_options['onsale'] = __('Sort by On Sale: Show first', 'woocommerce-product-sort-and-display' );
		$default_catalog_orderby_options['featured'] = __('Sort by Featured: Show first', 'woocommerce-product-sort-and-display' );

		return $default_catalog_orderby_options;
	}

	public function product_cat_columns( $columns ) {
		$have_description_column = false;
		$new_columns          = array();
		if ( is_array( $columns ) && count( $columns ) > 0 ) {
			foreach ( $columns as $column_key => $column_name ) {
				$new_columns[$column_key] = $column_name;
				if ( $column_key == 'description' ) {
					$have_description_column = true;
					$new_columns['psad_shop_page'] = __( 'Shop Page', 'woocommerce-product-sort-and-display' );
				}
			}
			if ( ! $have_description_column ) {
				$new_columns['psad_shop_page'] = __( 'Shop Page', 'a3_portfolios' );
			}
			$columns = $new_columns;
		}

		return $columns;
	}

	public function product_cat_column( $columns, $column, $id ) {
		$term = get_term_by('id', $id, 'product_cat');
		if ( $column == 'psad_shop_page' ) {
			if ( $term && $term->parent == 0 ) {
				$checked = '';
				$psad_include_shop_page = get_term_meta( $id, 'psad_include_shop_page', true );
				if ( '' == $psad_include_shop_page || 1 == $psad_include_shop_page ) {
					$checked = 'checked="checked"';
				}
				?>
				<div class="a3rev_panel_container a3rev_panel_container_on_table" style="border: medium none; margin: 0px auto; visibility: visible; height: auto; overflow: inherit; text-align: center; padding: 3px 3px; display: inline-block; vertical-align: middle;">
					<input data-id="<?php echo $id;?>" class="a3rev-ui-onoff_checkbox a3rev_panel_container_on_table_onoff" type="checkbox" <?php echo $checked; ?> name="psad_include_shop_page[<?php echo $id;?>]" id="psad_include_shop_page_<?php echo $id;?>" value="1" />
				</div>
				<?php
			}

		}

		return $columns;
	}

	public function product_cat_validate_script() {
		wp_register_script( 'psad-product-cat-admin-script', WC_PSAD_JS_URL . '/category.validate.admin.js', array('jquery'), WC_PSAD_VERSION );
		wp_enqueue_script( 'psad-product-cat-admin-script' );
	}

	// Save extra taxonomy fields callback function.
	public function psad_update_product_cat_custom_meta_ajax() {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%a3_shop_cat%' ) );

		update_term_meta( absint( $_POST['tax_id'] ), 'psad_include_shop_page', sanitize_text_field( $_POST['psad_include_shop_page'] ) );
	}

	public function feature_product() {
		if ( current_user_can( 'edit_products' ) && check_admin_referer( 'woocommerce-feature-product' ) ) {
			$product_id = absint( $_GET['product_id'] );
			$product 	= wc_get_product( $product_id );
			if ( $product ) {
				
				// If before save it's not featured product then need to make it as featured product when save
				if ( ! $product->is_featured() ) {
					update_post_meta( $product_id, '_psad_featured_order', $product->get_price() );
				} else {
					update_post_meta( $product_id, '_psad_featured_order', 10000000000000 );
				}
			}
		}
	}
	
	public function psad_yellow_message_dontshow() {
		check_ajax_referer( 'psad_yellow_message_dontshow', 'security' );
		$option_name   = sanitize_key( $_REQUEST['option_name'] );
		update_option( $option_name, 1 );
		die();
	}
	
	public function psad_yellow_message_dismiss() {
		check_ajax_referer( 'psad_yellow_message_dismiss', 'security' );
		$session_name   = $_REQUEST['session_name'];
		update_option( $session_name, 1 );
		if ( !isset($_SESSION) ) { @session_start(); } 
		$_SESSION[$session_name] = 1 ;
		die();
	}
	
	public function a3_wp_admin() {
		wp_enqueue_style( 'a3rev-wp-admin-style', WC_PSAD_CSS_URL . '/a3_wp_admin.css' );
	}
	
	public function plugin_extension_box( $boxes = array() ) {
		$support_box = '<a href="https://wordpress.org/support/plugin/woocommerce-product-sort-and-display" target="_blank" alt="'.__('Go to Support Forum', 'woocommerce-product-sort-and-display' ).'"><img src="'.WC_PSAD_IMAGES_URL.'/go-to-support-forum.png" /></a>';
		$boxes[] = array(
			'content' => $support_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		$review_box = '<div style="margin-bottom: 5px; font-size: 12px;"><strong>' . __('Is this plugin is just what you needed? If so', 'woocommerce-product-sort-and-display' ) . '</strong></div>';
        $review_box .= '<a href="https://wordpress.org/support/view/plugin-reviews/woocommerce-product-sort-and-display#postform" target="_blank" alt="'.__('Submit Review for Plugin on WordPress', 'woocommerce-product-sort-and-display' ).'"><img src="'.WC_PSAD_IMAGES_URL.'/a-5-star-rating-would-be-appreciated.png" /></a>';

        $boxes[] = array(
            'content' => $review_box,
            'css' => 'border: none; padding: 0; background: none;'
        );

		$pro_box = '<a href="'.WC_PSAD_AUTHOR_URI.'" target="_blank" alt="'.__('WooCommerce Product Sort and Display Pro', 'woocommerce-product-sort-and-display' ).'"><img src="'.WC_PSAD_IMAGES_URL.'/product-sort-and-display-pro.jpg" /></a>';
		$boxes[] = array(
			'content' => $pro_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		$free_woocommerce_box = '<a href="https://profiles.wordpress.org/a3rev/#content-plugins" target="_blank" alt="'.__('Free WooCommerce Plugins', 'woocommerce-product-sort-and-display' ).'"><img src="'.WC_PSAD_IMAGES_URL.'/free-woocommerce-plugins.jpg" /></a>';

		$boxes[] = array(
			'content' => $free_woocommerce_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		$free_wordpress_box = '<a href="https://profiles.wordpress.org/a3rev/#content-plugins" target="_blank" alt="'.__('Free WordPress Plugins', 'woocommerce-product-sort-and-display' ).'"><img src="'.WC_PSAD_IMAGES_URL.'/free-wordpress-plugins.png" /></a>';

		$boxes[] = array(
			'content' => $free_wordpress_box,
			'css' => 'border: none; padding: 0; background: none;'
		);

		return $boxes;
	}
	
	public function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WC_PSAD_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/plugins-extensions/woocommerce/product-sort-and-display/" target="_blank">'.__('Documentation', 'woocommerce-product-sort-and-display' ).'</a>';
		$links[] = '<a href="http://wordpress.org/support/plugin/woocommerce-product-sort-and-display/" target="_blank">'.__('Support', 'woocommerce-product-sort-and-display' ).'</a>';
		return $links;
	}

	public function settings_plugin_links($actions) {
		$actions = array_merge( array( 'settings' => '<a href="admin.php?page=wc-sort-display">' . __( 'Settings', 'woocommerce-product-sort-and-display' ) . '</a>' ), $actions );

		return $actions;
	}
}
