<div class="qodef-grid-item <?php echo esc_attr( valeska_get_page_content_sidebar_classes() ); ?>">
	<div class="qodef-search qodef-m">
		<?php
		// Include search form
		valeska_template_part( 'search', 'templates/parts/search-form' );

		// Include posts loop
		valeska_template_part( 'search', 'templates/parts/loop' );

		// Include pagination
		valeska_template_part( 'pagination', 'templates/pagination-wp' );
		?>
	</div>
</div>
