<?php

if ( ! function_exists( 'valeska_core_add_cpt_variation_simple' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_cpt_variation_simple( $variations ) {
		$variations['simple'] = esc_html__( 'Simple', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_cpt_layouts', 'valeska_core_add_cpt_variation_simple' );
}
