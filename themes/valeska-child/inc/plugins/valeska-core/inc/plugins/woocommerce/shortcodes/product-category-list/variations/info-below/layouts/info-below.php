<article <?php wc_product_cat_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<div class="qodef-woo-product-category-image">
			<?php valeska_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/image', '', $params ); ?>
			<?php valeska_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/link', '', $params ); ?>
		</div>
		<div class="qodef-e-content">
			<?php valeska_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/title', '', $params ); ?>
			<?php valeska_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/price', '', $params ); ?>
		</div>
	</div>
</article>
