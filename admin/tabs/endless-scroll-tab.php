<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Endless Scroll Tab

TABLE OF CONTENTS

- var parent_page
- var position
- var tab_data

- __construct()
- tab_init()
- tab_data()
- add_tab()
- settings_include()
- tab_manager()

-----------------------------------------------------------------------------------*/

class WC_PSA_Endless_Scroll_Tab extends WC_PSAD_Admin_UI
{	
	/**
	 * @var string
	 */
	private $parent_page = 'wc-sort-display';
	
	/**
	 * @var string
	 * You can change the order show of this tab in list tabs
	 */
	private $position = 2;
	
	/**
	 * @var array
	 */
	private $tab_data;
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		
		$this->settings_include();
		$this->tab_init();
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* tab_init() */
	/* Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function tab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_page . '_settings_tabs_array', array( $this, 'add_tab' ), $this->position );
		
	}
	
	/**
	 * tab_data()
	 * Get Tab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_tab_name'				: (required) Enter your tab name that you want to set for this tab
	 *		'label'				=> 'My Tab Name' 				: (required) Enter the tab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this tab
	 * )
	 *
	 */
	public function tab_data() {
		
		$tab_data = array( 
			'name'				=> 'endless-scroll',
			'label'				=> __( 'Endless Scroll', 'woocommerce-product-sort-and-display' ),
			'callback_function'	=> 'wc_psad_endless_scroll_tab_manager',
		);
		
		if ( $this->tab_data ) return $this->tab_data;
		return $this->tab_data = $tab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_tab() */
	/* Add tab to Admin Init and Parent Page
	/*-----------------------------------------------------------------------------------*/
	public function add_tab( $tabs_array ) {
			
		if ( ! is_array( $tabs_array ) ) $tabs_array = array();
		$tabs_array[] = $this->tab_data();
		
		return $tabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* panels_include() */
	/* Include form settings panels 
	/*-----------------------------------------------------------------------------------*/
	public function settings_include() {
		
		// Includes Settings file
		include_once( $this->admin_plugin_dir() . '/settings/endless-scroll-settings.php' );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* panels_include */
	/* Include form settings panels 
	/*-----------------------------------------------------------------------------------*/
	public function tab_manager() {
		global $wc_psad_admin_init;
		
		$this->plugin_extension_start();
		wc_psad_endless_scroll_settings_form();
		$this->plugin_extension_end();
		
	}
}

global $wc_psad_endless_scroll_tab;
$wc_psad_endless_scroll_tab = new WC_PSA_Endless_Scroll_Tab();

/** 
 * wc_psad_global_settings_tab_manager()
 * Define the callback function to show tab content
 */
function wc_psad_endless_scroll_tab_manager() {
	global $wc_psad_endless_scroll_tab;
	$wc_psad_endless_scroll_tab->tab_manager();
}

?>