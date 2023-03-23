<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/billboard/class-valeskacore-billboard-shortcode.php';

foreach ( glob( VALESKA_CORE_INC_PATH . '/shortcodes/billboard/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
