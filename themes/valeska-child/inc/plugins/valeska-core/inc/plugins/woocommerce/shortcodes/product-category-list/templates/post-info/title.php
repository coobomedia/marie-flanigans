<?php
$title_tag = isset( $title_tag ) && ! empty( $title_tag ) ? $title_tag : 'h2';
?>

<<?php echo esc_attr( $title_tag ); ?> itemprop="name" class="qodef-e-title woocommerce-loop-category__title" <?php qode_framework_inline_style( $this_shortcode->get_title_styles( $params ) ); ?>>
	<a itemprop="url" class="qodef-e-link" href="<?php echo esc_url( get_term_link( $category_slug, 'product_cat' ) ); ?>"><?php echo esc_html( $category_name ); ?></a>
</<?php echo esc_attr( $title_tag ); ?>>
