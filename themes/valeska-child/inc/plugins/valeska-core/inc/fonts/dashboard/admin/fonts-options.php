<?php

if ( ! function_exists( 'valeska_core_add_fonts_options' ) ) {
	/**
	 * Function that add options for this module
	 */
	function valeska_core_add_fonts_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => VALESKA_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'fonts',
				'title'       => esc_html__( 'Fonts', 'valeska-core' ),
				'description' => esc_html__( 'Global Fonts Options', 'valeska-core' ),
				'icon'        => 'fa fa-cog',
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_google_fonts',
					'title'         => esc_html__( 'Enable Google Fonts', 'valeska-core' ),
					'default_value' => 'yes',
					'args'          => array(
						'custom_class' => 'qodef-enable-google-fonts',
					),
				)
			);

			$google_fonts_section = $page->add_section_element(
				array(
					'name'       => 'qodef_google_fonts_section',
					'title'      => esc_html__( 'Google Fonts Options', 'valeska-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_enable_google_fonts' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_repeater = $google_fonts_section->add_repeater_element(
				array(
					'name'        => 'qodef_choose_google_fonts',
					'title'       => esc_html__( 'Google Fonts to Include', 'valeska-core' ),
					'description' => esc_html__( 'Choose Google Fonts which you want to use on your website', 'valeska-core' ),
					'button_text' => esc_html__( 'Add New Google Font', 'valeska-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type'  => 'googlefont',
					'name'        => 'qodef_choose_google_font',
					'title'       => esc_html__( 'Google Font', 'valeska-core' ),
					'description' => esc_html__( 'Choose Google Font', 'valeska-core' ),
					'args'        => array(
						'include' => 'google-fonts',
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_weight',
					'title'       => esc_html__( 'Google Fonts Weight', 'valeska-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts weights for your website. Impact on page load time', 'valeska-core' ),
					'options'     => array(
						'100'  => esc_html__( '100 Thin', 'valeska-core' ),
						'100i' => esc_html__( '100 Thin Italic', 'valeska-core' ),
						'200'  => esc_html__( '200 Extra-Light', 'valeska-core' ),
						'200i' => esc_html__( '200 Extra-Light Italic', 'valeska-core' ),
						'300'  => esc_html__( '300 Light', 'valeska-core' ),
						'300i' => esc_html__( '300 Light Italic', 'valeska-core' ),
						'400'  => esc_html__( '400 Regular', 'valeska-core' ),
						'400i' => esc_html__( '400 Regular Italic', 'valeska-core' ),
						'500'  => esc_html__( '500 Medium', 'valeska-core' ),
						'500i' => esc_html__( '500 Medium Italic', 'valeska-core' ),
						'600'  => esc_html__( '600 Semi-Bold', 'valeska-core' ),
						'600i' => esc_html__( '600 Semi-Bold Italic', 'valeska-core' ),
						'700'  => esc_html__( '700 Bold', 'valeska-core' ),
						'700i' => esc_html__( '700 Bold Italic', 'valeska-core' ),
						'800'  => esc_html__( '800 Extra-Bold', 'valeska-core' ),
						'800i' => esc_html__( '800 Extra-Bold Italic', 'valeska-core' ),
						'900'  => esc_html__( '900 Ultra-Bold', 'valeska-core' ),
						'900i' => esc_html__( '900 Ultra-Bold Italic', 'valeska-core' ),
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_subset',
					'title'       => esc_html__( 'Google Fonts Style', 'valeska-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts style for your website. Impact on page load time', 'valeska-core' ),
					'options'     => array(
						'latin'        => esc_html__( 'Latin', 'valeska-core' ),
						'latin-ext'    => esc_html__( 'Latin Extended', 'valeska-core' ),
						'cyrillic'     => esc_html__( 'Cyrillic', 'valeska-core' ),
						'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'valeska-core' ),
						'greek'        => esc_html__( 'Greek', 'valeska-core' ),
						'greek-ext'    => esc_html__( 'Greek Extended', 'valeska-core' ),
						'vietnamese'   => esc_html__( 'Vietnamese', 'valeska-core' ),
					),
				)
			);

			$page_repeater = $page->add_repeater_element(
				array(
					'name'        => 'qodef_custom_fonts',
					'title'       => esc_html__( 'Custom Fonts', 'valeska-core' ),
					'description' => esc_html__( 'Add custom fonts', 'valeska-core' ),
					'button_text' => esc_html__( 'Add New Custom Font', 'valeska-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_ttf',
					'title'      => esc_html__( 'Custom Font TTF', 'valeska-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_otf',
					'title'      => esc_html__( 'Custom Font OTF', 'valeska-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff',
					'title'      => esc_html__( 'Custom Font WOFF', 'valeska-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff2',
					'title'      => esc_html__( 'Custom Font WOFF2', 'valeska-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_custom_font_name',
					'title'      => esc_html__( 'Custom Font Name', 'valeska-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'valeska_core_action_after_page_fonts_options_map', $page );
		}
	}

	add_action( 'valeska_core_action_default_options_init', 'valeska_core_add_fonts_options', valeska_core_get_admin_options_map_position( 'fonts' ) );
}
