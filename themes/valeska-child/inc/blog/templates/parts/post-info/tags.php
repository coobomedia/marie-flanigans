<?php
$tags = get_the_tags();

if ( $tags ) {
	the_tags( '', '<span class="qodef-info-separator-single"></span>' ); ?>
	<div class="qodef-info-separator-end"></div>
<?php } ?>
