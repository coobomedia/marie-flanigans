<?php

if ( ! function_exists( 'valeska_core_add_video_post_format_meta_box' ) ) {
	/**
	 * Function that add options for post format
	 *
	 * @param mixed $page - general post format meta box section
	 */
	function valeska_core_add_video_post_format_meta_box( $page ) {

		if ( $page ) {
			$post_format_section = $page->add_section_element(
				array(
					'name'  => 'qodef_post_format_video_section',
					'title' => esc_html__( 'Post Format Video', 'valeska-core' ),
				)
			);

			$post_format_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_post_format_video_url',
					'title'       => esc_html__( 'Video URL', 'valeska-core' ),
					'description' => esc_html__( 'Input your video link here. Here are all the supported video formats https://wordpress.org/support/article/video-shortcode/#options  https://wordpress.org/support/article/embeds/#okay-so-what-sites-can-i-embed-from', 'valeska-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'valeska_core_action_after_video_post_format_meta_box', $page );
		}
	}

	add_action( 'valeska_core_action_after_blog_single_meta_box_map', 'valeska_core_add_video_post_format_meta_box', 2 );
}
