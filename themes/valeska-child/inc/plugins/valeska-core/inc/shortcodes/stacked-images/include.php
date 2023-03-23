<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/stacked-images/class-valeskacore-stacked-images-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/stacked-images/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
