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
