<?php

if ( ! function_exists( 'valeska_core_add_icon_with_text_variation_before_title' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_icon_with_text_variation_before_title( $variations ) {
		$variations['before-title'] = esc_html__( 'Before Title', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_icon_with_text_layouts', 'valeska_core_add_icon_with_text_variation_before_title' );
}
