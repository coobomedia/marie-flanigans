<?php
if ( $image ) {
	$image_url       = wp_get_attachment_url( $image );
	$style           = ! empty( $image_url ) ? 'background-image: url( ' . esc_url( $image_url ) . ')' : '';
	?>
	<div class="qodef-m-image qodef--background" <?php qode_framework_inline_style( $style ); ?>>
		<?php echo valeska_core_get_list_shortcode_item_image( 'full', $image ); ?>
	</div>
<?php } ?>
