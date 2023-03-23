<?php

if ( ! function_exists( 'valeska_core_add_author_list_variation_info_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_author_list_variation_info_below( $variations ) {
		$variations['info-below'] = esc_html__( 'Info Below', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_author_list_layouts', 'valeska_core_add_author_list_variation_info_below' );
}
