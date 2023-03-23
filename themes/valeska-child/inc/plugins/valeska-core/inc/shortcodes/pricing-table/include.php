<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/pricing-table/class-valeskacore-pricing-table-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/pricing-table/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
