<?php

if ( ! function_exists( 'valeska_core_add_sticky_header_option' ) ) {
	/**
	 * This function set header scrolling appearance value for global header option map
	 */
	function valeska_core_add_sticky_header_option( $options ) {
		$options['sticky'] = esc_html__( 'Sticky', 'valeska-core' );

		return $options;
	}

	add_filter( 'valeska_core_filter_header_scroll_appearance_option', 'valeska_core_add_sticky_header_option' );
}

if ( ! function_exists( 'valeska_core_sticky_header_global_js_var' ) ) {
	/**
	 * Function that extend global js variables
	 *
	 * @param array $global_variables
	 *
	 * @return array
	 */
	function valeska_core_sticky_header_global_js_var( $global_variables ) {
		$header_scroll_appearance = valeska_core_get_post_value_through_levels( 'qodef_header_scroll_appearance' );

		if ( 'sticky' === $header_scroll_appearance ) {
			$sticky_scroll_amount_meta = valeska_core_get_post_value_through_levels( 'qodef_sticky_header_scroll_amount' );
			$sticky_scroll_amount      = '' !== $sticky_scroll_amount_meta ? intval( $sticky_scroll_amount_meta ) : 0;

			$global_variables['qodefStickyHeaderScrollAmount'] = $sticky_scroll_amount;
		}

		return $global_variables;
	}

	add_filter( 'valeska_filter_localize_main_js', 'valeska_core_sticky_header_global_js_var' );
}

if ( ! function_exists( 'valeska_core_register_sticky_header_areas' ) ) {
	/**
	 * Function that registers widget area for sticky header
	 */
	function valeska_core_register_sticky_header_areas() {
		register_sidebar(
			array(
				'id'            => 'qodef-sticky-header-widget-area-one',
				'name'          => esc_html__( 'Sticky Header - Area One', 'valeska-core' ),
				'description'   => esc_html__( 'Widgets added here will appear in sticky header widget area one', 'valeska-core' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s qodef-sticky-right">',
				'after_widget'  => '</div>',
			)
		);

		register_sidebar(
			array(
				'id'            => 'qodef-sticky-header-widget-area-two',
				'name'          => esc_html__( 'Sticky Header - Area Two', 'valeska-core' ),
				'description'   => esc_html__( 'Widgets added here will appear in sticky header widget area two', 'valeska-core' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s qodef-sticky-right">',
				'after_widget'  => '</div>',
			)
		);
	}

	add_action( 'valeska_core_action_additional_header_widgets_area', 'valeska_core_register_sticky_header_areas' );
}

if ( ! function_exists( 'valeska_core_set_sticky_header_logo_image' ) ) {
	/**
	 * This function set header logo image for current scroll appearance type
	 *
	 * @param array $available_logo_images
	 * @param array $parameters
	 *
	 * @return array
	 */
	function valeska_core_set_sticky_header_logo_image( $available_logo_images, $parameters ) {

		if ( isset( $parameters['sticky_logo'] ) && ! empty( $parameters['sticky_logo'] ) ) {
			$available_logo_images         = array();
			$available_logo_images['main'] = 'sticky';
		}

		return $available_logo_images;
	}

	add_filter( 'valeska_core_filter_available_header_logo_images', 'valeska_core_set_sticky_header_logo_image', 10, 2 );
}

if ( ! function_exists( 'valeska_core_set_sticky_header_logo_svg_path' ) ) {
	/**
	 * This function set header logo svg path for current scroll appearance type
	 *
	 * @param string $logo_svg_path
	 * @param array $parameters
	 *
	 * @return string
	 */
	function valeska_core_set_sticky_header_logo_svg_path( $logo_svg_path, $parameters ) {
		$sticky_logo_svg_path = valeska_core_get_post_value_through_levels( 'qodef_logo_sticky_svg_path' );

		if ( ! empty( $sticky_logo_svg_path ) && isset( $parameters['sticky_logo'] ) && ! empty( $parameters['sticky_logo'] ) ) {
			$logo_svg_path = $sticky_logo_svg_path;
		}

		return $logo_svg_path;
	}

	add_filter( 'valeska_core_filter_header_logo_svg_path', 'valeska_core_set_sticky_header_logo_svg_path', 10, 2 );
}

if ( ! function_exists( 'valeska_core_set_additional_sticky_header_classes' ) ) {
	/**
	 * This function add additional sticky header area inner classes
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function valeska_core_set_additional_sticky_header_classes( $classes ) {
		$header_skin = valeska_core_get_post_value_through_levels( 'qodef_sticky_header_skin' );
		if ( ! empty( $header_skin ) && 'none' !== $header_skin ) {
			$classes[] = 'qodef-skin--' . $header_skin;
		}

		$header_appearance = valeska_core_get_post_value_through_levels( 'qodef_sticky_header_appearance' );
		$classes[]         = 'qodef-appearance--' . ( ! empty( $header_appearance ) ? esc_attr( $header_appearance ) : 'down' );

		return $classes;
	}

	add_filter( 'valeska_core_filter_sticky_header_class', 'valeska_core_set_additional_sticky_header_classes' );
}

if ( ! function_exists( 'valeska_core_set_sticky_header_area_styles' ) ) {
	/**
	 * Function that generates module inline styles
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	function valeska_core_set_sticky_header_area_styles( $style ) {
		$styles = array();

		$background_color = valeska_core_get_post_value_through_levels( 'qodef_sticky_header_background_color' );

		if ( ! empty( $background_color ) ) {
			$styles['background-color'] = $background_color;
		}

		if ( ! empty( $styles ) ) {
			$style .= qode_framework_dynamic_style( '.qodef-header-sticky', $styles );
		}

		$inner_styles = array();

		$side_padding = valeska_core_get_post_value_through_levels( 'qodef_sticky_header_side_padding' );

		if ( '' !== $side_padding ) {
			if ( qode_framework_string_ends_with_space_units( $side_padding ) ) {
				$inner_styles['padding-left']  = $side_padding;
				$inner_styles['padding-right'] = $side_padding;
			} else {
				$inner_styles['padding-left']  = intval( $side_padding ) . 'px';
				$inner_styles['padding-right'] = intval( $side_padding ) . 'px';
			}
		}

		if ( ! empty( $inner_styles ) ) {
			$style .= qode_framework_dynamic_style( '.qodef-header-sticky .qodef-header-sticky-inner', $inner_styles );
		}

		return $style;
	}

	add_filter( 'valeska_filter_add_inline_style', 'valeska_core_set_sticky_header_area_styles' );
}
