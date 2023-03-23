<?php
// Hook to include additional content before page content holder
do_action( 'valeska_core_action_before_team_content_holder' );
?>
	<main id="qodef-page-content" class="qodef-grid qodef-layout--template <?php echo esc_attr( valeska_core_get_grid_gutter_classes() ); ?>" role="main">
		<div class="qodef-grid-inner clear">
			<?php
			// Include team template
			$content = isset( $content ) ? $content : '';
			valeska_core_template_part( 'post-types/team', 'templates/team', $content );

			// Include page content sidebar
			valeska_core_theme_template_part( 'sidebar', 'templates/sidebar' );
			?>
		</div>
	</main>
<?php
// Hook to include additional content after main page content holder
do_action( 'valeska_core_action_after_team_content_holder' );
?>
