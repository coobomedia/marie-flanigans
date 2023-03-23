<?php

if ( ! function_exists( 'valeska_core_add_page_sidebar_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function valeska_core_add_page_sidebar_meta_box( $page ) {

		if ( $page ) {

			$sidebar_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-sidebar',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Sidebar Settings', 'valeska-core' ),
					'description' => esc_html__( 'Sidebar layout settings', 'valeska-core' ),
				)
			);

			$sidebar_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_sidebar_layout',
					'title'       => esc_html__( 'Sidebar Layout', 'valeska-core' ),
					'description' => esc_html__( 'Choose a sidebar layout', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'sidebar_layouts' ),
				)
			);

			$custom_sidebars = valeska_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$sidebar_tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_page_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'valeska-core' ),
						'description' => esc_html__( 'Choose a custom sidebar', 'valeska-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$sidebar_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'valeska-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'valeska_core_action_after_page_sidebar_meta_box_map', $sidebar_tab );
		}
	}

	add_action( 'valeska_core_action_after_general_meta_box_map', 'valeska_core_add_page_sidebar_meta_box' );
}

if ( ! function_exists( 'valeska_core_add_general_page_sidebar_meta_box_callback' ) ) {
	/**
	 * Function that set current meta box callback as general callback functions
	 *
	 * @param array $callbacks
	 *
	 * @return array
	 */
	function valeska_core_add_general_page_sidebar_meta_box_callback( $callbacks ) {
		$callbacks['page-sidebar'] = 'valeska_core_add_page_sidebar_meta_box';

		return $callbacks;
	}

	add_filter( 'valeska_core_filter_general_meta_box_callbacks', 'valeska_core_add_general_page_sidebar_meta_box_callback' );
}
