<?php
$min_price = valeska_core_woo_product_category_min_price( $params['category_id'] );
if ( valeska_is_installed( 'woocommerce' ) ) {
	$currency = get_woocommerce_currency_symbol();
}
?>
<?php
if ( 'yes' !== $hide_price && ( $min_price && $min_price !== 0 ) ) { ?>
	<span class="qodef-woo-product-category-price-holder price">
        <span class="qodef-price-text"><?php esc_html_e( 'from', 'valeska-core' ); ?></span>
        <span class="qodef-price-with-currency">
            <?php if ( ! empty ( $currency ) ) { ?>
	            <span class="qodef-currency"><?php echo esc_attr( $currency ); ?></span>
            <?php } ?>
            <span class="qodef-price"><?php echo esc_attr( $min_price ); ?></span>
        </span>
    </span>
<?php } ?>
