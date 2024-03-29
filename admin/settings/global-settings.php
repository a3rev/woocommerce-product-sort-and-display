<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

namespace A3Rev\WCPSAD\FrameWork\Settings {

use A3Rev\WCPSAD\FrameWork;

// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------
WC PSAD Global Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class Global_Panel extends FrameWork\Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'global-settings';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = '';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_sort_display_global_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init_form_fields' ), 1 );
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Global Settings successfully saved.', 'woocommerce-product-sort-and-display' ),
				'error_message'		=> __( 'Error: Global Settings can not save.', 'woocommerce-product-sort-and-display' ),
				'reset_message'		=> __( 'Global Settings successfully reseted.', 'woocommerce-product-sort-and-display' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'after_save_settings' ) );

		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );

		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init()
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {		
		$GLOBALS[$this->plugin_prefix.'admin_interface']->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $wc_psad_admin_interface;
		
		$wc_psad_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
	}

	/*-----------------------------------------------------------------------------------*/
	/* after_save_settings()
	/* Process when clean on deletion option is un selected */
	/*-----------------------------------------------------------------------------------*/
	public function after_save_settings() {
		if ( ( isset( $_POST['bt_save_settings'] ) || isset( $_POST['bt_reset_settings'] ) ) && get_option( $this->plugin_name . '_clean_on_deletion' ) == 0  )  {
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[ $this->plugin_path ]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		}
		if ( isset( $_POST['bt_save_settings'] ) && isset( $_POST['psad_flush_cached'] )  )  {
			delete_option( 'psad_flush_cached' );
			\A3Rev\WCPSAD\Functions::flush_cached();
		}
		if ( isset( $_POST['bt_save_settings'] ) && isset( $_POST['psad_global_category_reset'] ) ) {
			delete_option( 'psad_global_category_reset' );
			$metadata = array('psad_shop_product_per_page', 'psad_shop_product_show_type' );
			foreach ( $metadata as $meta_key ) {
				delete_metadata( 'term', '', $meta_key, '', true );
			}
		}
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {		
		$GLOBALS[$this->plugin_prefix.'admin_interface']->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'global-settings',
			'label'				=> __( 'Settings', 'woocommerce-product-sort-and-display' ),
			'callback_function'	=> 'wc_psad_global_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {		
		$output = '';
		$output .= $GLOBALS[$this->plugin_prefix.'admin_interface']->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		$sort_options = array(
			'menu_order' => __( 'Default sorting (custom ordering + name)', 'woocommerce' ),
			'popularity' => __( 'Popularity (sales)', 'woocommerce' ),
			'rating'     => __( 'Average Rating', 'woocommerce' ),
			'date'       => __( 'Sort by most recent', 'woocommerce' ),
			'price'      => __( 'Sort by price (asc)', 'woocommerce' ),
			'price-desc' => __( 'Sort by price (desc)', 'woocommerce' ),
			'onsale'     => __( 'Sort by On Sale: Show first', 'woocommerce-product-sort-and-display' ),
			'featured'   => __( 'Sort by Featured: Show first', 'woocommerce-product-sort-and-display' ),
		);

		$wc_version = get_option( 'woocommerce_version', '1.0' );

		$wc_display_settings_url = admin_url( 'customize.php?autofocus[panel]=woocommerce&autofocus[section]=woocommerce_product_catalog' );
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			
			array(
            	'name' 		=> __( 'Plugin Framework Global Settings', 'woocommerce-product-sort-and-display' ),
            	'id'		=> 'psad_plugin_framework_box',
                'type' 		=> 'heading',
                'first_open'=> true,
                'is_box'	=> true,
           	),
           	array(
           		'name'		=> __( 'Customize Admin Setting Box Display', 'woocommerce-product-sort-and-display' ),
           		'desc'		=> __( 'By default each admin panel will open with all Setting Boxes in the CLOSED position.', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
           	),
           	array(
				'type' 		=> 'onoff_toggle_box',
			),
           	array(
           		'name'		=> __( 'Google Fonts', 'woocommerce-product-sort-and-display' ),
           		'desc'		=> __( 'By Default Google Fonts are pulled from a static JSON file in this plugin. This file is updated but does not have the latest font releases from Google.', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
           	),
           	array(
                'type' 		=> 'google_api_key',
           	),
           	array(
            	'name' 		=> __( 'House Keeping', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
            ),
			array(
				'name' 		=> __( 'Clean up on Deletion', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __( 'On deletion (not deactivate) the plugin will completely remove all tables and data it created, leaving no trace it was ever here.', 'woocommerce-product-sort-and-display' ),
				'id' 		=> $this->plugin_name . '_clean_on_deletion',
				'type' 		=> 'onoff_checkbox',
				'default'	=> '0',
				'separate_option'	=> true,
				'free_version'		=> true,
				'checked_value'		=> '1',
				'unchecked_value'	=> '0',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),

			array(
            	'name' 		=> __( 'DB Query Cache', 'woocommerce-product-sort-and-display' ),
            	'desc'		=> __( 'Caching applies to product categories and products loading on shop page, (product category and product tags pages in Pro Version). Significantly reduces server resources used in fetching product categories and products. Highly Recommended for sites with more than 20 Product categories' , 'woocommerce-product-sort-and-display' ),
            	'id'		=> 'psad_queries_cached_box',
                'type' 		=> 'heading',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( 'Cache Queries', 'woocommerce-product-sort-and-display' ),
				'desc'		=> __( 'Cache is auto cleared every 24 hours', 'woocommerce-product-sort-and-display' ),
				'class'		=> 'psad_queries_cached_enable',
				'id' 		=> 'psad_queries_cached_enable',
				'default'	=> 'no',
				'type' 		=> 'onoff_checkbox',
				'separate_option'	=> true,
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),

			array(
                'type' 		=> 'heading',
				'class'		=> 'psad_queries_cached_enable_container',
           	),
           	array(
				'name' 		=> __( 'Manual Flush', 'woocommerce-product-sort-and-display' ),
				'desc'		=> __( 'Switch ON and save changes to manually clear Sort and Display Query caching', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_flush_cached',
				'default'	=> '0',
				'type' 		=> 'onoff_checkbox',
				'free_version'		=> true,
				'checked_value'		=> '1',
				'unchecked_value'	=> '0',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),

			array(
            	'name' 		=> __( 'Shop Page Show Products by Category', 'woocommerce-product-sort-and-display' ),
            	'id'		=> 'psad_shop_page_box',
                'type' 		=> 'heading',
                'desc' 		=> sprintf( __("These settings when activated show products sorted into categories on your shop page. You can tweak the display further on the WooCommerce <a target='_blank' href='%s'>Shop page display</a> settings on the customizer.", 'woocommerce-product-sort-and-display' ), $wc_display_settings_url ),
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Shop Page', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> sprintf( __("Sort and display products by category on Shop pages. Sort category display order by drop and drag at <a target='_blank' href='%s'>Product Categories</a>.", 'woocommerce-product-sort-and-display' ), admin_url( 'edit-tags.php?taxonomy=product_cat&post_type=product', 'relative' ) ),
				'class'		=> 'psad_shop_page_enable',
				'id' 		=> 'psad_shop_page_enable',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),
			
			array(
                'type' 		=> 'heading',
                'id'		=> 'psad_shop_page_enable_container',
				'class'		=> 'psad_shop_page_enable_container',
           	),
			array(  
				'name' 		=> __( 'Empty Parent Categories', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("ON and when Parent Cat has no products assigned to it, products from Child Cats of that Parent will be displayed. If none found the Category is not displayed.", 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_shop_drill_down',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),
			array(  
				'name' 		=> __( 'Categories Per Page', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Set the number of Category product groups to show per pagination or endless scroll event.', 'woocommerce-product-sort-and-display' ). ' '. __('Default is [default_value].', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_shop_category_per_page',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '3',
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Products per Category', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Set the number of products to show per Category on Shop pages. Can over ride on a category by category basis from each category edit page.', 'woocommerce-product-sort-and-display' ). ' '. __('Default is [default_value].', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_shop_product_per_page',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '4',
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Product Count', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("ON to show product count under category title.", 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_shop_enable_product_showing_count',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),

			array(
            	'name' 		=> __( 'Visual Content Separator', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
                'id'		=> 'psad_seperator_box',
           		'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Visual Separator', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("On to show a separator between each category group of products on Shop Page.", 'woocommerce-product-sort-and-display' ),
				'class'		=> 'psad_seperator_enable',
				'id' 		=> 'psad_seperator_enable',
				'default'	=> 'no',
				'type' 		=> 'onoff_checkbox',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),
			
			array(
                'type' 		=> 'heading',
                'id'		=> 'psad_seperator_enable_container',
				'class'		=> 'psad_seperator_enable_container',
           	),
			array(  
				'name' 		=> __( 'Separator Border', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_seperator_border',
				'type' 		=> 'border_styles',
				'free_version'		=> true,
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#000000' ),
			),
			array(  
				'name' 		=> __( 'Separator Padding', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_seperator_padding',
				'type' 		=> 'array_textfields',
				'free_version'		=> true,
				'ids'		=> array( 
	 								array(  'id' 		=> 'psad_seperator_padding_top',
	 										'name' 		=> __( 'Top', 'woocommerce-product-sort-and-display' ),
	 										'css'		=> 'width:40px;',
											'free_version'		=> true,
	 										'default'	=> 5 ),
	 
	 								array(  'id' 		=> 'psad_seperator_padding_bottom',
	 										'name' 		=> __( 'Bottom', 'woocommerce-product-sort-and-display' ),
	 										'css'		=> 'width:40px;',
											'free_version'		=> true,
	 										'default'	=> 5 ),
	 							)
			),

			array(
            	'name' 		=> __( 'Global Category Reset', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
                'id'		=> 'psad_global_category_reset_box',
           		'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Product Category Reset', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __( "On to reset all custom settings made in the 'Sort & Display' settings on individual Product Categories to the global setting on this page.", 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_global_category_reset',
				'default'	=> 'no',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
				'free_version'		=> true,
			),
			
			array(
            	'name' 		=> __( 'Parent / Child Category Page Settings', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_fields',
                'id'		=> 'psad_category_page_box',
                'desc' 		=> sprintf( __("<strong>Note:</strong> Set the WooCommerce <a target='_blank' href='%s'>Category Display</a> to 'Show Subcategories & Products' to show Selected Products from the Parent Category, then the Child Categories. Set 'Show Subcategories' and the Parent Products won't be shown. The settings below apply to all Categories. You can also set a unique display for each Category by editing <a target='_blank' href='%s'>that Category</a>.", 'woocommerce-product-sort-and-display' ), $wc_display_settings_url, admin_url( 'edit-tags.php?taxonomy=product_cat&post_type=product' ) ),
           		'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Product Categories', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("Sort and display products by their Child categories on the Parent Product category pages. Feature can be turned ON and OFF from each Category page.", 'woocommerce-product-sort-and-display' ),
				'class'		=> 'psad_category_page_enable',
				'id' 		=> 'psad_category_page_enable',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),
			
			array(
                'type' 		=> 'heading',
                'id'		=> 'psad_category_page_enable_container',
				'class'		=> 'psad_category_page_enable_container',
           	),
			array(  
				'name' 		=> __( 'Empty Parent Categories', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("ON and when a Parent Cat has no products assigned to it (products are assigned to the child categories) selected products from the Child Cats of that Parent will be displayed", 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_category_drill_down',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),
			array(  
				'name' 		=> __( 'Parent / Child Title', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("ON to show Child Category title as Parent / Child title breadcrumb. OFF to only show Child Cat name.", 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_show_parent_title',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),
			array(  
				'name' 		=> __( 'Parent Cat Products (No Child Cats)', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("The number of products to show per Endless Scroll or pagination.", 'woocommerce-product-sort-and-display' ). ' '. __('Default is [default_value].', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_category_product_nosub_per_page',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '12'
			),
			array(  
				'name' 		=> __( 'Parent Category Products', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("Sets the number of Parent Category Products to show before Child Cat Product Groups.", 'woocommerce-product-sort-and-display' ). ' '. __('Default is [default_value].', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_top_product_per_page',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '4'
			),
			array(  
				'name' => __( 'Child Cats Per Page', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Set the number of Child Categories to show per pagination or endless scroll event.', 'woocommerce-product-sort-and-display' ). ' '. __('Default is [default_value].', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_category_per_page',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '3'
			),
			array(  
				'name' 		=> __( 'Product Count', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("ON to show product count under category title.", 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_cat_enable_product_showing_count',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),
			
			array(
            	'name' 		=> __( 'Child Categories Product Display', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_fields',
                'id'		=> 'psad_one_level_box',
                'desc' 		=> __("Settings apply to Child Categories display on its Parent Category Page when the Parent Cat has sort and display activated. You can set custom Product display number and Sort Type for each Child Category by editing the category.", 'woocommerce-product-sort-and-display' ),
           		'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Number of Product Displayed', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Number of Child Category products displayed on its Parent Category page <strong>WHEN</strong> Parent has Sort and Display Feature activated.', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_product_per_page',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '4'
			),

			array(  
				'name' 		=> __( "Product Sort", 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Applies to all Child Categories display on Parent Cat Page <strong>WHEN</strong> Parent has Sort and Display Feature activated.', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_product_show_type',
				'type' 		=> 'select',
				'default'	=> 'menu_order',
				'css'		=> 'width: auto;',
				'options'	=> $sort_options,
			),
			
			array(
            	'name' 		=> __( 'Tag Page Settings', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_fields',
                'id'		=> 'psad_tag_page_box',
           		'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Tag Page', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("Sort and Display Product tag pages.", 'woocommerce-product-sort-and-display' ),
				'class'		=> 'psad_tag_page_enable',
				'id' 		=> 'psad_tag_page_enable',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
			),
			
			array(
                'type' 		=> 'heading',
                'id'		=> 'psad_tag_page_enable_container',
				'class'		=> 'psad_tag_page_enable_container',
           	),
			array(  
				'name' 		=> __( 'Tag Products', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __("The number of products to show per Endless Scroll or pagination.", 'woocommerce-product-sort-and-display' ). ' '. __('Default is [default_value].', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_tag_product_per_page',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '12'
			),
			array(  
				'name' 		=> __( "Product Sort", 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_tag_product_show_type',
				'type' 		=> 'select',
				'default'	=> 'menu_order',
				'css'		=> 'width: auto;',
				'options'	=> $sort_options,
			),
		
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
	
	$(document).ready(function() {
		if ( $("input.psad_explanation:checked").val() == 'yes') {
			$(".psad_explanation_message").show();
		} else {
			$(".psad_explanation_message").hide();
		}
		if ( $("input.psad_queries_cached_enable:checked").val() != 'yes') {
			$(".psad_queries_cached_enable_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}
		if ( $("input.psad_shop_page_enable:checked").val() != 'yes') {
			$(".psad_shop_page_enable_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}
		if ( $("input.psad_category_page_enable:checked").val() != 'yes') {
			$(".psad_category_page_enable_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}
		if ( $("input.psad_tag_page_enable:checked").val() != 'yes') {
			$(".psad_tag_page_enable_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}
		if ( $("input.psad_seperator_enable:checked").val() != 'yes') {
			$(".psad_seperator_enable_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}

		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.psad_explanation', function( event, value, status ) {
			if ( status == 'true' ) {
				$(".psad_explanation_message").slideDown();
			} else {
				$(".psad_explanation_message").slideUp();
			}
		});
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.psad_queries_cached_enable', function( event, value, status ) {
			$(".psad_queries_cached_enable_container").attr('style','display:none;');
			if ( status == 'true' ) {
				$(".psad_queries_cached_enable_container").slideDown();
			} else {
				$(".psad_queries_cached_enable_container").slideUp();
			}
		});
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.psad_shop_page_enable', function( event, value, status ) {
			$(".psad_shop_page_enable_container").attr('style','display:none;');
			if ( status == 'true' ) {
				$(".psad_shop_page_enable_container").slideDown();
			} else {
				$(".psad_shop_page_enable_container").slideUp();
			}
		});
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.psad_category_page_enable', function( event, value, status ) {
			$(".psad_category_page_enable_container").attr('style','display:none;');
			if ( status == 'true' ) {
				$(".psad_category_page_enable_container").slideDown();
			} else {
				$(".psad_category_page_enable_container").slideUp();
			}
		});
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.psad_tag_page_enable', function( event, value, status ) {
			$(".psad_tag_page_enable_container").attr('style','display:none;');
			if ( status == 'true' ) {
				$(".psad_tag_page_enable_container").slideDown();
			} else {
				$(".psad_tag_page_enable_container").slideUp();
			}
		});
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.psad_seperator_enable', function( event, value, status ) {
			$(".psad_seperator_enable_container").attr('style','display:none;');
			if ( status == 'true' ) {
				$(".psad_seperator_enable_container").slideDown();
			} else {
				$(".psad_seperator_enable_container").slideUp();
			}
		});
		
	});
	
})(jQuery);
</script>
    <?php	
	}
}

}

// global code
namespace {

/** 
 * wc_psad_global_settings_form()
 * Define the callback function to show subtab content
 */
function wc_psad_global_settings_form() {
	global $wc_psad_global_settings;
	$wc_psad_global_settings->settings_form();
}

}
