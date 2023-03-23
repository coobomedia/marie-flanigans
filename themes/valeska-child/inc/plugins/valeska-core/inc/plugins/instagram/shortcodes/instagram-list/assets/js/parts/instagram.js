(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_instagram_list = {};

	$( document ).ready(
		function () {
			qodefInstagram.init();
		}
	);

	var qodefInstagram = {
		init: function () {
			this.holder = $( '.sbi.qodef-instagram-swiper-container' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInstagram.initSlider( $( this ) );
					}
				);
			}
		},
		initSlider: function ( $currentItem, $initAllItems ) {
			var sliderOptions   = $currentItem.parent().attr( 'data-options' ),
				$instagramImage = $currentItem.find( '.sbi_item.sbi_type_image' ),
				$imageHolder    = $currentItem.find( '#sbi_images' );

			$currentItem.attr( 'data-options', sliderOptions );

			$imageHolder.addClass( 'swiper-wrapper' );

			if ( $instagramImage.length ) {
				$instagramImage.each(
					function () {
						$( this ).addClass( 'qodef-e qodef-image-wrapper swiper-slide' );
					}
				);
			}

			if ( typeof qodef.qodefSwiper === 'object' ) {

				if ( false === $initAllItems ) {
					qodef.qodefSwiper.initSlider( $currentItem );
				} else {
					qodef.qodefSwiper.init( $currentItem );
				}
			}
		},
	};

	qodefCore.shortcodes.valeska_core_instagram_list.qodefInstagram = qodefInstagram;
	qodefCore.shortcodes.valeska_core_instagram_list.qodefSwiper    = qodef.qodefSwiper;

})( jQuery );
