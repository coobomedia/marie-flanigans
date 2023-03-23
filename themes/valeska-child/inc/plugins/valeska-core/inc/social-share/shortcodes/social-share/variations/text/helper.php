<?php

if ( ! function_exists( 'valeska_core_add_social_share_variation_text' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_social_share_variation_text( $variations ) {
		$variations['text'] = esc_html__( 'Text', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_social_share_layouts', 'valeska_core_add_social_share_variation_text' );
}
