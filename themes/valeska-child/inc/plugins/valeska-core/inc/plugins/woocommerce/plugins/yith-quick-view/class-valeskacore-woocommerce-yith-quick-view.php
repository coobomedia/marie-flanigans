<?php

if ( ! class_exists( 'ValeskaCore_WooCommerce_YITH_Quick_View' ) ) {
	class ValeskaCore_WooCommerce_YITH_Quick_View {
		private static $instance;

		public function __construct() {

			if ( qode_framework_is_installed( 'yith-quick-view' ) ) {
				// Init
				add_action( 'init', array( $this, 'init' ), 15 );
			}
		}

		/**
		 * @return ValeskaCore_WooCommerce_YITH_Quick_View
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function init() {

			// Unset default templates modules
			$this->unset_templates_modules();

			// Change default templates position
			$this->change_templates_position();

			// Override default templates
			$this->override_templates();
		}

		function unset_templates_modules() {
			// Remove button element on shop pages

			$wcqv = new YITH_WCQV;

			if($wcqv ->load_frontend()) { //Prevent from showing after product on list

				// Remove Quick View button element on shop pages
				remove_action( 'woocommerce_after_shop_loop_item', array( YITH_WCQV_Frontend(), 'yith_add_quick_view_button' ), 15 );

				// Remove Quick View button element on wishlist page
				remove_action( 'yith_wcwl_table_after_product_name', array( YITH_WCQV_Frontend(), 'add_quick_view_button_wishlist' ), 15 );

				// Remove meta fields for products
				remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_meta', 30 );
			}
		}

		function change_templates_position() {
			// Add button element for shop pages

			$wcqv = new YITH_WCQV;

			if($wcqv ->load_frontend()) { //Prevent from showing after product on list
				add_action( 'valeska_action_product_list_item_additional_image_content', array( YITH_WCQV_Frontend(), 'yith_add_quick_view_button' ) );
				add_action( 'valeska_core_action_product_list_item_additional_image_content', array( YITH_WCQV_Frontend(), 'yith_add_quick_view_button' ) );
			}

			// add button on bottom of quickview
//			add_action( 'yith_wcqv_product_summary', 'woocommerce_template_wcqw_product_link', 31 );
			add_action( 'yith_wcqv_product_summary', 'valeska_core_get_yith_wishlist_shortcode', 31 );
		}

		function override_templates() {

		}
	}

	ValeskaCore_WooCommerce_YITH_Quick_View::get_instance();
}
