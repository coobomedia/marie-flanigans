<?php

if ( ! function_exists( 'valeska_core_add_team_single_sidebar_meta_boxes' ) ) {
	/**
	 * Function that add sidebar meta boxes for team single module
	 */
	function valeska_core_add_team_single_sidebar_meta_boxes( $page, $has_single ) {

		if ( $page && $has_single ) {
			$section = $page->add_section_element(
				array(
					'name'  => 'qodef_team_sidebar_section',
					'title' => esc_html__( 'Sidebar Settings', 'valeska-core' ),
				)
			);

			$section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_team_single_sidebar_layout',
					'title'         => esc_html__( 'Sidebar Layout', 'valeska-core' ),
					'description'   => esc_html__( 'Choose default sidebar layout for team singles', 'valeska-core' ),
					'default_value' => '',
					'options'       => valeska_core_get_select_type_options_pool( 'sidebar_layouts' ),
				)
			);

			$custom_sidebars = valeska_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$section->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_team_single_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'valeska-core' ),
						'description' => esc_html__( 'Choose a custom sidebar to display on team singles', 'valeska-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_team_single_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'valeska-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'items_space' ),
				)
			);
		}
	}

	add_action( 'valeska_core_action_after_team_meta_box_map', 'valeska_core_add_team_single_sidebar_meta_boxes', 10, 2 );
}
