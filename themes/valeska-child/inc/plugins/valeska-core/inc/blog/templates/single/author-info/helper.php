<?php

if ( ! function_exists( 'valeska_core_include_blog_single_author_info_template' ) ) {
	/**
	 * Function which includes additional module on single posts page
	 */
	function valeska_core_include_blog_single_author_info_template() {
		if ( is_single() ) {
			include_once VALESKA_CORE_INC_PATH . '/blog/templates/single/author-info/templates/author-info.php';
		}
	}

	add_action( 'valeska_action_after_blog_post_item', 'valeska_core_include_blog_single_author_info_template', 15 );  // permission 15 is set to define template position
}

if ( ! function_exists( 'valeska_core_get_author_social_networks' ) ) {
	/**
	 * Function which includes author info templates on single posts page
	 */
	function valeska_core_get_author_social_networks( $user_id ) {
		$icons           = array();
		$social_networks = array(
			'facebook'  => array(
				'label'   => esc_html__( 'facebook', 'valeska-core' ),
				'shorten' => esc_html__( 'Facebook', 'valeska-core' ),
			),
			'twitter'   => array(
				'label'   => esc_html__( 'twitter', 'valeska-core' ),
				'shorten' => esc_html__( 'Twitter', 'valeska-core' ),
			),
			'linkedin'  => array(
				'label'   => esc_html__( 'linkedin', 'valeska-core' ),
				'shorten' => esc_html__( 'Linkedin', 'valeska-core' ),
			),
			'instagram' => array(
				'label'   => esc_html__( 'instagram', 'valeska-core' ),
				'shorten' => esc_html__( 'Instagram', 'valeska-core' ),
			),
			'pinterest' => array(
				'label'   => esc_html__( 'pinterest', 'valeska-core' ),
				'shorten' => esc_html__( 'Pinterest', 'valeska-core' ),
			),
		);

		foreach ( $social_networks as $network ) {
			$network_meta = get_the_author_meta( 'qodef_user_' . $network['label'], $user_id );


			if ( ! empty( $network_meta ) ) {
				$network_list = array(
					'url'   => $network_meta,
					'icon'  => 'social_' . $network['label'],
					'class' => 'qodef-user-social-' . $network['label'],
					'text'  => $network['shorten'],
				);

				$icons[ $network['label'] ] = $network_list;
			}
		}

		return $icons;
	}
}
