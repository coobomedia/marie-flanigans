<?php

if ( ! function_exists( 'valeska_core_add_interactive_link_showcase_variation_interactive_list' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_interactive_link_showcase_variation_interactive_list( $variations ) {
		$variations['interactive-list'] = esc_html__( 'Interactive List', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_interactive_link_showcase_layouts', 'valeska_core_add_interactive_link_showcase_variation_interactive_list' );
}
