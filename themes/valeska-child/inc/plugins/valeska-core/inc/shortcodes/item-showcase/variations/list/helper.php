<?php

if ( ! function_exists( 'valeska_core_add_item_showcase_variation_list' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_item_showcase_variation_list( $variations ) {
		$variations['list'] = esc_html__( 'List', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_item_showcase_layouts', 'valeska_core_add_item_showcase_variation_list' );
}
