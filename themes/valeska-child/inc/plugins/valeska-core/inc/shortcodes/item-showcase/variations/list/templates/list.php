<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<div class="qodef-m-items qodef--left">
		<?php
		foreach ( $items[0] as $item ) {
			valeska_core_template_part( 'shortcodes/item-showcase', 'variations/list/templates/parts/item', '', array_merge( $params, array( 'item' => $item ) ) );
		}
		?>
	</div>
	<?php valeska_core_template_part( 'shortcodes/item-showcase', 'variations/list/templates/parts/image', '', $params ); ?>
	<div class="qodef-m-items qodef--right">
		<?php
		foreach ( $items[1] as $item ) {
			valeska_core_template_part( 'shortcodes/item-showcase', 'variations/list/templates/parts/item', '', array_merge( $params, array( 'item' => $item ) ) );
		}
		?>
	</div>
</div>
