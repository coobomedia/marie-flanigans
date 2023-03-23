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