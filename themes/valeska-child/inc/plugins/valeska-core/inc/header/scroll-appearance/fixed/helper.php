<?php

if ( ! function_exists( 'valeska_core_add_fixed_header_option' ) ) {
	/**
	 * This function set header scrolling appearance value for global header option map
	 */
	function valeska_core_add_fixed_header_option( $options ) {
		$options['fixed'] = esc_html__( 'Fixed', 'valeska-core' );

		return $options;
	}

	add_filter( 'valeska_core_filter_header_scroll_appearance_option', 'valeska_core_add_fixed_header_option' );
}
