<?php
$tags = get_the_tags();
?>
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
				valeska_template_part( 'blog', 'templates/parts/post-info/title' );

				// Include post content
				the_content();

				// Hook to include additional content after blog single content
				do_action( 'valeska_action_after_blog_single_content' );
				?>
			</div>
			<?php if ( $tags ) { ?>

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
			<?php } ?>
		</div>
	</div>
</article>
