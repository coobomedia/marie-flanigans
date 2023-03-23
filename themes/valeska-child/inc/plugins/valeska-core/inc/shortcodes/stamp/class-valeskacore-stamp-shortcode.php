<?php

if ( ! function_exists( 'valeska_core_add_stamp_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function valeska_core_add_stamp_shortcode( $shortcodes ) {
		$shortcodes[] = 'ValeskaCore_Stamp_Shortcode';

		return $shortcodes;
	}

	add_filter( 'valeska_core_filter_register_shortcodes', 'valeska_core_add_stamp_shortcode' );
}

if ( class_exists( 'ValeskaCore_Shortcode' ) ) {
	class ValeskaCore_Stamp_Shortcode extends ValeskaCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( VALESKA_CORE_SHORTCODES_URL_PATH . '/stamp' );
			$this->set_base( 'valeska_core_stamp' );
			$this->set_name( esc_html__( 'Stamp', 'valeska-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds stamp element', 'valeska-core' ) );
			$this->set_category( esc_html__( 'Valeska Core', 'valeska-core' ) );
			$this->set_scripts(
				array(
					'jquery-appear' => array(
						'registered' => true,
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'text',
					'title'      => esc_html__( 'Stamp Text', 'valeska-core' ),
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
					'field_type' => 'textfield',
					'name'       => 'text_font_size',
					'title'      => esc_html__( 'Text Font Size (px)', 'valeska-core' ),
					'group'      => esc_html__( 'Text Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'centered_text',
					'title'      => esc_html__( 'Centered Text', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'centered_text_color',
					'title'      => esc_html__( 'Centered Text Color', 'valeska-core' ),
					'group'      => esc_html__( 'Centered Text Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'centered_text_font_size',
					'title'      => esc_html__( 'Centered Text Font Size (px)', 'valeska-core' ),
					'group'      => esc_html__( 'Centered Text Style', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'textfield',
					'name'        => 'stamp_size',
					'title'       => esc_html__( 'Stamp Size (px)', 'valeska-core' ),
					'description' => esc_html__( 'Default value is 114', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'disable_stamp',
					'title'      => esc_html__( 'Disable Stamp', 'valeska-core' ),
					'options'    => array(
						''     => esc_html__( 'Never', 'valeska-core' ),
						'1440' => esc_html__( 'Below 1440px', 'valeska-core' ),
						'1280' => esc_html__( 'Below 1280px', 'valeska-core' ),
						'1024' => esc_html__( 'Below 1024px', 'valeska-core' ),
						'768'  => esc_html__( 'Below 768px', 'valeska-core' ),
						'680'  => esc_html__( 'Below 680px', 'valeska-core' ),
						'480'  => esc_html__( 'Below 480px', 'valeska-core' ),
					),
					'group'      => esc_html__( 'Visibility', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'textfield',
					'name'        => 'appearing_delay',
					'title'       => esc_html__( 'Appearing Delay (ms)', 'valeska-core' ),
					'description' => esc_html__( 'Default value is 0', 'valeska-core' ),
					'group'       => esc_html__( 'Visibility', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'absolute_position',
					'title'      => esc_html__( 'Enable Absolute Position', 'valeska-core' ),
					'options'    => valeska_core_get_select_type_options_pool( 'no_yes', false ),
					'group'      => esc_html__( 'Visibility', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'top_position',
					'title'      => esc_html__( 'Top Position (px or %)', 'valeska-core' ),
					'dependency' => array(
						'show' => array(
							'absolute_position' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
					'group'      => esc_html__( 'Visibility', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'bottom_position',
					'title'      => esc_html__( 'Bottom Position (px or %)', 'valeska-core' ),
					'dependency' => array(
						'show' => array(
							'absolute_position' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
					'group'      => esc_html__( 'Visibility', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'left_position',
					'title'      => esc_html__( 'Left Position (px or %)', 'valeska-core' ),
					'dependency' => array(
						'show' => array(
							'absolute_position' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
					'group'      => esc_html__( 'Visibility', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'right_position',
					'title'      => esc_html__( 'Right Position (px or %)', 'valeska-core' ),
					'dependency' => array(
						'show' => array(
							'absolute_position' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
					'group'      => esc_html__( 'Visibility', 'valeska-core' ),
				)
			);
		}

		public function load_assets() {
			wp_enqueue_script( 'jquery-appear' );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes']       = $this->getHolderClasses( $atts );
			$atts['holder_styles']        = $this->getHolderStyles( $atts );
			$atts['centered_text_styles'] = $this->getCenteredTextStyles( $atts );
			$atts['holder_data']          = $this->getHolderData( $atts );
			$atts['text_data']            = $this->getModifiedText( $atts );

			return valeska_core_get_template_part( 'shortcodes/stamp', 'templates/stamp', '', $atts );
		}

		private function getHolderClasses( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-stamp';
			$holder_classes[] = ! empty( $atts['disable_stamp'] ) ? 'qodef-hide-on--' . $atts['disable_stamp'] : '';
			$holder_classes[] = 'yes' === $atts['absolute_position'] ? 'qodef--abs' : '';

			return implode( ' ', $holder_classes );
		}

		private function getHolderStyles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['text_color'] ) ) {
				$styles[] = 'color: ' . $atts['text_color'];
			}

			if ( ! empty( $atts['text_font_size'] ) ) {
				$styles[] = 'font-size: ' . intval( $atts['text_font_size'] ) . 'px';
			}
			if ( ! empty( $atts['text_color'] ) ) {
				$styles[] = 'color: ' . $atts['text_color'];
			}

			if ( ! empty( $atts['stamp_size'] ) ) {
				$styles[] = 'width: ' . intval( $atts['stamp_size'] ) . 'px';
				$styles[] = 'height: ' . intval( $atts['stamp_size'] ) . 'px';
			}

			if ( isset( $atts['top_position'] ) && '' !== $atts['top_position'] ) {
				$styles[] = 'top: ' . $atts['top_position'];
			}
			if ( isset( $atts['bottom_position'] ) && '' !== $atts['bottom_position'] ) {
				$styles[] = 'bottom: ' . $atts['bottom_position'];
			}

			if ( isset( $atts['left_position'] ) && '' !== $atts['left_position'] ) {
				$styles[] = 'left: ' . $atts['left_position'];
			}

			if ( isset( $atts['right_position'] ) && '' !== $atts['right_position'] ) {
				$styles[] = 'right: ' . $atts['right_position'];
			}

			return implode( ';', $styles );
		}

		private function getCenteredTextStyles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['centered_text_font_size'] ) ) {
				$styles[] = 'font-size: ' . intval( $atts['centered_text_font_size'] ) . 'px';
			}
			if ( ! empty( $atts['centered_text_color'] ) ) {
				$styles[] = 'color: ' . $atts['centered_text_color'];
			}

			return implode( ';', $styles );
		}

		private function getHolderData( $atts ) {
			$slider_data = array();

			$slider_data['data-appearing-delay'] = ! empty( $atts['appearing_delay'] ) ? intval( $atts['appearing_delay'] ) : 0;

			return $slider_data;
		}

		private function getModifiedText( $atts ) {
			$text = $atts['text'];
			$data = array(
				'text'  => $this->get_split_text( $text ),
				'count' => count( $this->str_split_unicode( $text ) ),
			);

			return $data;
		}

		private function str_split_unicode( $str ) {
			return preg_split( '~~u', $str, - 1, PREG_SPLIT_NO_EMPTY );
		}

		private function get_split_text( $text ) {
			if ( ! empty( $text ) ) {
				$split_text = $this->str_split_unicode( $text );

				foreach ( $split_text as $key => $value ) {
					$split_text[ $key ] = '<span class="qodef-m-character">' . $value . '</span>';
				}

				return implode( ' ', $split_text );
			}

			return $text;
		}
	}
}
