<?php

if ( ! function_exists( 'valeska_core_add_banner_variation_image_behind' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_banner_variation_image_behind( $variations ) {
		$variations['image-behind'] = esc_html__( 'Image Behind', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_banner_layouts', 'valeska_core_add_banner_variation_image_behind' );
}
