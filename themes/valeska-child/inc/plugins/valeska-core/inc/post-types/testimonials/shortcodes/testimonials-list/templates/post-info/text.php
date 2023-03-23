<?php
$text = get_post_meta( get_the_ID(), 'qodef_testimonials_text', true );

if ( ! empty( $text ) ) { ?>
	<h3 itemprop="description" class="qodef-e-text"><?php echo esc_html( $text ); ?></h3>
<?php } ?>
