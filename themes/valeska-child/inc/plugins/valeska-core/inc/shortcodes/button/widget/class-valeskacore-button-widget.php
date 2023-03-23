<?php

if ( ! function_exists( 'valeska_core_add_button_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function valeska_core_add_button_widget( $widgets ) {
		$widgets[] = 'ValeskaCore_Button_Widget';

		return $widgets;
	}

	add_filter( 'valeska_core_filter_register_widgets', 'valeska_core_add_button_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class ValeskaCore_Button_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'valeska_core_button',
				)
			);
			if ( $widget_mapped ) {
				$this->set_base( 'valeska_core_button' );
				$this->set_name( esc_html__( 'Valeska Button', 'valeska-core' ) );
				$this->set_description( esc_html__( 'Add a button element into widget areas', 'valeska-core' ) );
			}
		}

		public function render( $atts ) {
			echo ValeskaCore_Button_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
