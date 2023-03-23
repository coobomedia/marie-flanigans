<?php

if ( ! function_exists( 'valeska_core_add_team_single_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function valeska_core_add_team_single_meta_box() {
		$qode_framework = qode_framework_get_framework_root();
		$has_single     = valeska_core_team_has_single();

		$page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'team' ),
				'type'  => 'meta',
				'slug'  => 'team',
				'title' => esc_html__( 'Team Single', 'valeska-core' ),
			)
		);

		if ( $page ) {
			$section = $page->add_section_element(
				array(
					'name'        => 'qodef_team_general_section',
					'title'       => esc_html__( 'General Settings', 'valeska-core' ),
					'description' => esc_html__( 'General information about team member.', 'valeska-core' ),
				)
			);

			if ( $has_single ) {
				$section->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_team_single_layout',
						'title'       => esc_html__( 'Single Layout', 'valeska-core' ),
						'description' => esc_html__( 'Choose default layout for team single', 'valeska-core' ),
						'options'     => array(
							'' => esc_html__( 'Default', 'valeska-core' ),
						),
					)
				);
			}

			$section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_team_member_role',
					'title'       => esc_html__( 'Role', 'valeska-core' ),
					'description' => esc_html__( 'Enter team member role', 'valeska-core' ),
				)
			);

			$social_icons_repeater = $section->add_repeater_element(
				array(
					'name'        => 'qodef_team_member_social_icons',
					'title'       => esc_html__( 'Social Networks', 'masterds-core' ),
					'description' => esc_html__( 'Populate team member social networks info', 'masterds-core' ),
					'button_text' => esc_html__( 'Add New Network', 'masterds-core' ),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_team_member_icon_text',
					'title'      => esc_html__( 'Icon Text', 'masterds-core' ),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_team_member_icon_link',
					'title'      => esc_html__( 'Icon Link', 'valeska-core' ),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_team_member_icon_target',
					'title'      => esc_html__( 'Icon Target', 'valeska-core' ),
					'options'    => valeska_core_get_select_type_options_pool( 'link_target' ),
				)
			);

			if ( $has_single ) {
				$section->add_field_element(
					array(
						'field_type'  => 'date',
						'name'        => 'qodef_team_member_birth_date',
						'title'       => esc_html__( 'Birth Date', 'valeska-core' ),
						'description' => esc_html__( 'Enter team member birth date', 'valeska-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_email',
						'title'       => esc_html__( 'E-mail', 'valeska-core' ),
						'description' => esc_html__( 'Enter team member e-mail address', 'valeska-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_address',
						'title'       => esc_html__( 'Address', 'valeska-core' ),
						'description' => esc_html__( 'Enter team member address', 'valeska-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_education',
						'title'       => esc_html__( 'Education', 'valeska-core' ),
						'description' => esc_html__( 'Enter team member education', 'valeska-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'file',
						'name'        => 'qodef_team_member_resume',
						'title'       => esc_html__( 'Resume', 'valeska-core' ),
						'description' => esc_html__( 'Upload team member resume', 'valeska-core' ),
						'args'        => array(
							'allowed_type' => '[application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
						),
					)
				);
			}

			// Hook to include additional options after module options
			do_action( 'valeska_core_action_after_team_meta_box_map', $page, $has_single );
		}
	}

	add_action( 'valeska_core_action_default_meta_boxes_init', 'valeska_core_add_team_single_meta_box' );
}
