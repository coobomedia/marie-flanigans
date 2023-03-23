<?php

if ( ! function_exists( 'valeska_child_theme_enqueue_scripts' ) ) {
	/**
	 * Function that enqueue theme's child style
	 */
	function valeska_child_theme_enqueue_scripts() {
		$main_style = 'valeska-main';

		wp_enqueue_style( 'valeska-child-style', get_stylesheet_directory_uri() . '/style.css', array( $main_style ) );
	}

	add_action( 'wp_enqueue_scripts', 'valeska_child_theme_enqueue_scripts' );
}

/** Remove product data tabs */
 
add_filter( 'woocommerce_product_tabs', 'my_remove_product_tabs', 98 );
 
function my_remove_product_tabs( $tabs ) {
  unset( $tabs['additional_information'] ); // To remove the additional information tab
  return $tabs;
}

add_filter( 'woocommerce_account_menu_items', 'bbloomer_remove_address_my_account', 9999 );
 
function bbloomer_remove_address_my_account( $items ) {
   unset( $items['subscriptions'] );
   unset( $items['downloads'] );
   return $items;
}

/**
 * @snippet    WooCommerce Show Product Image @ Checkout Page
*/

add_filter( 'woocommerce_cart_item_name', 'ts_product_image_on_checkout', 10, 3 );

function ts_product_image_on_checkout( $name, $cart_item, $cart_item_key ) {  

    /* Return if not checkout page */
    if ( ! is_checkout() ) {
        return $name;
    }

    /* Get product object */
    $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

    /* Get product thumbnail */
    $thumbnail = $_product->get_image();

    /* Add wrapper to image and add some css */
    $image = '<div class="ts-product-image" style="width: 52px; height: 45px; display: inline-block; padding-right: 7px; vertical-align: middle;">'
                . $thumbnail .
            '</div>';

    /* Prepend image to name and return it */
    return $image . $name;

}


function woocommerce_button_proceed_to_checkout() { ?>
 <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward">
 <?php esc_html_e( 'Checkout', 'woocommerce' ); ?>
	 <i class="arrow_right" style="position: relative; top: 1px;"></i>
 </a>
 <?php
}

add_action( 'woocommerce_cart_actions', 'woo_add_continue_shopping_button_to_cart' );

function woo_add_continue_shopping_button_to_cart() {
 $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
 
 echo ' <a href="'.$shop_page_url.'" class="button" style="float:left;">Keep Shopping <i class="arrow_right" style="position: relative; top: 1px;"></i></a>';
}

add_action( 'woocommerce_product_options_general_product_data', 'simple_product_with_external_url' );
function simple_product_with_external_url() {
    global $product_object;

    echo '<div class="options_group show_if_simple hidden">';

    // External Url
    woocommerce_wp_text_input( array(
        'id'          => '_ext_url_cust',
        'label'       => 'External Url',
        'description' => 'Custom external URL',
        'desc_tip'    => 'true',
        'placeholder' => 'Enter here your custom external URL'
    ) );

    echo '</div>';
}

add_action( 'woocommerce_admin_process_product_object', 'save_simple_product_with_external_url' );
function save_simple_product_with_external_url( $product ) {
    if( $product->is_type('simple') && isset($_POST['_ext_url_cust']) ) {
        $product->update_meta_data( '_ext_url_cust', sanitize_url($_POST['_ext_url_cust']) );
    }
}

add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );
function quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {
    $external_url = $product->get_meta('_ext_url_cust');

    if ( ! empty($external_url) ) {
        $html = sprintf( '<a href="%s" class="button alt add_to_cart_button">%s</a>', $product->get_permalink(), __("Where to Buy", "woocommerce") );
    }
    return $html;
}

add_filter( 'woocommerce_add_to_cart_redirect', 'redirect_simple_product_with_external_url' );
function redirect_simple_product_with_external_url( $url ) {
    if( isset($_REQUEST['add-to-cart']) && absint( $_REQUEST['add-to-cart'] ) > 0 )
        return get_post_meta( absint( $_REQUEST['add-to-cart'] ), '_ext_url_cust', true );

    return $url;
}


add_filter( 'ngettext', 'bbloomer_translate_tag_taxonomy', 9999, 5 );
 
function bbloomer_translate_tag_taxonomy( $translation, $single, $plural, $number, $domain ) {
   if ( is_product() && 'woocommerce' === $domain ) {
      // This will only trigger on the WooCommerce single product page
      $translation = ( 1 === $number ) ? str_ireplace( 'Tag:', 'Collection:', $translation ) : str_ireplace( 'Tags:', 'Collections:', $translation );
   }
   return $translation;
}
