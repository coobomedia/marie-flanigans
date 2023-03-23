(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefDropDownCart.init();
		}
	);

	var qodefDropDownCart = {
		init: function () {
			var $holder = $( '.qodef-woo-dropdown-cart' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						var $thisHolder = $( this ),
							$items      = $thisHolder.find( '.qodef-woo-dropdown-items' );

						qodefDropDownCart.addItemsClass( $items );

						qodefCore.body.on(
							'added_to_cart',
							function () {
								qodefDropDownCart.addItemsClass( $thisHolder.find( '.qodef-woo-dropdown-items' ) );
							}
						);
					}
				);
			}
		},
		addItemsClass: function ( $items ) {
			if ( $items.length && $items.children().length > 4 ) {
				$items.addClass( 'qodef--scrollable' );
			} else if ( $items.hasClass( 'qodef--scrollable' ) ) {
				$items.removeClass( 'qodef--scrollable' );
			}
		},
	};

})( jQuery );
