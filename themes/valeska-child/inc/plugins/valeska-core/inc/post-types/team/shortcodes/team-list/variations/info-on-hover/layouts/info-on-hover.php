<div <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<div class="qodef-e-image">
			<?php valeska_core_list_sc_template_part( 'post-types/team/shortcodes/team-list', 'post-info/image', '', $params ); ?>
		</div>
		<div class="qodef-e-content">
			<?php valeska_core_list_sc_template_part( 'post-types/team/shortcodes/team-list', 'post-info/role', '', $params ); ?>
			<?php valeska_core_list_sc_template_part( 'post-types/team/shortcodes/team-list', 'post-info/title', '', $params ); ?>
			<?php valeska_core_list_sc_template_part( 'post-types/team/shortcodes/team-list', 'post-info/excerpt', '', $params ); ?>
			<?php valeska_core_list_sc_template_part( 'post-types/team/shortcodes/team-list', 'post-info/social-icons', '', $params ); ?>
		</div>
	</div>
</div>
