(function ( $ ) {
	'use strict';

	var shortcode = 'valeska_core_product_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

	$( document ).on(
		'valeska_trigger_get_new_posts',
		function () {
			qodefProductList.init( true );
		}
	);

	$( window ).on(
		'load',
		() => {
			qodefProductList.init( false );
		}
	);

	var qodefProductList = {
		init ( newPosts ) {
			this.shortcode = $('.qodef-woo-product-list');

			if ( this.shortcode.length ) {
				this.shortcode.each(
					( index, element ) => {
						const $thisShortcode = $( element );

						if ( $thisShortcode.hasClass('qodef-appear-animation--yes') ) {
							qodefProductList.appearAnimation( $thisShortcode, newPosts );
						}
					}
				);
			}
		},
		appearAnimation ( $holder, newPosts ) {
			let $products;

			if ( newPosts ) {
				$products = $holder.find('.product:not(.qodef-appeared)');
			} else {
				$products = $holder.find('.product');
			}

			if ( $products.length ) {
				qodefCore.qodefIsInViewport.check(
					$products,
					() => {
						$products.each(
							( index, element ) => {
								const $thisProduct = $( element );

								setTimeout(
									() => {
										$thisProduct.addClass( 'qodef-appeared' );
									}, index * 180
								);
							}
						);
					}
				);
			}
		}
	};

	qodefCore.shortcodes[shortcode].qodefProductList = qodefProductList;

})( jQuery );
