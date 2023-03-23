<?php

if ( ! function_exists( 'valeska_core_add_yith_quick_view_options' ) ) {
	/**
	 * Function that add general options for this module
	 *
	 * @param object $page
	 */
	function valeska_core_add_yith_quick_view_options( $page ) {

		if ( $page ) {

			$yith_quick_view_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-yith-quick-view',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'YITH Quick View', 'valeska-core' ),
					'description' => esc_html__( 'Settings related to YITH Quick View', 'valeska-core' ),
				)
			);

			$yith_quick_view_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_woo_yith_quick_view_title_tag',
					'title'       => esc_html__( 'Title Tag', 'valeska-core' ),
					'description' => esc_html__( 'Choose title tag for YITH Quick View item', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'title_tag' ),
				)
			);
		}
	}

	add_action( 'valeska_core_action_after_woo_options_map', 'valeska_core_add_yith_quick_view_options' );
}
