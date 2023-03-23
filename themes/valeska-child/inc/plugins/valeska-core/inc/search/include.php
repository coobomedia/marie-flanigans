<?php

include_once VALESKA_CORE_INC_PATH . '/search/class-valeskacore-search.php';
include_once VALESKA_CORE_INC_PATH . '/search/helper.php';
include_once VALESKA_CORE_INC_PATH . '/search/dashboard/admin/search-options.php';

foreach ( glob( VALESKA_CORE_INC_PATH . '/search/layouts/*/include.php' ) as $layout ) {
	include_once $layout;
}
