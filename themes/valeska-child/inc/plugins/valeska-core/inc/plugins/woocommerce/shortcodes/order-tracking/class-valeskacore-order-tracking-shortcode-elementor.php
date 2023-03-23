<?php

class ValeskaCore_Order_Tracking_Shortcode_Elementor extends ValeskaCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'valeska_core_order_tracking' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'woocommerce' ) ) {
	valeska_core_get_elementor_widgets_manager()->register_widget_type( new ValeskaCore_Order_Tracking_Shortcode_Elementor() );
}
