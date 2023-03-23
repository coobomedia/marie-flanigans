<article <?php wc_product_cat_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<div class="qodef-woo-product-category-image">
			<?php valeska_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/image', '', $params ); ?>
			<div class="qodef-woo-product-category-image-inner">
				<?php valeska_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/title', '', $params ); ?>
			</div>
			<?php valeska_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/link', '', $params ); ?>
		</div>
	</div>
</article>
