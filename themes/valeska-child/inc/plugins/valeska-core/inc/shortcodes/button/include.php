<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/button/class-valeskacore-button-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/button/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
