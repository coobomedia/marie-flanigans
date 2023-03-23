<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/banner/class-valeskacore-banner-shortcode.php';

foreach ( glob( VALESKA_CORE_INC_PATH . '/shortcodes/banner/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
