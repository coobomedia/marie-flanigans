<article <?php qode_framework_class_attribute( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php valeska_core_template_part( 'shortcodes/author-list', 'templates/parts/image', '', $params ); ?>
		<div class="qodef-e-content">
			<div class="qodef-e-content-inner">
				<?php valeska_core_template_part( 'shortcodes/author-list', 'templates/parts/name', '', $params ); ?>
				<?php valeska_core_template_part( 'shortcodes/author-list', 'templates/parts/description', '', $params ); ?>
				<?php valeska_core_template_part( 'shortcodes/author-list', 'templates/parts/social', '', $params ); ?>
			</div>
		</div>
	</div>
</article>
