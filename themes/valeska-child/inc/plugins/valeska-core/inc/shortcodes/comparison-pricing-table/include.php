<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/comparison-pricing-table/class-valeskacore-comparison-pricing-table-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/comparison-pricing-table/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
