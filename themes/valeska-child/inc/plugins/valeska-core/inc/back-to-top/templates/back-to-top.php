<?php
$custom_icon    = valeska_core_get_custom_svg_opener_icon_html( 'back_to_top' );
$holder_classes = array();
if ( empty( $custom_icon ) ) {
	$holder_classes[] = 'qodef--predefined';
}
?>
<a id="qodef-back-to-top" href="#" <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<span class="qodef-back-to-top-icon">
		<?php
		if ( ! empty( $custom_icon ) ) {
			echo valeska_core_get_custom_svg_opener_icon_html( 'back_to_top' );
		} else { ?>
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			     width="22px" height="12.349px" viewBox="0 0 22 12.349" enable-background="new 0 0 22 12.349" xml:space="preserve">
				<polyline points="1.938,10.871 11.05,1.144 20.938,10.871 "/>
			</svg>
		<?php
		}
		?>
	</span>
</a>
