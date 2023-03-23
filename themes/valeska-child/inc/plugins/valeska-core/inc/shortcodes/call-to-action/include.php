<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/call-to-action/class-valeskacore-call-to-action-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/call-to-action/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
