<?php

if ( ! function_exists( 'valeska_core_register_product_for_meta_options' ) ) {
	/**
	 * Function that register product post type for meta box options
	 *
	 * @param array $post_types
	 *
	 * @return array
	 */
	function valeska_core_register_product_for_meta_options( $post_types ) {
		$post_types[] = 'product';

		return $post_types;
	}

	add_filter( 'qode_framework_filter_meta_box_save', 'valeska_core_register_product_for_meta_options' );
	add_filter( 'qode_framework_filter_meta_box_remove', 'valeska_core_register_product_for_meta_options' );
}

if ( ! function_exists( 'valeska_core_woo_get_global_product' ) ) {
	/**
	 * Function that return global WooCommerce object
	 *
	 * @return object
	 */
	function valeska_core_woo_get_global_product() {
		global $product;

		return $product;
	}
}

if ( ! function_exists( 'valeska_core_woo_set_admin_options_map_position' ) ) {
	/**
	 * Function that set dashboard admin options map position for this module
	 *
	 * @param int $position
	 * @param string $map
	 *
	 * @return int
	 */
	function valeska_core_woo_set_admin_options_map_position( $position, $map ) {

		if ( 'woocommerce' === $map ) {
			$position = 70;
		}

		return $position;
	}

	add_filter( 'valeska_core_filter_admin_options_map_position', 'valeska_core_woo_set_admin_options_map_position', 10, 2 );
}

if ( ! function_exists( 'valeska_core_include_woocommerce_shortcodes' ) ) {
	/**
	 * Function that includes shortcodes
	 */
	function valeska_core_include_woocommerce_shortcodes() {
		foreach ( glob( VALESKA_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/*/include.php' ) as $shortcode ) {
			include_once $shortcode;
		}
	}

	add_action( 'qode_framework_action_before_shortcodes_register', 'valeska_core_include_woocommerce_shortcodes' );
}

if ( ! function_exists( 'valeska_core_woo_product_get_rating_html' ) ) {
	/**
	 * Function that return ratings templates
	 *
	 * @param string $html - contains html content
	 * @param float $rating
	 * @param int $count - total number of ratings
	 *
	 * @return string
	 */
	function valeska_core_woo_product_get_rating_html( $html, $rating, $count ) {
		return qode_framework_is_installed( 'theme' ) ? valeska_woo_product_get_rating_html( $html, $rating, $count ) : '';
	}
}

if ( ! function_exists( 'valeska_core_woo_get_product_categories' ) ) {
	/**
	 * Function that render product categories
	 *
	 * @param string $before
	 * @param string $after
	 *
	 * @return string
	 */
	function valeska_core_woo_get_product_categories( $before = '', $after = '' ) {
		return qode_framework_is_installed( 'theme' ) ? valeska_woo_get_product_categories( $before, $after ) : '';
	}
}

if ( ! function_exists( 'valeska_core_woo_product_category_min_price' ) ) {
	/**
	 * Function that return category products min price
	 * Param $term_slug
	 * Return string
	 */

	function valeska_core_woo_product_category_min_price( $term_id ) {

		$min_price           = 0;
		$product_query_array = array(
			'post_status'         => 'publish',
			'post_type'           => 'product',
			'ignore_sticky_posts' => 1,
			'tax_query'           => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $term_id,
				),
			),
		);

		$products = new WP_Query( $product_query_array );
		$counter  = 0;

		if ( $products->have_posts() ) {
			while ( $products->have_posts() ) {
				$products->the_post();
				$counter ++;

				$price = get_post_meta( get_the_ID(), '_price', true );

				if ( $price && $price !== '' ) {
					if ( $counter === 1 ) {
						$min_price = $price;
					}

					if ( $price < $min_price ) {
						$min_price = $price;
					}

				}

			}
			wp_reset_postdata();
		}

		return $min_price;
	}
}

if ( ! function_exists( 'valeska_core_set_product_styles' ) ) {
	/**
	 * Function that generates module inline styles
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	function valeska_core_set_product_styles( $style ) {
		$price_styles        = valeska_core_get_typography_styles( 'qodef_product_price' );
		$price_single_styles = valeska_core_get_typography_styles( 'qodef_product_single_price' );

		if ( ! empty( $price_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page .price',
					'.qodef-woo-shortcode .price',
				),
				$price_styles
			);
		}

		if ( ! empty( $price_single_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page.qodef--single .entry-summary .price',
				),
				$price_single_styles
			);
		}

		$price_discount_styles        = array();
		$price_discount_color         = valeska_core_get_option_value( 'admin', 'qodef_product_price_discount_color' );
		$price_single_discount_styles = array();
		$price_single_discount_color  = valeska_core_get_option_value( 'admin', 'qodef_product_single_price_discount_color' );

		if ( ! empty( $price_discount_color ) ) {
			$price_discount_styles['color'] = $price_discount_color;
		}

		if ( ! empty( $price_single_discount_color ) ) {
			$price_single_discount_styles['color'] = $price_single_discount_color;
		}

		if ( ! empty( $price_discount_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page .price del',
					'.qodef-woo-shortcode .price del',
				),
				$price_discount_styles
			);
		}

		if ( ! empty( $price_single_discount_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page.qodef--single .entry-summary .price del',
				),
				$price_single_discount_styles
			);
		}

		$label_styles      = valeska_core_get_typography_styles( 'qodef_product_label' );
		$info_styles       = valeska_core_get_typography_styles( 'qodef_product_info' );
		$info_hover_styles = valeska_core_get_typography_hover_styles( 'qodef_product_info' );

		if ( ! empty( $label_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page.qodef--single .product_meta .qodef-woo-meta-label',
				),
				$label_styles
			);
		}

		if ( ! empty( $info_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page.qodef--single .product_meta .qodef-woo-meta-value',
					'#qodef-woo-page.qodef--single .shop_attributes th',
					'#qodef-woo-page.qodef--single .woocommerce-Reviews .woocommerce-review__author',
				),
				$info_styles
			);
		}

		if ( ! empty( $info_hover_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-woo-page.qodef--single .product_meta .qodef-woo-meta-value a:hover',
				),
				$info_hover_styles
			);
		}

		return $style;
	}

	add_filter( 'valeska_filter_add_inline_style', 'valeska_core_set_product_styles' );
}
