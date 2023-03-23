<div class="qodef-header-sticky">
	<div class="qodef-header-sticky-inner <?php echo implode( ' ', apply_filters( 'valeska_filter_header_inner_class', array(), 'sticky' ) ); ?>">
		<div class="qodef-divided-header-left-wrapper">
			<?php
			// Include widget area two
			valeska_core_get_header_widget_area( 'two', 'sticky-header-widget-area', 'sticky' );

			// Include divided left navigation
			valeska_core_template_part( 'header/layouts/divided', 'templates/parts/left-navigation' );
			?>
		</div>
		<?php
		// Include logo
		valeska_core_get_header_logo_image( array( 'sticky_logo' => true ) );
		?>
		<div class="qodef-divided-header-right-wrapper">
			<?php
			// Include divided right navigation
			valeska_core_template_part( 'header/layouts/divided', 'templates/parts/right-navigation' );

			// Include widget area one
			valeska_core_get_header_widget_area( 'one', 'sticky-header-widget-area', 'sticky' );
			?>
		</div>
		<?php do_action( 'valeska_core_action_after_sticky_header' ); ?>
	</div>
</div>
