<?php

if ( ! function_exists( 'valeska_core_add_button_variation_filled' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_button_variation_filled( $variations ) {
		$variations['filled'] = esc_html__( 'Filled', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_button_layouts', 'valeska_core_add_button_variation_filled' );
}
