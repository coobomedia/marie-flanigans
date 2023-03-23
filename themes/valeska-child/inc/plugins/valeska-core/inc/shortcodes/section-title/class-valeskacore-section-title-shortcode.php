<?php

if ( ! function_exists( 'valeska_core_add_section_title_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function valeska_core_add_section_title_shortcode( $shortcodes ) {
		$shortcodes[] = 'ValeskaCore_Section_Title_Shortcode';

		return $shortcodes;
	}

	add_filter( 'valeska_core_filter_register_shortcodes', 'valeska_core_add_section_title_shortcode' );
}

if ( class_exists( 'ValeskaCore_Shortcode' ) ) {
	class ValeskaCore_Section_Title_Shortcode extends ValeskaCore_Shortcode {

		public function map_shortcode() {

			$this->set_shortcode_path( VALESKA_CORE_SHORTCODES_URL_PATH . '/section-title' );
			$this->set_base( 'valeska_core_section_title' );
			$this->set_name( esc_html__( 'Section Title', 'valeska-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds section title element', 'valeska-core' ) );
			$this->set_category( esc_html__( 'Valeska Core', 'valeska-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title',
					'title'      => esc_html__( 'Title', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'text',
					'name'          => 'line_break_positions',
					'title'         => esc_html__( 'Positions of Line Break', 'valeska-core' ),
					'description'   => esc_html__( 'Enter the positions of the words after which you would like to create a line break. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have a line break, you would enter "1,3,4")', 'valeska-core' ),
					'default_value' => '-1',
					'group'         => esc_html__( 'Title Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'text',
					'name'          => 'italic_word_positions',
					'title'         => esc_html__( 'Positions of Italic Word', 'valeska-core' ),
					'description'   => esc_html__( 'Enter the positions of the italic words after which you would like to create a line break. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have a line break, you would enter "1,3,4")', 'valeska-core' ),
					'default_value' => '-1',
					'group'         => esc_html__( 'Title Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'disable_title_break_words',
					'title'         => esc_html__( 'Disable Title Line Break', 'valeska-core' ),
					'description'   => esc_html__( 'Enabling this option will disable title line breaks for screen size 1024 and lower', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'no_yes', false ),
					'default_value' => 'no',
					'group'         => esc_html__( 'Title Style', 'valeska-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'h2',
					'group'         => esc_html__( 'Title Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'title_color',
					'title'      => esc_html__( 'Title Color', 'valeska-core' ),
					'group'      => esc_html__( 'Title Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title_font_size',
					'title'      => esc_html__( 'Title Font Size', 'valeska-core' ),
					'group'      => esc_html__( 'Title Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title_font_weight',
					'title'      => esc_html__( 'Title Font Weight', 'valeska-core' ),
					'group'      => esc_html__( 'Title Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'subtitle',
					'title'      => esc_html__( 'Subtitle', 'valeska-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'subtitle_color',
					'title'      => esc_html__( 'Subtitle Color', 'valeska-core' ),
					'group'      => esc_html__( 'Subtitle Style', 'valeska-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'subtitle_font_size',
					'title'      => esc_html__( 'Subtitle Font Size', 'valeska-core' ),
					'group'      => esc_html__( 'Subtitle Style', 'valeska-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'link',
					'title'      => esc_html__( 'Title Custom Link', 'valeska-core' ),
					'group'      => esc_html__( 'Title Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'target',
					'title'         => esc_html__( 'Custom Link Target', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
					'dependency'    => array(
						'show' => array(
							'image_action' => array(
								'values'        => 'custom-link',
								'default_value' => '',
							),
						),
					),
					'group'         => esc_html__( 'Title Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'text',
					'title'      => esc_html__( 'Text', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'section_title_text',
					'title'      => esc_html__( 'Text', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_color',
					'title'      => esc_html__( 'Text Color', 'valeska-core' ),
					'group'      => esc_html__( 'Text Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text_margin_top',
					'title'      => esc_html__( 'Text Margin Top', 'valeska-core' ),
					'group'      => esc_html__( 'Text Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text_font_size',
					'title'      => esc_html__( 'Text Font Size', 'valeska-core' ),
					'group'      => esc_html__( 'Text Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'content_alignment',
					'title'      => esc_html__( 'Content Alignment', 'valeska-core' ),
					'options'    => array(
						''       => esc_html__( 'Default', 'valeska-core' ),
						'left'   => esc_html__( 'Left', 'valeska-core' ),
						'center' => esc_html__( 'Center', 'valeska-core' ),
						'right'  => esc_html__( 'Right', 'valeska-core' ),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'enable_button',
					'title'         => esc_html__( 'Enable Button', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'yes_no', false ),
					'default_value' => 'no',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'appear_animation',
					'title'         => esc_html__( 'Enable Appear Animation', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'yes_no', false ),
					'default_value' => 'no',
					'group'         => esc_html__( 'Animation Options', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'wait_for_trigger',
					'title'         => esc_html__( 'Wait For Trigger', 'valeska-core' ),
					'description'   => esc_html__( 'Enabling this option will delay appear animation until external trigger is activated', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'yes_no', false ),
					'default_value' => 'no',
					'dependency'    => array(
						'show' => array(
							'appear_animation' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
					'group'         => esc_html__( 'Animation Options', 'valeska-core' ),
				)
			);
			$this->import_shortcode_options(
				array(
					'shortcode_base'    => 'valeska_core_button',
					'exclude'           => array( 'custom_class' ),
					'additional_params' => array(
						'nested_group' => esc_html__( 'Button', 'valeska-core' ),
						'dependency'   => array(
							'show' => array(
								'enable_button' => array(
									'values'        => 'yes',
									'default_value' => 'no',
								),
							),
						),
					),
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes']  = $this->get_holder_classes( $atts );
			$atts['title']           = $this->get_modified_title( $atts );
			$atts['title_styles']    = $this->get_title_styles( $atts );
			$atts['subtitle_styles'] = $this->get_subtitle_styles( $atts );
			$atts['text_styles']     = $this->get_text_styles( $atts );
			$atts['button_params']   = $this->generate_button_params( $atts );

			return valeska_core_get_template_part( 'shortcodes/section-title', 'templates/section-title', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-section-title';
			$holder_classes[] = ! empty( $atts['content_alignment'] ) ? 'qodef-alignment--' . $atts['content_alignment'] : 'qodef-alignment--left';
			$holder_classes[] = 'yes' === $atts['disable_title_break_words'] ? 'qodef-title-break--disabled' : '';
			$holder_classes[] = ! empty( $atts['appear_animation'] ) ? 'qodef-section-title-appear-animation--' . $atts['appear_animation'] : '';
			$holder_classes[] = ! empty( $atts['wait_for_trigger'] ) && 'yes' === $atts['wait_for_trigger'] ? 'qodef-wait-for-trigger' : '';

			return implode( ' ', $holder_classes );
		}

		private function get_modified_title( $atts ) {
			$title = $atts['title'];

			if ( ! empty( $title ) ) {
				if ( ( ! empty( $atts['line_break_positions'] ) ) || ( ! empty( $atts['italic_word_positions'] ) ) ) {
					$split_title          = explode( ' ', $title );
					$line_break_positions = explode( ',', str_replace( ' ', '', $atts['line_break_positions'] ) );
					$italic_words         = explode( ',', str_replace( ' ', '', $atts['italic_word_positions'] ) );

					foreach ( $line_break_positions as $position ) {
						$position = intval( $position );
						if ( isset( $split_title[ $position - 1 ] ) && ! empty( $split_title[ $position - 1 ] ) ) {
							$split_title[ $position - 1 ] = $split_title[ $position - 1 ] . '<br />';
						}
					}
					foreach ( $italic_words as $position ) {
						$position = intval( $position );
						if ( ! empty( $split_title[ $position - 1 ] ) ) {
							$split_title[ $position - 1 ] = '<span class="qodef-m-title-italic">' . $split_title[ $position - 1 ] . '</span>';
						}
					}
				}
				$title = implode( ' ', $split_title );
			}


			return $title;
		}

		private function get_title_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['title_color'] ) ) {
				$styles[] = 'color: ' . $atts['title_color'];
			}
			if ( '' !== $atts['title_font_size'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['title_font_size'] ) ) {
					$styles[] = 'font-size: ' . $atts['title_font_size'];
				} else {
					$styles[] = 'font-size: ' . intval( $atts['title_font_size'] ) . 'px';
				}
			}
			if ( '' !== $atts['title_font_weight'] ) {
				$styles[] = 'font-weight: ' . $atts['title_font_weight'];
			}

			return $styles;
		}

		private function get_subtitle_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['subtitle_color'] ) ) {
				$styles[] = 'color: ' . $atts['subtitle_color'];
			}
			if ( '' !== $atts['subtitle_font_size'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['subtitle_font_size'] ) ) {
					$styles[] = 'font-size: ' . $atts['subtitle_font_size'];
				} else {
					$styles[] = 'font-size: ' . intval( $atts['subtitle_font_size'] ) . 'px';
				}
			}

			return $styles;
		}


		private function get_text_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['text_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['text_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['text_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['text_margin_top'] ) . 'px';
				}
			}

			if ( ! empty( $atts['text_color'] ) ) {
				$styles[] = 'color: ' . $atts['text_color'];
			}

			if ( '' !== $atts['text_font_size'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['text_font_size'] ) ) {
					$styles[] = 'font-size: ' . $atts['text_font_size'];
				} else {
					$styles[] = 'font-size: ' . intval( $atts['text_font_size'] ) . 'px';
				}
			}

			return $styles;
		}

		private function generate_button_params( $atts ) {
			$params = $this->populate_imported_shortcode_atts(
				array(
					'shortcode_base' => 'valeska_core_button',
					'exclude'        => array( 'custom_class' ),
					'atts'           => $atts,
				)
			);

			return $params;
		}
	}
}
