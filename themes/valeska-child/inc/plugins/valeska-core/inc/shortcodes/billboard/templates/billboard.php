<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?>>
	<?php valeska_core_template_part( 'shortcodes/billboard', 'templates/parts/background-image', '', $params ); ?>
	<div class="qodef-m-content">
		<div class="qodef-m-content-inner">
			<?php valeska_core_template_part( 'shortcodes/billboard', 'templates/parts/text', '', $params ); ?>
			<?php valeska_core_template_part( 'shortcodes/billboard', 'templates/parts/title', '', $params ); ?>
			<?php valeska_core_template_part( 'shortcodes/billboard', 'templates/parts/button', '', $params ); ?>
		</div>
	</div>
</div>
