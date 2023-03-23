<?php

include_once VALESKA_CORE_INC_PATH . '/blog/shortcodes/blog-list/class-valeskacore-blog-list-shortcode.php';

foreach ( glob( VALESKA_CORE_INC_PATH . '/blog/shortcodes/blog-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
