<?php

if ( ! function_exists( 'valeska_core_add_woo_dropdown_cart_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function valeska_core_add_woo_dropdown_cart_widget( $widgets ) {
		$widgets[] = 'ValeskaCore_WooCommerce_DropDown_Cart_Widget';

		return $widgets;
	}

	add_filter( 'valeska_core_filter_register_widgets', 'valeska_core_add_woo_dropdown_cart_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class ValeskaCore_WooCommerce_DropDown_Cart_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_base( 'valeska_core_woo_dropdown_cart' );
			$this->set_name( esc_html__( 'Valeska WooCommerce DropDown Cart', 'valeska-core' ) );
			$this->set_description( esc_html__( 'Display a shop cart icon with a dropdown that shows products that are in the cart', 'valeska-core' ) );
			$this->set_widget_option(
				array(
					'field_type'  => 'text',
					'name'        => 'widget_padding',
					'title'       => esc_html__( 'Widget Padding', 'valeska-core' ),
					'description' => esc_html__( 'Insert padding in format: top right bottom left', 'valeska-core' ),
				)
			);
		}

		public function render( $atts ) {
			$styles = array();

			if ( ! empty( $atts['widget_padding'] ) ) {
				$styles[] = 'padding: ' . $atts['widget_padding'];
			}
			?>
			<div class="qodef-woo-dropdown-cart qodef-m" <?php qode_framework_inline_style( $styles ); ?>>
				<div class="qodef-woo-dropdown-cart-inner qodef-m-inner">
					<?php valeska_core_template_part( 'plugins/woocommerce/widgets/dropdown-cart', 'templates/content' ); ?>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'valeska_core_woo_dropdown_cart_add_to_cart_fragment' ) ) {
	/**
	 * Function that return|update new cart content for products which are added into the cart
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	function valeska_core_woo_dropdown_cart_add_to_cart_fragment( $fragments ) {
		ob_start();
		?>
		<div class="qodef-woo-dropdown-cart-inner qodef-m-inner">
			<?php valeska_core_template_part( 'plugins/woocommerce/widgets/dropdown-cart', 'templates/content' ); ?>
		</div>

		<?php
		$fragments['.qodef-woo-dropdown-cart-inner'] = ob_get_clean();

		return $fragments;
	}

	add_filter( 'woocommerce_add_to_cart_fragments', 'valeska_core_woo_dropdown_cart_add_to_cart_fragment' );
}

