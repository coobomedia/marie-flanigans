<?php

include_once VALESKA_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/class-valeskacore-testimonials-list-shortcode.php';

foreach ( glob( VALESKA_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
