<div id="qodef-subscribe-popup-modal" class="qodef-sp-holder <?php echo esc_attr( $holder_classes ); ?>">
	<div class="qodef-sp-inner">
		<a class="qodef-sp-close" href="javascript:void(0)">
			<svg x="0px" y="0px" width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">
				<line fill="none" stroke="currentColor" stroke-miterlimit="10" x1="15.384" y1="4.994" x2="4.918" y2="15.459"/>
				<line fill="none" stroke="currentColor" stroke-miterlimit="10" x1="4.918" y1="4.994" x2="15.384" y2="15.459"/>
			</svg>
		</a>
		<?php if ( ! empty( $image ) ) : ?>
			<div class="qodef-sp-image">
				<?php echo wp_get_attachment_image( $image, 'full' ); ?>
			</div>
		<?php endif; ?>
		<div class="qodef-sp-content-container" <?php qode_framework_inline_style( $content_style ); ?>>
			<div class="qodef-sp-content-inner">
				<?php if ( ! empty( $title ) ) : ?>
					<h6 class="qodef-sp-title"><?php echo esc_html( $title ); ?></h6>
				<?php endif; ?>
				<?php if ( ! empty( $subtitle ) ) : ?>
					<p class="qodef-sp-subtitle"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>

				<?php echo do_shortcode( '[contact-form-7 id="' . $contact_form . '"]' ); ?>
			</div>
			<?php if ( 'yes' === $enable_prevent ) : ?>
				<div class="qodef-sp-prevent">
					<div class="qodef-sp-prevent-inner">
						<input class="qodef-sp-prevent-input" type="checkbox" name="qodef-sp-prevent-input" id="qodef-sp-prevent-input" />
						<label for="qodef-sp-prevent-input" class="qodef-sp-prevent-label"><?php esc_html_e( 'Disable This Pop-up', 'valeska-core' ); ?></label>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
