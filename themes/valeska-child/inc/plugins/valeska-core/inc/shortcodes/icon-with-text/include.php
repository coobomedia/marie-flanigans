<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/icon-with-text/class-valeskacore-icon-with-text-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/icon-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
