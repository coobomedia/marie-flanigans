<?php

if ( ! function_exists( 'valeska_core_add_vertical_sliding_header_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function valeska_core_add_vertical_sliding_header_global_option( $header_layout_options ) {
		$header_layout_options['vertical-sliding'] = array(
			'image' => VALESKA_CORE_HEADER_LAYOUTS_URL_PATH . '/vertical-sliding/assets/img/vertical-sliding-header.png',
			'label' => esc_html__( 'Vertical Sliding', 'valeska-core' ),
		);

		return $header_layout_options;
	}

	add_filter( 'valeska_core_filter_header_layout_option', 'valeska_core_add_vertical_sliding_header_global_option' );
}

if ( ! function_exists( 'valeska_core_register_vertical_sliding_header_layout' ) ) {
	/**
	 * Function which add header layout into global list
	 *
	 * @param array $header_layouts
	 *
	 * @return array
	 */
	function valeska_core_register_vertical_sliding_header_layout( $header_layouts ) {
		$header_layouts['vertical-sliding'] = 'ValeskaCore_Vertical_Sliding_Header';

		return $header_layouts;
	}

	add_filter( 'valeska_core_filter_register_header_layouts', 'valeska_core_register_vertical_sliding_header_layout' );
}

if ( ! function_exists( 'valeska_core_vertical_sliding_header_nav_menu_grid' ) ) {
	/**
	 * Function which set grid class name for current header layout
	 *
	 * @param string $grid_class
	 *
	 * @return string
	 */
	function valeska_core_vertical_sliding_header_nav_menu_grid( $grid_class ) {
		$header = valeska_core_get_post_value_through_levels( 'qodef_header_layout' );

		if ( 'vertical-sliding' === $header ) {
			return false;
		}

		return $grid_class;
	}

	add_filter( 'valeska_core_filter_drop_down_grid', 'valeska_core_vertical_sliding_header_nav_menu_grid' );
}

// same as in vertical menu
if ( ! function_exists( 'valeska_core_register_vertical_menu' ) ) {
	/**
	 * Function which add additional main menu navigation into global list
	 *
	 * @param array $menus
	 *
	 * @return array
	 */
	function valeska_core_register_vertical_menu( $menus ) {
		$menus['vertical-menu-navigation'] = esc_html__( 'Vertical Navigation', 'valeska-core' );

		return $menus;
	}

	add_filter( 'valeska_filter_register_navigation_menus', 'valeska_core_register_vertical_menu' );
}

if ( ! function_exists( 'valeska_core_vertical_sliding_header_hide_top_area' ) ) {
	/**
	 * Function that set dependency option value for specific module layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function valeska_core_vertical_sliding_header_hide_top_area( $options ) {
		$options[] = 'vertical-sliding';

		return $options;
	}

	add_filter( 'valeska_core_filter_top_area_hide_option', 'valeska_core_vertical_sliding_header_hide_top_area' );
}

if ( ! function_exists( 'valeska_core_vertical_sliding_header_hide_scroll_appearance' ) ) {
	/**
	 * Function that set dependency option value for specific module layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function valeska_core_vertical_sliding_header_hide_scroll_appearance( $options ) {
		$options[] = 'vertical-sliding';

		return $options;
	}

	add_filter( 'valeska_core_filter_header_scroll_appearance_hide_option', 'valeska_core_vertical_sliding_header_hide_scroll_appearance' );
}
