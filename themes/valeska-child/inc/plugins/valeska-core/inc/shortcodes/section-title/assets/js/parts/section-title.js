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