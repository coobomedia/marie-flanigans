<?php

if ( ! function_exists( 'valeska_core_add_icon_with_text_variation_before_content' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_icon_with_text_variation_before_content( $variations ) {
		$variations['before-content'] = esc_html__( 'Before Content', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_icon_with_text_layouts', 'valeska_core_add_icon_with_text_variation_before_content' );
}
