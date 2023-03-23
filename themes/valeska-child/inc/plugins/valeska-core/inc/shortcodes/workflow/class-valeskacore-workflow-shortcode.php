<?php

if ( ! function_exists( 'valeska_core_add_workflow_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function valeska_core_add_workflow_shortcode( $shortcodes ) {
		$shortcodes[] = 'ValeskaCore_Workflow_Shortcode';

		return $shortcodes;
	}

	add_filter( 'valeska_core_filter_register_shortcodes', 'valeska_core_add_workflow_shortcode' );
}

if ( class_exists( 'ValeskaCore_Shortcode' ) ) {
	class ValeskaCore_Workflow_Shortcode extends ValeskaCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( VALESKA_CORE_SHORTCODES_URL_PATH . '/workflow' );
			$this->set_base( 'valeska_workflow_gallery' );
			$this->set_name( esc_html__( 'Workflow', 'valeska-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds workflow holder', 'valeska-core' ) );
			$this->set_category( esc_html__( 'Valeska Core', 'valeska-core' ) );
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'image',
					'title'      => esc_html__( 'Image', 'valeska-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Workflow Items', 'valeska-core' ),
					'items'      => array(
						array(
							'field_type'    => 'text',
							'name'          => 'subtitle',
							'title'         => esc_html__( 'Subtitle', 'valeska-core' ),
							'default_value' => '',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'title',
							'title'         => esc_html__( 'Title', 'valeska-core' ),
							'default_value' => '',
						),
						array(
							'field_type'    => 'text',
							'name'          => 'text',
							'title'         => esc_html__( 'Text', 'valeska-core' ),
							'default_value' => '',
						),
					),
				)
			);
			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );

			$atts                   = $this->get_atts();
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['this_object']    = $this;
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );

			return valeska_core_get_template_part( 'shortcodes/workflow', 'templates/workflow', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-workflow';

			return implode( ' ', $holder_classes );
		}

		public function getItemAdditional( $items_atts ) {
			$additional = array();

			$additional['classes']       = 'qodef-m-workflow-image';
			$additional['circle_styles'] = '';
			$additional['image_styles']  = '';

			$additional['classes'] .= isset( $items_atts['image_background_color'] ) ? 'qodef-has-background' : '';

			if ( ! empty( $items_atts['circle_background_color'] ) ) {
				$additional['circle_styles'] = 'background-color: ' . $items_atts['circle_background_color'];
			}

			if ( ! empty( $items_atts['image_background_color'] ) ) {
				$additional['image_styles'] = 'background-color: ' . $items_atts['image_background_color'];
			}

			return $additional;
		}
	}
}
