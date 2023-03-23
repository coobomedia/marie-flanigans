<?php

class ValeskaCore_Side_Area_Mobile_Header extends ValeskaCore_Mobile_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'side-area' );
		$this->default_header_height = 70;

		parent::__construct();
	}

	/**
	 * @return ValeskaCore_Side_Area_Mobile_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function set_nav_menu_header_selector( $selector ) {
		return '#qodef-side-area-mobile-header .qodef-m-navigation';
	}
}
