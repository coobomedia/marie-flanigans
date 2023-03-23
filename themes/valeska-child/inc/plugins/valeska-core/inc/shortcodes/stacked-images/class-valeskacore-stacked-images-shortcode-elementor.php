<?php

class ValeskaCore_Stacked_Images_Shortcode_Elementor extends ValeskaCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'valeska_core_stacked_images' );

		parent::__construct( $data, $args );
	}
}

valeska_core_get_elementor_widgets_manager()->register_widget_type( new ValeskaCore_Stacked_Images_Shortcode_Elementor() );
