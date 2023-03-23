<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/custom-font/class-valeskacore-custom-font-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/custom-font/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
