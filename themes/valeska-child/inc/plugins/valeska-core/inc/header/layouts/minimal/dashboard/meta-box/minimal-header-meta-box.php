<?php

if ( ! function_exists( 'valeska_core_add_minimal_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function valeska_core_add_minimal_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_minimal_header_section',
				'title'      => esc_html__( 'Minimal Header', 'valeska-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'minimal',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_minimal_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'valeska-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'valeska-core' ),
				'default_value' => '',
				'options'       => valeska_core_get_select_type_options_pool( 'no_yes' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_height',
				'title'       => esc_html__( 'Header Height', 'valeska-core' ),
				'description' => esc_html__( 'Enter header height', 'valeska-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'valeska-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'valeska-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'valeska-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'valeska-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_minimal_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'valeska-core' ),
				'description' => esc_html__( 'Enter header background color', 'valeska-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'valeska-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_minimal_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'valeska-core' ),
				'description' => esc_html__( 'Enter header border color', 'valeska-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_border_width',
				'title'       => esc_html__( 'Header Border Width', 'valeska-core' ),
				'description' => esc_html__( 'Enter header border width size', 'valeska-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'valeska-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_minimal_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'valeska-core' ),
				'description' => esc_html__( 'Choose header border style', 'valeska-core' ),
				'options'     => valeska_core_get_select_type_options_pool( 'border_style' ),
			)
		);
	}

	add_action( 'valeska_core_action_after_page_header_meta_map', 'valeska_core_add_minimal_header_meta' );
}
