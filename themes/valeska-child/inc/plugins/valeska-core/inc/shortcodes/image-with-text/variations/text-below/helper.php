<?php

if ( ! function_exists( 'valeska_core_add_image_with_text_variation_text_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_image_with_text_variation_text_below( $variations ) {
		$variations['text-below'] = esc_html__( 'Text Below', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_image_with_text_layouts', 'valeska_core_add_image_with_text_variation_text_below' );
}
