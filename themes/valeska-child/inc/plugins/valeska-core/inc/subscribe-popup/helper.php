<?php

if ( ! function_exists( 'valeska_core_get_subscribe_popup' ) ) {
	/**
	 * Loads subscribe popup HTML
	 */
	function valeska_core_get_subscribe_popup() {
		if ( valeska_core_get_option_value( 'admin', 'qodef_enable_subscribe_popup' ) === 'yes' && valeska_core_get_option_value( 'admin', 'qodef_subscribe_popup_contact_form' ) !== '' ) {
			valeska_core_load_subscribe_popup_template();
		}
	}

	// Get subscribe popup HTML
	add_action( 'valeska_action_before_wrapper_close_tag', 'valeska_core_get_subscribe_popup' );
}

if ( ! function_exists( 'valeska_core_is_subscribe_popup_enabled' ) ) {
	/**
	 * Function that check is module enabled
	 *
	 * @return bool
	 */
	function valeska_core_is_subscribe_popup_enabled() {
		return 'yes' !== valeska_core_get_post_value_through_levels( 'qodef_enable_subscribe_popup' );
	}
}

if ( ! function_exists( 'valeska_core_add_subscribe_popup_to_body_classes' ) ) {
	/**
	 * Function that add additional class name into global class list for body tag
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function valeska_core_add_subscribe_popup_to_body_classes( $classes ) {
		$classes[] = valeska_core_is_subscribe_popup_enabled() ? 'qodef-subscribe-popup--disabled' : '';

		return $classes;
	}

	add_filter( 'body_class', 'valeska_core_add_subscribe_popup_to_body_classes' );
}

if ( ! function_exists( 'valeska_core_load_subscribe_popup_template' ) ) {
	/**
	 * Loads HTML template with params
	 */
	function valeska_core_load_subscribe_popup_template() {
		$params                     = array();

		$params['image']            = valeska_core_get_option_value( 'admin', 'qodef_subscribe_popup_image' );
		$params['title']            = valeska_core_get_option_value( 'admin', 'qodef_subscribe_popup_title' );
		$params['subtitle']         = valeska_core_get_option_value( 'admin', 'qodef_subscribe_popup_subtitle' );
		$background_image           = valeska_core_get_option_value( 'admin', 'qodef_subscribe_popup_background_image' );
		$params['content_style']    = ! empty( $background_image ) ? 'background-image: url(' . esc_url( wp_get_attachment_url( $background_image ) ) . ')' : '';
		$params['contact_form']     = valeska_core_get_option_value( 'admin', 'qodef_subscribe_popup_contact_form' );
		$params['enable_prevent']   = valeska_core_get_option_value( 'admin', 'qodef_enable_subscribe_popup_prevent' );
		$params['prevent_behavior'] = valeska_core_get_option_value( 'admin', 'qodef_subscribe_popup_prevent_behavior' );

		$holder_classes           = array();
		$holder_classes[]         = ! empty( $params['prevent_behavior'] ) ? 'qodef-sp-prevent-' . $params['prevent_behavior'] : 'qodef-sp-prevent-session';
		$params['holder_classes'] = implode( ' ', $holder_classes );

		echo valeska_core_get_template_part( 'subscribe-popup', 'templates/subscribe-popup', '', $params );
	}
}
