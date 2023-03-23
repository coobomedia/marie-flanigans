<?php
$social_icons = get_post_meta( get_the_ID(), 'qodef_team_member_social_icons', true );

if ( ! empty( $social_icons ) ) {
	?>
	<div class="qodef-team-member-social-icons">
		<?php
		foreach ( $social_icons as $icon ) {
			if ( ! empty( $icon['qodef_team_member_icon_text'] ) ) {
				$social_link      = $icon['qodef_team_member_icon_link'];
				$social_target    = ! empty( $icon['qodef_team_member_icon_target'] ) ? $icon['qodef_team_member_icon_target'] : '_blank';
				$social_icon_text = $icon['qodef_team_member_icon_text'];

				if ( ! empty( $icon['qodef_team_member_icon_text'] ) ) {
					?>
					<a class="qodef-team-member-social-icon" href="<?php echo esc_url( $social_link ); ?>" target="<?php echo esc_attr( $social_target ); ?>">
						<?php echo esc_html( $social_icon_text ); ?>
					</a>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</div>
<?php } ?>
