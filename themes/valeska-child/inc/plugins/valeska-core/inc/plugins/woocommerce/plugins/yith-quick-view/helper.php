<?php

if ( ! function_exists( 'valeska_core_include_yith_quick_view_plugin_is_installed' ) ) {
	/**
	 * Function that set case is installed element for framework functionality
	 *
	 * @param bool $installed
	 * @param string $plugin - plugin name
	 *
	 * @return bool
	 */
	function valeska_core_include_yith_quick_view_plugin_is_installed( $installed, $plugin ) {
		if ( 'yith-quick-view' === $plugin ) {
			return defined( 'YITH_WCQV' );
		}

		return $installed;
	}

	add_filter( 'qode_framework_filter_is_plugin_installed', 'valeska_core_include_yith_quick_view_plugin_is_installed', 10, 2 );
}

if ( ! function_exists( 'woocommerce_template_wcqw_product_link' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 */
	function woocommerce_template_wcqw_product_link() {
		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<a href="' . esc_url( $link ) . '" class="woocommerce-wcqw-product__link qodef-button qodef-layout--textual qodef-html--link"><span class="qodef-m-text">' . esc_html__( 'View Details', 'valeska-core' ) . '</span></a>';
	}
}