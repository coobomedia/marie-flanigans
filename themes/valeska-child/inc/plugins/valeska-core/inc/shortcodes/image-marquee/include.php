<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/image-marquee/class-valeskacore-image-marquee-shortcode.php';

foreach ( glob( VALESKA_CORE_INC_PATH . '/shortcodes/image-marquee/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
