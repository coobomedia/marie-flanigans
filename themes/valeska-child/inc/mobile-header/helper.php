<?php

if ( ! function_exists( 'valeska_load_page_mobile_header' ) ) {
	/**
	 * Function which loads page template module
	 */
	function valeska_load_page_mobile_header() {
		// Include mobile header template
		echo apply_filters( 'valeska_filter_mobile_header_template', valeska_get_template_part( 'mobile-header', 'templates/mobile-header' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'valeska_action_page_header_template', 'valeska_load_page_mobile_header' );
}

if ( ! function_exists( 'valeska_register_mobile_navigation_menus' ) ) {
	/**
	 * Function which registers navigation menus
	 */
	function valeska_register_mobile_navigation_menus() {
		$navigation_menus = apply_filters( 'valeska_filter_register_mobile_navigation_menus', array( 'mobile-navigation' => esc_html__( 'Mobile Navigation', 'valeska' ) ) );

		if ( ! empty( $navigation_menus ) ) {
			register_nav_menus( $navigation_menus );
		}
	}

	add_action( 'valeska_action_after_include_modules', 'valeska_register_mobile_navigation_menus' );
}
