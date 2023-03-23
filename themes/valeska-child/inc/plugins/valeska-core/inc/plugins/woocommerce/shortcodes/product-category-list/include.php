<?php

include_once VALESKA_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/media-custom-fields.php';
include_once VALESKA_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/class-valeskacore-product-category-list-shortcode.php';

foreach ( glob( VALESKA_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}

include_once VALESKA_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/widget/class-valeskacore-product-category-list-widget.php';