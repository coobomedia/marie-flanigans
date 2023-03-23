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