<?php

class ValeskaCore_Section_Title_Shortcode_Elementor extends ValeskaCore_Elementor_Widget_Base {

	function __construct( array $data = array(), $args = null ) {
		$this->set_shortcode_slug( 'valeska_core_section_title' );

		parent::__construct( $data, $args );
	}
}

valeska_core_get_elementor_widgets_manager()->register_widget_type( new ValeskaCore_Section_Title_Shortcode_Elementor() );
