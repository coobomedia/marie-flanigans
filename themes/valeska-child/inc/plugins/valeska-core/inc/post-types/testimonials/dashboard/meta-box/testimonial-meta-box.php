<?php

if ( ! function_exists( 'valeska_core_add_testimonials_meta_box' ) ) {
	/**
	 * Function that adds fields for testimonials
	 */
	function valeska_core_add_testimonials_meta_box() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'testimonials' ),
				'type'  => 'meta',
				'slug'  => 'testimonials',
				'title' => esc_html__( 'Testimonials Parameters', 'valeska-core' ),
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_title',
					'title'      => esc_html__( 'Title', 'valeska-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'textarea',
					'name'       => 'qodef_testimonials_text',
					'title'      => esc_html__( 'Text', 'valeska-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_author',
					'title'      => esc_html__( 'Author', 'valeska-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_testimonials_author_job',
					'title'      => esc_html__( 'Author Job Title', 'valeska-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'valeska_core_action_after_testimonials_meta_box_map', $page );
		}
	}

	add_action( 'valeska_core_action_default_meta_boxes_init', 'valeska_core_add_testimonials_meta_box' );
}
