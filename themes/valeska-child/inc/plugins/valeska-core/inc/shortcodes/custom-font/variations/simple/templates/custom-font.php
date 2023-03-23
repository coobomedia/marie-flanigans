<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php echo qode_framework_get_inline_attrs( $holder_data, true ); ?>>
    <?php if ( ! empty( $tagline ) ) { ?>
        <span class="qodef-m-tagline">
            <?php echo esc_html( $tagline ); ?>
        </span>
    <?php } ?>
    <<?php echo esc_attr( $title_tag ); ?> <?php qode_framework_class_attribute( $title_classes ); ?> <?php qode_framework_inline_style( $title_styles ); ?>>
        <?php echo qode_framework_wp_kses_html( 'content', $title ); ?>
    </<?php echo esc_attr( $title_tag ); ?>>
</div>