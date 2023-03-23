<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/counter/class-valeskacore-counter-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/counter/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
