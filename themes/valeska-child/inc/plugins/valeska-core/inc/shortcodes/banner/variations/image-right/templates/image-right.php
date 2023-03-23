<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $background_styles ); ?>>
	<div class="qodef-m-content">
		<div class="qodef-m-content-inner">
			<?php valeska_core_template_part( 'shortcodes/banner', 'templates/parts/subtitle', '', $params ); ?>
			<?php valeska_core_template_part( 'shortcodes/banner', 'templates/parts/title', '', $params ); ?>
			<?php valeska_core_template_part( 'shortcodes/banner', 'templates/parts/text', '', $params ); ?>
			<?php valeska_core_template_part( 'shortcodes/banner', 'templates/parts/button', '', $params ); ?>
		</div>
	</div>
	<?php valeska_core_template_part( 'shortcodes/banner', 'templates/parts/image', '', $params ); ?>
</div>
