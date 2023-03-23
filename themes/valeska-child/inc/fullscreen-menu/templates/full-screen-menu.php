<div id="qodef-fullscreen-area">
	<?php if ( $fullscreen_menu_in_grid ) { ?>
	<div class="qodef-content-grid">
		<?php } ?>

		<div id="qodef-fullscreen-area-inner">
			<?php if ( has_nav_menu( 'fullscreen-menu-navigation' ) ) { ?>
				<nav class="qodef-fullscreen-menu" role="navigation" aria-label="<?php esc_attr_e( 'Full Screen Menu', 'valeska-core' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'fullscreen-menu-navigation',
							'container'      => '',
							'link_before'    => '<span class="qodef-menu-item-text">',
							'link_after'     => '</span>',
							'walker'         => new ValeskaCoreRootMainMenuWalker(),
						)
					);
					?>
				</nav>
			<?php } ?>
			<?php
			valeska_core_get_header_widget_area( 'two' );
			?>
		</div>
		<?php if ( $fullscreen_menu_in_grid ) { ?>
	</div>
<?php } ?>
</div>
