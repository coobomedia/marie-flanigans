<?php

if ( ! function_exists( 'valeska_core_add_product_category_list_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function valeska_core_add_product_category_list_widget( $widgets ) {
		$widgets[] = 'ValeskaCore_Product_Category_List_Widget';

		return $widgets;
	}

	add_filter( 'valeska_core_filter_register_widgets', 'valeska_core_add_product_category_list_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class ValeskaCore_Product_Category_List_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'widget_title',
					'title'      => esc_html__( 'Title', 'valeska-core' ),
				)
			);
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'valeska_core_product_category_list',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'valeska_core_product_category_list' );
				$this->set_name( esc_html__( 'Valeska Product Category List', 'valeska-core' ) );
				$this->set_description( esc_html__( 'Display a list of product categories', 'valeska-core' ) );
			}
		}

		public function render( $atts ) {
			echo ValeskaCore_Product_Category_List_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
