<?php

if ( ! function_exists( 'valeska_core_add_stacked_images_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function valeska_core_add_stacked_images_shortcode( $shortcodes ) {
		$shortcodes[] = 'ValeskaCore_Stacked_Images_Shortcode';

		return $shortcodes;
	}

	add_filter( 'valeska_core_filter_register_shortcodes', 'valeska_core_add_stacked_images_shortcode' );
}

if ( class_exists( 'ValeskaCore_Shortcode' ) ) {
	class ValeskaCore_Stacked_Images_Shortcode extends ValeskaCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'valeska_core_filter_stacked_images_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'valeska_core_filter_stacked_images_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( VALESKA_CORE_SHORTCODES_URL_PATH . '/stacked-images' );
			$this->set_base( 'valeska_core_stacked_images' );
			$this->set_name( esc_html__( 'Stacked Images', 'valeska-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds image with text element', 'valeska-core' ) );
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
					'field_type'    => 'select',
					'name'          => 'parallax_item',
					'title'         => esc_html__( 'Enable Parallax Item', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'yes_no' ),
					'default_value' => '',
				)
			);

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'zoom_scroll',
					'title'         => esc_html__( 'Enable Zoom Scroll', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'yes_no' ),
					'default_value' => '',
				)
			);

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'enable_main_video',
					'title'         => esc_html__( 'Enable Main Video', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'yes_no' ),
					'default_value' => '',
				)
			);

			$options_map = valeska_core_get_variations_options_map( $this->get_layouts() );

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'layout',
					'title'         => esc_html__( 'Layout', 'valeska-core' ),
					'options'       => $this->get_layouts(),
					'default_value' => $options_map['default_value'],
					'visibility'    => array( 'map_for_page_builder' => $options_map['visibility'] ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'main_video',
					'title'      => esc_html__( 'Main Video', 'valeska-core' ),
					'description' => esc_html__( 'Self-Hosted video only.', 'valeska-core' ),
					'dependency'  => array(
						'show' => array(
							'enable_main_video' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'main_image',
					'title'      => esc_html__( 'Main Image', 'valeska-core' ),
					'dependency'  => array(
						'hide' => array(
							'enable_main_video' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'images_proportion',
					'default_value' => 'full',
					'title'         => esc_html__( 'Image Proportions', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'list_image_dimension', false ),
					'dependency'  => array(
						'hide' => array(
							'enable_main_video' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'custom_image_width',
					'title'       => esc_html__( 'Custom Image Width', 'valeska-core' ),
					'description' => esc_html__( 'Enter image width in px', 'valeska-core' ),
					'dependency'  => array(
						'show' => array(
							'images_proportion' => array(
								'values'        => 'custom',
								'default_value' => 'full',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'custom_image_height',
					'title'       => esc_html__( 'Custom Image Height', 'valeska-core' ),
					'description' => esc_html__( 'Enter image height in px', 'valeska-core' ),
					'dependency'  => array(
						'show' => array(
							'images_proportion' => array(
								'values'        => 'custom',
								'default_value' => 'full',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Image Items', 'valeska-core' ),
					'items'      => array(
						array(
							'field_type' => 'image',
							'name'       => 'item_image',
							'title'      => esc_html__( 'Item Image', 'valeska-core' ),
						),
						array(
							'field_type'    => 'select',
							'name'          => 'images_proportion',
							'default_value' => 'full',
							'title'         => esc_html__( 'Image Proportions', 'valeska-core' ),
							'options'       => valeska_core_get_select_type_options_pool( 'list_image_dimension', false ),
						),
						array(
							'field_type'  => 'text',
							'name'        => 'custom_image_width',
							'title'       => esc_html__( 'Custom Image Width', 'valeska-core' ),
							'description' => esc_html__( 'Enter image width in px', 'valeska-core' ),
							'dependency'  => array(
								'show' => array(
									'images_proportion' => array(
										'values'        => 'custom',
										'default_value' => 'full',
									),
								),
							),
						),
						array(
							'field_type'  => 'text',
							'name'        => 'custom_image_height',
							'title'       => esc_html__( 'Custom Image Height', 'valeska-core' ),
							'description' => esc_html__( 'Enter image height in px', 'valeska-core' ),
							'dependency'  => array(
								'show' => array(
									'images_proportion' => array(
										'values'        => 'custom',
										'default_value' => 'full',
									),
								),
							),
						),
						array(
							'field_type'    => 'select',
							'name'          => 'item_vertical_anchor',
							'title'         => esc_html__( 'Image Vertical Anchor', 'valeska-core' ),
							'options'       => array(
								'top'    => esc_html__( 'Top', 'valeska-core' ),
								'bottom' => esc_html__( 'Bottom', 'valeska-core' ),
							),
							'default_value' => 'top',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_vertical_position',
							'title'         => esc_html__( 'Image Vertical Position', 'valeska-core' ),
							'default_value' => '25%',
						),
						array(
							'field_type'    => 'select',
							'name'          => 'item_horizontal_anchor',
							'title'         => esc_html__( 'Image Horizontal Anchor', 'valeska-core' ),
							'options'       => array(
								'left'  => esc_html__( 'Left', 'valeska-core' ),
								'right' => esc_html__( 'Right', 'valeska-core' ),
							),
							'default_value' => 'left',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_horizontal_position',
							'title'         => esc_html__( 'Image Horizontal Position', 'valeska-core' ),
							'default_value' => '25%',
						),
					),
				)
			);
			$this->map_extra_options();
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'valeska_core_stacked_images', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function load_assets() {
			wp_enqueue_script( 'jquery-appear' );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['item_classes']   = $this->get_item_classes( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );

			return valeska_core_get_template_part( 'shortcodes/stacked-images', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-stacked-images';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
            $holder_classes[] = ! empty( $atts['parallax_item'] ) && ( 'yes' === $atts['parallax_item'] ) ? 'qodef-parallax-item' : '';
            $holder_classes[] = ! empty( $atts['zoom_scroll'] ) && ( 'yes' === $atts['zoom_scroll'] ) ? 'qodef-zoom-scroll' : '';

			return implode( ' ', $holder_classes );
		}

		public function get_item_classes( $atts ) {
			$item_classes = array();

			$item_classes[] = 'qodef-m-image';

			return $item_classes;
		}
	}
}
