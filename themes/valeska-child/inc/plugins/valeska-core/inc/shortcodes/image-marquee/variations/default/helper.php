<?php

if ( ! function_exists( 'valeska_core_add_image_marquee_variation_default' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_image_marquee_variation_default( $variations ) {
		$variations['default'] = esc_html__( 'Default', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_image_marquee_layouts', 'valeska_core_add_image_marquee_variation_default' );
}
