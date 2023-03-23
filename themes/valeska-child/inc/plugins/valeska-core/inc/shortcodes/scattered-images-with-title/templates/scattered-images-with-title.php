<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
    <div class="qodef-m-layer-holder">
        <div class="qodef-m-layer qodef-m-layer--bottom">
            <?php
            // include items
            if ( ! empty( $bottom_layer_images ) ) {
                foreach ( $bottom_layer_images as $bottom_layer_image ) {
                    valeska_core_template_part( 'shortcodes/scattered-images-with-title', 'templates/parts/image', '', array_merge( $params, $bottom_layer_image ) );
                }
            }
            ?>
        </div>
        <div class="qodef-m-layer qodef-m-layer--top">
            <?php
            // include items
            if ( ! empty( $top_layer_images ) ) {
                foreach ( $top_layer_images as $top_layer_image ) {
                    valeska_core_template_part( 'shortcodes/scattered-images-with-title', 'templates/parts/image', '', array_merge( $params, $top_layer_image ) );
                }
            }
            ?>
        </div>
    </div>
    <?php if ( ! empty( $title ) ) { ?>
        <div class="qodef-m-title-holder">
            <?php valeska_core_template_part( 'shortcodes/scattered-images-with-title', 'templates/parts/title', '', $params ); ?>
        </div>
    <?php } ?>
</div>
