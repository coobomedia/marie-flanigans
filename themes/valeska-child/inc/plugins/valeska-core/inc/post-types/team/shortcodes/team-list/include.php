<?php

include_once VALESKA_CORE_CPT_PATH . '/team/shortcodes/team-list/class-valeskacore-team-list-shortcode.php';

foreach ( glob( VALESKA_CORE_CPT_PATH . '/team/shortcodes/team-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
