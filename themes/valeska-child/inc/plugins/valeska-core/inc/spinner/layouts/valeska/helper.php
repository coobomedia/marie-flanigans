<?php

if ( ! function_exists( 'valeska_core_add_valeska_spinner_layout_option' ) ) {
    /**
     * Function that set new value into page spinner layout options map
     *
     * @param array $layouts - module layouts
     *
     * @return array
     */
    function valeska_core_add_valeska_spinner_layout_option( $layouts ) {
        $layouts['valeska'] = esc_html__( 'Valeska', 'valeska-core' );

        return $layouts;
    }

    add_filter( 'valeska_core_filter_page_spinner_layout_options', 'valeska_core_add_valeska_spinner_layout_option' );
}

if ( ! function_exists( 'valeska_core_set_valeska_spinner_layout_as_default_option' ) ) {
    /**
     * Function that set default value for page spinner layout options map
     *
     * @param string $default_value
     *
     * @return string
     */
    function valeska_core_set_valeska_spinner_layout_as_default_option( $default_value ) {
        return 'pulse';
    }

    add_filter( 'valeska_core_filter_page_spinner_default_layout_option', 'valeska_core_set_valeska_spinner_layout_as_default_option' );
}
