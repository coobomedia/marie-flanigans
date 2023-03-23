<?php

if ( ! function_exists( 'valeska_core_add_team_list_variation_info_on_hover' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_team_list_variation_info_on_hover( $variations ) {
		$variations['info-on-hover'] = esc_html__( 'Info on Hover', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_team_list_layouts', 'valeska_core_add_team_list_variation_info_on_hover' );
}
