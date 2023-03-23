<?php

if ( ! function_exists( 'valeska_core_add_standard_mobile_header_options' ) ) {
	/**
	 * Function that add additional header layout options
	 *
	 * @param object $page
	 * @param array $general_tab
	 */
	function valeska_core_add_standard_mobile_header_options( $page, $general_tab ) {

		$section = $general_tab->add_section_element(
			array(
				'name'       => 'qodef_standard_mobile_header_section',
				'title'      => esc_html__( 'Standard Mobile Header', 'valeska-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_mobile_header_layout' => array(
							'values'        => 'standard',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_mobile_header_height',
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
				'name'        => 'qodef_standard_mobile_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'valeska-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'valeska-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'valeska-core' ),
				),
				'dependency'  => array(
					'show' => array(
						'qodef_mobile_header_in_grid' => array(
							'values'        => 'no',
							'default_value' => 'no',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_standard_mobile_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'valeska-core' ),
				'description' => esc_html__( 'Enter header background color', 'valeska-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'valeska-core' ),
				),
			)
		);
	}

	add_action( 'valeska_core_action_after_mobile_header_options_map', 'valeska_core_add_standard_mobile_header_options', 10, 2 );
}
