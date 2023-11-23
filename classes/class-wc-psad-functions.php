<?php
/**
 * WC_PSAD Functions
 *
 * Table Of Contents
 *
 * auto_create_order_keys_all_products()
 * update_orders_value()
 * add_custom_options_sort()
 * change_orderby_query()
 */

namespace A3Rev\WCPSAD;

class Functions 
{	
	public static function is_wc_36_or_larger() {
		if ( version_compare( WC_VERSION, '3.6.0', '>=' ) ) {
			return true;
		}

		return false;
	}

	public static function is_wc_38_or_larger() {
		if ( version_compare( WC_VERSION, '3.8.0', '>=' ) ) {
			return true;
		}

		return false;
	}

	public static function auto_create_order_keys_all_products() {
		global $wpdb;
		
		// Get all Products
		$all_products = $wpdb->get_results( " SELECT ID FROM ".$wpdb->posts." WHERE post_status='publish' AND post_type='product' " );	
		
		// Create sort keys
		if ( $all_products && count( $all_products ) > 0 ) {
			foreach ( $all_products as $a_product ) {
				$product 	= wc_get_product( $a_product->ID );

				if ( $product ) {
					if ( ! self::is_wc_36_or_larger() ) {
						if ( $product->is_on_sale() ) {
							update_post_meta( $a_product->ID, '_psad_onsale_order', $product->get_price() );
						} else {
							update_post_meta( $a_product->ID, '_psad_onsale_order', 10000000000000 );
						}
					}

					if ( $product->is_featured() ) {
						update_post_meta( $a_product->ID, '_psad_featured_order', $product->get_price() );
					} else {
						update_post_meta( $a_product->ID, '_psad_featured_order', 10000000000000 );
					}
				}
			}
		}
	}
	
	public static function update_orders_value( $post_id, $post ) {
		if ( is_int( wp_is_post_revision( $post_id ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post_id ) ) ) return;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;
		if ( $post->post_type != 'product' ) return $post_id;
		
		$product 	= wc_get_product( $post );
		if ( $product ) {
			if ( ! self::is_wc_36_or_larger() ) {
				if ( $product->is_on_sale() ) {
					update_post_meta( $post_id, '_psad_onsale_order', $product->get_price() );
				} else {
					update_post_meta( $post_id, '_psad_onsale_order', 10000000000000 );
				}
			}
			if ( $product->is_featured() ) {
				update_post_meta( $post_id, '_psad_featured_order', $product->get_price() );
			} else {
				update_post_meta( $post_id, '_psad_featured_order', 10000000000000 );
			}
		}
	}

	public static function add_custom_options_sort( $woocommerce_catalog_orderby = array() ) {
		$woocommerce_catalog_orderby['onsale'] = __('Sort by On Sale: Show first', 'woocommerce-product-sort-and-display' );
		$woocommerce_catalog_orderby['featured'] = __('Sort by Featured: Show first', 'woocommerce-product-sort-and-display' );
		
		return $woocommerce_catalog_orderby;
	}

	public static function change_orderby_query( $ordering_args ) {
		$orderby = $ordering_args['orderby'];
		$order   = $ordering_args['order'];

		switch ( $orderby ) {
			case 'onsale' :
				if ( self::is_wc_38_or_larger() ) {
					add_filter( 'posts_clauses', array( __CLASS__, 'order_by_onsale_post_clauses' ) );
				} elseif ( self::is_wc_36_or_larger() ) {
					$ordering_args = self::order_by_onsale_post_clauses( $ordering_args );
				} else {
					$ordering_args['orderby']  = array( 'meta_value_num' => 'ASC', 'menu_order' => 'ASC', 'date' => 'DESC', 'title' => 'ASC' );
					$ordering_args['order']    = 'ASC';
					$ordering_args['meta_key'] = '_psad_onsale_order';
				}
				break;
			case 'featured' :
				$ordering_args['orderby']  = array( 'meta_value_num' => 'ASC', 'menu_order' => 'ASC', 'date' => 'DESC', 'title' => 'ASC' );
				$ordering_args['order']    = 'ASC';
				$ordering_args['meta_key'] = '_psad_featured_order';
				break;
			case 'price':
				$callback = 'DESC' === $order ? 'order_by_price_desc_post_clauses' : 'order_by_price_asc_post_clauses';
				add_filter( 'posts_clauses', array( __CLASS__, $callback ) );
				break;
			case 'popularity':
				add_filter( 'posts_clauses', array( __CLASS__, 'order_by_popularity_post_clauses' ) );
				break;
			case 'rating':
				add_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
				break;
		}
		
		return $ordering_args;
	}

	public static function order_by_onsale_post_clauses( $args ) {
		if ( empty( $args['join'] ) ) {
			$args['join'] = '';
		}

		$args['join']    = self::append_product_sorting_table_join( $args['join'] );
		$args['orderby'] = ' wc_product_meta_lookup.onsale DESC, wc_product_meta_lookup.product_id DESC ';

		return $args;
	}

	public static function order_by_price_desc_post_clauses( $args ) {
		if ( empty( $args['join'] ) ) {
			$args['join'] = '';
		}

		$args['join']    = self::append_product_sorting_table_join( $args['join'] );
		$args['orderby'] = ' wc_product_meta_lookup.max_price DESC, wc_product_meta_lookup.product_id DESC ';
		return $args;
	}

	public static function order_by_price_asc_post_clauses( $args ) {
		if ( empty( $args['join'] ) ) {
			$args['join'] = '';
		}

		$args['join']    = self::append_product_sorting_table_join( $args['join'] );
		$args['orderby'] = ' wc_product_meta_lookup.min_price ASC, wc_product_meta_lookup.product_id DESC ';
		return $args;
	}

	public static function order_by_popularity_post_clauses( $args ) {
		if ( empty( $args['join'] ) ) {
			$args['join'] = '';
		}

		$args['join']    = self::append_product_sorting_table_join( $args['join'] );
		$args['orderby'] = ' wc_product_meta_lookup.total_sales DESC, wc_product_meta_lookup.product_id DESC ';
		return $args;
	}

	public static function order_by_rating_post_clauses( $args ) {
		if ( empty( $args['join'] ) ) {
			$args['join'] = '';
		}

		$args['join']    = self::append_product_sorting_table_join( $args['join'] );
		$args['orderby'] = ' wc_product_meta_lookup.average_rating DESC, wc_product_meta_lookup.product_id DESC ';
		return $args;
	}

	public static function append_product_sorting_table_join( $sql ) {
		global $wpdb;

		if ( ! strstr( $sql, 'wc_product_meta_lookup' ) ) {
			$sql .= " LEFT JOIN {$wpdb->wc_product_meta_lookup} wc_product_meta_lookup ON $wpdb->posts.ID = wc_product_meta_lookup.product_id ";
		}
		return $sql;
	}

	public static function generate_transient_name( $prefix = '' , $transient_string = '' ) {
		$transient_name = $prefix . '-' . str_replace( array( '&', '=' ), array( '-', '_' ), $transient_string );
		if ( strlen( $transient_name ) > 172 ) {
			$transient_name = '';
		}

		return $transient_name;
	}

	public static function flush_cached_cat_list() {
		global $wpdb;

		$wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%a3_shop_cat%' ) );
		$wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%a3_s_cat%' ) );
	}

	public static function flush_cached() {
		global $wpdb;

		self::flush_cached_cat_list();
		$wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%a3_shop_cat_products%' ) );
		$wpdb->query( $wpdb->prepare( 'DELETE FROM '. $wpdb->options . ' WHERE option_name LIKE %s', '%a3_s_p_cat_%' ) );
	}
	
	public static function upgrade_version_1_0_2() {	
		
		// Shop Page Scroll Styling Updating
		$psad_es_shop_bt_border = get_option( 'psad_es_shop_bt_border' );
		if ( $psad_es_shop_bt_border == false || !is_array( $psad_es_shop_bt_border ) ) { 	
			$psad_es_shop_bt_border = array(
				'width'					=> get_option( 'psad_es_shop_bt_border_width', 1 ).'px',
				'style'					=> get_option( 'psad_es_shop_bt_border_style', 'solid' ),
				'color'					=> get_option( 'psad_es_shop_bt_border_color', '#7497B9' ),
				'corner'				=> 'rounded',
				'top_left_corner'		=> get_option( 'psad_es_shop_bt_rounded', 3 ),
				'top_right_corner'		=> get_option( 'psad_es_shop_bt_rounded', 3 ),
				'bottom_left_corner'	=> get_option( 'psad_es_shop_bt_rounded', 3 ),
				'bottom_right_corner'	=> get_option( 'psad_es_shop_bt_rounded', 3 ),
				
			);
			update_option( 'psad_es_shop_bt_border', $psad_es_shop_bt_border );
		}
		
		$psad_es_shop_bt_font = get_option( 'psad_es_shop_bt_font' );
		if ( $psad_es_shop_bt_font == false || !is_array( $psad_es_shop_bt_font ) ) { 
			$psad_es_shop_bt_font = array(
				'size'					=> get_option( 'psad_es_shop_bt_font_size', 12 ).'px',
				'face'					=> get_option( 'psad_es_shop_bt_font_family', 'Arial, sans-serif' ),
				'style'					=> get_option( 'psad_es_shop_bt_font_style', 'bold' ),
				'color'					=> get_option( 'psad_es_shop_bt_font_color', '#FFFFFF' ),
			);
			update_option( 'psad_es_shop_bt_font', $psad_es_shop_bt_font );
		}
		
		$psad_es_shop_link_font = get_option( 'psad_es_shop_link_font' );
		if ( $psad_es_shop_link_font == false || !is_array( $psad_es_shop_link_font ) ) { 
			$psad_es_shop_link_font = array(
				'size'					=> get_option( 'psad_es_shop_link_font_size', 12 ).'px',
				'face'					=> get_option( 'psad_es_shop_link_font_family', 'Arial, sans-serif' ),
				'style'					=> get_option( 'psad_es_shop_link_font_style', 'bold' ),
				'color'					=> get_option( 'psad_es_shop_link_font_color', '#7497B9' ),
			);
			update_option( 'psad_es_shop_link_font', $psad_es_shop_link_font );
		}
		
		// Category Page Scroll Styling Updating
		$psad_es_category_bt_border = get_option( 'psad_es_category_bt_border' );
		if ( $psad_es_category_bt_border == false || !is_array( $psad_es_category_bt_border ) ) { 	
			$psad_es_category_bt_border = array(
				'width'					=> get_option( 'psad_es_category_bt_border_width', 1 ).'px',
				'style'					=> get_option( 'psad_es_category_bt_border_style', 'solid' ),
				'color'					=> get_option( 'psad_es_category_bt_border_color', '#7497B9' ),
				'corner'				=> 'rounded',
				'top_left_corner'		=> get_option( 'psad_es_category_bt_rounded', 3 ),
				'top_right_corner'		=> get_option( 'psad_es_category_bt_rounded', 3 ),
				'bottom_left_corner'	=> get_option( 'psad_es_category_bt_rounded', 3 ),
				'bottom_right_corner'	=> get_option( 'psad_es_category_bt_rounded', 3 ),
				
			);
			update_option( 'psad_es_category_bt_border', $psad_es_category_bt_border );
		}
		
		$psad_es_category_bt_font = get_option( 'psad_es_category_bt_font' );
		if ( $psad_es_category_bt_font == false || !is_array( $psad_es_category_bt_font ) ) { 
			$psad_es_category_bt_font = array(
				'size'					=> get_option( 'psad_es_category_bt_font_size', 12 ).'px',
				'face'					=> get_option( 'psad_es_category_bt_font_family', 'Arial, sans-serif' ),
				'style'					=> get_option( 'psad_es_category_bt_font_style', 'bold' ),
				'color'					=> get_option( 'psad_es_category_bt_font_color', '#FFFFFF' ),
			);
			update_option( 'psad_es_category_bt_font', $psad_es_category_bt_font );
		}
		
		$psad_es_category_link_font = get_option( 'psad_es_category_link_font' );
		if ( $psad_es_category_link_font == false || !is_array( $psad_es_category_link_font ) ) { 
			$psad_es_category_link_font = array(
				'size'					=> get_option( 'psad_es_category_link_font_size', 12 ).'px',
				'face'					=> get_option( 'psad_es_category_link_font_family', 'Arial, sans-serif' ),
				'style'					=> get_option( 'psad_es_category_link_font_style', 'bold' ),
				'color'					=> get_option( 'psad_es_category_link_font_color', '#7497B9' ),
			);
			update_option( 'psad_es_category_link_font', $psad_es_category_link_font );
		}
		
		// Parent Cat & Tag Page Scroll Styling Updating
		$psad_es_products_bt_border = get_option( 'psad_es_products_bt_border' );
		if ( $psad_es_products_bt_border == false || !is_array( $psad_es_products_bt_border ) ) { 	
			$psad_es_products_bt_border = array(
				'width'					=> get_option( 'psad_es_products_bt_border_width', 1 ).'px',
				'style'					=> get_option( 'psad_es_products_bt_border_style', 'solid' ),
				'color'					=> get_option( 'psad_es_products_bt_border_color', '#7497B9' ),
				'corner'				=> 'rounded',
				'top_left_corner'		=> get_option( 'psad_es_products_bt_rounded', 3 ),
				'top_right_corner'		=> get_option( 'psad_es_products_bt_rounded', 3 ),
				'bottom_left_corner'	=> get_option( 'psad_es_products_bt_rounded', 3 ),
				'bottom_right_corner'	=> get_option( 'psad_es_products_bt_rounded', 3 ),
				
			);
			update_option( 'psad_es_products_bt_border', $psad_es_products_bt_border );
		}
		
		$psad_es_products_bt_font = get_option( 'psad_es_products_bt_font' );
		if ( $psad_es_products_bt_font == false || !is_array( $psad_es_products_bt_font ) ) { 
			$psad_es_products_bt_font = array(
				'size'					=> get_option( 'psad_es_products_bt_font_size', 12 ).'px',
				'face'					=> get_option( 'psad_es_products_bt_font_family', 'Arial, sans-serif' ),
				'style'					=> get_option( 'psad_es_products_bt_font_style', 'bold' ),
				'color'					=> get_option( 'psad_es_products_bt_font_color', '#FFFFFF' ),
			);
			update_option( 'psad_es_products_bt_font', $psad_es_products_bt_font );
		}
		
		$psad_es_products_link_font = get_option( 'psad_es_products_link_font' );
		if ( $psad_es_products_link_font == false || !is_array( $psad_es_products_link_font ) ) { 
			$psad_es_products_link_font = array(
				'size'					=> get_option( 'psad_es_products_link_font_size', 12 ).'px',
				'face'					=> get_option( 'psad_es_products_link_font_family', 'Arial, sans-serif' ),
				'style'					=> get_option( 'psad_es_products_link_font_style', 'bold' ),
				'color'					=> get_option( 'psad_es_products_link_font_color', '#7497B9' ),
			);
			update_option( 'psad_es_products_link_font', $psad_es_products_link_font );
		}
		
		// View All Products Styling Updating
		$psad_es_category_item_bt_border = get_option( 'psad_es_category_item_bt_border' );
		if ( $psad_es_category_item_bt_border == false || !is_array( $psad_es_category_item_bt_border ) ) { 	
			$psad_es_category_item_bt_border = array(
				'width'					=> get_option( 'psad_es_category_item_bt_border_width', 1 ).'px',
				'style'					=> get_option( 'psad_es_category_item_bt_border_style', 'solid' ),
				'color'					=> get_option( 'psad_es_category_item_bt_border_color', '#7497B9' ),
				'corner'				=> 'rounded',
				'top_left_corner'		=> get_option( 'psad_es_category_item_bt_rounded', 3 ),
				'top_right_corner'		=> get_option( 'psad_es_category_item_bt_rounded', 3 ),
				'bottom_left_corner'	=> get_option( 'psad_es_category_item_bt_rounded', 3 ),
				'bottom_right_corner'	=> get_option( 'psad_es_category_item_bt_rounded', 3 ),
				
			);
			update_option( 'psad_es_category_item_bt_border', $psad_es_category_item_bt_border );
		}
		
		$psad_es_category_item_bt_font = get_option( 'psad_es_category_item_bt_font' );
		if ( $psad_es_category_item_bt_font == false || !is_array( $psad_es_category_item_bt_font ) ) { 
			$psad_es_category_item_bt_font = array(
				'size'					=> get_option( 'psad_es_category_item_bt_font_size', 12 ).'px',
				'face'					=> get_option( 'psad_es_category_item_bt_font_family', 'Arial, sans-serif' ),
				'style'					=> get_option( 'psad_es_category_item_bt_font_style', 'bold' ),
				'color'					=> get_option( 'psad_es_category_item_bt_font_color', '#FFFFFF' ),
			);
			update_option( 'psad_es_category_item_bt_font', $psad_es_category_item_bt_font );
		}
		
		$psad_es_category_item_link_font = get_option( 'psad_es_category_item_link_font' );
		if ( $psad_es_category_item_link_font == false || !is_array( $psad_es_category_item_link_font ) ) { 
			$psad_es_category_item_link_font = array(
				'size'					=> get_option( 'psad_es_category_item_link_font_size', 12 ).'px',
				'face'					=> get_option( 'psad_es_category_item_link_font_family', 'Arial, sans-serif' ),
				'style'					=> get_option( 'psad_es_category_item_link_font_style', 'bold' ),
				'color'					=> get_option( 'psad_es_category_item_link_font_color', '#7497B9' ),
			);
			update_option( 'psad_es_category_item_link_font', $psad_es_category_item_link_font );
		}
		
		// Visual Content Separator Styling Updating
		$psad_seperator_border = get_option( 'psad_seperator_border' );
		if ( $psad_seperator_border == false || !is_array( $psad_seperator_border ) ) { 	
			$psad_seperator_border = array(
				'width'					=> get_option( 'psad_seperator_border_width', 1 ).'px',
				'style'					=> get_option( 'psad_seperator_border_style', 'solid' ),
				'color'					=> get_option( 'psad_seperator_border_color', '#000000' ),
			);
			update_option( 'psad_seperator_border', $psad_seperator_border );
		}
		update_option( 'psad_seperator_padding_top', get_option('psad_seperator_padding_tb') );
		update_option( 'psad_seperator_padding_bottom', get_option('psad_seperator_padding_tb') );
		
		// Count Meta Styling Updating
		$psad_count_meta_font = get_option( 'psad_count_meta_font' );
		if ( $psad_count_meta_font == false || !is_array( $psad_count_meta_font ) ) { 
			$psad_count_meta_font = array(
				'size'					=> get_option( 'psad_count_meta_font_size', 11 ).'px',
				'face'					=> get_option( 'psad_count_meta_font_family', 'Arial, sans-serif' ),
				'style'					=> get_option( 'psad_count_meta_font_style', 'italic' ),
				'color'					=> get_option( 'psad_count_meta_font_color', '#000000' ),
			);
			update_option( 'psad_count_meta_font', $psad_count_meta_font );
		}
		
	}
}
