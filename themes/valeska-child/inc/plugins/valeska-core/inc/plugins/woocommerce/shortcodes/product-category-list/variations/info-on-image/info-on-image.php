<?php

if ( ! function_exists( 'valeska_core_add_product_category_list_variation_info_on_image' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_product_category_list_variation_info_on_image( $variations ) {
		$variations['info-on-image'] = esc_html__( 'Info On Image', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_product_category_list_layouts', 'valeska_core_add_product_category_list_variation_info_on_image' );
}
