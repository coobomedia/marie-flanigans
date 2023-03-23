<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		valeska_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/media', '', $params );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<?php
					// Include post date info
					valeska_core_theme_template_part( 'blog', 'templates/parts/post-info/categories' );
					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
				valeska_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/title', '', $params );
				// Hook to include additional content after blog single content
				do_action( 'valeska_action_after_blog_single_content' );
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left">
					<?php
					// Include post author info
					valeska_core_theme_template_part( 'blog', 'templates/parts/post-info/author' );
					?>
				</div>
			</div>
		</div>
	</div>
</article>
