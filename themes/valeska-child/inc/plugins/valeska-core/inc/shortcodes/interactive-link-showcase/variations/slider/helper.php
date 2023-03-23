<?php

if ( ! function_exists( 'valeska_core_add_interactive_link_showcase_variation_slider' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_interactive_link_showcase_variation_slider( $variations ) {
		$variations['slider'] = esc_html__( 'Slider', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_interactive_link_showcase_layouts', 'valeska_core_add_interactive_link_showcase_variation_slider' );
}
