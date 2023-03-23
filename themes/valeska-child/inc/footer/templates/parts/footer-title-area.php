
<?php if ( valeska_is_footer_title_area_enabled() ) { ?>
	<div id="qodef-page-footer-title-area">
		<div id="qodef-page-footer-title-area-inner" class="<?php echo esc_attr( valeska_get_footer_title_area_classes() ); ?>">
			<div class="qodef-grid qodef-layout--columns qodef-responsive--custom qodef-col-num--1">
				<div class="qodef-grid-inner clear">
						<div class="qodef-grid-item">
							<?php valeska_get_footer_widget_area( 'title', 1 ); ?>
						</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
