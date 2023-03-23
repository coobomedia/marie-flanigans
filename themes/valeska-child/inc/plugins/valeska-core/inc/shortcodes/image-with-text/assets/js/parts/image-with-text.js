(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_image_with_text = {};

	$( document ).ready(
		() => {
			qodefImageWithText.init();
		}
	);

	var qodefImageWithText = {
		init () {
			const $holder = $( '.qodef-image-with-text' );

			if ( $holder.length ) {
				$holder.each(
					( index, element ) => {
						var $thisHolder = $( element );

						qodefImageWithText.scrollAnimation( $thisHolder );

						if ( $thisHolder.hasClass('qodef-iwt-appear-animation--yes') ) {
							qodefImageWithText.appearAnimation( $thisHolder );
						}
					}
				);
			}
		},
		scrollAnimation ( $thisHolder ) {
			if ( $thisHolder.hasClass( 'qodef-image-action--scrolling-image' ) ) {
				let $imageHolder = $thisHolder.find( '.qodef-m-image' ),
					$frame       = $thisHolder.find( '.qodef-m-frame' ),
					$image       = $thisHolder.find( '.qodef-m-image-holder-inner > a > img, .qodef-m-image-holder-inner > img' ),
					horizontal   = $thisHolder.hasClass('qodef-scrolling-direction--horizontal'),
					frameHeight,
					frameWidth,
					imageHeight,
					imageWidth,
					delta,
					timing,
					scrollable  = false;

				const setSize = () => {
					frameHeight = $frame.height();
					imageHeight = $image.height();
					frameWidth  = $frame.width();
					imageWidth  = $image.width();
					delta       = Math.round( imageHeight - frameHeight );
					timing      = Math.round( imageHeight / frameHeight ) * 2;

					if ( horizontal ) {
						delta = Math.round( imageWidth - frameWidth );
						timing = Math.round( imageWidth / frameWidth ) * 2;

						if ( imageWidth > frameWidth ) {
							scrollable = true;
						}
					} else {
						delta = Math.round( imageHeight - frameHeight );
						timing = Math.round( imageHeight / frameHeight ) * 2;

						if ( imageHeight > frameHeight ) {
							scrollable = true;
						}
					}
				};

				var initAnimation = () => {
					$imageHolder.on(
						'mouseenter',
						() => {
							$image.css(
								'transition-duration',
								timing + 's'
							);

							$image.css(
								'transform',
								'translate3d(0px, -' + delta + 'px, 0px)'
							);
						}
					);

					$imageHolder.on(
						'mouseleave',
						() => {
							if ( scrollable ) {
								$image.css(
									'transition-duration',
									Math.min(
										timing / 3,
										3
									) + 's'
								);
								$image.css(
									'transform',
									'translate3d(0px, 0px, 0px)'
								);
							}
						}
					);
				};

				$thisHolder.waitForImages(
					() => {
						$thisHolder.css(
							'visibility',
							'visible'
						);
						setSize();
						initAnimation();
					}
				);

				$( window ).resize(
					() => {
						setSize();
					}
				);
			}
		},
		appearAnimation ( $holder ) {
			const delay = $holder.data('appearing-delay');

			if ( $holder.hasClass('qodef-wait-for-trigger') ) {
				const interval = setInterval(
					() => {
						if ( qodef.body.hasClass('qodef-siwt-animation-done') ) {
							setTimeout(
								() => {
									$holder.addClass( 'qodef-appeared' );
								}, delay
							);
							clearInterval(interval);
						}
					}, 100
				);
			} else {
				qodefCore.qodefIsInViewport.check(
					$holder,
					() => {
						setTimeout(
							() => {
								$holder.addClass( 'qodef-appeared' );
							}, delay
						);
					}
				);
			}
		}
	};

	qodefCore.shortcodes.valeska_core_image_with_text.qodefImageWithText = qodefImageWithText;
	qodefCore.shortcodes.valeska_core_image_with_text.qodefMagnificPopup = qodef.qodefMagnificPopup;
	qodefCore.shortcodes.valeska_core_image_with_text.qodefAppear        = qodef.qodefAppear;

})( jQuery );
