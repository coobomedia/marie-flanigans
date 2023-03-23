<?php

if ( ! function_exists( 'valeska_core_add_item_showcase_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function valeska_core_add_item_showcase_shortcode( $shortcodes ) {
		$shortcodes[] = 'ValeskaCore_Item_Showcase_Shortcode';

		return $shortcodes;
	}

	add_filter( 'valeska_core_filter_register_shortcodes', 'valeska_core_add_item_showcase_shortcode' );
}

if ( class_exists( 'ValeskaCore_Shortcode' ) ) {
	class ValeskaCore_Item_Showcase_Shortcode extends ValeskaCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'valeska_core_filter_item_showcase_layouts', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( VALESKA_CORE_SHORTCODES_URL_PATH . '/item-showcase' );
			$this->set_base( 'valeska_core_item_showcase' );
			$this->set_name( esc_html__( 'Item Showcase', 'valeska-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds item showcase holder', 'valeska-core' ) );
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
					'field_type' => 'image',
					'name'       => 'main_image',
					'title'      => esc_html__( 'Image', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'main_image_offset',
					'title'      => esc_html__( 'Image Top Offset', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Child elements', 'valeska-core' ),
					'items'      => array(
						array(
							'field_type' => 'text',
							'name'       => 'item_title',
							'title'      => esc_html__( 'Title', 'valeska-core' ),
						),
						array(
							'field_type' => 'select',
							'name'       => 'item_title_tag',
							'title'      => esc_html__( 'Title Tag', 'valeska-core' ),
							'options'    => valeska_core_get_select_type_options_pool( 'title_tag', false ),
						),
						array(
							'field_type' => 'color',
							'name'       => 'item_title_color',
							'title'      => esc_html__( 'Title Color', 'valeska-core' ),
						),
						array(
							'field_type' => 'textarea',
							'name'       => 'item_text',
							'title'      => esc_html__( 'Text', 'valeska-core' ),
						),
						array(
							'field_type' => 'color',
							'name'       => 'item_text_color',
							'title'      => esc_html__( 'Text Color', 'valeska-core' ),
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_text_margin_top',
							'title'      => esc_html__( 'Text Margin Top', 'valeska-core' ),
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_link',
							'title'      => esc_html__( 'Link', 'valeska-core' ),
						),
						array(
							'field_type' => 'select',
							'name'       => 'item_link_target',
							'title'      => esc_html__( 'Link Target', 'valeska-core' ),
							'options'    => valeska_core_get_select_type_options_pool( 'link_target', false ),
						),
					),
				)
			);
		}

		public function load_assets() {
			wp_enqueue_script( 'jquery-appear' );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['items']          = array_chunk( $this->parse_repeater_items( $atts['children'] ), ceil( count( $this->parse_repeater_items( $atts['children'] ) ) / 2 ) );
			$atts['this_shortcode'] = $this;

			return valeska_core_get_template_part( 'shortcodes/item-showcase', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-item-showcase';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';

			return implode( ' ', $holder_classes );
		}

		public function get_image_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['main_image_offset'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['main_image_offset'] ) ) {
					$styles[] = 'margin-top: -' . $atts['main_image_offset'];
				} else {
					$styles[] = 'margin-top: -' . intval( $atts['main_image_offset'] ) . 'px';
				}
			}

			return $styles;
		}

		public function get_title_styles( $item ) {
			$styles = array();

			if ( ! empty( $item['item_title_color'] ) ) {
				$styles[] = 'color: ' . $item['item_title_color'];
			}

			return $styles;
		}

		public function get_text_styles( $item ) {
			$styles = array();

			if ( ! empty( $item['item_text_color'] ) ) {
				$styles[] = 'color: ' . $item['item_text_color'];
			}

			if ( isset( $item['item_text_margin_top'] ) && '' !== $item['item_text_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $item['item_text_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $item['main_image_offset'];
				} else {
					$styles[] = 'margin-top: ' . intval( $item['item_text_margin_top'] ) . 'px';
				}
			}

			return $styles;
		}
	}
}
