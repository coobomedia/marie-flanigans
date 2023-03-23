<?php

if ( ! function_exists( 'valeska_core_add_button_variation_textual' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_button_variation_textual( $variations ) {
		$variations['textual'] = esc_html__( 'Textual', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_button_layouts', 'valeska_core_add_button_variation_textual' );
}
