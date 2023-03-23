<?php do_action( 'valeska_action_before_page_header' ); ?>

<header id="qodef-page-header" role="banner">
	<div id="qodef-page-header-inner" class="<?php echo implode( ' ', apply_filters( 'valeska_filter_header_inner_class', array(), 'default' ) ); ?>">
		<?php
		// include logo
		valeska_core_get_header_logo_image();

		// include opener
		valeska_core_get_opener_icon_html(
			array(
				'option_name'  => 'vertical_sliding_menu',
				'custom_class' => 'qodef-fullscreen-menu-opener',
			),
			false
		);
		?>
	</div>
</header>
