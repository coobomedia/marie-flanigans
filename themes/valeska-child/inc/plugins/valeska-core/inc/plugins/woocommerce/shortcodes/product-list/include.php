<?php

include_once VALESKA_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/class-valeskacore-product-list-shortcode.php';

foreach ( glob( VALESKA_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
