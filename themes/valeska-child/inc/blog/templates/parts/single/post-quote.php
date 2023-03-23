<article <?php post_class( 'qodef-blog-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post format part
		valeska_template_part( 'blog', 'templates/parts/post-format/quote' );
		?>
		<div class="qodef-e-content">

			<div class="qodef-e-text">
				<?php
				// Include post content
				the_content();

				// Hook to include additional content after blog single content
				do_action( 'valeska_action_after_blog_single_content' );
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left qodef-e-info">
					<?php
					// Include post author info
					valeska_template_part( 'blog', 'templates/parts/post-info/tags' );

					?>
				</div>
				<div class="qodef-e-right qodef-e-info">
					<?php
					// Include post tags info
					valeska_template_part( 'blog', 'templates/parts/post-info/share' );
					?>
				</div>
			</div>
		</div>
	</div>
</article>
