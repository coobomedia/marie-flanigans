<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/info-section/class-valeskacore-info-section-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/info-section/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
