<article <?php post_class( 'qodef-blog-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		valeska_template_part( 'blog', 'templates/parts/post-info/media' );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<?php
					// Include post date info
					valeska_template_part( 'blog', 'templates/parts/post-info/date' );

					// Include post author info
					valeska_template_part( 'blog', 'templates/parts/post-info/categories' );

					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
				valeska_template_part( 'blog', 'templates/parts/post-info/title', '', array( 'title_tag' => 'h2' ) );

				// Hook to include additional content after blog single content
				do_action( 'valeska_action_after_blog_single_content' );
				?>
				<?php the_excerpt(); ?>
			</div>
			<?php
		if ( valeska_post_has_read_more() ) {
			$button_params = array(
				'link'          => get_permalink() . '#more-' . get_the_ID(),
				'button_layout' => 'textual',
				'text'          => esc_html__( 'Continue Reading', 'valeska' ),
			);
		} else {
			$button_params = array(
				'link'          => get_the_permalink(),
				'button_layout' => 'textual',
				'text'          => esc_html__( 'Read More', 'valeska' ),
			);
		}

		valeska_render_button_element( $button_params );
		?>

	</div>
		
		</div>
	</div>
</article>


