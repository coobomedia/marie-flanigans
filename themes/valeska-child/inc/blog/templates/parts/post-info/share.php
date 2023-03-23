<?php if ( class_exists( 'ValeskaCore_Social_Share_Shortcode' ) ) { ?>
	<?php
	$params           = array();
	$params['layout'] = 'text';
	echo ValeskaCore_Social_Share_Shortcode::call_shortcode( $params );
	?>
	<?php
}
