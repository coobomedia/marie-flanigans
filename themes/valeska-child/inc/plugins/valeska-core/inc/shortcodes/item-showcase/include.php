<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/item-showcase/class-valeskacore-item-showcase-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/item-showcase/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
