<?php
$static_title_tag = isset( $static_title_tag ) && ! empty( $static_title_tag ) ? $static_title_tag : 'h6';

if ( ! empty( $static_title ) ) { ?>
	<<?php echo esc_attr( $static_title_tag ); ?> class="qodef-e-static-title">
		<?php echo esc_html( $static_title ); ?>
	</<?php echo esc_attr( $static_title_tag ); ?>>
	<?php
}
if ( $image ) {
	$image_url = wp_get_attachment_url( $image );
	$style     = ! empty( $image_url ) ? 'background-image: url( ' . esc_url( $image_url ) . ')' : '';
	?>
	<div class="qodef-m-image qodef--background" <?php qode_framework_inline_style( $style ); ?>>
		<?php echo valeska_core_get_list_shortcode_item_image( 'full', $image ); ?>
	</div>
	<?php
}
