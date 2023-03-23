<?php if ( is_object( WC()->cart ) ) { ?>
	<div class="qodef-m-content">
		<?php
		// Hook to include additional content before cart items
		do_action( 'valeska_core_action_woocommerce_before_side_area_cart_content' );

		if ( ! WC()->cart->is_empty() ) {
			valeska_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/loop' );

			valeska_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/order-details' );

			valeska_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/button' );
		} else {
			// Include posts not found
			valeska_core_template_part( 'plugins/woocommerce/widgets/side-area-cart', 'templates/parts/posts-not-found' );
		}

		?>
	</div>
<?php } ?>
