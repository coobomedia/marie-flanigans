<?php

include_once VALESKA_CORE_CPT_PATH . '/clients/shortcodes/clients-list/class-valeskacore-clients-list-shortcode.php';

foreach ( glob( VALESKA_CORE_CPT_PATH . '/clients/shortcodes/clients-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
