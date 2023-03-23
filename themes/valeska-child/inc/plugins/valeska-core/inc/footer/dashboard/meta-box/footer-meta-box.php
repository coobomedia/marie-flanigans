<?php

if ( ! function_exists( 'valeska_core_add_page_footer_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function valeska_core_add_page_footer_meta_box( $page ) {

		if ( $page ) {
			$custom_sidebars = valeska_core_get_custom_sidebars();
			$footer_columns  = apply_filters( 'valeska_core_filter_footer_areas_columns_size', array() );

			$footer_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-footer',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Footer Settings', 'valeska-core' ),
					'description' => esc_html__( 'Footer layout settings', 'valeska-core' ),
				)
			);

			$footer_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_enable_page_footer',
					'title'       => esc_html__( 'Enable Page Footer', 'valeska-core' ),
					'description' => esc_html__( 'Use this option to enable/disable page footer', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			$page_footer_section = $footer_tab->add_section_element(
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
					'field_type'  => 'select',
					'name'        => 'qodef_enable_uncovering_footer',
					'title'       => esc_html__( 'Enable Uncovering Footer', 'valeska-core' ),
					'description' => esc_html__( 'Enabling this option will make Footer gradually appear on scroll', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'no_yes' ),
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
					'field_type'  => 'select',
					'name'        => 'qodef_enable_top_footer_area',
					'title'       => esc_html__( 'Enable Top Footer Area', 'valeska-core' ),
					'description' => esc_html__( 'Use this option to enable/disable top footer area', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'no_yes' ),
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
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_top_area_in_grid',
					'title'       => esc_html__( 'Top Footer Area in Grid', 'valeska-core' ),
					'description' => esc_html__( 'Enabling this option will set page top footer area to be in grid', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			if ( isset( $footer_columns['footer_top_sidebars_number'] ) && ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				for ( $i = 1; $i <= intval( $footer_columns['footer_top_sidebars_number'] ); $i ++ ) {
					$top_footer_area_section->add_field_element(
						array(
							'field_type'  => 'select',
							'name'        => 'qodef_footer_top_area_custom_widget_' . $i,
							'title'       => sprintf( esc_html__( 'Custom Footer Top Area - Column %s', 'valeska-core' ), $i ),
							'description' => sprintf( esc_html__( 'Widgets added here will appear in the %s column of top footer area', 'valeska-core' ), $i ),
							'options'     => $custom_sidebars,
						)
					);
				}
			}

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
					'field_type'  => 'select',
					'name'        => 'qodef_enable_bottom_footer_area',
					'title'       => esc_html__( 'Enable Bottom Footer Area', 'valeska-core' ),
					'description' => esc_html__( 'Use this option to enable/disable bottom footer area', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'no_yes' ),
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
					'field_type'  => 'select',
					'name'        => 'qodef_set_footer_bottom_area_in_grid',
					'title'       => esc_html__( 'Bottom Footer Area in Grid', 'valeska-core' ),
					'description' => esc_html__( 'Enabling this option will set page bottom footer area to be in grid', 'valeska-core' ),
					'options'     => valeska_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			if ( isset( $footer_columns['footer_bottom_sidebars_number'] ) && ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				for ( $i = 1; $i <= intval( $footer_columns['footer_bottom_sidebars_number'] ); $i ++ ) {
					$bottom_footer_area_section->add_field_element(
						array(
							'field_type'  => 'select',
							'name'        => 'qodef_footer_bottom_area_custom_widget_' . $i,
							'title'       => sprintf( esc_html__( 'Custom Footer Bottom Area - Column %s', 'valeska-core' ), $i ),
							'description' => sprintf( esc_html__( 'Widgets added here will appear in the %s column of bottom footer area', 'valeska-core' ), $i ),
							'options'     => $custom_sidebars,
						)
					);
				}
			}

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
			do_action( 'valeska_core_action_after_page_footer_meta_box_map', $footer_tab );
		}
	}

	add_action( 'valeska_core_action_after_general_meta_box_map', 'valeska_core_add_page_footer_meta_box' );
}
