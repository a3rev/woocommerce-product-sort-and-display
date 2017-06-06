<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC PSAD Shop Page Scroll Settings

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

class WC_PSAD_Endless_Scroll_Settings extends WC_PSAD_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'endless-scroll';
	
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
	public $form_key = 'woo_psad_endless_scroll_settings';
	
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
				'success_message'	=> __( 'Endless Scroll Settings successfully saved.', 'woocommerce-product-sort-and-display' ),
				'error_message'		=> __( 'Error: Endless Scroll Settings can not save.', 'woocommerce-product-sort-and-display' ),
				'reset_message'		=> __( 'Endless Scroll Settings successfully reseted.', 'woocommerce-product-sort-and-display' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );

	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
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
		global $wc_psad_admin_interface;
		
		$wc_psad_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}

	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_psad_admin_interface;
		
		$wc_psad_admin_interface->get_settings( $this->form_fields, $this->option_name );
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
			'name'				=> 'endless-scoll',
			'label'				=> __( 'Endless Scroll', 'woocommerce-product-sort-and-display' ),
			'callback_function'	=> 'wc_psad_endless_scroll_settings_form',
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
		global $wc_psad_admin_interface;
		
		$output = '';
		$output .= $wc_psad_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
		
			// Shop Page Scroll
			array(
            	'name' 		=> __( 'Shop Page Scroll', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
                'id'		=> 'psad_shop_page_scroll_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Endless Scroll', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __( "On to activate the Endless Scroll feature for Category groups on Shop page.", 'woocommerce-product-sort-and-display' ),
				'class'		=> 'psad_endless_scroll_category_shop',
				'id' 		=> 'psad_endless_scroll_category_shop',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'OFF', 'woocommerce-product-sort-and-display' ),
				'free_version'		=> true,
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'psad_endless_scroll_category_shop_container',
           	),
			array(  
				'name' 		=> __( 'Scroll Type', 'woocommerce-product-sort-and-display' ),
				'class'		=> 'chzn-select psad_endless_scroll_category_shop_tyle',
				'id' 		=> 'psad_endless_scroll_category_shop_tyle',
				'css' 		=> 'width:120px;',
				'type' 		=> 'select',
				'default'	=> 'click',
				'options'	=> array(
						'click'		=> __( 'Click More...', 'woocommerce-product-sort-and-display' ) ,	
						'auto'		=> __( 'Auto Scroll', 'woocommerce-product-sort-and-display' ) ,	
					),
				'free_version'		=> true,
			),

			array(
            	'name' 		=> __( 'Shop Page Categories Endless Scroll on Click style', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
                'class'		=> 'psad_endless_scroll_category_shop_tyle_container',
                'id'		=> 'psad_shop_page_scroll_click_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Button or Hyperlink Text', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_bt_type',
				'class'		=> 'psad_es_shop_bt_type',
				'default'	=> 'link',
				'type' 		=> 'switcher_checkbox',
				'checked_value'		=> 'link',
				'unchecked_value'	=> 'button',
				'checked_label'		=> __( 'Linked', 'woocommerce-product-sort-and-display' ),
				'unchecked_label' 	=> __( 'Button', 'woocommerce-product-sort-and-display' ),
				'free_version'		=> true,
			),
			
			array(
            	'name' 		=> __( 'Button Styling', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
				'class'		=> 'psad_es_shop_click_more_bt_container',
           	),
			array(  
				'name' 		=> __( 'Button Text', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Text for Endless Scroll on shop page', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_bt_text',
				'type' 		=> 'text',
				'default'	=> __( 'Click More Categories', 'woocommerce-product-sort-and-display' ),
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Button Align', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_bt_align',
				'css' 		=> 'width:120px;',
				'type' 		=> 'select',
				'default'	=> 'center',
				'options'	=> array(
						'center'		=> __( 'Center', 'woocommerce-product-sort-and-display' ) ,	
						'left'			=> __( 'Left', 'woocommerce-product-sort-and-display' ) ,	
						'right'			=> __( 'Right', 'woocommerce-product-sort-and-display' ) ,	
					),
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Button Padding', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __( 'Padding from Button text to Button border', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_bt_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'psad_es_shop_bt_padding_tb',
	 										'name' 		=> __( 'Top/Bottom', 'woocommerce-product-sort-and-display' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5,
	 										'free_version'		=> true ),
	 
	 								array(  'id' 		=> 'psad_es_shop_bt_padding_lr',
	 										'name' 		=> __( 'Left/Right', 'woocommerce-product-sort-and-display' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5,
	 										'free_version'		=> true ),
	 							),
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Background Colour', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Default [default_value]', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_bt_bg',
				'type' 		=> 'color',
				'default'	=> '#7497B9',
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient From', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Default [default_value]', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_bt_bg_from',
				'type' 		=> 'color',
				'default'	=> '#7497B9',
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient To', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Default [default_value]', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_bt_bg_to',
				'type' 		=> 'color',
				'default'	=> '#4b6E90',
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Button Border', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_bt_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#7497B9', 'corner' => 'rounded' , 'top_left_corner' => 3 , 'top_right_corner' => 3 , 'bottom_left_corner' => 3 , 'bottom_right_corner' => 3 ),
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Button Font', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_bt_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'line_height' => '1.4em', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#FFFFFF' ),
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Button Shadow', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_bt_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 0, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#999999', 'inset' => '' ),
				'free_version'		=> true,
			),

			array(
            	'name' 		=> __( 'Linked Text Styling', 'woocommerce-product-sort-and-display' ),
                'type' 		=> 'heading',
				'class'		=> 'psad_es_shop_click_more_linked_container',
           	),
			array(  
				'name' 		=> __( 'Linked Text', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Text for Endless Scroll on shop page', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_link_text',
				'type' 		=> 'text',
				'default'	=> __( 'Click More Categories', 'woocommerce-product-sort-and-display' ),
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Linked Text Align', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_link_align',
				'css' 		=> 'width:120px;',
				'type' 		=> 'select',
				'default'	=> 'center',
				'options'	=> array(
						'center'		=> __( 'Center', 'woocommerce-product-sort-and-display' ) ,	
						'left'			=> __( 'Left', 'woocommerce-product-sort-and-display' ) ,	
						'right'			=> __( 'Right', 'woocommerce-product-sort-and-display' ) ,	
					),
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Hyperlink Font', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_link_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'line_height' => '1.4em', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#7497B9' ),
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'Hyperlink Hover Colour', 'woocommerce-product-sort-and-display' ),
				'desc' 		=> __('Default [default_value]', 'woocommerce-product-sort-and-display' ),
				'id' 		=> 'psad_es_shop_link_font_hover_color',
				'type' 		=> 'color',
				'default'	=> '#4b6E90',
				'free_version'		=> true,
			),

        ));
	}

	public function include_script() {
	?>
<script>
(function($) {
	
	$(document).ready(function() {

		// Shop Page Scroll
		if ( $("input.psad_es_shop_bt_type:checked").val() == 'link') {
			$(".psad_es_shop_click_more_bt_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		} else {
			$(".psad_es_shop_click_more_linked_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}

		if ( $("select.psad_endless_scroll_category_shop_tyle").val() != 'click') {
			$(".psad_endless_scroll_category_shop_tyle_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}

		if ( $("input.psad_endless_scroll_category_shop:checked").val() != 'yes') {
			$(".psad_endless_scroll_category_shop_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
			$(".psad_endless_scroll_category_shop_tyle_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}

		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.psad_endless_scroll_category_shop', function( event, value, status ) {
			$(".psad_endless_scroll_category_shop_container").attr('style','display:none;');
			$(".psad_endless_scroll_category_shop_tyle_container").attr('style','display:none;');
			if ( status == 'true' ) {
				$(".psad_endless_scroll_category_shop_container").slideDown();
				if ( $("select.psad_endless_scroll_category_shop_tyle").val() == 'click') {
					$(".psad_endless_scroll_category_shop_tyle_container").slideDown();
				}
			} else {
				$(".psad_endless_scroll_category_shop_container").slideUp();
				$(".psad_endless_scroll_category_shop_tyle_container").slideUp();
			}
		});

		$("select.psad_endless_scroll_category_shop_tyle").on( 'change', function() {
			$(".psad_endless_scroll_category_shop_tyle_container").attr('style','display:none;');
			if ( $(this).val() == 'click' ) {
				$(".psad_endless_scroll_category_shop_tyle_container").slideDown();
			} else {
				$(".psad_endless_scroll_category_shop_tyle_container").slideUp();
			}
		});

		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.psad_es_shop_bt_type', function( event, value, status ) {
			$(".psad_es_shop_click_more_linked_container").attr('style','display:none;');
			$(".psad_es_shop_click_more_bt_container").attr('style','display:none;');
			if ( status == 'true' ) {
				$(".psad_es_shop_click_more_linked_container").slideDown();
				$(".psad_es_shop_click_more_bt_container").slideUp();
			} else {
				$(".psad_es_shop_click_more_linked_container").slideUp();
				$(".psad_es_shop_click_more_bt_container").slideDown();
			}
		});
	});

})(jQuery);
</script>
    <?php
	}
}

global $wc_psad_endless_scroll_settings;
$wc_psad_endless_scroll_settings = new WC_PSAD_Endless_Scroll_Settings();

/** 
 * wc_psad_endless_scroll_settings_form()
 * Define the callback function to show subtab content
 */
function wc_psad_endless_scroll_settings_form() {
	global $wc_psad_endless_scroll_settings;
	$wc_psad_endless_scroll_settings->settings_form();
}

?>