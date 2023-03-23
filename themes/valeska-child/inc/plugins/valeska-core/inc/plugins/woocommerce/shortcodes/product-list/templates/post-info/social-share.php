<?php if ( class_exists( 'ValeskaCore_Social_Share_Shortcode' ) ) { ?>
	<div class="qodef-woo-product-social-share">
		<?php
		$params          = array();
		$params['title'] = esc_html__( 'Share:', 'valeska-core' );

		echo ValeskaCore_Social_Share_Shortcode::call_shortcode( $params );
		?>
	</div>
<?php } ?>
