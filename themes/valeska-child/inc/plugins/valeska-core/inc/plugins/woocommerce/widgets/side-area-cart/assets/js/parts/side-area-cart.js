(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideAreaCart.init();
		}
	);

	var qodefSideAreaCart = {
		init: function () {
			var $holder = $( '.qodef-woo-side-area-cart' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						var $thisHolder = $( this );

						if ( qodefCore.windowWidth > 680 ) {
							qodefSideAreaCart.trigger( $thisHolder );
							qodef.body.addClass( 'qodef-side-cart--initialized' );

							qodefCore.body.on(
								'added_to_cart',
								function () {
									if ( ! qodef.body.hasClass( 'qodef-side-cart--initialized' ) ) {
										qodefSideAreaCart.trigger( $thisHolder );
									}
								}
							);
						}
					}
				);
			}
		},
		trigger: function ( $holder ) {

			// Open Side Area
			$( '.qodef-woo-side-area-cart' ).on(
				'click',
				'.qodef-m-opener',
				function ( e ) {
					e.preventDefault();

					var $items = $holder.find( '.qodef-m-items' );

					if ( ! $holder.hasClass( 'qodef--opened' ) ) {
						qodefSideAreaCart.openSideArea( $holder );
						if ( $items.length && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
							qodefCore.qodefPerfectScrollbar.init( $items );
						}

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefSideAreaCart.closeSideArea( $holder );
								}
							}
						);
					} else {
						qodefSideAreaCart.closeSideArea( $holder );
					}
				}
			);

			$( '.qodef-woo-side-area-cart' ).on(
				'click',
				'.qodef-m-close',
				function ( e ) {
					e.preventDefault();
					qodefSideAreaCart.closeSideArea( $holder );
				}
			);
		},
		openSideArea: function ( $holder ) {
			qodefCore.qodefScroll.disable();

			$holder.addClass( 'qodef--opened' );
			$('body').addClass( 'qodef-side-cart--opened' );
			$( '#qodef-page-wrapper' ).prepend( '<div class="qodef-woo-side-area-cart-cover"/>' );

			$( '.qodef-woo-side-area-cart-cover' ).on(
				'click',
				function ( e ) {
					e.preventDefault();

					qodefSideAreaCart.closeSideArea( $holder );
				}
			);
		},
		closeSideArea: function ( $holder ) {
			if ( $holder.hasClass( 'qodef--opened' ) ) {
				qodefCore.qodefScroll.enable();

				$holder.removeClass( 'qodef--opened' );
				$('body').removeClass( 'qodef-side-cart--opened' );
				$( '.qodef-woo-side-area-cart-cover' ).remove();
			}
		}
	};

})( jQuery );
