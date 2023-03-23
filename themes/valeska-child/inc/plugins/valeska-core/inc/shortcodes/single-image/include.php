<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/single-image/class-valeskacore-single-image-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/single-image/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
