<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/tabs/class-valeskacore-tab-shortcode.php';
include_once VALESKA_CORE_SHORTCODES_PATH . '/tabs/class-valeskacore-tab-child-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/tabs/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
