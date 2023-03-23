<input name="add-to-cart" type="hidden" value="<?php echo get_the_ID(); ?>"/>
<?php if ( isset( $show_quantity_field ) && $show_quantity_field ) { ?>
	<input name="quantity" type="number" value="1" min="1"/>
<?php } elseif ( isset( $quantity_value ) && ! empty( $quantity_value ) ) { ?>
	<input name="quantity" type="hidden" value="<?php echo intval( $quantity_value ); ?>"/>
<?php } else { ?>
	<input name="quantity" type="hidden" value="1"/>
	<?php
}

if ( class_exists( 'ValeskaCore_Button_Shortcode' ) ) {
	$params = array(
		'html_type'     => 'submit',
		'button_layout' => 'outlined',
		'text'          => $button_params['input_text'],
		'input_name'    => 'submit',
	);

	if ( isset( $button_params['button_layout'] ) && ! empty( $button_params['button_layout'] ) ) {
		$params['button_layout'] = $button_params['button_layout'];
	}

	if ( isset( $button_params['size'] ) && ! empty( $button_params['size'] ) ) {
		$params['size'] = $button_params['size'];
	}

	echo ValeskaCore_Button_Shortcode::call_shortcode( $params );
	?>
<?php } else { ?>
	<button type="submit"><?php echo esc_attr( $button_params['input_text'] ); ?></button>
<?php } ?>
