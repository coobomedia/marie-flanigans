<?php

include_once VALESKA_CORE_CPT_PATH . '/clients/helper.php';

foreach ( glob( VALESKA_CORE_CPT_PATH . '/clients/dashboard/meta-box/*.php' ) as $module ) {
	include_once $module;
}
