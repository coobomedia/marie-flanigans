<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/countdown/class-valeskacore-countdown-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/countdown/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
