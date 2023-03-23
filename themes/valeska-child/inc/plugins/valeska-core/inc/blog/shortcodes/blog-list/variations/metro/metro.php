<?php

if ( ! function_exists( 'valeska_core_add_blog_list_variation_metro' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_blog_list_variation_metro( $variations ) {
		$variations['metro'] = esc_html__( 'Metro', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_blog_list_layouts', 'valeska_core_add_blog_list_variation_metro' );
}
