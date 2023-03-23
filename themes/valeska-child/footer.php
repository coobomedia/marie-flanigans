			</div><!-- close #qodef-page-inner div from header.php -->
		</div><!-- close #qodef-page-outer div from header.php -->


		<div class="newsletter-footer">
			<h1>Newsletter</h1>
			<p style="text-align: center;">Be the first to receive Marie’s product updates, styling tips, and design inspiration.</p>
			<div id="fd-form-625f126956c69c8b0fd4244b">
			</div>
						<script>
							window.fd('form', {
								formId: '625f126956c69c8b0fd4244b',
								containerEl: '#fd-form-625f126956c69c8b0fd4244b'
							});
						</script>
		</div>


		
		<?php
		// Hook to include page footer template
		do_action( 'valeska_action_page_footer_template' );

		// Hook to include additional content before wrapper close tag
		do_action( 'valeska_action_before_wrapper_close_tag' );
		?>
	</div><!-- close #qodef-page-wrapper div from header.php -->
	<?php
	// Hook to include additional content before body tag closed
	do_action( 'valeska_action_before_body_tag_close' );
	?>
<?php wp_footer(); ?>
</body>
</html>
