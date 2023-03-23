<?php if ( isset( $query_result ) && intval( $max_num_pages ) > 1 ) { ?>
	<div class="qodef-m-pagination qodef--load-more" <?php qode_framework_inline_style( $pagination_type_load_more_top_margin ); ?>>
		<div class="qodef-m-pagination-inner">
			<?php
			$button_params = array(
				'custom_class'  => 'qodef-load-more-button',
				'button_layout' => 'outlined',
				'link'          => '#',
				'text'          => esc_html__( 'Load More', 'valeska-core' ),
			);

			echo ValeskaCore_Button_Shortcode::call_shortcode( $button_params );
			?>
		</div>
	</div>
    <span class="qodef-m-pagination-spinner"></span>
<?php } ?>
