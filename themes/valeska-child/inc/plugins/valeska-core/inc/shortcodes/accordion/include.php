<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/accordion/class-valeskacore-accordion-shortcode.php';
include_once VALESKA_CORE_SHORTCODES_PATH . '/accordion/class-valeskacore-accordion-child-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/accordion/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
