<?php

class ValeskaCore_Vertical_Sliding_Header extends ValeskaCore_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'vertical-sliding' );
		$this->set_overriding_whole_header( true );

		add_filter( 'valeska_core_filter_available_header_logo_images', array( $this, 'set_logo_image' ) );

		parent::__construct();
	}

	/**
	 * @return ValeskaCore_Vertical_Sliding_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function enqueue_additional_assets() {
		wp_enqueue_style( 'perfect-scrollbar', VALESKA_CORE_URL_PATH . 'assets/plugins/perfect-scrollbar/perfect-scrollbar.css', array() );
		wp_enqueue_script( 'perfect-scrollbar', VALESKA_CORE_URL_PATH . 'assets/plugins/perfect-scrollbar/perfect-scrollbar.jquery.min.js', array( 'jquery' ), false, true );
	}

	public function set_nav_menu_header_selector( $selector ) {
		return '.qodef-header--vertical-sliding .qodef-header-vertical-sliding-navigation';
	}

	public function set_nav_menu_narrow_header_selector( $selector ) {
		return '';
	}

	public function set_logo_image( $available_logo_images ) {
		$available_logo_images         = array();
		$available_logo_images['main'] = 'vertical_sliding';

		return $available_logo_images;
	}

	function fullscreen_menu_template() {
		$parameters = array(
			'fullscreen_menu_in_grid' => 'yes' === valeska_core_get_post_value_through_levels( 'qodef_fullscreen_menu_in_grid' ),
		);

		valeska_core_template_part( 'fullscreen-menu', 'templates/full-screen-menu', '', $parameters );
	}
}
