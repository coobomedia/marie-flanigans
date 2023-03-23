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