<?php

if ( ! function_exists( 'valeska_core_yith_quick_view_single_title' ) ) {
	/**
	 * Function that override product single item title template
	 */
	function valeska_core_yith_quick_view_single_title() {
		$option    = valeska_get_post_value_through_levels( 'qodef_woo_yith_quick_view_title_tag' );
		$title_tag = ! empty( $option ) ? esc_attr( $option ) : 'h1';

		echo '<' . esc_attr( $title_tag ) . ' class="qodef-woo-product-title product_title entry-title">' . wp_kses_post( get_the_title() ) . '</' . esc_attr( $title_tag ) . '>';
	}
}