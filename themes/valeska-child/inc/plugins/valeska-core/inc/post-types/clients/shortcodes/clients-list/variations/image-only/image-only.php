<?php

if ( ! function_exists( 'valeska_core_add_clients_list_variation_image_only' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function valeska_core_add_clients_list_variation_image_only( $variations ) {
		$variations['image-only'] = esc_html__( 'Image Only', 'valeska-core' );

		return $variations;
	}

	add_filter( 'valeska_core_filter_clients_list_layouts', 'valeska_core_add_clients_list_variation_image_only' );
}
