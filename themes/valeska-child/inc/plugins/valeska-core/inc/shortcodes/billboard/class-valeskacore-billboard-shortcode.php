<?php

if ( ! function_exists( 'valeska_core_add_billboard_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function valeska_core_add_billboard_shortcode( $shortcodes ) {
		$shortcodes[] = 'ValeskaCore_Billboard_Shortcode';

		return $shortcodes;
	}

	add_filter( 'valeska_core_filter_register_shortcodes', 'valeska_core_add_billboard_shortcode' );
}

if ( class_exists( 'ValeskaCore_Shortcode' ) ) {
	class ValeskaCore_Billboard_Shortcode extends ValeskaCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'valeska_core_filter_billboard_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'valeska_core_filter_billboard_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( VALESKA_CORE_SHORTCODES_URL_PATH . '/billboard' );
			$this->set_base( 'valeska_core_billboard' );
			$this->set_name( esc_html__( 'Billboard', 'valeska-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds billboard element', 'valeska-core' ) );
			$this->set_category( esc_html__( 'Valeska Core', 'valeska-core' ) );
			$this->set_scripts(
				array(
					'skrollr' => array(
						'registered' => false,
						'url'        => VALESKA_CORE_INC_URL_PATH . '/shortcodes/billboard/assets/js/plugins/skrollr.min.js',
						'dependency' => array( 'jquery' ),
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
					'field_type'  => 'text',
					'name'        => 'height_offset',
					'title'       => esc_html__( 'Height Offset', 'valeska-core' ),
					'description' => esc_html__( 'Enter offset which would reduce the height (100% of the active window) of the shortcode.', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'background_image',
					'title'      => esc_html__( 'Background Image', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'orientations',
					'title'      => esc_html__( 'Image Orientations', 'valeska-core' ),
					'options'    => array(
						'left'  => esc_html__( 'Left', 'valeska-core' ),
						'right' => esc_html__( 'Right', 'valeska-core' ),
					),
				)
			);
			$this->set_option(
				array(
					'name'          => 'enable_scale_effect',
					'field_type'    => 'select',
					'title'         => esc_html__( 'Enable Scale Effect', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'no_yes' ),
					'default_value' => 'no',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title',
					'title'      => esc_html__( 'Title', 'valeska-core' ),
					'group'      => esc_html__( 'Content', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'h2',
					'group'         => esc_html__( 'Content', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'title_color',
					'title'      => esc_html__( 'Title Color', 'valeska-core' ),
					'group'      => esc_html__( 'Content', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title_margin_top',
					'title'      => esc_html__( 'Title Margin Top', 'valeska-core' ),
					'group'      => esc_html__( 'Content', 'valeska-core' ),
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
					'field_type' => 'text',
					'name'       => 'text_field',
					'title'      => esc_html__( 'Text', 'valeska-core' ),
					'group'      => esc_html__( 'Content', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'text_tag',
					'title'         => esc_html__( 'Text Tag', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'p',
					'group'         => esc_html__( 'Content', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_color',
					'title'      => esc_html__( 'Text Color', 'valeska-core' ),
					'group'      => esc_html__( 'Content', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text_margin_top',
					'title'      => esc_html__( 'Text Margin Top', 'valeska-core' ),
					'group'      => esc_html__( 'Content', 'valeska-core' ),
				)
			);
			$this->import_shortcode_options(
				array(
					'shortcode_base'    => 'valeska_core_button',
					'exclude'           => array( 'custom_class' ),
					'additional_params' => array(
						'group' => esc_html__( 'Button', 'valeska-core' ),
					),
				)
			);

			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['holder_styles']  = $this->get_holder_styles( $atts );
			$atts['title']          = $this->get_modified_title( $atts );
			$atts['title_styles']   = $this->get_title_styles( $atts );
			$atts['text_styles']    = $this->get_text_styles( $atts );
			$atts['button_params']  = $this->generate_button_params( $atts );
			$atts['image_style']    = $this->get_image_style( $atts );
			$atts['data_attrs']     = $this->get_data_attrs( $atts );

			return valeska_core_get_template_part( 'shortcodes/billboard', 'templates/billboard', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-billboard';
			$holder_classes[] = ! empty( $atts['orientations'] ) ? 'qodef-image-orientations--' . $atts['orientations'] : '';
			$holder_classes[] = ( 'yes' === $atts['enable_scale_effect'] ) ? 'qodef-effect--scale' : '';
			$holder_classes[] = 'yes' === $atts['disable_title_break_words'] ? 'qodef-title-break--disabled' : '';

			return implode( ' ', $holder_classes );
		}
		private function get_modified_title( $atts ) {
			$title = $atts['title'];

			if ( ! empty( $title ) ) {
				if ( ! empty( $atts['line_break_positions'] ) ) {
					$split_title          = explode( ' ', $title );
					$line_break_positions = explode( ',', str_replace( ' ', '', $atts['line_break_positions'] ) );

					foreach ( $line_break_positions as $position ) {
						$position = intval( $position );
						if ( isset( $split_title[ $position - 1 ] ) && ! empty( $split_title[ $position - 1 ] ) ) {
							$split_title[ $position - 1 ] = $split_title[ $position - 1 ] . '<br />';
						}
					}
				}

				$title = implode( ' ', $split_title );
			}

			return $title;
		}

		private function get_holder_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['height_offset'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['height_offset'], true ) ) {
					$styles[] = 'height: calc(100vh - ' . $atts['height_offset'] . ')';
				} else {
					$styles[] = 'height: calc(100vh - ' . intval( $atts['height_offset'] ) . 'px)';
				}
			}

			return $styles;
		}

		private function get_title_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['title_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['title_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['title_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['title_margin_top'] ) . 'px';
				}
			}

			if ( ! empty( $atts['title_color'] ) ) {
				$styles[] = 'color: ' . $atts['title_color'];
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

		private function get_image_style( $atts ) {
			$image_style = array();

			if ( 'yes' === $atts['enable_scale_effect'] && ! empty( $atts['background_image'] ) ) {
				$image_style[] = 'background-image: url("' . wp_get_attachment_image_src( $atts['background_image'], 'full' )[0] . '");';
			}

			return $image_style;
		}

		private function get_data_attrs( $atts ) {
			$data = array();

			if ( 'yes' === $atts['enable_scale_effect'] ) {
				$data['data-bottom-top'] = 'transform: scale(1);';
				$data['data-top-bottom'] = 'transform: scale(1.08);';
			}

			return $data;
		}
	}
}
