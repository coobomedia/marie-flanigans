<?php
$is_enabled = valeska_core_get_post_value_through_levels( 'qodef_blog_single_enable_single_post_navigation' );

if ( 'yes' === $is_enabled ) {
	$through_same_category = 'yes' === valeska_core_get_post_value_through_levels( 'qodef_blog_single_post_navigation_through_same_category' );
	?>
	<div id="qodef-single-post-navigation" class="qodef-m">
		<div class="qodef-m-inner">
			<?php
			$post_navigation = array(
				'prev' => array(
					'label' => '<span class="qodef-m-nav-label">' . esc_html__( 'Previous', 'valeska-core' ) . '</span>',
					'icon'  => valeska_get_svg_icon( 'pagination-arrow-left' ),
				),
				'next' => array(
					'label' => '<span class="qodef-m-nav-label">' . esc_html__( 'Next', 'valeska-core' ) . '</span>',
					'icon'  => valeska_get_svg_icon( 'pagination-arrow-right' ),
				),
			);

			if ( $through_same_category ) {
				if ( '' !== get_previous_post( true ) ) {
					$post_navigation['prev']['post'] = get_previous_post( true );
				}
				if ( '' !== get_next_post( true ) ) {
					$post_navigation['next']['post'] = get_next_post( true );
				}
			} else {
				if ( '' !== get_previous_post() ) {
					$post_navigation['prev']['post'] = get_previous_post();
				}
				if ( '' !== get_next_post() ) {
					$post_navigation['next']['post'] = get_next_post();
				}
			}

			foreach ( $post_navigation as $key => $value ) {
				if ( isset( $post_navigation[ $key ]['post'] ) ) {
					$current_post = $value['post'];
					$post_id      = $current_post->ID;
					?>
					<a itemprop="url" class="qodef-m-nav qodef--<?php echo esc_attr( $key ); ?>" href="<?php echo get_permalink( $post_id ); ?>">
						<span class="qodef-m-nav-image">
							<?php echo get_the_post_thumbnail( $post_id, 'thumbnail' ); ?>
						</span>
						<span class="qodef-m-nav-info">
							<?php echo wp_kses( $value['label'], array( 'span' => array( 'class' => true ) ) ); ?>
						</span>
					</a>
					<?php
				}
			}
			?>
		</div>
	</div>
<?php } ?>
