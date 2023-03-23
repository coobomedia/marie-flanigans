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