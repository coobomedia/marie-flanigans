<?php

include_once VALESKA_CORE_INC_PATH . '/header/top-area/class-valeskacore-top-area.php';
include_once VALESKA_CORE_INC_PATH . '/header/top-area/helper.php';

foreach ( glob( VALESKA_CORE_INC_PATH . '/header/top-area/dashboard/*/*.php' ) as $dashboard ) {
	include_once $dashboard;
}
