<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/text-marquee/class-valeskacore-text-marquee-shortcode.php';

foreach ( glob( VALESKA_CORE_INC_PATH . '/shortcodes/text-marquee/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
