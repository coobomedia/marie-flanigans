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