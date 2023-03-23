<?php

if ( ! function_exists( 'valeska_core_add_pricing_table_variation_standard' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_pricing_table_variation_standard( $variations ) {

		$variations['standard'] = esc_html__( 'Standard', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_pricing_table_layouts', 'valeska_core_add_pricing_table_variation_standard' );
}
