<?php

include_once VALESKA_CORE_SHORTCODES_PATH . '/interactive-link-showcase/class-valeskacore-interactive-link-showcase-shortcode.php';

foreach ( glob( VALESKA_CORE_SHORTCODES_PATH . '/interactive-link-showcase/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
