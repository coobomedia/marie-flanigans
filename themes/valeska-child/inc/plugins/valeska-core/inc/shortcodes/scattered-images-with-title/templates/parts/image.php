<div class="<?php echo esc_attr( $item_classes ); ?>">
    <?php
    if ( is_array( $image_size ) && count( $image_size ) ) {
        echo qode_framework_generate_thumbnail( $image_id, $image_size[0], $image_size[1] );
    } else {
        echo wp_get_attachment_image( $image_id, $image_size );
    }
    ?>
</div>
