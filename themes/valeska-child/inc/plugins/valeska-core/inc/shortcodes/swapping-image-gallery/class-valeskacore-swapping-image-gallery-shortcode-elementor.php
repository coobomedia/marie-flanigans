<?php

class ValeskaCore_Swapping_Image_Gallery_Shortcode_Elementor extends ValeskaCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'valeska_core_swapping_image_gallery' );

		parent::__construct( $data, $args );
	}
}

valeska_core_get_elementor_widgets_manager()->register_widget_type( new ValeskaCore_Swapping_Image_Gallery_Shortcode_Elementor() );
