<?php

if ( ! function_exists( 'valeska_core_add_page_footer_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function valeska_core_add_page_footer_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => VALESKA_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'footer',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Footer', 'valeska-core' ),
				'description' => esc_html__( 'Global Footer Options', 'valeska-core' ),
			)
		);

		if ( $page ) {

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_page_footer',
					'title'         => esc_html__( 'Enable Page Footer', 'valeska-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable page footer', 'valeska-core' ),
					'default_value' => 'yes',
				)
			);

			$page_footer_section = $page->add_section_element(
				array(
					'name'       => 'qodef_page_footer_section',
					'title'      => esc_html__( 'Footer Area', 'valeska-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_page_footer' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			// General Footer Area Options

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_uncovering_footer',
					'title'         => esc_html__( 'Enable Uncovering Footer', 'valeska-core' ),
					'description'   => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'valeska-core' ),
					'default_value' => 'no',
				)
			);

			// Title Footer Area Section

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_title_footer_area',
					'title'         => esc_html__( 'Enable Title Footer Area', 'valeska-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable title footer area', 'valeska-core' ),
					'default_value' => 'yes',
				)
			);

			$title_footer_area_section = $page_footer_section->add_section_element(
				array(
					'name'       => 'qodef_title_footer_area_section',
					'title'      => esc_html__( 'Title Footer Area', 'valeska-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_title_footer_area' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$title_footer_area_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_set_footer_title_area_in_grid',
					'title'         => esc_html__( 'Title Footer Area In Grid', 'valeska-core' ),
					'description'   => esc_html__( 'Enabling this option will set page title footer area to be in grid', 'valeska-core' ),
					'default_value' => 'yes',
				)
			);

			$title_footer_area_styles_section = $title_footer_area_section->add_section_element(
				array(
					'name'  => 'qodef_top_footer_area_styles_section',
					'title' => esc_html__( 'Title Footer Area Styles', 'valeska-core' ),
				)
			);

			$title_footer_area_styles_row = $title_footer_area_styles_section->add_row_element(
				array(
					'name'  => 'qodef_title_footer_area_styles_row',
					'title' => '',
				)
			);

			$title_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_title_footer_area_padding_top',
					'title'      => esc_html__( 'Padding Top', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$title_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_title_footer_area_padding_bottom',
					'title'      => esc_html__( 'Padding Bottom', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$title_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_title_footer_area_side_padding',
					'title'      => esc_html__( 'Side Padding', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$title_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_title_footer_area_background_color',
					'title'      => esc_html__( 'Background Color', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$title_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_title_footer_area_top_border_color',
					'title'      => esc_html__( 'Top Border Color', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$title_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_title_footer_area_top_border_width',
					'title'      => esc_html__( 'Top Border Width', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
						'suffix'    => esc_html__( 'px', 'valeska-core' ),
					),
				)
			);

			$title_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_title_footer_area_top_border_style',
					'title'      => esc_html__( 'Top Border Style', 'valeska-core' ),
					'options'    => valeska_core_get_select_type_options_pool( 'border_style' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			// Top Footer Area Section

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_top_footer_area',
					'title'         => esc_html__( 'Enable Top Footer Area', 'valeska-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable top footer area', 'valeska-core' ),
					'default_value' => 'yes',
				)
			);

			$top_footer_area_section = $page_footer_section->add_section_element(
				array(
					'name'       => 'qodef_top_footer_area_section',
					'title'      => esc_html__( 'Top Footer Area', 'valeska-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_top_footer_area' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_set_footer_top_area_in_grid',
					'title'         => esc_html__( 'Top Footer Area In Grid', 'valeska-core' ),
					'description'   => esc_html__( 'Enabling this option will set page top footer area to be in grid', 'valeska-core' ),
					'default_value' => 'yes',
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_set_footer_top_area_columns',
					'title'         => esc_html__( 'Top Footer Area Columns', 'valeska-core' ),
					'description'   => esc_html__( 'Choose number of columns for top footer area', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'columns_number', true ),
					'default_value' => '6',
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_top_area_grid_gutter',
					'title'       => esc_html__( 'Top Footer Area Grid Gutter', 'valeska-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between columns for top footer area', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$top_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_top_area_content_alignment',
					'title'       => esc_html__( 'Content Alignment', 'valeska-core' ),
					'description' => esc_html__( 'Set widgets content alignment inside top footer area', 'valeska-core' ),
					'options'     => array(
						''       => esc_html__( 'Default', 'valeska-core' ),
						'left'   => esc_html__( 'Left', 'valeska-core' ),
						'center' => esc_html__( 'Center', 'valeska-core' ),
						'right'  => esc_html__( 'Right', 'valeska-core' ),
					),
				)
			);

			$top_footer_area_styles_section = $top_footer_area_section->add_section_element(
				array(
					'name'  => 'qodef_top_footer_area_styles_section',
					'title' => esc_html__( 'Top Footer Area Styles', 'valeska-core' ),
				)
			);

			$top_footer_area_styles_row = $top_footer_area_styles_section->add_row_element(
				array(
					'name'  => 'qodef_top_footer_area_styles_row',
					'title' => '',
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_padding_top',
					'title'      => esc_html__( 'Padding Top', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_padding_bottom',
					'title'      => esc_html__( 'Padding Bottom', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_side_padding',
					'title'      => esc_html__( 'Side Padding', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_top_footer_area_background_color',
					'title'      => esc_html__( 'Background Color', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_top_footer_area_background_image',
					'title'      => esc_html__( 'Background Image', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_top_footer_area_top_border_color',
					'title'      => esc_html__( 'Top Border Color', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_top_footer_area_top_border_width',
					'title'      => esc_html__( 'Top Border Width', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
						'suffix'    => esc_html__( 'px', 'valeska-core' ),
					),
				)
			);

			$top_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_top_footer_area_top_border_style',
					'title'      => esc_html__( 'Top Border Style', 'valeska-core' ),
					'options'    => valeska_core_get_select_type_options_pool( 'border_style' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$top_footer_area_styles_row_2 = $top_footer_area_styles_section->add_row_element(
				array(
					'name'  => 'qodef_top_footer_area_styles_row_2',
					'title' => '',
				)
			);

			$top_footer_area_styles_row_2->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_top_footer_area_widgets_margin_bottom',
					'title'       => esc_html__( 'Widgets Margin Bottom', 'valeska-core' ),
					'description' => esc_html__( 'Set space value between widgets', 'valeska-core' ),
					'args'        => array(
						'col_width' => 4,
					),
				)
			);

			$top_footer_area_styles_row_2->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_top_footer_area_widgets_title_margin_bottom',
					'title'       => esc_html__( 'Widgets Title Margin Bottom', 'valeska-core' ),
					'description' => esc_html__( 'Set space value between widget title and widget content', 'valeska-core' ),
					'args'        => array(
						'col_width' => 4,
					),
				)
			);

			// Bottom Footer Area Section

			$page_footer_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_bottom_footer_area',
					'title'         => esc_html__( 'Enable Bottom Footer Area', 'valeska-core' ),
					'description'   => esc_html__( 'Use this option to enable/disable bottom footer area', 'valeska-core' ),
					'default_value' => 'yes',
				)
			);

			$bottom_footer_area_section = $page_footer_section->add_section_element(
				array(
					'name'       => 'qodef_bottom_footer_area_section',
					'title'      => esc_html__( 'Bottom Footer Area', 'valeska-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_enable_bottom_footer_area' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_set_footer_bottom_area_in_grid',
					'title'         => esc_html__( 'Bottom Footer Area In Grid', 'valeska-core' ),
					'description'   => esc_html__( 'Enabling this option will set page bottom footer area to be in grid', 'valeska-core' ),
					'default_value' => 'yes',
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_set_footer_bottom_area_columns',
					'title'         => esc_html__( 'Bottom Footer Area Columns', 'valeska-core' ),
					'description'   => esc_html__( 'Choose number of columns for bottom footer area', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'columns_number', true, array( '3', '4', '5', '6' ) ),
					'default_value' => '2',
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_bottom_area_grid_gutter',
					'title'       => esc_html__( 'Bottom Footer Area Grid Gutter', 'valeska-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between columns for bottom footer area', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$bottom_footer_area_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_bottom_area_content_alignment',
					'title'       => esc_html__( 'Content Alignment', 'valeska-core' ),
					'description' => esc_html__( 'Set widgets content alignment inside bottom footer area', 'valeska-core' ),
					'options'     => array(
						''              => esc_html__( 'Default', 'valeska-core' ),
						'left'          => esc_html__( 'Left', 'valeska-core' ),
						'center'        => esc_html__( 'Center', 'valeska-core' ),
						'right'         => esc_html__( 'Right', 'valeska-core' ),
						'space-between' => esc_html__( 'Space Between', 'valeska-core' ),
					),
				)
			);

			$bottom_footer_area_styles_section = $bottom_footer_area_section->add_section_element(
				array(
					'name'  => 'qodef_bottom_footer_area_styles_section',
					'title' => esc_html__( 'Bottom Footer Area Styles', 'valeska-core' ),
				)
			);

			$bottom_footer_area_styles_row = $bottom_footer_area_styles_section->add_row_element(
				array(
					'name'  => 'qodef_bottom_footer_area_styles_row',
					'title' => '',
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_padding_top',
					'title'      => esc_html__( 'Padding Top', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_padding_bottom',
					'title'      => esc_html__( 'Padding Bottom', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_side_padding',
					'title'      => esc_html__( 'Side Padding', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_bottom_footer_area_background_color',
					'title'      => esc_html__( 'Background Color', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_bottom_footer_area_top_border_color',
					'title'      => esc_html__( 'Top Border Color', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_bottom_footer_area_top_border_width',
					'title'      => esc_html__( 'Top Border Width', 'valeska-core' ),
					'args'       => array(
						'col_width' => 3,
						'suffix'    => esc_html__( 'px', 'valeska-core' ),
					),
				)
			);

			$bottom_footer_area_styles_row->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_bottom_footer_area_top_border_style',
					'title'      => esc_html__( 'Top Border Style', 'valeska-core' ),
					'options'    => valeska_core_get_select_type_options_pool( 'border_style' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			// Hook to include additional options after module options
			do_action( 'valeska_core_action_after_page_footer_options_map', $page );
		}
	}

	add_action( 'valeska_core_action_default_options_init', 'valeska_core_add_page_footer_options', valeska_core_get_admin_options_map_position( 'footer' ) );
}
