<?php

if ( ! function_exists( 'valeska_core_add_wishlist_dropdown_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function valeska_core_add_wishlist_dropdown_widget( $widgets ) {
		$widgets[] = 'ValeskaCore_Wishlist_Dropdown_Widget';

		return $widgets;
	}

	add_filter( 'valeska_core_filter_register_widgets', 'valeska_core_add_wishlist_dropdown_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class ValeskaCore_Wishlist_Dropdown_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_base( 'valeska_core_wishlist' );
			$this->set_name( esc_html__( 'Valeska Wishlist', 'valeska-core' ) );
			$this->set_description( esc_html__( 'Display a wishlist heart icon with a dropdown that shows all items you added in wishlist', 'valeska-core' ) );

			$this->set_widget_option(
				array(
					'field_type'  => 'text',
					'name'        => 'widget_margin',
					'title'       => esc_html__( 'Margin', 'valeska-core' ),
					'description' => esc_html__( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'valeska-core' ),
				)
			);
		}

		public function render( $atts ) {
			$styles = array();

			if ( '' !== $atts['widget_margin'] ) {
				$styles[] = 'margin: ' . $atts['widget_margin'];
			}

			$number_of_items = valeska_core_get_number_of_wishlist_items();

			$classes = ! empty( $number_of_items ) ? 'qodef-items--has' : 'qodef-items--no';
			?>
			<div class="qodef-wishlist-dropdown qodef-m <?php echo esc_attr( $classes ); ?>" <?php qode_framework_inline_style( $styles ); ?>>
				<div class="qodef-m-inner">
					<?php valeska_core_template_part( 'wishlist', 'widgets/wishlist-dropdown/templates/content', '', array( 'number_of_items' => $number_of_items ) ); ?>
				</div>
			</div>
			<?php
		}
	}
}
