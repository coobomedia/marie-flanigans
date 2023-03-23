<?php

if ( ! function_exists( 'valeska_core_add_custom_font_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function valeska_core_add_custom_font_widget( $widgets ) {
		$widgets[] = 'ValeskaCore_Custom_Font_Widget';

		return $widgets;
	}

	add_filter( 'valeska_core_filter_register_widgets', 'valeska_core_add_custom_font_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class ValeskaCore_Custom_Font_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'valeska_core_custom_font',
				)
			);
			if ( $widget_mapped ) {
				$this->set_base( 'valeska_core_custom_font' );
				$this->set_name( esc_html__( 'Valeska Custom Font', 'valeska-core' ) );
				$this->set_description( esc_html__( 'Add a custom font element into widget areas', 'valeska-core' ) );
			}
		}

		public function render( $atts ) {
			echo ValeskaCore_Custom_Font_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
