<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<div class="qodef-m-images">
		<?php if ( ! empty( $main_image ) ) { ?>
            <div class="qodef-m-main-image">
                <div <?php qode_framework_class_attribute( $item_classes ); ?>>
                    <?php
                    $images_proportion   = isset( $images_proportion ) && ! empty( $images_proportion ) ? esc_attr( $images_proportion ) : 'full';
                    $custom_image_width  = isset( $custom_image_width ) && '' !== $custom_image_width ? intval( $custom_image_width ) : 0;
                    $custom_image_height = isset( $custom_image_height ) && '' !== $custom_image_height ? intval( $custom_image_height ) : 0;
                    echo valeska_core_get_list_shortcode_item_image( $images_proportion, $main_image, $custom_image_width, $custom_image_height );
                    ?>
                </div>
            </div>
		<?php } ?>
		<?php if ( ! empty( $main_video ) ) { ?>
            <div class="qodef-m-main-image">
                <div <?php qode_framework_class_attribute( $item_classes ); ?>>
                    <video id="qodef-main-video" autoplay muted loop>
                        <source src="<?php echo esc_url( $main_video ); ?>" type="video/mp4">
                    </video>
                </div>
            </div>
		<?php } ?>
		<?php if ( ! empty( $items ) ) {
			foreach ( $items as $item ) { ?>
                <div <?php qode_framework_class_attribute( $item_classes ); ?> style="<?php echo esc_attr($item['item_vertical_anchor']) . ':' . esc_attr($item['item_vertical_position']) . '; ' . esc_attr($item['item_horizontal_anchor']) . ':' . esc_attr($item['item_horizontal_position']) . '; ' . 'text-align' . ':' . esc_attr($item['item_horizontal_anchor']); ?>">
                    <?php
                    $item['images_proportion']   = isset( $item['images_proportion'] ) && ! empty( $item['images_proportion'] ) ? esc_attr( $item['images_proportion'] ) : 'full';
                    $item['custom_image_width']  = isset( $item['custom_image_width'] ) && '' !== $item['custom_image_width'] ? intval( $item['custom_image_width'] ) : 0;
                    $item['custom_image_height'] = isset( $item['custom_image_height'] ) && '' !== $item['custom_image_height'] ? intval( $item['custom_image_height'] ) : 0;
                    echo valeska_core_get_list_shortcode_item_image( $item['images_proportion'], $item['item_image'], $item['custom_image_width'], $item['custom_image_height'] );
                    ?>
                </div>
			<?php }
		} ?>
	</div>
</div>
