<?php if ( ! empty( $video_link ) ) { ?>
	<a itemprop="url" class="qodef-m-play qodef-magnific-popup qodef-popup-item" <?php echo qode_framework_get_inline_style( $play_button_styles ); ?> href="<?php echo esc_url( $video_link ); ?>" data-type="iframe">
		<span class="qodef-m-play-inner">
			<?php echo qode_framework_icons()->render_icon( 'arrow_triangle-right_alt', 'elegant-icons' ); ?>
		</span>
	</a>
<?php } ?>
