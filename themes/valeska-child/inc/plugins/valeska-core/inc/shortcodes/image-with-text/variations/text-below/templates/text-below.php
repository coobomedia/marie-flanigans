<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php echo qode_framework_get_inline_attrs( $holder_data, true ); ?>>
	<?php valeska_core_template_part( 'shortcodes/image-with-text', 'templates/parts/image', '', $params ); ?>
	<div class="qodef-m-content">
		<?php valeska_core_template_part( 'shortcodes/image-with-text', 'templates/parts/title', '', $params ); ?>
		<?php valeska_core_template_part( 'shortcodes/image-with-text', 'templates/parts/text', '', $params ); ?>
	</div>
</div>
