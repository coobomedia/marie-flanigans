<div class="qodef-divided-header-left-wrapper">
	<?php
	// Include widget area two
	valeska_core_get_header_widget_area( 'two' );

	// Include divided left navigation
	valeska_core_template_part( 'header/layouts/divided', 'templates/parts/left-navigation' );
	?>
</div>
<?php
// Include logo
valeska_core_get_header_logo_image();
?>
<div class="qodef-divided-header-right-wrapper">
	<?php
	// Include divided right navigation
	valeska_core_template_part( 'header/layouts/divided', 'templates/parts/right-navigation' );

	// Include widget area one
	valeska_core_get_header_widget_area();
	?>
</div>
