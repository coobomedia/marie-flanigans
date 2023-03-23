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
