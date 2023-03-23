<?php

if ( ! function_exists( 'valeska_core_register_team_for_meta_options' ) ) {
	/**
	 * Function that add custom post type into global meta box allowed items array for saving meta box options
	 *
	 * @param array $post_types
	 *
	 * @return array
	 */
	function valeska_core_register_team_for_meta_options( $post_types ) {
		$post_types[] = 'team';

		return $post_types;
	}

	add_filter( 'qode_framework_filter_meta_box_save', 'valeska_core_register_team_for_meta_options' );
	add_filter( 'qode_framework_filter_meta_box_remove', 'valeska_core_register_team_for_meta_options' );
}

if ( ! function_exists( 'valeska_core_add_team_custom_post_type' ) ) {
	/**
	 * Function that adds team custom post type
	 *
	 * @param array $cpts
	 *
	 * @return array
	 */
	function valeska_core_add_team_custom_post_type( $cpts ) {
		$cpts[] = 'ValeskaCore_Team_CPT';

		return $cpts;
	}

	add_filter( 'valeska_core_filter_register_custom_post_types', 'valeska_core_add_team_custom_post_type' );
}

if ( class_exists( 'QodeFrameworkCustomPostType' ) ) {
	class ValeskaCore_Team_CPT extends QodeFrameworkCustomPostType {

		public function map_post_type() {
			$name = esc_html__( 'Team', 'valeska-core' );
			$this->set_base( 'team' );
			$this->set_menu_position( 10 );
			$this->set_menu_icon( 'dashicons-businessperson' );
			$this->set_slug( 'team' );
			$this->set_name( $name );
			$this->set_path( VALESKA_CORE_CPT_PATH . '/team' );
			$this->set_labels(
				array(
					'name'          => esc_html__( 'Valeska Team', 'valeska-core' ),
					'singular_name' => esc_html__( 'Team Member', 'valeska-core' ),
					'add_item'      => esc_html__( 'New Team Member', 'valeska-core' ),
					'add_new_item'  => esc_html__( 'Add New Team Member', 'valeska-core' ),
					'edit_item'     => esc_html__( 'Edit Team Member', 'valeska-core' ),
				)
			);
			if ( ! valeska_core_team_has_single() ) {
				$this->set_public( false );
				$this->set_archive( false );
				$this->set_supports(
					array(
						'title',
						'thumbnail',
					)
				);
			}
			$this->add_post_taxonomy(
				array(
					'base'          => 'team-category',
					'slug'          => 'team-category',
					'singular_name' => esc_html__( 'Category', 'valeska-core' ),
					'plural_name'   => esc_html__( 'Categories', 'valeska-core' ),
				)
			);
		}
	}
}
