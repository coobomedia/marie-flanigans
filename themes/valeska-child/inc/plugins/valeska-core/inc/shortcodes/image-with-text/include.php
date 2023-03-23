<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/image-with-text/class-valeskacore-image-with-text-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/image-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
