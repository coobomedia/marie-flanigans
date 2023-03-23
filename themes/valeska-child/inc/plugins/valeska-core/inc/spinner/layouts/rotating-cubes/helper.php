<?php

if ( ! function_exists( 'valeska_core_add_rotating_cubes_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function valeska_core_add_rotating_cubes_spinner_layout_option( $layouts ) {
		$layouts['rotating-cubes'] = esc_html__( 'Rotating Cubes', 'valeska-core' );

		return $layouts;
	}

	add_filter( 'valeska_core_filter_page_spinner_layout_options', 'valeska_core_add_rotating_cubes_spinner_layout_option' );
}