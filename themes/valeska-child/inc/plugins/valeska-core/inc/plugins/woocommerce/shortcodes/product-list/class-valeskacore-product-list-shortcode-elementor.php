<?php

class ValeskaCore_Product_List_Shortcode_Elementor extends ValeskaCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'valeska_core_product_list' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'woocommerce' ) ) {
	valeska_core_get_elementor_widgets_manager()->register_widget_type( new ValeskaCore_Product_List_Shortcode_Elementor() );
}
