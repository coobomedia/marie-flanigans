(function ( $ ) {
	'use strict';

	// This case is important when theme is not active
	if ( typeof qodef !== 'object' ) {
		window.qodef = {};
	}

	window.qodefCore                = {};
	qodefCore.shortcodes            = {};
	qodefCore.listShortcodesScripts = {
		qodefSwiper: qodef.qodefSwiper,
		qodefPagination: qodef.qodefPagination,
		qodefFilter: qodef.qodefFilter,
		qodefMasonryLayout: qodef.qodefMasonryLayout,
		qodefJustifiedGallery: qodef.qodefJustifiedGallery,
	};

	qodefCore.body         = $( 'body' );
	qodefCore.html         = $( 'html' );
	qodefCore.windowWidth  = $( window ).width();
	qodefCore.windowHeight = $( window ).height();
	qodefCore.scroll       = 0;

	$( document ).ready(
		function () {
			qodefCore.scroll = $( window ).scrollTop();
			qodefInlinePageStyle.init();
		}
	);

	$( window ).resize(
		function () {
			qodefCore.windowWidth  = $( window ).width();
			qodefCore.windowHeight = $( window ).height();
		}
	);

	$( window ).scroll(
		function () {
			qodefCore.scroll = $( window ).scrollTop();
		}
	);

	$( window ).load(
		function () {
			qodefParallaxItem.init();
		}
	);

	/**
	 * Check element to be in the viewport
	 */
	var qodefIsInViewport = {
		check: function ( $element, callback, onlyOnce ) {
			if ( $element.length ) {
				var offset = typeof $element.data( 'viewport-offset' ) !== 'undefined' ? $element.data( 'viewport-offset' ) : 0.15; // When item is 15% in the viewport

				var observer = new IntersectionObserver(
					function ( entries ) {
						// isIntersecting is true when element and viewport are overlapping
						// isIntersecting is false when element and viewport don't overlap
						if ( entries[0].isIntersecting === true ) {
							callback.call( $element );

							// Stop watching the element when it's initialize
							if ( onlyOnce !== false ) {
								observer.disconnect();
							}
						}
					},
					{ threshold: [offset] }
				);

				observer.observe( $element[0] );
			}
		},
	};

	qodefCore.qodefIsInViewport = qodefIsInViewport;

	var qodefScroll = {
		disable: function () {
			if ( window.addEventListener ) {
				window.addEventListener(
					'wheel',
					qodefScroll.preventDefaultValue,
					{ passive: false }
				);
			}

			// window.onmousewheel = document.onmousewheel = qodefScroll.preventDefaultValue;
			document.onkeydown = qodefScroll.keyDown;
		},
		enable: function () {
			if ( window.removeEventListener ) {
				window.removeEventListener(
					'wheel',
					qodefScroll.preventDefaultValue,
					{ passive: false }
				);
			}
			window.onmousewheel = document.onmousewheel = document.onkeydown = null;
		},
		preventDefaultValue: function ( e ) {
			e = e || window.event;
			if ( e.preventDefault ) {
				e.preventDefault();
			}
			e.returnValue = false;
		},
		keyDown: function ( e ) {
			var keys = [37, 38, 39, 40];
			for ( var i = keys.length; i--; ) {
				if ( e.keyCode === keys[i] ) {
					qodefScroll.preventDefaultValue( e );
					return;
				}
			}
		}
	};

	qodefCore.qodefScroll = qodefScroll;

	var qodefPerfectScrollbar = {
		init: function ( $holder ) {
			if ( $holder.length ) {
				qodefPerfectScrollbar.qodefInitScroll( $holder );
			}
		},
		qodefInitScroll: function ( $holder ) {
			var $defaultParams = {
				wheelSpeed: 0.6,
				suppressScrollX: true
			};

			var $ps = new PerfectScrollbar(
				$holder[0],
				$defaultParams
			);

			$( window ).resize(
				function () {
					$ps.update();
				}
			);
		}
	};

	qodefCore.qodefPerfectScrollbar = qodefPerfectScrollbar;

	var qodefInlinePageStyle = {
		init: function () {
			this.holder = $( '#valeska-core-page-inline-style' );

			if ( this.holder.length ) {
				var style = this.holder.data( 'style' );

				if ( style.length ) {
					$( 'head' ).append( '<style type="text/css">' + style + '</style>' );
				}
			}
		}
	};

	/**
	 * Init parallax items
	 */
	var qodefParallaxItem = {
		init () {
			const $parallaxItems = $('.qodef-parallax-item');
			const $zoomItems     = $('.qodef-zoom-scroll');

			if ( $parallaxItems.length ) {
				$parallaxItems.each(
					( index, element ) => {
						const $currentItem = $( element );

						if ( $currentItem.hasClass('qodef-stacked-images') ) {
							const $currentImage = $currentItem.find('.qodef-m-images > .qodef-m-image');

							$currentImage.attr(
								'data-parallax',
								'{"y": -50, "smoothness": 60}'
							);
						} else if ( $currentItem.hasClass('qodef-grid-item') ) {
							$currentItem.children('.qodef-e-inner').attr(
								'data-parallax',
								'{"y": -50, "smoothness": 60}'
							);
						} else if ( $currentItem.hasClass('rs-layer') ) {
							$currentItem.find('img').attr(
								'data-parallax',
								'{"y": -50, "smoothness": 60}'
							);
						} else {
							$currentItem.attr(
								'data-parallax',
								'{"y": -50, "smoothness": 60}'
							);
						}
					}
				);
			}

			if ( $zoomItems.length ) {
				$zoomItems.each(
					( index, element ) => {
						const $thisItem = $( element );
						let   $thisImage;

						if ( $thisItem.hasClass('qodef-stacked-images') ) {
							$thisImage = $thisItem.find('.qodef-m-main-image .qodef-m-image');
						} else {
							$thisImage = $thisItem.find('img');
						}

						$thisImage.attr(
							'data-parallax',
							'{"scale": 1.2, "smoothness": 30}'
						);
					}
				);
			}

			qodefParallaxItem.initParallax();
		},
		initParallax () {
			const parallaxInstances = $('[data-parallax]');

			if ( parallaxInstances.length && ! qodefCore.html.hasClass( 'touchevents' ) && typeof ParallaxScroll === 'object' ) {
				ParallaxScroll.init(); //initialization removed from plugin js file to have it run only on non-touch devices
			}
		}
	};

	qodefCore.qodefParallaxItem = qodefParallaxItem;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
	    function () {
            qodefBackToTop.init();
        }
	);

	var qodefBackToTop = {
		init: function () {
			this.holder = $( '#qodef-back-to-top' );

			if ( this.holder.length ) {
				// Scroll To Top
				this.holder.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefBackToTop.animateScrollToTop();
					}
				);

				qodefBackToTop.showHideBackToTop();
			}
		},
		animateScrollToTop: function () {
			var startPos = qodef.scroll,
				newPos   = qodef.scroll,
				step     = .9,
				animationFrameId;

			var startAnimation = function () {
				if ( newPos === 0 ) {
					return;
				}

				newPos < 0.0001 ? newPos = 0 : null;

				var ease = qodefBackToTop.easingFunction( (startPos - newPos) / startPos );
				$( 'html, body' ).scrollTop( startPos - (startPos - newPos) * ease );
				newPos = newPos * step;

				animationFrameId = requestAnimationFrame( startAnimation );
			};
			startAnimation();
			$( window ).one(
				'wheel touchstart',
				function () {
					cancelAnimationFrame( animationFrameId );
				}
			);
		},
		easingFunction: function ( n ) {
			return 0 == n ? 0 : Math.pow( 1024, n - 1 );
		},
		showHideBackToTop: function () {
			$( window ).scroll(
				function () {
					var $thisItem = $( this ),
						b         = $thisItem.scrollTop(),
						c         = $thisItem.height(),
						d;

					if ( b > 0 ) {
						d = b + c / 2;
					} else {
						d = 1;
					}

					if ( d < 1e3 ) {
						qodefBackToTop.addClass( 'off' );
					} else {
						qodefBackToTop.addClass( 'on' );
					}
				}
			);
		},
		addClass: function ( a ) {
			this.holder.removeClass( 'qodef--off qodef--on' );

			if ( a === 'on' ) {
				this.holder.addClass( 'qodef--on' );
			} else {
				this.holder.addClass( 'qodef--off' );
			}
		}
	};

})( jQuery );

(function ($) {
	"use strict";

	$( window ).on(
		'load',
		function () {
			qodefBackgroundText.init();
		}
	);

	$( window ).resize(
		function () {
			qodefBackgroundText.init();
		}
	);

	var qodefBackgroundText = {
		init                    : function () {
			var $holder = $( '.qodef-background-text' );

			if ($holder.length) {
				$holder.each(
					function () {
						qodefBackgroundText.responsiveOutputHandler( $( this ) );
					}
				);
			}
		},
		responsiveOutputHandler : function ($holder) {
			var breakpoints = {
				3840: 1441,
				1440: 1367,
				1366: 1025,
				1024: 1
			};

			$.each(
				breakpoints,
				function (max, min) {
					if (qodef.windowWidth <= max && qodef.windowWidth >= min) {
						qodefBackgroundText.generateResponsiveOutput( $holder, max );
					}
				}
			);
		},
		generateResponsiveOutput: function ($holder, width) {
			var $textHolder = $holder.find( '.qodef-m-background-text' );

			if ($textHolder.length) {
				$textHolder.css(
					{
						'font-size': $textHolder.data( 'size-' + width ) + 'px',
						'top'      : $textHolder.data( 'vertical-offset-' + width ) + 'px',
					}
				);
			}
		},
	};

	window.qodefBackgroundText = qodefBackgroundText;
})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefUncoverFooter.init();
		}
	);

	var qodefUncoverFooter = {
		holder: '',
		init: function () {
			this.holder = $( '#qodef-page-footer.qodef--uncover' );

			if ( this.holder.length && ! qodefCore.html.hasClass( 'touchevents' ) ) {
				qodefUncoverFooter.addClass();
				qodefUncoverFooter.setHeight( this.holder );

				$( window ).resize(
					function () {
						qodefUncoverFooter.setHeight( qodefUncoverFooter.holder );
					}
				);
			}
		},
		setHeight: function ( $holder ) {
			$holder.css( 'height', 'auto' );

			var footerHeight = $holder.outerHeight();

			if ( footerHeight > 0 ) {
				$( '#qodef-page-outer' ).css(
					{
						'margin-bottom': footerHeight,
						'background-color': qodefCore.body.css( 'backgroundColor' )
					}
				);

				$holder.css( 'height', footerHeight );
			}
		},
		addClass: function () {
			qodefCore.body.addClass( 'qodef-page-footer--uncover' );
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefFullscreenMenu.init();
		}
	);

	var qodefFullscreenMenu = {
		init: function () {
			var $fullscreenMenuOpener = $( 'a.qodef-fullscreen-menu-opener' ),
				$menuItems            = $( '#qodef-fullscreen-area nav ul li a' );

			// Open popup menu
			$fullscreenMenuOpener.on(
				'click',
				function ( e ) {
					e.preventDefault();
					var $thisOpener = $( this );

					if ( ! qodefCore.body.hasClass( 'qodef-fullscreen-menu--opened' ) ) {
						qodefFullscreenMenu.openFullscreen( $thisOpener );

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefFullscreenMenu.closeFullscreen( $thisOpener );
								}
							}
						);
					} else {
						qodefFullscreenMenu.closeFullscreen( $thisOpener );
					}
				}
			);

			//open dropdowns
			$menuItems.on(
				'tap click',
				function ( e ) {
					var $thisItem = $( this );

					if ( $thisItem.parent().hasClass( 'menu-item-has-children' ) ) {
						e.preventDefault();
						qodefFullscreenMenu.clickItemWithChild( $thisItem );
					} else if ( $thisItem.attr( 'href' ) !== 'http://#' && $thisItem.attr( 'href' ) !== '#' ) {
						qodefFullscreenMenu.closeFullscreen( $fullscreenMenuOpener );
					}
				}
			);
		},
		openFullscreen: function ( $opener ) {
			$opener.addClass( 'qodef--opened' );
			qodefCore.body.removeClass( 'qodef-fullscreen-menu-animate--out' ).addClass( 'qodef-fullscreen-menu--opened qodef-fullscreen-menu-animate--in' );
			qodefCore.qodefScroll.disable();
		},
		closeFullscreen: function ( $opener ) {
			$opener.removeClass( 'qodef--opened' );
			qodefCore.body.removeClass( 'qodef-fullscreen-menu--opened qodef-fullscreen-menu-animate--in' ).addClass( 'qodef-fullscreen-menu-animate--out' );
			qodefCore.qodefScroll.enable();
			$( 'nav.qodef-fullscreen-menu ul.sub_menu' ).slideUp( 200 );
		},
		clickItemWithChild: function ( thisItem ) {
			var $thisItemParent  = thisItem.parent(),
				$thisItemSubMenu = $thisItemParent.find( '.sub-menu' ).first();

			if ( $thisItemSubMenu.is( ':visible' ) ) {
				$thisItemSubMenu.slideUp( 300 );
				$thisItemParent.removeClass( 'qodef--opened' );
			} else {
				$thisItemSubMenu.slideDown( 300 );
				$thisItemParent.addClass( 'qodef--opened' ).siblings().find( '.sub-menu' ).slideUp( 400 );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefHeaderScrollAppearance.init();
		}
	);

	var qodefHeaderScrollAppearance = {
		appearanceType: function () {
			return qodefCore.body.attr( 'class' ).indexOf( 'qodef-header-appearance--' ) !== -1 ? qodefCore.body.attr( 'class' ).match( /qodef-header-appearance--([\w]+)/ )[1] : '';
		},
		init: function () {
			var appearanceType = this.appearanceType();

			if ( appearanceType !== '' && appearanceType !== 'none' ) {
				qodefCore[appearanceType + 'HeaderAppearance']();
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
	    function () {
            qodefMobileHeaderAppearance.init();
        }
	);

	/*
	 **	Init mobile header functionality
	 */
	var qodefMobileHeaderAppearance = {
		init: function () {
			if ( qodefCore.body.hasClass( 'qodef-mobile-header-appearance--sticky' ) ) {

				var docYScroll1   = qodefCore.scroll,
					displayAmount = qodefGlobal.vars.mobileHeaderHeight + qodefGlobal.vars.adminBarHeight,
					$pageOuter    = $( '#qodef-page-outer' );

				qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );

				$( window ).scroll(
				    function () {
                        qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );
                        docYScroll1 = qodefCore.scroll;
                    }
				);

				$( window ).resize(
				    function () {
                        $pageOuter.css( 'padding-top', 0 );
                        qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );
                    }
				);
			}
		},
		showHideMobileHeader: function ( docYScroll1, displayAmount, $pageOuter ) {
			if ( qodefCore.windowWidth <= 1024 ) {
				if ( qodefCore.scroll > displayAmount * 2 ) {
					//set header to be fixed
					qodefCore.body.addClass( 'qodef-mobile-header--sticky' );

					//add transition to it
					setTimeout(
						function () {
							qodefCore.body.addClass( 'qodef-mobile-header--sticky-animation' );
						},
						300
					); //300 is duration of sticky header animation

					//add padding to content so there is no 'jumping'
					$pageOuter.css( 'padding-top', qodefGlobal.vars.mobileHeaderHeight );
				} else {
					//unset fixed header
					qodefCore.body.removeClass( 'qodef-mobile-header--sticky' );

					//remove transition
					setTimeout(
						function () {
							qodefCore.body.removeClass( 'qodef-mobile-header--sticky-animation' );
						},
						300
					); //300 is duration of sticky header animation

					//remove padding from content since header is not fixed anymore
					$pageOuter.css( 'padding-top', 0 );
				}

				if ( (qodefCore.scroll > docYScroll1 && qodefCore.scroll > displayAmount) || (qodefCore.scroll < displayAmount * 3) ) {
					//show sticky header
					qodefCore.body.removeClass( 'qodef-mobile-header--sticky-display' );
				} else {
					//hide sticky header
					qodefCore.body.addClass( 'qodef-mobile-header--sticky-display' );
				}
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefNavMenu.init();
		}
	);

	var qodefNavMenu = {
		init: function () {
			qodefNavMenu.dropdownBehavior();
			qodefNavMenu.wideDropdownPosition();
			qodefNavMenu.dropdownPosition();
		},
		dropdownBehavior: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li' );

			$menuItems.each(
				function () {
					var $thisItem = $( this );

					if ( $thisItem.find( '.qodef-drop-down-second' ).length ) {
						$thisItem.waitForImages(
							function () {
								var $dropdownHolder      = $thisItem.find( '.qodef-drop-down-second' ),
									$dropdownMenuItem    = $dropdownHolder.find( '.qodef-drop-down-second-inner ul' ),
									dropDownHolderHeight = $dropdownMenuItem.outerHeight();

								if ( navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) ) {
									$thisItem.on(
										'touchstart mouseenter',
										function () {
											$dropdownHolder.css(
												{
													'height': dropDownHolderHeight,
													'overflow': 'visible',
													'visibility': 'visible',
													'opacity': '1',
												}
											);
										}
									).on(
										'mouseleave',
										function () {
											$dropdownHolder.css(
												{
													'height': '0px',
													'overflow': 'hidden',
													'visibility': 'hidden',
													'opacity': '0',
												}
											);
										}
									);
								} else {
									if ( qodefCore.body.hasClass( 'qodef-drop-down-second--animate-height' ) ) {
										var animateConfig = {
											interval: 0,
											over: function () {
												setTimeout(
													function () {
														$dropdownHolder.addClass( 'qodef-drop-down--start' ).css(
															{
																'visibility': 'visible',
																'height': '0',
																'opacity': '1',
															}
														);
														$dropdownHolder.stop().animate(
															{
																'height': dropDownHolderHeight,
															},
															400,
															'linear',
															function () {
																$dropdownHolder.css( 'overflow', 'visible' );
															}
														);
													},
													100
												);
											},
											timeout: 100,
											out: function () {
												$dropdownHolder.stop().animate(
													{
														'height': '0',
														'opacity': 0,
													},
													100,
													function () {
														$dropdownHolder.css(
															{
																'overflow': 'hidden',
																'visibility': 'hidden',
															}
														);
													}
												);

												$dropdownHolder.removeClass( 'qodef-drop-down--start' );
											}
										};

										$thisItem.hoverIntent( animateConfig );
									} else {
										var config = {
											interval: 0,
											over: function () {
												setTimeout(
													function () {
														$dropdownHolder.addClass( 'qodef-drop-down--start' ).stop().css( { 'height': dropDownHolderHeight } );
													},
													150
												);
											},
											timeout: 150,
											out: function () {
												$dropdownHolder.stop().css( { 'height': '0' } ).removeClass( 'qodef-drop-down--start' );
											}
										};

										$thisItem.hoverIntent( config );
									}
								}
							}
						);
					}
				}
			);
		},
		wideDropdownPosition: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li.qodef-menu-item--wide' );

			if ( $menuItems.length ) {
				$menuItems.each(
					function () {
						var $menuItem        = $( this );
						var $menuItemSubMenu = $menuItem.find( '.qodef-drop-down-second' );

						if ( $menuItemSubMenu.length ) {
							$menuItemSubMenu.css( 'left', 0 );

							var leftPosition = $menuItemSubMenu.offset().left;

							if ( qodefCore.body.hasClass( 'qodef--boxed' ) ) {
								//boxed layout case
								var boxedWidth = $( '.qodef--boxed #qodef-page-wrapper' ).outerWidth();
								leftPosition   = leftPosition - (qodefCore.windowWidth - boxedWidth) / 2;
								$menuItemSubMenu.css( { 'left': -leftPosition, 'width': boxedWidth } );

							} else if ( qodefCore.body.hasClass( 'qodef-drop-down-second--full-width' ) ) {
								//wide dropdown full width case
								$menuItemSubMenu.css( { 'left': -leftPosition, 'width': qodefCore.windowWidth } );
							} else {
								//wide dropdown in grid case
								$menuItemSubMenu.css( { 'left': -leftPosition + (qodefCore.windowWidth - $menuItemSubMenu.width()) / 2 } );
							}
						}
					}
				);
			}
		},
		dropdownPosition: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li.qodef-menu-item--narrow.menu-item-has-children' );

			if ( $menuItems.length ) {
				$menuItems.each(
					function () {
						var $thisItem         = $( this ),
							menuItemPosition  = $thisItem.offset().left,
							$dropdownHolder   = $thisItem.find( '.qodef-drop-down-second' ),
							$dropdownMenuItem = $dropdownHolder.find( '.qodef-drop-down-second-inner ul' ),
							dropdownMenuWidth = $dropdownMenuItem.outerWidth(),
							menuItemFromLeft  = $( window ).width() - menuItemPosition;

						if ( qodef.body.hasClass( 'qodef--boxed' ) ) {
							//boxed layout case
							var boxedWidth   = $( '.qodef--boxed #qodef-page-wrapper' ).outerWidth();
							menuItemFromLeft = boxedWidth - menuItemPosition;
						}

						var dropDownMenuFromLeft;

						if ( $thisItem.find( 'li.menu-item-has-children' ).length > 0 ) {
							dropDownMenuFromLeft = menuItemFromLeft - dropdownMenuWidth;
						}

						$dropdownHolder.removeClass( 'qodef-drop-down--right' );
						$dropdownMenuItem.removeClass( 'qodef-drop-down--right' );
						if ( menuItemFromLeft < dropdownMenuWidth || dropDownMenuFromLeft < dropdownMenuWidth ) {
							$dropdownHolder.addClass( 'qodef-drop-down--right' );
							$dropdownMenuItem.addClass( 'qodef-drop-down--right' );
						}
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefParallaxBackground.init();
		}
	);

	/**
	 * Init global parallax background functionality
	 */
	var qodefParallaxBackground = {
		init: function ( settings ) {
			this.$sections = $( '.qodef-parallax' );

			// Allow overriding the default config
			$.extend( this.$sections, settings );

			var isSupported = ! qodefCore.html.hasClass( 'touchevents' ) && ! qodefCore.body.hasClass( 'qodef-browser--edge' ) && ! qodefCore.body.hasClass( 'qodef-browser--ms-explorer' );

			if ( this.$sections.length && isSupported ) {
				this.$sections.each(
					function () {
						qodefParallaxBackground.ready( $( this ) );
					}
				);
			}
		},
		ready: function ( $section ) {
			$section.$imgHolder  = $section.find( '.qodef-parallax-img-holder' );
			$section.$imgWrapper = $section.find( '.qodef-parallax-img-wrapper' );
			$section.$img        = $section.find( 'img.qodef-parallax-img' );

			var h           = $section.height(),
				imgWrapperH = $section.$imgWrapper.height();

			$section.movement = 100 * (imgWrapperH - h) / h / 2; //percentage (divided by 2 due to absolute img centering in CSS)

			$section.buffer       = window.pageYOffset;
			$section.scrollBuffer = null;


			//calc and init loop
			requestAnimationFrame(
				function () {
					$section.$imgHolder.animate( { opacity: 1 }, 100 );
					qodefParallaxBackground.calc( $section );
					qodefParallaxBackground.loop( $section );
				}
			);

			//recalc
			$( window ).on(
				'resize',
				function () {
					qodefParallaxBackground.calc( $section );
				}
			);
		},
		calc: function ( $section ) {
			var wH = $section.$imgWrapper.height(),
				wW = $section.$imgWrapper.width();

			if ( $section.$img.width() < wW ) {
				$section.$img.css(
					{
						'width': '100%',
						'height': 'auto',
					}
				);
			}

			if ( $section.$img.height() < wH ) {
				$section.$img.css(
					{
						'height': '100%',
						'width': 'auto',
						'max-width': 'unset',
					}
				);
			}
		},
		loop: function ( $section ) {
			if ( $section.scrollBuffer === Math.round( window.pageYOffset ) ) {
				requestAnimationFrame(
					function () {
						qodefParallaxBackground.loop( $section );
					}
				); //repeat loop

				return false; //same scroll value, do nothing
			} else {
				$section.scrollBuffer = Math.round( window.pageYOffset );
			}

			var wH   = window.outerHeight,
				sTop = $section.offset().top,
				sH   = $section.height();

			if ( $section.scrollBuffer + wH * 1.2 > sTop && $section.scrollBuffer < sTop + sH ) {
				var delta = (Math.abs( $section.scrollBuffer + wH - sTop ) / (wH + sH)).toFixed( 4 ), //coeff between 0 and 1 based on scroll amount
					yVal  = (delta * $section.movement).toFixed( 4 );

				if ( $section.buffer !== delta ) {
					$section.$imgWrapper.css( 'transform', 'translate3d(0,' + yVal + '%, 0)' );
				}

				$section.buffer = delta;
			}

			requestAnimationFrame(
				function () {
					qodefParallaxBackground.loop( $section );
				}
			); //repeat loop
		}
	};

	qodefCore.qodefParallaxBackground = qodefParallaxBackground;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefReview.init();
		}
	);

	var qodefReview = {
		init: function () {
			var ratingHolder = $( '#qodef-page-comments-form .qodef-rating-inner' );

			var addActive = function ( stars, ratingValue ) {
				for ( var i = 0; i < stars.length; i++ ) {
					var star = stars[i];

					if ( i < ratingValue ) {
						$( star ).addClass( 'active' );
					} else {
						$( star ).removeClass( 'active' );
					}
				}
			};

			ratingHolder.each(
				function () {
					var thisHolder  = $( this ),
						ratingInput = thisHolder.find( '.qodef-rating' ),
						ratingValue = ratingInput.val(),
						stars       = thisHolder.find( '.qodef-star-rating' );

					addActive( stars, ratingValue );

					stars.on(
						'click',
						function () {
							ratingInput.val( $( this ).data( 'value' ) ).trigger( 'change' );
						}
					);

					ratingInput.change(
						function () {
							ratingValue = ratingInput.val();

							addActive( stars, ratingValue );
						}
					);
				}
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideArea.init();
		}
	);

	var qodefSideArea = {
		init: function () {
			var $sideAreaOpener = $( 'a.qodef-side-area-opener' ),
				$sideAreaClose  = $( '#qodef-side-area-close' ),
				$sideArea       = $( '#qodef-side-area' );

			qodefSideArea.openerHoverColor( $sideAreaOpener );

			// Open Side Area
			$sideAreaOpener.on(
				'click',
				function ( e ) {
					e.preventDefault();

					if ( ! qodefCore.body.hasClass( 'qodef-side-area--opened' ) ) {
						qodefSideArea.openSideArea();

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefSideArea.closeSideArea();
								}
							}
						);
					} else {
						qodefSideArea.closeSideArea();
					}
				}
			);

			$sideAreaClose.on(
				'click',
				function ( e ) {
					e.preventDefault();
					qodefSideArea.closeSideArea();
				}
			);

			if ( $sideArea.length && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $sideArea );
			}
		},
		openSideArea: function () {
			var $wrapper      = $( '#qodef-page-wrapper' );
			var currentScroll = $( window ).scrollTop();

			$( '.qodef-side-area-cover' ).remove();
			$wrapper.prepend( '<div class="qodef-side-area-cover"/>' );
			qodefCore.body.removeClass( 'qodef-side-area-animate--out' ).addClass( 'qodef-side-area--opened qodef-side-area-animate--in' );

			$( '.qodef-side-area-cover' ).on(
				'click',
				function ( e ) {
					e.preventDefault();
					qodefSideArea.closeSideArea();
				}
			);

			$( window ).scroll(
				function () {
					if ( Math.abs( qodefCore.scroll - currentScroll ) > 400 ) {
						qodefSideArea.closeSideArea();
					}
				}
			);
		},
		closeSideArea: function () {
			qodefCore.body.removeClass( 'qodef-side-area--opened qodef-side-area-animate--in' ).addClass( 'qodef-side-area-animate--out' );
		},
		openerHoverColor: function ( $opener ) {
			if ( typeof $opener.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $opener.data( 'hover-color' );
				var originalColor = $opener.css( 'color' );

				$opener.on(
					'mouseenter',
					function () {
						$opener.css( 'color', hoverColor );
					}
				).on(
					'mouseleave',
					function () {
						$opener.css( 'color', originalColor );
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSpinner.init();
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				qodefSpinner.init( isEditMode );
			}
		}
	);

	var qodefSpinner = {
		init: function ( isEditMode ) {
			this.holder = $( '#qodef-page-spinner:not(.qodef-layout--valeska)' );

			if ( this.holder.length ) {
				qodefSpinner.animateSpinner( this.holder, isEditMode );
				qodefSpinner.fadeOutAnimation();
			}
		},
		animateSpinner: function ( $holder, isEditMode ) {
			$( window ).on(
				'load',
				function () {
					qodefSpinner.fadeOutLoader( $holder );
				}
			);

			if ( isEditMode ) {
				qodefSpinner.fadeOutLoader( $holder );
			}
		},
		fadeOutLoader: function ( $holder, speed, delay, easing ) {
			speed  = speed ? speed : 600;
			delay  = delay ? delay : 0;
			easing = easing ? easing : 'swing';

			$holder.delay( delay ).fadeOut( speed, easing );

			$( window ).on(
				'bind',
				'pageshow',
				function ( event ) {
					if ( event.originalEvent.persisted ) {
						$holder.fadeOut( speed, easing );
					}
				}
			);
		},
		fadeOutAnimation: function () {

			// Check for fade out animation
			if ( qodefCore.body.hasClass( 'qodef-spinner--fade-out' ) ) {
				var $pageHolder = $( '#qodef-page-wrapper' ),
					$linkItems  = $( 'a' );

				// If back button is pressed, than show content to avoid state where content is on display:none
				window.addEventListener(
					'pageshow',
					function ( event ) {
						var historyPath = event.persisted || (typeof window.performance !== 'undefined' && window.performance.navigation.type === 2);
						if ( historyPath && ! $pageHolder.is( ':visible' ) ) {
							$pageHolder.show();
						}
					}
				);

				$linkItems.on(
					'click',
					function ( e ) {
						var $clickedLink = $( this );

						if (
							e.which === 1 && // check if the left mouse button has been pressed
							$clickedLink.attr( 'href' ).indexOf( window.location.host ) >= 0 && // check if the link is to the same domain
							! $clickedLink.hasClass( 'remove' ) && // check is WooCommerce remove link
							$clickedLink.parent( '.product-remove' ).length <= 0 && // check is WooCommerce remove link
							$clickedLink.parents( '.woocommerce-product-gallery__image' ).length <= 0 && // check is product gallery link
							typeof $clickedLink.data( 'rel' ) === 'undefined' && // check pretty photo link
							typeof $clickedLink.attr( 'rel' ) === 'undefined' && // check VC pretty photo link
							! $clickedLink.hasClass( 'lightbox-active' ) && // check is lightbox plugin active
							(typeof $clickedLink.attr( 'target' ) === 'undefined' || $clickedLink.attr( 'target' ) === '_self') && // check if the link opens in the same window
							$clickedLink.attr( 'href' ).split( '#' )[0] !== window.location.href.split( '#' )[0] // check if it is an anchor aiming for a different page
						) {
							e.preventDefault();

							$pageHolder.fadeOut(
								600,
								'easeOutSine',
								function () {
									window.location = $clickedLink.attr( 'href' );
								}
							);
						}
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefSubscribeModal.init();
		}
	);

	var qodefSubscribeModal = {
		init: function () {
			this.holder = $( '#qodef-subscribe-popup-modal' );

			if ( this.holder.length ) {
				var $preventHolder = this.holder.find( '.qodef-sp-prevent-inner' ),
					$modalClose    = $( '.qodef-sp-close' ),
					disabledPopup  = 'no';

				if ( $preventHolder.length ) {
					var isLocalStorage = this.holder.hasClass( 'qodef-sp-prevent-cookies' ),
						$preventInput  = $preventHolder.find( '.qodef-sp-prevent-input' );

					if ( isLocalStorage ) {
						disabledPopup = localStorage.getItem( 'disabledPopup' );
						sessionStorage.removeItem( 'disabledPopup' );
					} else {
						disabledPopup = sessionStorage.getItem( 'disabledPopup' );
						localStorage.removeItem( 'disabledPopup' );
					}

					$preventHolder.children().on(
						'click',
						function ( e ) {
							$preventInput.val(this.checked);

							if ( $preventInput.attr('value') === 'true' ) {
								if ( isLocalStorage ) {
									localStorage.setItem( 'disabledPopup', 'yes' );
								} else {
									sessionStorage.setItem( 'disabledPopup', 'yes' );
								}
							} else {
								if ( isLocalStorage ) {
									localStorage.setItem( 'disabledPopup', 'no' );
								} else {
									sessionStorage.setItem( 'disabledPopup', 'no' );
								}
							}
						}
					);
				}

				if ( disabledPopup !== 'yes' ) {
					if ( qodefCore.body.hasClass( 'qodef-sp-opened' ) ) {
						qodefSubscribeModal.handleClassAndScroll( 'remove' );
					} else {
						qodefSubscribeModal.handleClassAndScroll( 'add' );
					}

					$modalClose.on(
						'click',
						function ( e ) {
							e.preventDefault();

							qodefSubscribeModal.handleClassAndScroll( 'remove' );
						}
					);

					// Close on escape
					$( document ).keyup(
						function ( e ) {
							if ( e.keyCode === 27 ) { // KeyCode for ESC button is 27
								qodefSubscribeModal.handleClassAndScroll( 'remove' );
							}
						}
					);
				}
			}
		},

		handleClassAndScroll: function ( option ) {
			if ( option === 'remove' ) {
				qodefCore.body.removeClass( 'qodef-sp-opened' );
			}

			if ( option === 'add' ) {
				qodefCore.body.addClass( 'qodef-sp-opened' );
			}
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefWishlist.init();
		}
	);

	/**
	 * Function object that represents wishlist area popup.
	 * @returns {{init: Function}}
	 */
	var qodefWishlist = {
		init: function () {
			var $wishlistLink = $( '.qodef-wishlist .qodef-m-link' );

			if ( $wishlistLink.length ) {
				$wishlistLink.each(
					function () {
						var $thisWishlistLink = $( this ),
							wishlistIconHTML  = $thisWishlistLink.html(),
							$responseMessage  = $thisWishlistLink.siblings( '.qodef-m-response' );

						$thisWishlistLink.off().on(
							'click',
							function ( e ) {
								e.preventDefault();

								if ( qodefCore.body.hasClass( 'logged-in' ) ) {
									var itemID = $thisWishlistLink.data( 'id' );

									if ( itemID !== 'undefined' && ! $thisWishlistLink.hasClass( 'qodef--added' ) ) {
										$thisWishlistLink.html( '<span class="fa fa-spinner fa-spin" aria-hidden="true"></span>' );

										var wishlistData = {
											type: 'add',
											itemID: itemID,
										};

										$.ajax(
											{
												type: 'POST',
												url: qodefGlobal.vars.restUrl + qodefGlobal.vars.wishlistRestRoute,
												data: {
													options: wishlistData,
												},
												beforeSend: function ( request ) {
													request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
												},
												success: function ( response ) {

													if ( response.status === 'success' ) {
														$thisWishlistLink.addClass( 'qodef--added' );
														$responseMessage.html( response.message ).addClass( 'qodef--show' ).fadeIn( 200 );

														$( document ).trigger(
															'valeska_core_wishlist_item_is_added',
															[itemID, response.data.user_id]
														);
													} else {
														$responseMessage.html( response.message ).addClass( 'qodef--show' ).fadeIn( 200 );
													}

													setTimeout(
														function () {
															$thisWishlistLink.html( wishlistIconHTML );

															var $wishlistTitle = $thisWishlistLink.find( '.qodef-m-link-label' );

															if ( $wishlistTitle.length ) {
																$wishlistTitle.text( $wishlistTitle.data( 'added-title' ) );
															}

															$responseMessage.fadeOut( 300 ).removeClass( 'qodef--show' ).empty();
														},
														800
													);
												}
											}
										);
									}
								} else {
									// Trigger event.
									$( document.body ).trigger( 'valeska_membership_trigger_login_modal' );
								}
							}
						);
					}
				);
			}
		}
	};

	$( document ).on(
		'valeska_core_wishlist_item_is_removed',
		function ( e, removedItemID ) {
			var $wishlistLink = $( '.qodef-wishlist .qodef-m-link' );

			if ( $wishlistLink.length ) {
				$wishlistLink.each(
					function () {
						var $thisWishlistLink = $( this ),
							$wishlistTitle    = $thisWishlistLink.find( '.qodef-m-link-label' );

						if ( $thisWishlistLink.data( 'id' ) === removedItemID && $thisWishlistLink.hasClass( 'qodef--added' ) ) {
							$thisWishlistLink.removeClass( 'qodef--added' );

							if ( $wishlistTitle.length ) {
								$wishlistTitle.text( $wishlistTitle.data( 'title' ) );
							}
						}
					}
				);
			}
		}
	);

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_accordion = {};

	$( document ).ready(
		function () {
			qodefAccordion.init();
		}
	);

	var qodefAccordion = {
		init: function () {
			var $holder = $( '.qodef-accordion' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						qodefAccordion.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			if ( $currentItem.hasClass( 'qodef-behavior--accordion' ) ) {
				qodefAccordion.initAccordion( $currentItem );
			}

			if ( $currentItem.hasClass( 'qodef-behavior--toggle' ) ) {
				qodefAccordion.initToggle( $currentItem );
			}

			$currentItem.addClass( 'qodef--init' );
		},
		initAccordion: function ( $accordion ) {
			$accordion.accordion(
				{
					animate: 'swing',
					collapsible: true,
					active: 0,
					icons: '',
					heightStyle: 'fill',
				}
			);
		},
		initToggle: function ( $toggle ) {
			var $toggleAccordionTitle = $toggle.find( '.qodef-accordion-title' );

			$toggleAccordionTitle.off().on(
				'mouseenter',
				function () {
					$( this ).addClass( 'ui-state-hover' );
				}
			).on(
				'mouseleave',
				function () {
					$( this ).removeClass( 'ui-state-hover' );
				}
			).on(
				'click',
				function () {
					var $thisTitle = $( this );

					if ( $thisTitle.hasClass( 'ui-state-active' ) ) {
						$thisTitle.removeClass( 'ui-state-active' );
						$thisTitle.next().removeClass( 'ui-accordion-content-active' ).slideUp( 300 );
					} else {
						$thisTitle.addClass( 'ui-state-active' );
						$thisTitle.next().addClass( 'ui-accordion-content-active' ).slideDown( 400 );
					}
				}
			);
		}
	};

	qodefCore.shortcodes.valeska_core_accordion.qodefAccordion = qodefAccordion;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefAuthorListPagination.init();
		}
	);

	$( window ).scroll(
		function () {
			qodefAuthorListPagination.scroll();
		}
	);

	$( document ).on(
		'valeska_core_trigger_author_load_more',
		function ( e, $holder, nextPage ) {
			qodefAuthorListPagination.triggerLoadMore( $holder, nextPage );
		}
	);

	/*
	 **	Init pagination functionality
	 */
	var qodefAuthorListPagination = {
		init: function ( settings ) {
			this.holder = $( '.qodef-author-pagination--on' );

			// Allow overriding the default config
			$.extend( this.holder, settings );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $holder = $( this );

						qodefAuthorListPagination.initPaginationType( $holder );
					}
				);
			}
		},
		scroll: function ( settings ) {
			this.holder = $( '.qodef-author-pagination--on' );

			// Allow overriding the default config
			$.extend( this.holder, settings );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $holder = $( this );

						if ( $holder.hasClass( 'qodef-pagination-type--infinite-scroll' ) ) {
							qodefAuthorListPagination.initInfiniteScroll( $holder );
						}
					}
				);
			}
		},
		initPaginationType: function ( $holder ) {
			if ( $holder.hasClass( 'qodef-pagination-type--standard' ) ) {
				qodefAuthorListPagination.initStandard( $holder );
			} else if ( $holder.hasClass( 'qodef-pagination-type--load-more' ) ) {
				qodefAuthorListPagination.initLoadMore( $holder );
			} else if ( $holder.hasClass( 'qodef-pagination-type--infinite-scroll' ) ) {
				qodefAuthorListPagination.initInfiniteScroll( $holder );
			}
		},
		initStandard: function ( $holder ) {
			var $paginationItems = $holder.find( '.qodef-m-pagination-items' );

			if ( $paginationItems.length ) {
				var options = $holder.data( 'options' );

				$paginationItems.children().each( function () {
					var $thisItem = $( this ),
						$itemLink = $thisItem.children( 'a' );

					qodefAuthorListPagination.changeStandardState( $holder, options.max_num_pages, 1 );

					$itemLink.on(
						'click',
						function ( e ) {
							e.preventDefault();

							if ( ! $thisItem.hasClass( 'qodef--active' ) ) {
								qodefAuthorListPagination.getNewPosts( $holder, $itemLink.data( 'paged' ) );
							}
						}
					);
				} );
			}
		},
		changeStandardState: function ( $holder, max_num_pages, nextPage ) {
			if ( $holder.hasClass( 'qodef-pagination-type--standard' ) ) {
				var $paginationNav = $holder.find( '.qodef-m-pagination-items' ),
					$numericItem   = $paginationNav.children( '.qodef--number' ),
					$prevItem      = $paginationNav.children( '.qodef--prev' ),
					$nextItem      = $paginationNav.children( '.qodef--next' );

				$numericItem.removeClass( 'qodef--active' ).eq( nextPage - 1 ).addClass( 'qodef--active' );

				$prevItem.children().data( 'paged', nextPage - 1 );

				if ( nextPage > 1 ) {
					$prevItem.show();
				} else {
					$prevItem.hide();
				}

				$nextItem.children().data( 'paged', nextPage + 1 );

				if ( nextPage === max_num_pages ) {
					$nextItem.hide();
				} else {
					$nextItem.show();
				}
			}
		},
		initLoadMore: function ( $holder ) {
			var $loadMoreButton = $holder.find( '.qodef-load-more-button' );

			$loadMoreButton.on(
				'click',
				function ( e ) {
					e.preventDefault();

					qodefAuthorListPagination.getNewPosts( $holder );
				}
			);
		},
		triggerLoadMore: function ( $holder, nextPage ) {
			qodefAuthorListPagination.getNewPosts( $holder, nextPage );
		},
		hideLoadMoreButton: function ( $holder, options ) {
			if ( $holder.hasClass( 'qodef-pagination-type--load-more' ) && options.next_page > options.max_num_pages ) {
				$holder.find( '.qodef-load-more-button' ).hide();
			}
		},
		initInfiniteScroll: function ( $holder ) {
			var holderEndPosition = $holder.outerHeight() + $holder.offset().top,
				scrollPosition    = qodefCore.scroll + qodefCore.windowHeight,
				options           = $holder.data( 'options' );

			if ( ! $holder.hasClass( 'qodef--loading' ) && scrollPosition > holderEndPosition && options.max_num_pages >= options.next_page ) {
				qodefAuthorListPagination.getNewPosts( $holder );
			}
		},
		getNewPosts: function ( $holder, nextPage ) {
			$holder.addClass( 'qodef--loading' );

			var $itemsHolder = $holder.children( '.qodef-grid-inner' );
			var options      = $holder.data( 'options' );

			qodefAuthorListPagination.setNextPageValue( options, nextPage, false );

			$.ajax(
				{
					type: 'GET',
					url: qodefGlobal.vars.restUrl + qodefGlobal.vars.authorPaginationRestRoute,
					data: {
						options: options,
					},
					beforeSend: function ( request ) {
						request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
					},
					success: function ( response ) {

						if ( response.status === 'success' ) {
							qodefAuthorListPagination.setNextPageValue( options, nextPage, true );
							qodefAuthorListPagination.changeStandardState( $holder, options.max_num_pages, nextPage );

							$itemsHolder.waitForImages(
								function () {
									qodefAuthorListPagination.addPosts( $itemsHolder, response.data, nextPage );

									qodefCore.body.trigger(
										'valeska_core_trigger_get_new_authors',
										[$holder]
									);
								}
							);

							qodefAuthorListPagination.hideLoadMoreButton( $holder, options );
						} else {
							console.log( response.message );
						}
					},
					complete: function () {
						$holder.removeClass( 'qodef--loading' );
					}
				}
			);
		},
		setNextPageValue: function ( options, nextPage, ajaxTrigger ) {
			if ( typeof nextPage !== 'undefined' && nextPage !== '' && ! ajaxTrigger ) {
				options.next_page = nextPage;
			} else if ( ajaxTrigger ) {
				options.next_page = parseInt( options.next_page, 10 ) + 1;
			}
		},
		addPosts: function ( $itemsHolder, newItems, nextPage ) {
			if ( typeof nextPage !== 'undefined' && nextPage !== '' ) {
				$itemsHolder.html( newItems );
			} else {
				$itemsHolder.append( newItems );
			}
		}
	};

})( jQuery );

(function ( $ ) {
    'use strict';

    var shortcode = 'valeska_core_banner';

    qodefCore.shortcodes[shortcode] = {};

    if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
        $.each(
            qodefCore.listShortcodesScripts,
            function ( key, value ) {
                qodefCore.shortcodes[shortcode][key] = value;
            }
        );
    }

    $( window ).on(
        'load',
        () => {
            qodefBanner.init();
        }
    );

    var qodefBanner = {
        init () {
            this.banner = $('.qodef-banner');

            if ( this.banner.length ) {
                this.banner.each(
                    ( index, element ) => {
                        const $thisBanner = $( element );

                        if ( $thisBanner.hasClass('qodef-hover-animation--yes') ) {
                            qodefBanner.linkHover( $thisBanner );
                        }
                    }
                );
            }
        },
        linkHover ( $holder ) {
            const $button = $holder.find('.qodef-button');

            $button.on(
                'mouseenter',
                () => {
                    $holder.addClass('qodef--active');
                }
            );

            $button.on(
                'mouseleave',
                () => {
                    $holder.removeClass('qodef--active');
                }
            );
        }
    };

    qodefCore.shortcodes[shortcode].qodefBanner = qodefBanner;

})( jQuery );
(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_billboard = {};

	$( document ).ready(
		function () {
			qodefBillboard.init();
		}
	);

	var qodefBillboard = {
		init: function () {
			this.holder = $( '.qodef-billboard' );

			if ( this.holder.length ) {

				if ( this.holder.hasClass( 'qodef-effect--scale' ) ) {
					if ( $( window ).width() > 1024 ) {
						skrollr.init( { forceHeight: false } );
					}
				}
			}
		},
	};

	qodefCore.shortcodes.valeska_core_billboard.qodefBillboard = qodefBillboard;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_button = {};

	$( document ).ready(
		function () {
			qodefButton.init();
		}
	);

	var qodefButton = {
		init: function () {
			this.buttons = $( '.qodef-button' );

			if ( this.buttons.length ) {
				this.buttons.each(
					function () {
						qodefButton.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefButton.buttonHoverColor( $currentItem );
			qodefButton.buttonHoverBgColor( $currentItem );
			qodefButton.buttonHoverBorderColor( $currentItem );
		},
		buttonHoverColor: function ( $button ) {
			if ( typeof $button.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $button.data( 'hover-color' );
				var originalColor = $button.css( 'color' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'color', hoverColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'color', originalColor );
					}
				);
			}
		},
		buttonHoverBgColor: function ( $button ) {
			if ( typeof $button.data( 'hover-background-color' ) !== 'undefined' ) {
				var hoverBackgroundColor    = $button.data( 'hover-background-color' );
				var originalBackgroundColor = $button.css( 'background-color' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'background-color', hoverBackgroundColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'background-color', originalBackgroundColor );
					}
				);
			}
		},
		buttonHoverBorderColor: function ( $button ) {
			if ( typeof $button.data( 'hover-border-color' ) !== 'undefined' ) {
				var hoverBorderColor    = $button.data( 'hover-border-color' );
				var originalBorderColor = $button.css( 'borderTopColor' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'border-color', hoverBorderColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'border-color', originalBorderColor );
					}
				);
			}
		},
		changeColor: function ( $button, cssProperty, color ) {
			$button.css( cssProperty, color );
		}
	};

	qodefCore.shortcodes.valeska_core_button.qodefButton = qodefButton;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_cards_gallery = {};

	$( document ).ready(
		function () {
			qodefCardsGallery.init();
		}
	);

	var qodefCardsGallery = {
		init: function () {
			this.holder = $( '.qodef-cards-gallery' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefCardsGallery.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefCardsGallery.initCards( $currentItem );
			qodefCardsGallery.initBundle( $currentItem );
		},
		initCards: function ( $holder ) {
			var $cards = $holder.find( '.qodef-m-card' );
			$cards.each(
				function () {
					var $card = $( this );

					$card.on(
						'click',
						function () {
							if ( ! $cards.last().is( $card ) ) {
								$card.addClass( 'qodef-out qodef-animating' ).siblings().addClass( 'qodef-animating-siblings' );
								$card.detach();
								$card.insertAfter( $cards.last() );

								setTimeout(
									function () {
										$card.removeClass( 'qodef-out' );
									},
									200
								);

								setTimeout(
									function () {
										$card.removeClass( 'qodef-animating' ).siblings().removeClass( 'qodef-animating-siblings' );
									},
									1200
								);

								$cards = $holder.find( '.qodef-m-card' );

								return false;
							}
						}
					);
				}
			);
		},
		initBundle: function ( $holder ) {
			if ( $holder.hasClass( 'qodef-animation--bundle' ) && ! qodefCore.html.hasClass( 'touchevents' ) ) {
				$holder.appear(
					function () {
						$holder.addClass( 'qodef-appeared' );
						$holder.find( 'img' ).one(
							'animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd',
							function () {
								$( this ).addClass( 'qodef-animation-done' );
							}
						);
					},
					{ accX: 0, accY: -100 }
				);
			}
		}
	};

	qodefCore.shortcodes.valeska_core_cards_gallery.qodefCardsGallery = qodefCardsGallery;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_countdown = {};

	$( document ).ready(
		function () {
			qodefCountdown.init();
		}
	);

	var qodefCountdown = {
		init: function () {
			this.countdowns = $( '.qodef-countdown' );

			if ( this.countdowns.length ) {
				this.countdowns.each(
					function () {
						qodefCountdown.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $countdownElement = $currentItem.find( '.qodef-m-date' ),
				options           = qodefCountdown.generateOptions( $currentItem );

			qodefCountdown.initCountdown( $countdownElement, options );
		},
		generateOptions: function ( $countdown ) {
			var options  = {};
			options.date = typeof $countdown.data( 'date' ) !== 'undefined' ? $countdown.data( 'date' ) : null;

			options.weekLabel       = typeof $countdown.data( 'week-label' ) !== 'undefined' ? $countdown.data( 'week-label' ) : '';
			options.weekLabelPlural = typeof $countdown.data( 'week-label-plural' ) !== 'undefined' ? $countdown.data( 'week-label-plural' ) : '';

			options.dayLabel       = typeof $countdown.data( 'day-label' ) !== 'undefined' ? $countdown.data( 'day-label' ) : '';
			options.dayLabelPlural = typeof $countdown.data( 'day-label-plural' ) !== 'undefined' ? $countdown.data( 'day-label-plural' ) : '';

			options.hourLabel       = typeof $countdown.data( 'hour-label' ) !== 'undefined' ? $countdown.data( 'hour-label' ) : '';
			options.hourLabelPlural = typeof $countdown.data( 'hour-label-plural' ) !== 'undefined' ? $countdown.data( 'hour-label-plural' ) : '';

			options.minuteLabel       = typeof $countdown.data( 'minute-label' ) !== 'undefined' ? $countdown.data( 'minute-label' ) : '';
			options.minuteLabelPlural = typeof $countdown.data( 'minute-label-plural' ) !== 'undefined' ? $countdown.data( 'minute-label-plural' ) : '';

			options.secondLabel       = typeof $countdown.data( 'second-label' ) !== 'undefined' ? $countdown.data( 'second-label' ) : '';
			options.secondLabelPlural = typeof $countdown.data( 'second-label-plural' ) !== 'undefined' ? $countdown.data( 'second-label-plural' ) : '';

			return options;
		},
		initCountdown: function ( $countdownElement, options ) {
			var $weekHTML   = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%w</span><span class="qodef-label">' + '%!w:' + options.weekLabel + ',' + options.weekLabelPlural + ';</span></span>';
			var $dayHTML    = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%d</span><span class="qodef-label">' + '%!d:' + options.dayLabel + ',' + options.dayLabelPlural + ';</span></span>';
			var $hourHTML   = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%H</span><span class="qodef-label">' + '%!H:' + options.hourLabel + ',' + options.hourLabelPlural + ';</span></span>';
			var $minuteHTML = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%M</span><span class="qodef-label">' + '%!M:' + options.minuteLabel + ',' + options.minuteLabelPlural + ';</span></span>';
			var $secondHTML = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%S</span><span class="qodef-label">' + '%!S:' + options.secondLabel + ',' + options.secondLabelPlural + ';</span></span>';

			$countdownElement.countdown(
				options.date,
				function ( event ) {
					$( this ).html( event.strftime( $weekHTML + $dayHTML + $hourHTML + $minuteHTML + $secondHTML ) );
				}
			);
		}
	};

	qodefCore.shortcodes.valeska_core_countdown.qodefCountdown = qodefCountdown;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_counter = {};

	$( document ).ready(
		function () {
			qodefCounter.init();
		}
	);

	var qodefCounter = {
		init: function () {
			this.counters = $( '.qodef-counter' );

			if ( this.counters.length ) {
				this.counters.each(
					function () {
						qodefCounter.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $counterElement = $currentItem.find( '.qodef-m-digit' ),
				options         = qodefCounter.generateOptions( $currentItem );

			qodefCounter.counterScript( $counterElement, options );
		},
		generateOptions: function ( $counter ) {
			var options   = {};
			options.start = typeof $counter.data( 'start-digit' ) !== 'undefined' && $counter.data( 'start-digit' ) !== '' ? $counter.data( 'start-digit' ) : 0;
			options.end   = typeof $counter.data( 'end-digit' ) !== 'undefined' && $counter.data( 'end-digit' ) !== '' ? $counter.data( 'end-digit' ) : null;
			options.step  = typeof $counter.data( 'step-digit' ) !== 'undefined' && $counter.data( 'step-digit' ) !== '' ? $counter.data( 'step-digit' ) : 1;
			options.delay = typeof $counter.data( 'step-delay' ) !== 'undefined' && $counter.data( 'step-delay' ) !== '' ? parseInt( $counter.data( 'step-delay' ), 10 ) : 100;
			options.txt   = typeof $counter.data( 'digit-label' ) !== 'undefined' && $counter.data( 'digit-label' ) !== '' ? $counter.data( 'digit-label' ) : '';

			return options;
		},
		counterScript: function ( $counterElement, options ) {
			var defaults = {
				start: 0,
				end: null,
				step: 1,
				delay: 50,
				txt: '',
			};

			var settings = $.extend( defaults, options || {} );
			var nb_start = settings.start;
			var nb_end   = settings.end;

			$counterElement.text( nb_start + settings.txt );

			var counter = function () {
				// Definition of conditions of arrest
				if ( nb_end !== null && nb_start >= nb_end ) {
					return;
				}
				// incrementation
				nb_start = nb_start + settings.step;

				if ( nb_start >= nb_end ) {
					nb_start = nb_end;
				}
				// display
				$counterElement.text( nb_start + settings.txt );
			};

			// Timer
			// Launches every "settings.delay"
			$counterElement.appear(
				function () {
					setInterval( counter, settings.delay );
				},
				{ accX: 0, accY: 0 }
			);
		}
	};

	qodefCore.shortcodes.valeska_core_counter.qodefCounter = qodefCounter;

})( jQuery );

(function ( $ ) {
    'use strict';

    var shortcode = 'valeska_core_custom_font';

    qodefCore.shortcodes[shortcode] = {};

    if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
        $.each(
            qodefCore.listShortcodesScripts,
            function ( key, value ) {
                qodefCore.shortcodes[shortcode][key] = value;
            }
        );
    }

    $( window ).on(
        'load',
        () => {
            qodefCustomFont.init();
        }
    );

    var qodefCustomFont = {
        init () {
            this.customFont = $('.qodef-custom-font');

            if ( this.customFont.length ) {
                this.customFont.each(
                    ( index, element ) => {
                        const $thisCustomFont = $( element );

                        if ( $thisCustomFont.hasClass('qodef-custom-font-appear-animation--yes') ) {
                            qodefCustomFont.appearAnimation( $thisCustomFont );
                        }
                    }
                );
            }
        },
        appearAnimation ( $holder ) {
            qodefCore.qodefIsInViewport.check(
                $holder,
                () => {
                    const $titleParts = $holder.find('.qodef-m-title-part'),
                          delay       = $holder.data('appearing-delay');

                    setTimeout(
                        () => {
                            $holder.addClass('qodef-appeared');
                        }, delay
                    );

                    if ( $titleParts.length ) {
                        $titleParts.each(
                            ( index, element ) => {
                                const $thisTitlePart = $( element );

                                setTimeout(
                                    () => {
                                        $thisTitlePart.addClass('qodef-appeared');
                                    }, index * 180 + ( delay + 80 )
                                );
                            }
                        );
                    }
                }
            );
        }
    };

    qodefCore.shortcodes[shortcode].qodefCustomFont = qodefCustomFont;

})( jQuery );
(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_frame_slider = {};

	$( document ).ready(
		function () {
			qodefFrameSlider.init();
		}
	);

	var qodefFrameSlider = {
		init: function () {
			this.holder = $( '.qodef-frame-slider-holder' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefFrameSlider.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $holder ) {
			var $swiperHolder = $holder.find( '.qodef-m-swiper' ),
				$sliderHolder = $holder.find( '.qodef-m-items' ),
				$pagination   = $holder.find( '.swiper-pagination' );

			var $swiper = new Swiper(
				$swiperHolder,
				{
					slidesPerView: 'auto',
					centeredSlides: true,
					spaceBetween: 0,
					autoplay: true,
					loop: true,
					speed: 800,
					pagination: {
						el: $pagination,
						type: 'bullets',
						clickable: true,
					},
					on: {
						init: function () {
							setTimeout(
								function () {
									$sliderHolder.addClass( 'qodef-swiper--initialized' );
								},
								1500
							);
						}
					},
				}
			);
		}
	};

	qodefCore.shortcodes.valeska_core_frame_slider.qodefFrameSlider = qodefFrameSlider;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_google_map = {};

	$( document ).ready(
		function () {
			qodefGoogleMap.init();
		}
	);

	var qodefGoogleMap = {
		init: function () {
			this.holder = $( '.qodef-google-map' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefGoogleMap.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			if ( typeof window.qodefGoogleMap !== 'undefined' ) {
				window.qodefGoogleMap.init( $currentItem.find( '.qodef-m-map' ) );
			}
		},
	};

	qodefCore.shortcodes.valeska_core_google_map.qodefGoogleMap = qodefGoogleMap;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_icon = {};

	$( document ).ready(
		function () {
			qodefIcon.init();
		}
	);

	var qodefIcon = {
		init: function () {
			this.icons = $( '.qodef-icon-holder' );

			if ( this.icons.length ) {
				this.icons.each(
					function () {
						qodefIcon.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefIcon.iconHoverColor( $currentItem );
			qodefIcon.iconHoverBgColor( $currentItem );
			qodefIcon.iconHoverBorderColor( $currentItem );
		},
		iconHoverColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-color' ) !== 'undefined' ) {
				var spanHolder    = $iconHolder.find( 'span' ).length ? $iconHolder.find( 'span' ) : $iconHolder;
				var originalColor = spanHolder.css( 'color' );
				var hoverColor    = $iconHolder.data( 'hover-color' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							spanHolder,
							'color',
							hoverColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							spanHolder,
							'color',
							originalColor
						);
					}
				);
			}
		},
		iconHoverBgColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-background-color' ) !== 'undefined' ) {
				var hoverBackgroundColor    = $iconHolder.data( 'hover-background-color' );
				var originalBackgroundColor = $iconHolder.css( 'background-color' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'background-color',
							hoverBackgroundColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'background-color',
							originalBackgroundColor
						);
					}
				);
			}
		},
		iconHoverBorderColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-border-color' ) !== 'undefined' ) {
				var hoverBorderColor    = $iconHolder.data( 'hover-border-color' );
				var originalBorderColor = $iconHolder.css( 'borderTopColor' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'border-color',
							hoverBorderColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'border-color',
							originalBorderColor
						);
					}
				);
			}
		},
		changeColor: function ( iconElement, cssProperty, color ) {
			iconElement.css(
				cssProperty,
				color
			);
		}
	};

	qodefCore.shortcodes.valeska_core_icon.qodefIcon = qodefIcon;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_image_gallery                    = {};
	qodefCore.shortcodes.valeska_core_image_gallery.qodefSwiper        = qodef.qodefSwiper;
	qodefCore.shortcodes.valeska_core_image_gallery.qodefMasonryLayout = qodef.qodefMasonryLayout;
	qodefCore.shortcodes.valeska_core_image_gallery.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );

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

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_interactive_link_showcase = {};

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_item_showcase = {};

	$( document ).ready(
		function () {
			qodefItemShowcaseList.init();
		}
	);

	var qodefItemShowcaseList = {
		init: function () {
			this.holder = $( '.qodef-item-showcase' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefItemShowcaseList.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			$currentItem.appear(
				function () {
					$currentItem.addClass( 'qodef--init' );
				},
				{ accX: 0, accY: -100 }
			);
		},
	};

	qodefCore.shortcodes.valeska_core_item_showcase.qodefItemShowcaseList = qodefItemShowcaseList;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_progress_bar = {};

	$( document ).ready(
		function () {
			qodefProgressBar.init();
		}
	);

	/**
	 * Init progress bar shortcode functionality
	 */
	var qodefProgressBar = {
		init: function () {
			this.holder = $( '.qodef-progress-bar' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefProgressBar.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var layout = $currentItem.data( 'layout' );

			$currentItem.appear(
				function () {
					$currentItem.addClass( 'qodef--init' );

					var $container = $currentItem.find( '.qodef-m-canvas' ),
						data       = qodefProgressBar.generateBarData( $currentItem, layout ),
						number     = $currentItem.data( 'number' ) / 100;

					switch (layout) {
						case 'circle':
							qodefProgressBar.initCircleBar( $container, data, number );
							break;
						case 'semi-circle':
							qodefProgressBar.initSemiCircleBar( $container, data, number );
							break;
						case 'line':
							data = qodefProgressBar.generateLineData( $currentItem, number );
							qodefProgressBar.initLineBar( $container, data );
							break;
						case 'custom':
							qodefProgressBar.initCustomBar( $container, data, number );
							break;
					}
				}
			);
		},
		generateBarData: function ( thisBar, layout ) {
			var activeWidth   = thisBar.data( 'active-line-width' );
			var activeColor   = thisBar.data( 'active-line-color' );
			var inactiveWidth = thisBar.data( 'inactive-line-width' );
			var inactiveColor = thisBar.data( 'inactive-line-color' );
			var easing        = 'linear';
			var duration      = typeof thisBar.data( 'duration' ) !== 'undefined' && thisBar.data( 'duration' ) !== '' ? parseInt( thisBar.data( 'duration' ), 10 ) : 1600;
			var textColor     = thisBar.data( 'text-color' );

			return {
				strokeWidth: activeWidth,
				color: activeColor,
				trailWidth: inactiveWidth,
				trailColor: inactiveColor,
				easing: easing,
				duration: duration,
				svgStyle: {
					width: '100%',
					height: '100%'
				},
				text: {
					style: {
						color: textColor
					},
					autoStyleContainer: false
				},
				from: {
					color: inactiveColor
				},
				to: {
					color: activeColor
				},
				step: function ( state, bar ) {
					if ( layout !== 'custom' ) {
						bar.setText( Math.round( bar.value() * 100 ) + '%' );
					}
				},
			};
		},
		generateLineData: function ( thisBar, number ) {
			var height         = thisBar.data( 'active-line-width' );
			var activeColor    = thisBar.data( 'active-line-color' );
			var inactiveHeight = thisBar.data( 'inactive-line-width' );
			var inactiveColor  = thisBar.data( 'inactive-line-color' );
			var duration       = typeof thisBar.data( 'duration' ) !== 'undefined' && thisBar.data( 'duration' ) !== '' ? parseInt( thisBar.data( 'duration' ), 10 ) : 1600;
			var textColor      = thisBar.data( 'text-color' );

			return {
				percentage: number * 100,
				duration: duration,
				fillBackgroundColor: activeColor,
				backgroundColor: inactiveColor,
				height: height,
				inactiveHeight: inactiveHeight,
				followText: thisBar.hasClass( 'qodef-percentage--floating' ),
				textColor: textColor,
			};
		},
		initCircleBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.Circle( $container[0], data );

				$bar.animate( number );
			}
		},
		initSemiCircleBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.SemiCircle( $container[0], data );

				$bar.animate( number );
			}
		},
		initCustomBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.Path( $container[0], data );

				$bar.set( 0 );
				$bar.animate( number );
			}
		},
		initLineBar: function ( $container, data ) {
			$container.LineProgressbar( data );
		},
		checkBar: function ( $container ) {
			// check if svg is already in container, elementor fix
			if ( $container.find( 'svg' ).length ) {
				return false;
			}

			return true;
		}
	};

	qodefCore.shortcodes.valeska_core_progress_bar.qodefProgressBar = qodefProgressBar;

})( jQuery );

(function ( $ ) {
    'use strict';

    var shortcode = 'valeska_core_scattered_images_with_title';

    qodefCore.shortcodes[shortcode] = {};

    if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
        $.each(
            qodefCore.listShortcodesScripts,
            function ( key, value ) {
                qodefCore.shortcodes[shortcode][key] = value;
            }
        );
    }

    $( window ).on(
        'load',
        () => {
            qodefScatteredImagesWithTitle.init();
        }
    );

    var qodefScatteredImagesWithTitle = {
        init () {
            this.shortcode = $('.qodef-scattered-images-with-title');

            if ( this.shortcode.length ) {
                this.shortcode.each(
                    ( index, element ) => {
                        const $thisShortcode = $( element );

                        if ( $thisShortcode.hasClass( 'qodef-wait-for-trigger' ) ) {
                            const interval = setInterval(
                                () => {
                                    if ( qodef.body.hasClass( 'qodef-spinner--done' ) ) {
                                        qodefScatteredImagesWithTitle.initAnimation( $thisShortcode );
                                        clearInterval( interval );
                                    }
                                }, 100
                            );
                        } else {
                            qodefScatteredImagesWithTitle.initAnimation( $thisShortcode );
                        }
                    }
                );
            }
        },
        initAnimation ( $holder ) {
            const $layers       = $holder.find('.qodef-m-layer'),
                  $bottomLayer  = $holder.find('.qodef-m-layer--bottom'),
                  $topLayer     = $holder.find('.qodef-m-layer--top'),
                  $bottomImages = $bottomLayer.find('.qodef-m-image'),
                  $topImages    = $topLayer.find('.qodef-m-image'),
                  $title        = $holder.find('.qodef-m-title-holder'),
                  $titleParts   = $title.find('.qodef-m-title-part');

            function showLayerImages ( $images, repeat ) {
                qodefCore.qodefScroll.disable();

                if ( $images.length ) {
                    $images.each(
                        ( index, element ) => {
                            const $thisImage = $( element );

                            setTimeout(
                                () => {
                                    $thisImage.addClass( 'qodef-active' );
                                    $thisImage.animate(
                                        { opacity: 1 }, 640, 'easeInQuad', () => {
                                            if ( repeat ) {
                                                showLayerImages( $topImages, false );
                                            } else {
                                                if ( index === $images.length - 1 && !qodef.body.hasClass( 'qodef-siwt-show-images-done' ) ) {
                                                    qodef.body.addClass( 'qodef-siwt-show-images-done' );
                                                    hideLayers( $layers );
                                                }
                                            }
                                        }
                                    );
                                }, index * 180
                            );
                        }
                    );
                }
            }

            function hideLayers ( $layers ) {
                if ( $layers ) {
                    $layers.each(
                        ( index, element ) => {
                            const $thisLayer = $( element );

                            $thisLayer.addClass( 'qodef-hide' );
                            setTimeout(
                                () => {
                                    qodef.body.addClass( 'qodef-siwt-hide-images-done' );
                                    showTitle( $titleParts );
                                }, 240
                            );
                        }
                    );
                }
            }

            function showTitle ( $titleParts ) {
                if ( $titleParts.length ) {
                    $titleParts.each(
                        ( index, element ) => {
                            const $thisTitlePart = $( element );

                            setTimeout(
                                () => {
                                    $thisTitlePart.addClass( 'qodef-active' );
                                    if ( index === $titleParts.length - 1 && !qodef.body.hasClass( 'qodef-siwt-show-title-done' ) ) {
                                        qodef.body.addClass( 'qodef-siwt-show-title-done' );
                                        setTimeout(
                                            () => {
                                                $title.addClass( 'qodef-hide' );
                                                $holder.addClass( 'qodef-animation-done' );
                                                qodef.body.addClass( 'qodef-siwt-animation-done' );
                                                qodefCore.qodefScroll.enable();
                                            }, index * 180 + 1200
                                        );
                                    }
                                }, index * 180
                            );
                        }
                    );
                }
            }

            showLayerImages( $bottomImages, true );
        }
    };

    qodefCore.shortcodes[shortcode].qodefScatteredImagesWithTitle = qodefScatteredImagesWithTitle;

})( jQuery );
(function ( $ ) {
    'use strict';

    var shortcode = 'valeska_core_section_title';

    qodefCore.shortcodes[shortcode] = {};

    if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
        $.each(
            qodefCore.listShortcodesScripts,
            function ( key, value ) {
                qodefCore.shortcodes[shortcode][key] = value;
            }
        );
    }

    $( window ).on(
        'load',
        () => {
            qodefSectionTitle.init();
        }
    );

    var qodefSectionTitle = {
        init () {
            this.sectionTitle = $('.qodef-section-title');

            if ( this.sectionTitle.length ) {
                this.sectionTitle.each(
                    ( index, element ) => {
                        const $thisSectionTitle = $( element );

                        if ( $thisSectionTitle.hasClass('qodef-section-title-appear-animation--yes') ) {
                            qodefSectionTitle.appearAnimation( $thisSectionTitle );
                        }
                    }
                );
            }
        },
        appearAnimation ( $holder ) {
            if ( $holder.hasClass('qodef-wait-for-trigger') ) {
                const interval = setInterval(
                    () => {
                        if ( qodef.body.hasClass('qodef-external-trigger') ) {
                            $holder.addClass( 'qodef-appeared' );
                            clearInterval(interval);
                        }
                    }, 100
                );
            } else {
                qodefCore.qodefIsInViewport.check(
                    $holder,
                    () => {
                        $holder.addClass( 'qodef-appeared' );
                    }
                );
            }
        }
    };

    qodefCore.shortcodes[shortcode].qodefSectionTitle = qodefSectionTitle;

})( jQuery );
(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_single_image                    = {};
	qodefCore.shortcodes.valeska_core_single_image.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_stamp = {};

	$( document ).ready(
		function () {
			qodefInitStamp.init();
		}
	);

	/**
	 * Inti stamp shortcode on appear
	 */
	var qodefInitStamp = {
		init: function () {
			this.holder = $( '.qodef-stamp' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInitStamp.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var appearing_delay = typeof $currentItem.data( 'appearing-delay' ) !== 'undefined' ? parseInt( $currentItem.data( 'appearing-delay' ), 10 ) : 0;

			// Initialization
			qodefInitStamp.initStampText( $currentItem );
			qodefInitStamp.load( $currentItem, appearing_delay );

			if ( $currentItem.hasClass( 'qodef--repeating' ) ) {
				setInterval(
					function () {
						qodefInitStamp.reLoad( $currentItem );
					},
					5500
				);
			}
		},
		initStampText: function ( $currentItem ) {
			var $stamp = $currentItem.children( '.qodef-m-text' ),
				count  = typeof $currentItem.data( 'appearing-delay' ) !== 'undefined' ? parseInt( $stamp.data( 'count' ), 10 ) : 1;

			$stamp.children().each(
				function ( i ) {
					var transform       = -90 + i * 360 / count,
						transitionDelay = i * 60 / count * 10;

					$( this ).css(
						{
							'transform': 'rotate(' + transform + 'deg) translateZ(0)',
							'transition-delay': transitionDelay + 'ms',
						}
					);
				}
			);
		},
		load: function ( $holder, appearing_delay ) {
			if ( $holder.hasClass( 'qodef--nested' ) ) {
				setTimeout(
					function () {
						qodefInitStamp.appear( $holder );
					},
					appearing_delay
				);
			} else {
				$holder.appear(
					function () {
						setTimeout(
							function () {
								qodefInitStamp.appear( $holder );
							},
							appearing_delay
						);
					},
					{ accX: 0, accY: -100 }
				);
			}
		},
		reLoad: function ( $holder ) {
			$holder.removeClass( 'qodef--init' );

			setTimeout(
				function () {
					$holder.removeClass( 'qodef--appear' );

					setTimeout(
						function () {
							qodefInitStamp.appear( $holder );
						},
						500
					);
				},
				600
			);
		},
		appear: function ( $holder ) {
			$holder.addClass( 'qodef--appear' );

			setTimeout(
				function () {
					$holder.addClass( 'qodef--init' );
				},
				300
			);
		}
	};

	qodefCore.shortcodes.valeska_core_stamp.qodefInitStamp = qodefInitStamp;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_swapping_image_gallery = {};

	$( document ).ready(
		function () {
			qodefSwappingImageGallery.init();
		}
	);

	var qodefSwappingImageGallery = {
		init: function () {
			this.holder = $( '.qodef-swapping-image-gallery' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefSwappingImageGallery.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $swiperHolder     = $currentItem.find( '.qodef-m-image-holder' );
			var $paginationHolder = $currentItem.find( '.qodef-m-thumbnails-holder .qodef-grid-inner' );
			var spaceBetween      = 0;
			var slidesPerView     = 1;
			var centeredSlides    = false;
			var loop              = false;
			var autoplay          = false;
			var speed             = 800;

			var $swiper = new Swiper(
				$swiperHolder,
				{
					slidesPerView: slidesPerView,
					centeredSlides: centeredSlides,
					spaceBetween: spaceBetween,
					autoplay: autoplay,
					loop: loop,
					speed: speed,
					pagination: {
						el: $paginationHolder,
						type: 'custom',
						clickable: true,
						bulletClass: 'qodef-m-thumbnail',
					},
					on: {
						init: function () {
							$swiperHolder.addClass( 'qodef-swiper--initialized' );
							$paginationHolder.find( '.qodef-m-thumbnail' ).eq( 0 ).addClass( 'qodef--active' );
						},
						slideChange: function slideChange() {
							var swiper      = this;
							var activeIndex = swiper.activeIndex;
							$paginationHolder.find( '.qodef--active' ).removeClass( 'qodef--active' );
							$paginationHolder.find( '.qodef-m-thumbnail' ).eq( activeIndex ).addClass( 'qodef--active' );
						}
					},
				}
			);
		},
	};

	qodefCore.shortcodes.valeska_core_swapping_image_gallery.qodefSwappingImageGallery = qodefSwappingImageGallery;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_tabs = {};

	$( document ).ready(
		function () {
			qodefTabs.init();
		}
	);

	var qodefTabs = {
		init: function () {
			this.holder = $( '.qodef-tabs' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefTabs.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			$currentItem.children( '.qodef-tabs-content' ).each(
				function ( index ) {
					index = index + 1;

					var $that    = $( this ),
						link     = $that.attr( 'id' ),
						$navItem = $that.parent().find( '.qodef-tabs-navigation li:nth-child(' + index + ') a' ),
						navLink  = $navItem.attr( 'href' );

					link = '#' + link;

					if ( link.indexOf( navLink ) > -1 ) {
						$navItem.attr(
							'href',
							link
						);
					}
				}
			);

			$currentItem.addClass( 'qodef--init' ).tabs();
		}
	};

	qodefCore.shortcodes.valeska_core_tabs.qodefTabs = qodefTabs;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_text_marquee = {};

	$( document ).ready(
		function () {
			qodefTextMarquee.init();
		}
	);

	var qodefTextMarquee = {
		init: function () {
			this.holder = $( '.qodef-text-marquee' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefTextMarquee.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefTextMarquee.initMarquee( $currentItem );
			qodefTextMarquee.initResponsive( $currentItem.find( '.qodef-m-content' ) );
		},
		initResponsive: function ( thisMarquee ) {
			var fontSize,
				lineHeight,
				coef1 = 1,
				coef2 = 1;

			if ( qodefCore.windowWidth < 1480 ) {
				coef1 = 0.8;
			}

			if ( qodefCore.windowWidth < 1200 ) {
				coef1 = 0.7;
			}

			if ( qodefCore.windowWidth < 768 ) {
				coef1 = 0.55;
				coef2 = 0.65;
			}

			if ( qodefCore.windowWidth < 600 ) {
				coef1 = 0.45;
				coef2 = 0.55;
			}

			if ( qodefCore.windowWidth < 480 ) {
				coef1 = 0.4;
				coef2 = 0.5;
			}

			fontSize = parseInt( thisMarquee.css( 'font-size' ) );

			if ( fontSize > 200 ) {
				fontSize = Math.round( fontSize * coef1 );
			} else if ( fontSize > 60 ) {
				fontSize = Math.round( fontSize * coef2 );
			}

			thisMarquee.css( 'font-size', fontSize + 'px' );

			lineHeight = parseInt( thisMarquee.css( 'line-height' ) );

			if ( lineHeight > 70 && qodefCore.windowWidth < 1440 ) {
				lineHeight = '1.2em';
			} else if ( lineHeight > 35 && qodefCore.windowWidth < 768 ) {
				lineHeight = '1.2em';
			} else {
				lineHeight += 'px';
			}

			thisMarquee.css( 'line-height', lineHeight );
		},
		initMarquee: function ( thisMarquee ) {
			var elements = thisMarquee.find( '.qodef-m-text' ),
				delta    = 0.05;

			elements.each(
				function ( i ) {
					$( this ).data( 'x', 0 );
				}
			);

			requestAnimationFrame(
				function () {
					qodefTextMarquee.loop( thisMarquee, elements, delta );
				}
			);
		},
		inRange: function ( thisMarquee ) {
			if ( qodefCore.scroll + qodefCore.windowHeight >= thisMarquee.offset().top && qodefCore.scroll < thisMarquee.offset().top + thisMarquee.height() ) {
				return true;
			}

			return false;
		},
		loop: function ( thisMarquee, elements, delta ) {
			if ( ! qodefTextMarquee.inRange( thisMarquee ) ) {
				requestAnimationFrame(
					function () {
						qodefTextMarquee.loop( thisMarquee, elements, delta );
					}
				);
				return false;
			} else {
				elements.each(
					function ( i ) {
						var el = $( this );
						el.css( 'transform', 'translate3d(' + el.data( 'x' ) + '%, 0, 0)' );
						el.data( 'x', (el.data( 'x' ) - delta).toFixed( 2 ) );
						el.offset().left < -el.width() - 25 && el.data( 'x', 100 * Math.abs( i - 1 ) );
					}
				);
				requestAnimationFrame(
					function () {
						qodefTextMarquee.loop( thisMarquee, elements, delta );
					}
				);
			}
		}
	};

	qodefCore.shortcodes.valeska_core_text_marquee.qodefTextMarquee = qodefTextMarquee;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_vertical_split_slider = {};

	$( document ).ready(
		function () {
			qodefVerticalSplitSlider.init();
		}
	);

	var qodefVerticalSplitSlider = {
		init: function () {
			var $holder            = $( '.qodef-vertical-split-slider' ),
				$headerInner       = $( '#qodef-page-header-inner' ),
				breakpoint         = qodefVerticalSplitSlider.getBreakpoint( $holder ),
				initialHeaderStyle = '';

			if ( $headerInner.hasClass( 'qodef-skin--light' ) ) {
				initialHeaderStyle = 'light';
			} else if ( $headerInner.hasClass( 'qodef-skin--dark' ) ) {
				initialHeaderStyle = 'dark';
			}

			if ( $holder.length ) {
				$holder.multiscroll(
					{
						navigation: true,
						navigationPosition: 'right',
						afterRender: function () {
							qodefCore.body.addClass( 'qodef-vertical-split-slider--initialized' );
							qodefVerticalSplitSlider.headerClassHandler( $( '.ms-left .ms-section:first-child' ).data( 'header-skin' ), initialHeaderStyle, $headerInner );
						},
						onLeave: function ( index, nextIndex ) {
							qodefVerticalSplitSlider.headerClassHandler( $( $( '.ms-left .ms-section' )[nextIndex - 1] ).data( 'header-skin' ), initialHeaderStyle, $headerInner );
						},
					}
				);

				$holder.height( qodefCore.windowHeight );
				qodefVerticalSplitSlider.buildAndDestroy( breakpoint );

				$( window ).resize(
					function () {
						qodefVerticalSplitSlider.buildAndDestroy( breakpoint );
					}
				);
			}
		},
		getBreakpoint: function ( $holder ) {
			if ( $holder.hasClass( 'qodef-disable-below--768' ) ) {
				return 768;
			} else {
				return 1024;
			}
		},
		buildAndDestroy: function ( breakpoint ) {
			if ( qodefCore.windowWidth <= breakpoint ) {
				$.fn.multiscroll.destroy();
				qodefCore.body.removeClass( 'qodef-vertical-split-slider--initialized' );
			} else {
				$.fn.multiscroll.build();
				qodefCore.body.addClass( 'qodef-vertical-split-slider--initialized' );
			}
		},
		headerClassHandler: function ( slideHeaderStyle, initialHeaderStyle, $headerInner ) {
			var $controls = $( '#multiscroll-nav' );

			if ( slideHeaderStyle !== undefined && slideHeaderStyle !== '' ) {
				$headerInner.removeClass( 'qodef-skin--light qodef-skin--dark' ).addClass( 'qodef-skin--' + slideHeaderStyle );

				if ( $controls.length ) {
					$controls.removeClass( 'qodef-skin--light qodef-skin--dark' ).addClass( 'qodef-skin--' + slideHeaderStyle );
				}
			} else if ( initialHeaderStyle !== '' ) {
				$headerInner.removeClass( 'qodef-skin--light qodef-skin--dark' ).addClass( 'qodef-skin--' + slideHeaderStyle );

				if ( $controls.length ) {
					$controls.removeClass( 'qodef-skin--light qodef-skin--dark' ).addClass( 'qodef-skin--' + slideHeaderStyle );
				}
			} else {
				$headerInner.removeClass( 'qodef-skin--light qodef-skin--dark' );

				if ( $controls.length ) {
					$controls.removeClass( 'qodef-skin--light qodef-skin--dark' );
				}
			}
		}
	};

	qodefCore.shortcodes.valeska_vertical_split_slider.qodefVerticalSplitSlider = qodefVerticalSplitSlider;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_video_button                    = {};
	qodefCore.shortcodes.valeska_core_video_button.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefStickySidebar.init();
		}
	);

	var qodefStickySidebar = {
		init: function () {
			var info = $( '.widget_valeska_core_sticky_sidebar' );

			if ( info.length && qodefCore.windowWidth > 1024 ) {
				info.wrapper = info.parents( '#qodef-page-sidebar' );
				info.offsetM = info.offset().top - info.wrapper.offset().top;
				info.adj     = 15;

				qodefStickySidebar.callStack( info );

				$( window ).on(
					'resize',
					function () {
						if ( qodefCore.windowWidth > 1024 ) {
							qodefStickySidebar.callStack( info );
						}
					}
				);

				$( window ).on(
					'scroll',
					function () {
						if ( qodefCore.windowWidth > 1024 ) {
							qodefStickySidebar.infoPosition( info );
						}
					}
				);
			}
		},
		calc: function ( info ) {
			var content = $( '.qodef-page-content-section' ),
				headerH = qodefCore.body.hasClass( 'qodef-header-appearance--none' ) ? 0 : parseInt( qodefGlobal.vars.headerHeight, 10 );

			// If posts not found set content to have the same height as the sidebar
			if ( qodefCore.windowWidth > 1024 && content.height() < 100 ) {
				content.css( 'height', info.wrapper.height() - content.height() );
			}

			info.start = content.offset().top;
			info.end   = content.outerHeight();
			info.h     = info.wrapper.height();
			info.w     = info.outerWidth();
			info.left  = info.offset().left;
			info.top   = headerH + qodefGlobal.vars.adminBarHeight - info.offsetM;
			info.data( 'state', 'top' );
		},
		infoPosition: function ( info ) {
			if ( qodefCore.scroll < info.start - info.top && qodefCore.scroll + info.h && info.data( 'state' ) !== 'top' ) {
				gsap.to(
					info.wrapper,
					.1,
					{
						y: 5,
					}
				);
				gsap.to(
					info.wrapper,
					.3,
					{
						y: 0,
						delay: .1,
					}
				);
				info.data( 'state', 'top' );
				info.wrapper.css(
					{
						'position': 'static',
					}
				);
			} else if ( qodefCore.scroll >= info.start - info.top && qodefCore.scroll + info.h + info.adj <= info.start + info.end &&
				info.data( 'state' ) !== 'fixed' ) {
				var c = info.data( 'state' ) === 'top' ? 1 : -1;
				info.data( 'state', 'fixed' );
				info.wrapper.css(
					{
						'position': 'fixed',
						'top': info.top,
						'left': info.left,
						'width': info.w,
					}
				);
				gsap.fromTo(
					info.wrapper,
					.2,
					{
						y: 0
					},
					{
						y: c * 10,
						ease: Power4.easeInOut
					}
				);
				gsap.to(
					info.wrapper,
					.2,
					{
						y: 0,
						delay: .2,
					}
				);
			} else if ( qodefCore.scroll + info.h + info.adj > info.start + info.end && info.data( 'state' ) !== 'bottom' ) {
				info.data( 'state', 'bottom' );
				info.wrapper.css(
					{
						'position': 'absolute',
						'top': info.end - info.h - info.adj,
						'left': 'auto',
						'width': info.w,
					}
				);
				gsap.fromTo(
					info.wrapper,
					.1,
					{
						y: 0
					},
					{
						y: -5,
					}
				);
				gsap.to(
					info.wrapper,
					.3,
					{
						y: 0,
						delay: .1,
					}
				);
			}
		},
		callStack: function ( info ) {
			this.calc( info );
			this.infoPosition( info );
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'valeska_core_blog_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

	$( window ).on(
		'load',
		() => {
			qodefBlogList.init();
		}
	);

	var qodefBlogList = {
		init () {
			this.blog = $('.qodef-blog');

			if ( this.blog.length ) {
				this.blog.each(
					( index, element ) => {
						const $thisBlogList = $( element );

						if ( $thisBlogList.hasClass('qodef-hover-animation--yes') ) {
							qodefBlogList.linkHover( $thisBlogList );
						}
					}
				);
			}
		},
		linkHover ( $holder ) {
			const $items = $holder.find('.qodef-blog-item');

			$items.each(
				( index, element ) => {
					const $thisItem = $( element ),
						  $itemMedia = $thisItem.find('.qodef-e-media-image'),
						  $titleLink = $thisItem.find('.qodef-e-title-link');

					$itemMedia.on(
						'mouseenter',
						() => {
							$thisItem.addClass('qodef--active');
						}
					);

					$itemMedia.on(
						'mouseleave',
						() => {
							$thisItem.removeClass('qodef--active');
						}
					);

					$titleLink.on(
						'mouseenter',
						() => {
							$thisItem.addClass('qodef--active');
						}
					);

					$titleLink.on(
						'mouseleave',
						() => {
							$thisItem.removeClass('qodef--active');
						}
					);
				}
			);
		}
	};

	qodefCore.shortcodes[shortcode].qodefResizeIframes = qodef.qodefResizeIframes;
	qodefCore.shortcodes[shortcode].qodefBlogList      = qodefBlogList;

})( jQuery );
(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefVerticalNavMenu.init();
		}
	);

	/**
	 * Function object that represents vertical menu area.
	 * @returns {{init: Function}}
	 */
	var qodefVerticalNavMenu = {
		initNavigation: function ( $verticalMenuObject ) {
			var $verticalNavObject = $verticalMenuObject.find( '.qodef-header-vertical-navigation' );

			if ( $verticalNavObject.hasClass( 'qodef-vertical-drop-down--below' ) ) {
				qodefVerticalNavMenu.dropdownClickToggle( $verticalNavObject );
			} else if ( $verticalNavObject.hasClass( 'qodef-vertical-drop-down--side' ) ) {
				qodefVerticalNavMenu.dropdownFloat( $verticalNavObject );
			}
		},
		dropdownClickToggle: function ( $verticalNavObject ) {
			var $menuItems = $verticalNavObject.find( 'ul li.menu-item-has-children' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second, > ul' );
					var menuItem         = this;
					var $dropdownOpener  = $( this ).find( '> a' );
					var slideUpSpeed     = 'fast';
					var slideDownSpeed   = 'slow';

					$dropdownOpener.on(
						'click tap',
						function ( e ) {
							e.preventDefault();
							e.stopPropagation();

							if ( $elementToExpand.is( ':visible' ) ) {
								$( menuItem ).removeClass( 'qodef-menu-item--open' );
								$elementToExpand.slideUp( slideUpSpeed );
							} else if ( $dropdownOpener.parent().parent().children().hasClass( 'qodef-menu-item--open' ) && $dropdownOpener.parent().parent().parent().hasClass( 'qodef-vertical-menu' ) ) {
								$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
								$( this ).parent().parent().children().find( ' > .qodef-drop-down-second' ).slideUp( slideUpSpeed );

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							} else {

								if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
									$menuItems.removeClass( 'qodef-menu-item--open' );
									$menuItems.find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								if ( $( this ).parent().parent().children().hasClass( 'qodef-menu-item--open' ) ) {
									$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
									$( this ).parent().parent().children().find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							}
						}
					);
				}
			);
		},
		dropdownFloat: function ( $verticalNavObject ) {
			var $menuItems = $verticalNavObject.find( 'ul li.menu-item-has-children' );
			var $allDropdowns = $menuItems.find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );
					var menuItem         = this;

					if ( Modernizr.touch ) {
						var $dropdownOpener = $( this ).find( '> a' );

						$dropdownOpener.on(
							'click tap',
							function ( e ) {
								e.preventDefault();
								e.stopPropagation();

								if ( $elementToExpand.hasClass( 'qodef-float--open' ) ) {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								} else {
									if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
										$menuItems.removeClass( 'qodef-menu-item--open' );
										$allDropdowns.removeClass( 'qodef-float--open' );
									}

									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								}
							}
						);
					} else {
						//must use hoverIntent because basic hover effect doesn't catch dropdown
						//it doesn't start from menu item's edge
						$( this ).hoverIntent(
							{
								over: function () {
									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								},
								out: function () {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								},
								timeout: 300
							}
						);
					}
				}
			);
		},
		verticalAreaScrollable: function ( $verticalMenuObject ) {
			return $verticalMenuObject.hasClass( 'qodef-with-scroll' );
		},
		initVerticalAreaScroll: function ( $verticalMenuObject ) {
			if ( qodefVerticalNavMenu.verticalAreaScrollable( $verticalMenuObject ) && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $verticalMenuObject );
			}
		},
		init: function () {
			var $verticalMenuObject = $( '.qodef-header--vertical #qodef-page-header' );

			if ( $verticalMenuObject.length ) {
				qodefVerticalNavMenu.initNavigation( $verticalMenuObject );
				qodefVerticalNavMenu.initVerticalAreaScroll( $verticalMenuObject );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	var fixedHeaderAppearance = {
		showHideHeader: function ( $pageOuter, $header ) {
			if ( qodefCore.windowWidth > 1024 ) {
				if ( qodefCore.scroll <= 0 ) {
					qodefCore.body.removeClass( 'qodef-header--fixed-display' );
					$pageOuter.css( 'padding-top', '0' );
					$header.css( 'margin-top', '0' );
				} else {
					qodefCore.body.addClass( 'qodef-header--fixed-display' );
					$pageOuter.css( 'padding-top', parseInt( qodefGlobal.vars.headerHeight + qodefGlobal.vars.topAreaHeight ) + 'px' );
					$header.css( 'margin-top', parseInt( qodefGlobal.vars.topAreaHeight ) + 'px' );
				}
			}
		},
		init: function () {

			if ( ! qodefCore.body.hasClass( 'qodef-header--vertical' ) ) {
				var $pageOuter = $( '#qodef-page-outer' ),
					$header    = $( '#qodef-page-header' );

				fixedHeaderAppearance.showHideHeader( $pageOuter, $header );

				$( window ).scroll(
					function () {
						fixedHeaderAppearance.showHideHeader( $pageOuter, $header );
					}
				);

				$( window ).resize(
					function () {
						$pageOuter.css( 'padding-top', '0' );
						fixedHeaderAppearance.showHideHeader( $pageOuter, $header );
					}
				);
			}
		}
	};

	qodefCore.fixedHeaderAppearance = fixedHeaderAppearance.init;

})( jQuery );

(function ( $ ) {
	'use strict';

	var stickyHeaderAppearance = {
		header: '',
		docYScroll: 0,
		init: function () {
			var displayAmount = stickyHeaderAppearance.displayAmount();

			// Set variables
			stickyHeaderAppearance.header 	  = $( '.qodef-header-sticky' );
			stickyHeaderAppearance.docYScroll = $( document ).scrollTop();

			// Set sticky visibility
			stickyHeaderAppearance.setVisibility( displayAmount );

			$( window ).scroll(
				function () {
					stickyHeaderAppearance.setVisibility( displayAmount );
				}
			);
		},
		displayAmount: function () {
			if ( qodefGlobal.vars.qodefStickyHeaderScrollAmount !== 0 ) {
				return parseInt( qodefGlobal.vars.qodefStickyHeaderScrollAmount, 10 );
			} else {
				return parseInt( qodefGlobal.vars.headerHeight + qodefGlobal.vars.adminBarHeight, 10 );
			}
		},
		setVisibility: function ( displayAmount ) {
			var isStickyHidden = qodefCore.scroll < displayAmount;

			if ( stickyHeaderAppearance.header.hasClass( 'qodef-appearance--up' ) ) {
				var currentDocYScroll = $( document ).scrollTop();

				isStickyHidden = (currentDocYScroll > stickyHeaderAppearance.docYScroll && currentDocYScroll > displayAmount) || (currentDocYScroll < displayAmount);

				stickyHeaderAppearance.docYScroll = $( document ).scrollTop();
			}

			stickyHeaderAppearance.showHideHeader( isStickyHidden );
		},
		showHideHeader: function ( isStickyHidden ) {
			if ( isStickyHidden ) {
				qodefCore.body.removeClass( 'qodef-header--sticky-display' );
			} else {
				qodefCore.body.addClass( 'qodef-header--sticky-display' );
			}
		},
	};

	qodefCore.stickyHeaderAppearance = stickyHeaderAppearance.init;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideAreaMobileHeader.init();
		}
	);

	var qodefSideAreaMobileHeader = {
		init: function () {
			var $holder = $( '#qodef-side-area-mobile-header' );

			if ( $holder.length && qodefCore.body.hasClass( 'qodef-mobile-header--side-area' ) ) {
				var $navigation = $holder.find( '.qodef-m-navigation' );

				qodefSideAreaMobileHeader.initOpenerTrigger( $holder, $navigation );
				qodefSideAreaMobileHeader.initNavigationClickToggle( $navigation );

				if ( typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
					qodefCore.qodefPerfectScrollbar.init( $holder );
				}
			}
		},
		initOpenerTrigger: function ( $holder, $navigation ) {
			var $openerIcon = $( '.qodef-side-area-mobile-header-opener' ),
				$closeIcon  = $holder.children( '.qodef-m-close' );

			if ( $openerIcon.length && $navigation.length ) {
				$openerIcon.on(
					'tap click',
					function ( e ) {
						e.stopPropagation();
						e.preventDefault();

						if ( $holder.hasClass( 'qodef--opened' ) ) {
							$holder.removeClass( 'qodef--opened' );
						} else {
							$holder.addClass( 'qodef--opened' );
						}
					}
				);
			}

			$closeIcon.on(
				'tap click',
				function ( e ) {
					e.stopPropagation();
					e.preventDefault();

					if ( $holder.hasClass( 'qodef--opened' ) ) {
						$holder.removeClass( 'qodef--opened' );
					}
				}
			);
		},
		initNavigationClickToggle: function ( $navigation ) {
			var $menuItems = $navigation.find( 'ul li.menu-item-has-children' );

			$menuItems.each(
				function () {
					var $thisItem        = $( this ),
						$elementToExpand = $thisItem.find( ' > .qodef-drop-down-second, > ul' ),
						$dropdownOpener  = $thisItem.find( '> .qodef-menu-item-arrow' ),
						slideUpSpeed     = 'fast',
						slideDownSpeed   = 'slow';

					$dropdownOpener.on(
						'click tap',
						function ( e ) {
							e.preventDefault();
							e.stopPropagation();

							if ( $elementToExpand.is( ':visible' ) ) {
								$thisItem.removeClass( 'qodef-menu-item--open' );
								$elementToExpand.slideUp( slideUpSpeed );
							} else if ( $dropdownOpener.parent().parent().children().hasClass( 'qodef-menu-item--open' ) && $dropdownOpener.parent().parent().parent().hasClass( 'qodef-vertical-menu' ) ) {
								$thisItem.parent().parent().children().removeClass( 'qodef-menu-item--open' );
								$thisItem.parent().parent().children().find( ' > .qodef-drop-down-second' ).slideUp( slideUpSpeed );

								$thisItem.addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							} else {

								if ( ! $thisItem.parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
									$menuItems.removeClass( 'qodef-menu-item--open' );
									$menuItems.find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								if ( $thisItem.parent().parent().children().hasClass( 'qodef-menu-item--open' ) ) {
									$thisItem.parent().parent().children().removeClass( 'qodef-menu-item--open' );
									$thisItem.parent().parent().children().find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								$thisItem.addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							}
						}
					);
				}
			);
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearchFullscreen.init();
		}
	);

	var qodefSearchFullscreen = {
		init: function () {
			var $searchOpener = $( 'a.qodef-search-opener' ),
				$searchHolder = $( '.qodef-fullscreen-search-holder' ),
				$searchClose  = $searchHolder.find( '.qodef-m-close' );

			if ( $searchOpener.length && $searchHolder.length ) {
				$searchOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						if ( qodefCore.body.hasClass( 'qodef-fullscreen-search--opened' ) ) {
							qodefSearchFullscreen.closeFullscreen( $searchHolder );
						} else {
							qodefSearchFullscreen.openFullscreen( $searchHolder );
						}
					}
				);
				$searchClose.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchFullscreen.closeFullscreen( $searchHolder );
					}
				);

				//Close on escape
				$( document ).keyup(
					function ( e ) {
						if ( e.keyCode === 27 && qodefCore.body.hasClass( 'qodef-fullscreen-search--opened' ) ) { //KeyCode for ESC button is 27
							qodefSearchFullscreen.closeFullscreen( $searchHolder );
						}
					}
				);
			}
		},
		openFullscreen: function ( $searchHolder ) {
			qodefCore.body.removeClass( 'qodef-fullscreen-search--fadeout' );
			qodefCore.body.addClass( 'qodef-fullscreen-search--opened qodef-fullscreen-search--fadein' );

			setTimeout(
				function () {
					$searchHolder.find( '.qodef-m-form-field' ).focus();
				},
				900
			);

			qodefCore.qodefScroll.disable();
		},
		closeFullscreen: function ( $searchHolder ) {
			qodefCore.body.removeClass( 'qodef-fullscreen-search--opened qodef-fullscreen-search--fadein' );
			qodefCore.body.addClass( 'qodef-fullscreen-search--fadeout' );

			setTimeout(
				function () {
					$searchHolder.find( '.qodef-m-form-field' ).val( '' );
					$searchHolder.find( '.qodef-m-form-field' ).blur();
					qodefCore.body.removeClass( 'qodef-fullscreen-search--fadeout' );
				},
				300
			);

			qodefCore.qodefScroll.enable();
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearchCoversHeader.init();
		}
	);

	var qodefSearchCoversHeader = {
		init: function () {
			var $searchOpener = $( 'a.qodef-search-opener' ),
				$searchForm   = $( '.qodef-search-cover-form' ),
				$searchClose  = $searchForm.find( '.qodef-m-close' );

			if ( $searchOpener.length && $searchForm.length ) {
				$searchOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchCoversHeader.openCoversHeader( $searchForm );
					}
				);
				$searchClose.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchCoversHeader.closeCoversHeader( $searchForm );
					}
				);
			}
		},
		openCoversHeader: function ( $searchForm ) {
			qodefCore.body.addClass( 'qodef-covers-search--opened qodef-covers-search--fadein' );
			qodefCore.body.removeClass( 'qodef-covers-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).focus();
				},
				600
			);
		},
		closeCoversHeader: function ( $searchForm ) {
			qodefCore.body.removeClass( 'qodef-covers-search--opened qodef-covers-search--fadein' );
			qodefCore.body.addClass( 'qodef-covers-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).val( '' );
					$searchForm.find( '.qodef-m-form-field' ).blur();
					qodefCore.body.removeClass( 'qodef-covers-search--fadeout' );
				},
				300
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearch.init();
		}
	);

	var qodefSearch = {
		init: function () {
			this.search = $( 'a.qodef-search-opener' );

			if ( this.search.length ) {
				this.search.each(
					function () {
						var $thisSearch = $( this );

						qodefSearch.searchHoverColor( $thisSearch );
					}
				);
			}
		},
		searchHoverColor: function ( $searchHolder ) {
			if ( typeof $searchHolder.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $searchHolder.data( 'hover-color' ),
					originalColor = $searchHolder.css( 'color' );

				$searchHolder.on(
					'mouseenter',
					function () {
						$searchHolder.css( 'color', hoverColor );
					}
				).on(
					'mouseleave',
					function () {
						$searchHolder.css( 'color', originalColor );
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefProgressBarSpinner.init();
		}
	);

	$( window ).on(
		'load',
		function () {
			qodefProgressBarSpinner.windowLoaded = true;
			qodefProgressBarSpinner.completeAnimation();
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				qodefProgressBarSpinner.init( isEditMode );
			}
		}
	);

	var qodefProgressBarSpinner = {
		holder: '',
		windowLoaded: false,
		percentNumber: 0,
		init: function ( isEditMode ) {
			this.holder = $( '#qodef-page-spinner.qodef-layout--progress-bar' );

			if ( this.holder.length ) {
				qodefProgressBarSpinner.animateSpinner( this.holder, isEditMode );
			}
		},
		animateSpinner: function ( $holder, isEditMode ) {
			var $numberHolder = $holder.find( '.qodef-m-spinner-number-label' ),
				$spinnerLine  = $holder.find( '.qodef-m-spinner-line-front' );

			$spinnerLine.animate(
				{ 'width': '100%' },
				10000,
				'linear'
			);

			var numberInterval = setInterval(
				function () {
					qodefProgressBarSpinner.animatePercent( $numberHolder, qodefProgressBarSpinner.percentNumber );

					if ( qodefProgressBarSpinner.windowLoaded ) {
						clearInterval( numberInterval );
					}
				},
				100
			);

			if ( isEditMode ) {
				qodefProgressBarSpinner.fadeOutLoader( $holder );
			}
		},
		completeAnimation: function () {
			var $holder = qodefProgressBarSpinner.holder.length ? qodefProgressBarSpinner.holder : $( '#qodef-page-spinner.qodef-layout--progress-bar' );

			var numberIntervalFastest = setInterval(
				function () {

					if ( qodefProgressBarSpinner.percentNumber >= 100 ) {
						clearInterval( numberIntervalFastest );

						$holder.find( '.qodef-m-spinner-line-front' ).stop().animate(
							{ 'width': '100%' },
							500
						);

						$holder.addClass( 'qodef--finished' );

						setTimeout(
							function () {
								qodefProgressBarSpinner.fadeOutLoader( $holder );
							},
							600
						);
					} else {
						qodefProgressBarSpinner.animatePercent(
							$holder.find( '.qodef-m-spinner-number-label' ),
							qodefProgressBarSpinner.percentNumber
						);
					}
				},
				6
			);
		},
		animatePercent: function ( $numberHolder, percentNumber ) {
			if ( percentNumber < 100 ) {
				percentNumber += 5;
				$numberHolder.text( percentNumber );

				qodefProgressBarSpinner.percentNumber = percentNumber;
			}
		},
		fadeOutLoader: function ( $holder, speed, delay, easing ) {
			speed  = speed ? speed : 600;
			delay  = delay ? delay : 0;
			easing = easing ? easing : 'swing';

			$holder.delay( delay ).fadeOut( speed, easing );

			$( window ).on(
				'bind',
				'pageshow',
				function ( event ) {
					if ( event.originalEvent.persisted ) {
						$holder.fadeOut( speed, easing );
					}
				}
			);
		}
	};

})( jQuery );

(function ($) {
    "use strict";

    $( document ).ready(
        () => {
            qodefValeskaSpinner.init();
        }
    );

    $( window ).on(
        'load',
        () => {
            qodefValeskaSpinner.windowLoaded = true;
        }
    );

    $( window ).on(
        'elementor/frontend/init',
        () => {
            const isEditMode = Boolean( elementorFrontend.isEditMode() );

            if ( isEditMode ) {
                qodefValeskaSpinner.init( isEditMode );
            }
        }
    );

    var qodefValeskaSpinner = {
        init ( isEditMode ) {
            const $holder = $('#qodef-page-spinner.qodef-layout--valeska');

            if ( $holder.length ) {
                if ( isEditMode ) {
                    qodefValeskaSpinner.fadeOutLoader( $holder );
                } else {
                    qodefValeskaSpinner.animateSpinner( $holder );
                }
            }
        },
        animateSpinner ( $holder ) {
            $holder.addClass('qodef--init');

            const $counter = $holder.find('.qodef-m-number');

            const startCounter = () => {
                let counter = {
                    var: 0
                };

                TweenLite.to(counter, 6.5, {
                    var: 100,
                    onUpdate () {
                        if ( counter.var < 10 ) {
                            $counter[0].innerHTML = '0' + Math.ceil(counter.var);
                        } else {
                            $counter[0].innerHTML = Math.ceil(counter.var);
                        }
                    },
                    onComplete () {
                        qodefValeskaSpinner.fadeOutLoader( $holder, 600 );
                        qodef.body.addClass( 'qodef-spinner--done' );
                    }
                });
            };

            startCounter();
        },
        fadeOutLoader ( $holder, speed, delay, easing ) {
            speed = speed ? speed : 500;
            delay = delay ? delay : 0;
            easing = easing ? easing : 'swing';

            if ( $holder.length ) {
                $holder.delay(delay).fadeOut(speed, easing);

                $(window).on(
                    'bind', 'pageshow',
                    ( event ) => {
                        if ( event.originalEvent.persisted ) {
                            $holder.fadeOut(speed, easing);
                        }
                    }
                );
            }
        }
    };

})(jQuery);
(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefWishlistDropdown.init();
		}
	);

	/**
	 * Function object that represents wishlist dropdown.
	 * @returns {{init: Function}}
	 */
	var qodefWishlistDropdown = {
		init: function () {
			var $holder = $( '.qodef-wishlist-dropdown' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						var $thisHolder = $( this ),
							$link       = $thisHolder.find( '.qodef-m-link' );

						$link.on(
							'click',
							function ( e ) {
								e.preventDefault();
							}
						);

						qodefWishlistDropdown.removeItem( $thisHolder );
					}
				);
			}
		},
		removeItem: function ( $holder ) {
			var $removeLink = $holder.find( '.qodef-e-remove' );

			$removeLink.off().on(
				'click',
				function ( e ) {
					e.preventDefault();

					var $thisRemoveLink = $( this ),
						removeLinkHTML  = $thisRemoveLink.html(),
						removeItemID    = $thisRemoveLink.data( 'id' );

					$thisRemoveLink.html( '<span class="fa fa-spinner fa-spin" aria-hidden="true"></span>' );

					var wishlistData = {
						type: 'remove',
						itemID: removeItemID,
					};

					$.ajax(
						{
							type: 'POST',
							url: qodefGlobal.vars.restUrl + qodefGlobal.vars.wishlistRestRoute,
							data: {
								options: wishlistData,
							},
							beforeSend: function ( request ) {
								request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
							},
							success: function ( response ) {
								if ( response.status === 'success' ) {
									var newNumberOfItemsValue = parseInt( response.data['count'], 10 );

									$holder.find( '.qodef-m-link-count' ).html( newNumberOfItemsValue );

									if ( newNumberOfItemsValue === 0 ) {
										$holder.removeClass( 'qodef-items--has' ).addClass( 'qodef-items--no' );
									}

									$thisRemoveLink.closest( '.qodef-m-item' ).fadeOut( 200 ).remove();

									$( document ).trigger(
										'valeska_core_wishlist_item_is_removed',
										[removeItemID]
									);
								} else {
									$thisRemoveLink.html( removeLinkHTML );
								}
							}
						}
					);
				}
			);
		}
	};

	$( document ).on(
		'valeska_core_wishlist_item_is_added',
		function ( e, addedItemID, addedUserID ) {
			var $holder = $( '.qodef-wishlist-dropdown' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						var $thisHolder        = $( this ),
							$link              = $thisHolder.find( '.qodef-m-link' ),
							numberOfItemsValue = $link.find( '.qodef-m-link-count' ),
							$itemsHolder       = $thisHolder.find( '.qodef-m-items' );

						var wishlistData = {
							itemID: addedItemID,
							userID: addedUserID,
						};

						$.ajax(
							{
								type: 'POST',
								url: qodefGlobal.vars.restUrl + qodefGlobal.vars.wishlistDropdownRestRoute,
								data: {
									options: wishlistData,
								},
								beforeSend: function ( request ) {
									request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
								},
								success: function ( response ) {
									if ( response.status === 'success' ) {
										numberOfItemsValue.html( parseInt( response.data['count'], 10 ) );

										if ( $thisHolder.hasClass( 'qodef-items--no' ) ) {
											$thisHolder.removeClass( 'qodef-items--no' ).addClass( 'qodef-items--has' );
										}

										$itemsHolder.append( response.data['new_html'] );
									}
								},
								complete: function () {
									qodefWishlistDropdown.init();
								}
							}
						);
					}
				);
			}
		}
	);

})( jQuery );

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

(function ( $ ) {
	'use strict';

	/*
	 **	Re-init scripts on gallery loaded
	 */
	$( document ).on(
		'yith_wccl_product_gallery_loaded',
		function () {

			if ( typeof qodefCore.qodefWooMagnificPopup === 'function' ) {
				qodefCore.qodefWooMagnificPopup.init();
			}
		}
	);

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_product_category_list                    = {};
	qodefCore.shortcodes.valeska_core_product_category_list.qodefMasonryLayout = qodef.qodefMasonryLayout;
	qodefCore.shortcodes.valeska_core_product_category_list.qodefSwiper        = qodef.qodefSwiper;

})( jQuery );

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

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_clients_list             = {};
	qodefCore.shortcodes.valeska_core_clients_list.qodefSwiper = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'valeska_core_team_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.valeska_core_testimonials_list             = {};
	qodefCore.shortcodes.valeska_core_testimonials_list.qodefSwiper = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseInteractiveList.init();
		}
	);

	var qodefInteractiveLinkShowcaseInteractiveList = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--interactive-list' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInteractiveLinkShowcaseInteractiveList.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $links            = $currentItem.find( '.qodef-m-item' ),
				x                 = 0,
				y                 = 0,
				currentXCPosition = 0,
				currentYCPosition = 0;

			if ( $links.length ) {
				$links.on(
					'mouseenter',
					function () {
						$links.removeClass( 'qodef--active' );
						$( this ).addClass( 'qodef--active' );
					}
				).on(
					'mousemove',
					function ( event ) {
						var $thisLink         = $( this ),
							$followInfoHolder = $thisLink.find( '.qodef-e-follow-content' ),
							$followImage      = $followInfoHolder.find( '.qodef-e-follow-image' ),
							$followImageItem  = $followImage.find( 'img' ),
							followImageWidth  = $followImageItem.width(),
							followImagesCount = parseInt( $followImage.data( 'images-count' ), 10 ),
							followImagesSrc   = $followImage.data( 'images' ),
							$followTitle      = $followInfoHolder.find( '.qodef-e-follow-title' ),
							itemWidth         = $thisLink.outerWidth(),
							itemHeight        = $thisLink.outerHeight(),
							itemOffsetTop     = $thisLink.offset().top - qodefCore.scroll,
							itemOffsetLeft    = $thisLink.offset().left;

						x = (event.clientX - itemOffsetLeft) >> 0;
						y = (event.clientY - itemOffsetTop) >> 0;

						if ( x > itemWidth ) {
							currentXCPosition = itemWidth;
						} else if ( x < 0 ) {
							currentXCPosition = 0;
						} else {
							currentXCPosition = x;
						}

						if ( y > itemHeight ) {
							currentYCPosition = itemHeight;
						} else if ( y < 0 ) {
							currentYCPosition = 0;
						} else {
							currentYCPosition = y;
						}

						if ( followImagesCount > 1 ) {
							var imagesUrl    = followImagesSrc.split( '|' ),
								itemPartSize = itemWidth / followImagesCount;

							$followImageItem.removeAttr( 'srcset' );

							if ( currentXCPosition < itemPartSize ) {
								$followImageItem.attr( 'src', imagesUrl[0] );
							}

							// -2 is constant - to remove first and last item from the loop
							for ( var index = 1; index <= (followImagesCount - 2); index++ ) {
								if ( currentXCPosition >= itemPartSize * index && currentXCPosition < itemPartSize * (index + 1) ) {
									$followImageItem.attr( 'src', imagesUrl[index] );
								}
							}

							if ( currentXCPosition >= itemWidth - itemPartSize ) {
								$followImageItem.attr( 'src', imagesUrl[followImagesCount - 1] );
							}
						}

						$followImage.css(
							{
								'top': itemHeight / 2,
							}
						);
						$followTitle.css(
							{
								'transform': 'translateY(' + -(parseInt( itemHeight, 10 ) / 2 + currentYCPosition) + 'px)',
								'left': -(currentXCPosition - followImageWidth / 2),
							}
						);
						$followInfoHolder.css( { 'top': currentYCPosition, 'left': currentXCPosition } );
					}
				).on(
					'mouseleave',
					function () {
						$links.removeClass( 'qodef--active' );
					}
				);
			}

			$currentItem.addClass( 'qodef--init' );
		},
	};

	qodefCore.shortcodes.valeska_core_interactive_link_showcase.qodefInteractiveLinkShowcaseInteractiveList = qodefInteractiveLinkShowcaseInteractiveList;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseList.init();
		}
	);

	var qodefInteractiveLinkShowcaseList = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--list' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInteractiveLinkShowcaseList.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $images = $currentItem.find( '.qodef-m-image' ),
				$links  = $currentItem.find( '.qodef-m-item' );

			$images.eq( 0 ).addClass( 'qodef--active' );
			$links.eq( 0 ).addClass( 'qodef--active' );

			$links.on(
				'touchstart mouseenter',
				function ( e ) {
					var $thisLink = $( this );

					if ( ! qodefCore.html.hasClass( 'touchevents' ) || ( ! $thisLink.hasClass( 'qodef--active' ) && qodefCore.windowWidth > 680) ) {
						e.preventDefault();
						$images.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
						$links.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
					}
				}
			).on(
				'touchend mouseleave',
				function () {
					var $thisLink = $( this );

					if ( ! qodefCore.html.hasClass( 'touchevents' ) || ( ! $thisLink.hasClass( 'qodef--active' ) && qodefCore.windowWidth > 680) ) {
						$links.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
						$images.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
					}
				}
			);

			$currentItem.addClass( 'qodef--init' );
		},
	};

	qodefCore.shortcodes.valeska_core_interactive_link_showcase.qodefInteractiveLinkShowcaseList = qodefInteractiveLinkShowcaseList;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseSlider.init();
		}
	);

	var qodefInteractiveLinkShowcaseSlider = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--slider' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInteractiveLinkShowcaseSlider.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $images = $currentItem.find( '.qodef-m-image' );

			var $swiperSlider = new Swiper(
				$currentItem.find( '.swiper-container' ),
				{
					loop: true,
					slidesPerView: 'auto',
					centeredSlides: true,
					speed: 1400,
					mousewheel: true,
					init: false
				}
			);

			$currentItem.waitForImages(
				function () {
					$swiperSlider.init();
				}
			);

			$swiperSlider.on(
				'init',
				function () {
					$images.eq( 0 ).addClass( 'qodef--active' );
					$currentItem.find( '.swiper-slide-active' ).addClass( 'qodef--active' );

					$swiperSlider.on(
						'slideChangeTransitionStart',
						function () {
							var $swiperSlides    = $currentItem.find( '.swiper-slide' ),
								$activeSlideItem = $currentItem.find( '.swiper-slide-active' );

							$images.removeClass( 'qodef--active' ).eq( $activeSlideItem.data( 'swiper-slide-index' ) ).addClass( 'qodef--active' );
							$swiperSlides.removeClass( 'qodef--active' );

							$activeSlideItem.addClass( 'qodef--active' );
						}
					);

					$currentItem.find( '.swiper-slide' ).on(
						'click',
						function ( e ) {
							var $thisSwiperLink  = $( this ),
								$activeSlideItem = $currentItem.find( '.swiper-slide-active' );

							if ( ! $thisSwiperLink.hasClass( 'swiper-slide-active' ) ) {
								e.preventDefault();
								e.stopImmediatePropagation();

								if ( e.pageX < $activeSlideItem.offset().left ) {
									$swiperSlider.slidePrev();
									return false;
								}

								if ( e.pageX > $activeSlideItem.offset().left + $activeSlideItem.outerWidth() ) {
									$swiperSlider.slideNext();
									return false;
								}
							}
						}
					);

					$currentItem.addClass( 'qodef--init' );
				}
			);
		},
	};

	qodefCore.shortcodes.valeska_core_interactive_link_showcase.qodefInteractiveLinkShowcaseSlider = qodefInteractiveLinkShowcaseSlider;

})( jQuery );
