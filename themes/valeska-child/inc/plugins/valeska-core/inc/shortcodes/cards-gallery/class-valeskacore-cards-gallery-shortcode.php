<?php

if ( ! function_exists( 'valeska_core_add_cards_gallery_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function valeska_core_add_cards_gallery_shortcode( $shortcodes ) {
		$shortcodes[] = 'ValeskaCore_Cards_Gallery_Shortcode';

		return $shortcodes;
	}

	add_filter( 'valeska_core_filter_register_shortcodes', 'valeska_core_add_cards_gallery_shortcode' );
}

if ( class_exists( 'ValeskaCore_Shortcode' ) ) {
	class ValeskaCore_Cards_Gallery_Shortcode extends ValeskaCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( VALESKA_CORE_SHORTCODES_URL_PATH . '/cards-gallery' );
			$this->set_base( 'valeska_core_cards_gallery' );
			$this->set_name( esc_html__( 'Cards Gallery', 'valeska-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds cards gallery holder', 'valeska-core' ) );
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
					'name'          => 'link_target',
					'title'         => esc_html__( 'Link Target', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'orientation',
					'title'         => esc_html__( 'Info Position', 'valeska-core' ),
					'options'       => array(
						''      => esc_html__( 'Default', 'valeska-core' ),
						'right' => esc_html__( 'Shuffled Right', 'valeska-core' ),
						'left'  => esc_html__( 'Shuffled Left', 'valeska-core' ),
					),
					'default_value' => 'right',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'bundle_animation',
					'title'         => esc_html__( 'Bundle Animation', 'valeska-core' ),
					'options'       => valeska_core_get_select_type_options_pool( 'no_yes' ),
					'default_value' => 'no',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Image Items', 'valeska-core' ),
					'items'      => array(
						array(
							'field_type'    => 'text',
							'name'          => 'item_link',
							'title'         => esc_html__( 'Link', 'valeska-core' ),
							'default_value' => '',
						),
						array(
							'field_type' => 'image',
							'name'       => 'item_image',
							'title'      => esc_html__( 'Item Image', 'valeska-core' ),
						),
					),
				)
			);
			$this->map_extra_options();
		}

		public function load_assets() {
			wp_enqueue_script( 'jquery-appear' );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );

			return valeska_core_get_template_part( 'shortcodes/cards-gallery', 'templates/cards-gallery', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-cards-gallery';
			$holder_classes[] = ! empty( $atts['orientation'] ) ? 'qodef-orientation--' . $atts['orientation'] : 'qodef-orientation--right';
			$holder_classes[] = isset( $atts['bundle_animation'] ) && 'yes' === $atts['bundle_animation'] ? 'qodef-animation--bundle' : 'qodef-animation--no';

			return implode( ' ', $holder_classes );
		}
	}
}
