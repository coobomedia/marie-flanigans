<?php

if ( ! function_exists( 'valeska_core_add_banner_variation_image_right' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_banner_variation_image_right( $variations ) {
		$variations['image-right'] = esc_html__( 'Image Right', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_banner_layouts', 'valeska_core_add_banner_variation_image_right' );
}
