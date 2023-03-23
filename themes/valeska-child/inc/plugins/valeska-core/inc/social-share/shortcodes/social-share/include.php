<?php

include_once VALESKA_CORE_INC_PATH . '/social-share/shortcodes/social-share/class-valeskacore-social-share-shortcode.php';

foreach ( glob( VALESKA_CORE_INC_PATH . '/social-share/shortcodes/social-share/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
