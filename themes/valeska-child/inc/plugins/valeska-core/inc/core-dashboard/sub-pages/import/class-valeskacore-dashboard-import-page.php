<?php

if ( ! function_exists( 'valeska_core_add_import_sub_page_to_list' ) ) {
	/**
	 * Function that add additional sub page item into welcome page list
	 *
	 * @param array $sub_pages
	 *
	 * @return array
	 */
	function valeska_core_add_import_sub_page_to_list( $sub_pages ) {
		$sub_pages[] = 'ValeskaCore_Dashboard_Import_Page';

		return $sub_pages;
	}

	add_filter( 'valeska_core_filter_add_welcome_sub_page', 'valeska_core_add_import_sub_page_to_list', 11 );
}

if ( class_exists( 'ValeskaCore_Dashboard_Sub_Page' ) ) {
	class ValeskaCore_Dashboard_Import_Page extends ValeskaCore_Dashboard_Sub_Page {

		public function __construct() {
			parent::__construct();
		}

		public function add_sub_page() {
			$this->set_base( 'import' );
			$this->set_title( esc_html__( 'Import', 'valeska-core' ) );
			$this->set_atts( $this->set_atributtes() );
		}

		public function set_atributtes() {
			$params = array();

			$iparams = ValeskaCore_Dashboard::get_instance()->get_import_params();
			if ( is_array( $iparams ) && isset( $iparams['submit'] ) ) {
				$params['submit'] = $iparams['submit'];
			}

			return $params;
		}
	}
}
