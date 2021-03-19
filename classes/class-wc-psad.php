<?php
/**
 * WC_PSAD Class
 *
 * Table Of Contents
 *
 * WC_PSAD()
 * init()
 * limit_posts_per_page()
 * remove_woocommerce_pagination()
 * remove_responsi_action()
 * psad_endless_scroll_shop()
 * check_shop_page()
 * psad_wp_enqueue_script()
 * psad_wp_enqueue_style()
 * start_remove_orderby_shop()
 * end_remove_orderby_shop()
 * dont_show_product_on_shop()
 * rewrite_shop_page()
 */

namespace A3Rev\WCPSAD;

class Main
{

	public function __construct() {
		$this->init();
	}

	public function is_wc_36_or_larger() {
		if ( version_compare( WC_VERSION, '3.6.0', '>=' ) ) {
			return true;
		}

		return false;
	}

	public function init () {
		global $psad_queries_cached_enable;
		$psad_queries_cached_enable = get_option( 'psad_queries_cached_enable', 'no' );

		add_filter('loop_shop_per_page', array( $this, 'limit_posts_per_page'),99);

		//Fix Responsi Theme.
		add_action( 'responsi_head', array( $this, 'remove_responsi_action'), 11 );
		add_action( 'woo_head', array( $this, 'remove_responsi_action'), 11 );
		add_action( 'wp_head', array( $this, 'remove_woocommerce_pagination'), 10 );

		//Check if shop page
		add_action( 'woocommerce_before_shop_loop', array( $this, 'check_shop_page'), 1 );

		//Remove ordering dropdown on shop page
		add_action( 'woocommerce_before_shop_loop', array( $this, 'remove_ordering_dropdown'), 1 );

		// For Shop page
		//add_action( 'woocommerce_before_shop_loop', array( $this, 'start_remove_orderby_shop'), 2 );
		//add_action( 'woocommerce_before_shop_loop', array( $this, 'end_remove_orderby_shop'), 40 );
		add_filter( 'woocommerce_product_subcategories_args', array( $this, 'dont_show_categories_on_shop') );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'dont_show_product_on_shop'), 41 );
		add_action( 'woocommerce_after_shop_loop', array( $this, 'rewrite_shop_page'), 12 );

		//Enqueue Script
		add_action( 'woocommerce_after_shop_loop', array( $this, 'psad_wp_enqueue_script'),12 );

		// Add Custom style on frontend
		add_action( 'wp_enqueue_scripts', array( $this, 'include_customized_style'), 12 );
		//add_action( 'woocommerce_after_shop_loop', array( $this, 'psad_wp_enqueue_style'), 12 );

	}

	public function remove_product_query_filters() {
		remove_filter( 'posts_clauses', array( __NAMESPACE__ . '\Functions', 'order_by_onsale_post_clauses' ) );
	}

	public function get_sort_options() {
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

		return $sort_options;
	}

	public function limit_posts_per_page( $per_page ) {
		global $wp_query;
		if(!is_admin()){
			if( is_post_type_archive( 'product' ) && get_option('psad_shop_page_enable') == 'yes' ) $per_page = 1;
		}

		return $per_page;
	}

	public function remove_woocommerce_pagination(){

		global $wp_query;
		$is_shop = is_post_type_archive( 'product' );
		if( ($is_shop && get_option('psad_shop_page_enable') == 'yes') ){
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
			remove_action( 'woocommerce_after_main_content', 'canvas_commerce_pagination', 01, 0 );
		}
	}

	public function remove_responsi_action(){
		global $wp_query;
		if(function_exists('responsi_add_pagination_links')){
			global $wp_query;
			$is_shop = is_post_type_archive( 'product' );
			//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			if($is_shop && get_option('psad_shop_page_enable') == 'yes'){
				remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
				remove_action( 'woo_head', 'add_responsi_pagination_theme',11 );
				remove_action( 'a3rev_head', 'add_responsi_pagination_theme',11 );
				remove_action( 'woo_loop_after', 'responsi_pagination', 10, 0 );
				remove_action( 'responsi_loop_after', 'responsi_pagination', 10, 0 );
				//remove_action( 'responsi_catalog_ordering', 'woocommerce_catalog_ordering', 30 );
			}
		}
	}

	public function psad_endless_scroll_shop($show_click_more = true){
		global $wp_version;
		global $a3_lazy_load_excludes;
		$cur_wp_version = preg_replace('/-.*$/', '', $wp_version);
		?>
		<script type="text/javascript">
			jQuery(window).on( 'load', function(){
				//pbc infinitescroll
				var pbc_nextPage;
				var pbc_currentPage = jQuery('.pbc_pagination span.current').html();

				var pageNumbers = jQuery('.pbc_pagination').find('a.page-numbers');
				if(pageNumbers.length > 0){
					pageNumbers.each(function(index){
						if(jQuery(this).html() == (parseInt(pbc_currentPage) + 1)){
							pbc_nextPage = jQuery(this);
						}
					});
				}

				if(pbc_nextPage){
					jQuery('.pbc_content').infinitescroll({
						navSelector  : 'nav.pbc_pagination',
						nextSelector : pbc_nextPage,
						itemSelector : '.products_categories_row',
						loading: {
							finishedMsg: '<?php _e( 'No more categories to load.', 'woocommerce-product-sort-and-display' );?>',
							msgText:"<em><?php _e( 'Loading the next set of Categories...', 'woocommerce-product-sort-and-display' );?></em>",
							img: '<?php echo WC_PSAD_JS_URL;?>/masonry/loading-black.gif'
						},
						path:function generatePageUrl(pbc_currentPage){
							var pageNumbers = jQuery('.pbc_pagination').find('a.page-numbers');
							var url      = window.location.href;
							if ( url.indexOf("?") > -1 ) {
	                        	return [url+"&paged="+pbc_currentPage] ;
	                        } else {
	                        	return [url+"?paged="+pbc_currentPage] ;
	                        }
	                    }
					},function( newElements ) {
						var $newElems = jQuery( newElements ).css({ opacity: 0 });
						jQuery('.pbc_content').append( $newElems );
						jQuery('.pbc_content_click_more').show();
						<?php
						if(function_exists('responsi_add_pagination_links')){
							?>
							jQuery('#main').find('#infscr-loading').css('max-width',jQuery('#main').width()+'px');
                            $newElems.find('.thumbnail_container .thumbnail > a > img[srcset]').each(function(){
                                var src = '';
                                src = jQuery(this).attr('src');
                                if( src != '' ){
                                    jQuery(this).attr('src','');
                                    jQuery(this).attr('src',src);
                                }
                            });
							$newElems.imagesLoaded(function(){
								$newElems.animate({ opacity: 1 });
								jQuery('.box-content').masonry('reload');
							}).trigger('newElements');
						<?php } else { ?>
						$newElems.animate({ opacity: 1 });
						<?php } ?>
					});
					<?php if($show_click_more){?>
					jQuery(window).off('.infscr');
					<?php } ?>
					<?php if ( function_exists( 'a3_lazy_load_enable' ) ) { ?>
					<?php if ( $a3_lazy_load_excludes && ! $a3_lazy_load_excludes->check_excluded() ) { ?>
					jQuery(window).on('lazyload', function(){
						jQuery('.box-content').masonry('reload');
					}).lazyLoadXT({});
					<?php } } ?>
					jQuery('.pbc_content_click_more a').on('click', function(){
						jQuery('.pbc_content_click_more').hide();
    					jQuery('.pbc_content').infinitescroll('retrieve');
					 	return false;
					});
				}
			});
        </script>
		<?php
	}

	public function check_shop_page(){
		global $is_shop;
		$is_shop = false;
		if( is_post_type_archive( 'product' ) ) $is_shop = true;
		return $is_shop;
	}

	public function remove_ordering_dropdown() {

		if ( is_post_type_archive( 'product' ) ) {
			//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		}

		// remove for work compatibility on StoreFront Theme
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
	}

	public function psad_wp_enqueue_script(){
		global $is_shop;
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$enqueue_script = false;
		if( $is_shop && get_option('psad_shop_page_enable') == 'yes' ) $enqueue_script = true;
		if(!$enqueue_script) return;
		wp_register_script( 'jquery_infinitescroll', WC_PSAD_JS_URL.'/masonry/jquery.infinitescroll.min.js', array( 'jquery', 'jquery-masonry' ), WC_PSAD_VERSION );
		wp_enqueue_script( 'jquery_infinitescroll' );
	}

	public function psad_wp_enqueue_style(){
		global $is_shop;
		$enqueue_style = false;
		if( $is_shop && get_option('psad_shop_page_enable') == 'yes' ) $enqueue_style = true;
		if(!$enqueue_style) return;
		wp_enqueue_style( 'psad-css', WC_PSAD_CSS_URL.'/style.css', array(), WC_PSAD_VERSION );
	}

	public function include_customized_style(){
		if ( is_post_type_archive( 'product' ) && get_option('psad_shop_page_enable', '' ) == 'yes' && get_option('psad_endless_scroll_category_shop', '' ) == 'yes' ) {
	?>
    <style>
	.wc_content .woocommerce-pagination, .pbc_content .woocommerce-pagination,.wc_content nav, .woocommerce-pagination, .woo-pagination {display:none !important;}
	</style>
	<?php
		}
	}

	public function start_remove_orderby_shop(){
		global $is_shop;
		if ( $is_shop && get_option('psad_shop_page_enable') == 'yes' ) {
			ob_start();
		}
	}
	public function end_remove_orderby_shop(){
		global $is_shop;
		if ( $is_shop && get_option('psad_shop_page_enable') == 'yes' ) {
			ob_end_clean();
		}
	}

	public function dont_show_categories_on_shop( $categories_query_arg ) {
		if ( is_post_type_archive( 'product' ) ) {
			// override the arg of get sub categories query for don't get categories are set not show on shop page
			$categories_query_arg['meta_query'] = array(
					'relation' => 'OR',
					array(
						'key'     => 'psad_include_shop_page',
						'value'   => 1,
						'compare' => '=',
					),
					array(
						'key'     => 'psad_include_shop_page',
						'compare' => 'NOT EXISTS',
					),
				);
		}

		return $categories_query_arg;
	}

	public function dont_show_product_on_shop() {
		global $is_shop;
		if ( $is_shop && get_option('psad_shop_page_enable') == 'yes' ) {
			global $wp_query;

			// set 0 to don't get products on shop page from WC
			$wp_query->post_count  =  0;
			$wp_query->max_num_pages =  0;
		}
	}

	public function rewrite_shop_page() {
		global $is_shop;

		$woocommerce_version = get_option( 'woocommerce_version', null );

		//Check rewrite this for shop page
		if ( !$is_shop || get_option('psad_shop_page_enable') != 'yes' ) return;

		//Start Shop
		global $woocommerce, $wp_query, $wp_rewrite;

		$enable_product_showing_count = get_option('psad_shop_enable_product_showing_count');
		$product_ids_on_sale = ( ( version_compare( $woocommerce_version, '2.1', '<' ) ) ? woocommerce_get_product_ids_on_sale() : wc_get_product_ids_on_sale() );
		$product_ids_on_sale[] = 0;
		$global_psad_shop_product_per_page = get_option('psad_shop_product_per_page', 4);
		$global_psad_shop_product_show_type = apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );

		$term 			= get_queried_object();
		$parent_id 		= empty( $term->term_id ) ? 0 : $term->term_id;

		$page = 1;

		if ( get_query_var( 'paged' ) ) $page = get_query_var( 'paged' );
		$psad_shop_category_per_page = get_option('psad_shop_category_per_page', 0);
		if ( $psad_shop_category_per_page <= 0 ) $psad_shop_category_per_page = 3;

		global $psad_queries_cached_enable;

		$user_roles = '';
		if ( is_user_logged_in() ) {
			$user_login = wp_get_current_user();
			$user_roles_a = $user_login->roles;
			if ( is_array( $user_roles_a ) && count( $user_roles_a ) > 0 ) {
				$user_roles = implode( ',', $user_roles_a );
			}
		}

		$product_categories = false;
		$transient_parameter = 'role='.$user_roles;
		$transient_name = Functions::generate_transient_name( 'a3_shop_cat', $transient_parameter );
		if ( $psad_queries_cached_enable == 'yes' && '' != $transient_name ) {
			// Get cached shop categories query results
			$product_categories = get_transient( $transient_name );
		}

		if ( ! $product_categories ) {
			$args = array(
				'parent'       => $parent_id,
				'child_of'     => $parent_id,
				'menu_order'   => 'ASC',
				'hide_empty'   => 1,
				'hierarchical' => 1,
				'taxonomy'     => 'product_cat',
				'pad_counts'   => 1,
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key'     => 'psad_include_shop_page',
						'value'   => 1,
						'compare' => '=',
					),
					array(
						'key'     => 'psad_include_shop_page',
						'compare' => 'NOT EXISTS',
					),
				),
			);

			$product_categories = get_categories( $args  );

			if ( $psad_queries_cached_enable == 'yes' && '' != $transient_name ) {
				// Set cached shop categories query results for 1 day
				set_transient( $transient_name, $product_categories, 86400 );
			}
		}

		$numOfItems = $psad_shop_category_per_page;
		$to = $page * $numOfItems;
		$current = $to - $numOfItems;
		$total = sizeof($product_categories);
		$orderby = array( 'menu_order' => 'ASC', 'date' => 'DESC', 'title' => 'ASC' );
		$order = 'ASC';

		if ($to > count ($product_categories) ) $to = count($product_categories);

		$psad_es_category_item_bt_type = get_option( 'psad_es_category_item_bt_type' );
		$psad_es_category_item_bt_text = esc_attr( stripslashes( get_option( 'psad_es_category_item_link_text', '' ) ) );
		$psad_es_category_item_bt_position = get_option('psad_es_category_item_bt_position', 'bottom');

		$class = 'click_more_link';
		if ( $psad_es_category_item_bt_type == 'button' ) {
			$class = 'click_more_button';
			$psad_es_category_item_bt_text = esc_attr( stripslashes( get_option( 'psad_es_category_item_bt_text', '' ) ) );
		}
		if ( trim( $psad_es_category_item_bt_text ) == '' ) { $psad_es_category_item_bt_text = __('See more...', 'woocommerce-product-sort-and-display' ); }

		echo '<div style="clear:both;"></div>';
		echo '<div class="pbc_container">';
		echo '<div style="clear:both;"></div>';
		echo '<div class="pbc_content">';

		if ( version_compare( $woocommerce_version, '3.0.0', '>=' ) ) {
			$product_visibility_terms  = wc_get_product_visibility_term_ids();
			$product_visibility_not_in = array( $product_visibility_terms['exclude-from-catalog'] );
			// Hide out of stock products.
			if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
				$product_visibility_not_in[] = $product_visibility_terms['outofstock'];
			}

			$tax_query_visibility = array(
				'taxonomy'         => 'product_visibility',
				'field'            => 'term_taxonomy_id',
				'terms'            => $product_visibility_not_in,
				'operator'         => 'NOT IN',
			);
		}

		if ( $product_categories ) {
			$product_categories = array_values( $product_categories );

			for ( $i = $current ; $i < $to ; ++$i ) {

				$category = $product_categories[$i];
				$list_product_output = '';

				$psad_shop_product_per_page	= get_term_meta( $category->term_id, 'psad_shop_product_per_page', true );
				if (!$psad_shop_product_per_page || $psad_shop_product_per_page <= 0)
					$psad_shop_product_per_page = $global_psad_shop_product_per_page;
				if ( $psad_shop_product_per_page <= 0 )
					$psad_shop_product_per_page = 4;

				$psad_shop_product_show_type	= get_term_meta( $category->term_id, 'psad_shop_product_show_type', true );
				if (!$psad_shop_product_show_type || $psad_shop_product_show_type == '') {
					$psad_shop_product_show_type = $global_psad_shop_product_show_type;
				}

				if ( isset( $_GET['orderby'] ) && ! empty( $_GET['orderby'] ) ) {
					$psad_shop_product_show_type = wc_clean( wp_unslash( $_GET['orderby'] ) );
				}

				$list_products = false;

				$transient_parameter = 'cat='.$category->term_id.'&show_type='.$psad_shop_product_show_type.'&number='.$psad_shop_product_per_page.'&role='.$user_roles;
				$transient_name = Functions::generate_transient_name( 'a3_shop_cat_products', $transient_parameter );

				if ( $psad_queries_cached_enable == 'yes' && '' != $transient_name ) {
					// Get cached shop each category query results
					$list_products = get_transient( $transient_name );
				}

				if ( ! $list_products ) {

					if ($psad_shop_product_show_type == 'onsale') {
						$wp_query->query_vars['post__in'] = $product_ids_on_sale;
					} elseif ($psad_shop_product_show_type == 'featured') {
						$wp_query->query_vars['no_found_rows'] = 1;
						$wp_query->query_vars['post_status'] = 'publish';
						$wp_query->query_vars['post_type'] = 'product';
						if ( version_compare( $woocommerce_version, '2.1', '>' ) )
							$wp_query->query_vars['meta_query'] = \WC()->query->get_meta_query();
						else
							$wp_query->query_vars['meta_query'] = $woocommerce->query->get_meta_query();


						if ( version_compare( $woocommerce_version, '3.0.0', '<' ) ) {
							$wp_query->query_vars['meta_query'][] = array(
								'key' => '_featured',
								'value' => 'yes'
							);
						} else {
							$wp_query->query_vars['tax_query']['relation'] = 'AND';
							$wp_query->query_vars['tax_query'][] = array(
								'taxonomy' => 'product_visibility',
								'field'    => 'term_taxonomy_id',
								'terms'    => array( $product_visibility_terms['featured'] ),
							);
						}
					}

					$product_args = array(
						'post_type'				=> 'product',
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'	=> 1,
						'orderby' 				=> $orderby,
						'order' 				=> $order,
						'posts_per_page' 		=> $psad_shop_product_per_page,
						'tax_query' 			=> array(
							array(
								'taxonomy' 		=> 'product_cat',
								'terms' 		=> $category->slug ,
								'include_children' => false ,
								'field' 		=> 'slug',
								'operator' 		=> 'IN'
							)
						)
					);

					if ( version_compare( $woocommerce_version, '3.0.0', '<' ) ) {
						$product_args['meta_query'] = array(
							array(
								'key' 			=> '_visibility',
								'value' 		=> array('catalog', 'visible'),
								'compare' 		=> 'IN'
							)
						);
					} else {
						$product_args['tax_query']['relation'] = 'AND';
						$product_args['tax_query'][] = $tax_query_visibility;
					}

					$ogrinal_product_args = $product_args;

					if ( in_array( $psad_shop_product_show_type , array( 'onsale', 'featured' ) ) ) {
						$ordering_args = array();
						switch ( $psad_shop_product_show_type ) {
							case 'onsale' :
								if ( $this->is_wc_36_or_larger() ) {
									add_filter( 'posts_clauses', array( __NAMESPACE__ . '\Functions', 'order_by_onsale_post_clauses' ) );
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
						}
						$product_args = array_merge( $product_args, $ordering_args );
					} else {
						if ( false !== stristr( $psad_shop_product_show_type, '-' ) ) {
							// Get order + orderby args from string
							$orderby_value               = explode( '-', $psad_shop_product_show_type );
							$psad_shop_product_show_type = esc_attr( $orderby_value[0] );
							$order                       = ! empty( $orderby_value[1] ) ? $orderby_value[1] : $order;
						}
						remove_all_actions( 'woocommerce_get_catalog_ordering_args' );
						$ordering_args = \WC()->query->get_catalog_ordering_args( $psad_shop_product_show_type, $order );
						$product_args = array_merge( $product_args, $ordering_args );
					}

					$products = query_posts( $product_args );
					$this->remove_product_query_filters();

					$psad_shop_drill_down = get_option('psad_shop_drill_down', 'yes');
					$have_products = false;

					if ( have_posts() ) {
						$have_products = true;
					} elseif ( $psad_shop_drill_down == 'yes' ) {
						$product_args['tax_query'] = array(
							array(
								'taxonomy' 		=> 'product_cat',
								'terms' 		=> $category->slug ,
								'include_children' => true ,
								'field' 		=> 'slug',
								'operator' 		=> 'IN'
							)
						);

						if ( version_compare( $woocommerce_version, '3.0.0', '>=' ) ) {
							$product_args['tax_query']['relation'] = 'AND';
							$product_args['tax_query'][] = $tax_query_visibility;
						}

						$products = query_posts( $product_args );

						if ( have_posts() ) {
							$have_products = true;
						}
					}

					$count_posts_get = count( $products );
					$total_posts     = $wp_query->found_posts;

				} else {
					$have_products   = $list_products['have_products'];
					$count_posts_get = $list_products['count_products'];
					$total_posts     = $list_products['total_posts'];
				}

				if ( $have_products ) {
					$term_link_html = '';
					if ( $category->parent > 0 ) {
					$my_term = get_term($category->parent,'product_cat');
						$term_link = get_term_link( $my_term, 'product_cat' );
						if ( is_wp_error( $term_link ) )
							continue;
						$term_link_html = '<a href="'.$term_link.'">'. $my_term->name. '</a> / ';
					}
					$term_link_sub_html = get_term_link( $category->slug, 'product_cat' );
					echo '<div id="products_categories_row_'.$category->term_id.'" class="products_categories_row">';
					echo '<div class="custom_box custom_box_archive responsi_title"><h2 class="title pbc_title">'.$term_link_html.'<a href="'. ( ! is_wp_error( $term_link_sub_html ) ? $term_link_sub_html : '' ).'">' .$category->name.'</a></h2>';
					if ( $enable_product_showing_count == 'yes' || ( $count_posts_get < $total_posts && $psad_es_category_item_bt_position == 'top' ) ) {
						echo '<div class="product_categories_showing_count_container">';
						if ( $enable_product_showing_count == 'yes' ) echo '<span class="product_categories_showing_count">'.__('Showing', 'woocommerce-product-sort-and-display' ). ' 1 - ' .$count_posts_get.' '.__('of', 'woocommerce-product-sort-and-display' ). ' '. $total_posts .' '. __('products in this Category', 'woocommerce-product-sort-and-display' ).'</span> ';
						if ( $count_posts_get < $total_posts && $psad_es_category_item_bt_position == 'top' ) echo '<span class="click_more_each_categories"><a class="categories_click '.$class.'" id="'.$category->term_id.'" href="'.$term_link_sub_html.'">'.$psad_es_category_item_bt_text.'</a></span>';
						echo '</div>';
					}
					if( trim($category->description) != '' ) echo '<blockquote class="term-description"><p>'.$category->description.'</p></blockquote>';
					echo '</div>';

					if ( ! $list_products ) {

						ob_start();

						woocommerce_product_loop_start();
						while ( have_posts() ) : the_post();
							if ( version_compare( $woocommerce_version, '2.1', '<' ) )
								woocommerce_get_template( 'content-product.php' );
							else
								wc_get_template( 'content-product.php' );
						endwhile;
						woocommerce_product_loop_end();

						$list_product_output = ob_get_clean();

						echo $list_product_output;

					} else {
						echo $list_products['products_output'];
					}

					if ( $psad_es_category_item_bt_position != 'top' ) {
						if ( $count_posts_get < $total_posts ) {
							echo '<div class="click_more_each_categories" style="width:100%;clear:both;"><a class="categories_click '.$class.'" id="'.$category->term_id.'" href="'.$term_link_sub_html.'">'.$psad_es_category_item_bt_text.'</a></div>';
						} else {
							echo '<div class="click_more_each_categories" style="width:100%;clear:both;"><span class="categories_click">'.__('No more products to view in this category', 'woocommerce-product-sort-and-display' ).'</span></div>';
						}
					}
					echo '</div>';
					echo '<div class="psad_seperator products_categories_row" style="clear:both;"></div>';
				}

				if ( $psad_queries_cached_enable == 'yes' && ! $list_products && '' != $transient_name ) {
					$list_products = array(
						'have_products'   => $have_products,
						'count_products'  => $count_posts_get,
						'total_posts'     => $total_posts,
						'products_output' => $list_product_output,
					);

					// Set cached shop each category query results for 1 day
					set_transient( $transient_name, $list_products, 86400 );
				}
			}
		}

		echo '<div style="clear:both;"></div>';

		$psad_endless_scroll_category_shop = get_option('psad_endless_scroll_category_shop');
		$psad_endless_scroll_category_shop_tyle = get_option('psad_endless_scroll_category_shop_tyle');

		$use_endless_scroll = false;
		$show_click_more = false;
		if( $is_shop && $psad_endless_scroll_category_shop == 'yes'){
			$use_endless_scroll = true;
			if( $psad_endless_scroll_category_shop_tyle == 'click'){
				$show_click_more = true;
			}
		}

		if ( ceil($total / $numOfItems) > 1 ){
			echo '<nav class="pagination woo-pagination woocommerce-pagination pbc_pagination">';
			// fixed for 4.1.2
			$defaults = array(
				'base' => esc_url( add_query_arg( 'paged', '%#%' ) ),
				'format' => '',
				'total' => ceil($total / $numOfItems),
				'current' => $page,
				'prev_text' 	=> '&larr;',
				'next_text' 	=> '&rarr;',
				'type'			=> 'list',
				'end_size'		=> 3,
				'mid_size'		=> 3
			);
			if( $wp_rewrite->using_permalinks() && ! is_search() )
				$defaults['base'] = user_trailingslashit( trailingslashit( str_replace( 'page/'.$page , '' , esc_url( add_query_arg( array( 'paged' => false, 'orderby' => false ) ) ) ) ) . 'page/%#%' );

			echo paginate_links( $defaults );
			echo '</nav>';
		}
		echo '</div><!-- pbc_content -->';
		echo '<div style="clear:both;"></div>';
		if ($use_endless_scroll) {
			$this->psad_endless_scroll_shop($show_click_more);
		}
		if ( $use_endless_scroll && $show_click_more ) {
			if ( ceil($total / $numOfItems) > 1 ) {
				$psad_es_shop_bt_type = get_option( 'psad_es_shop_bt_type' );
				$psad_es_shop_bt_text = esc_attr( stripslashes( get_option( 'psad_es_shop_link_text', '' ) ) );
				$class = 'click_more_link';
				if ( $psad_es_shop_bt_type == 'button' ) {
					$class = 'click_more_button';
					$psad_es_shop_bt_text = esc_attr( stripslashes( get_option( 'psad_es_shop_bt_text', '' ) ) );
				}
				if ( trim( $psad_es_shop_bt_text ) == '' ) { $psad_es_shop_bt_text = __('Click More Categories', 'woocommerce-product-sort-and-display' ); }
				echo '<div class="pbc_content_click_more custom_box endless_click_shop"><a href="#"><a class="categories_click '.$class.'" href="#">'.$psad_es_shop_bt_text.'</a></div>';
			}
		}
		echo '<div style="clear:both;"></div>';
		echo '</div><!-- pbc_container -->';
		echo '<div style="clear:both;"></div>';
		wp_reset_postdata();
		//End Shop
	}

}
