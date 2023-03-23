<?php

if ( ! function_exists( 'valeska_core_add_blog_list_variation_minimal' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_blog_list_variation_minimal( $variations ) {
		$variations['minimal'] = esc_html__( 'Minimal', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_blog_list_layouts', 'valeska_core_add_blog_list_variation_minimal' );
}
