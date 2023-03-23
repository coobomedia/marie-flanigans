<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/author-list/helper.php';
include_once VALESKA_CORE_SHORTCODES_PATH . '/author-list/class-valeskacore-author-list-shortcode.php';

foreach ( glob( VALESKA_CORE_INC_PATH . '/shortcodes/author-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
