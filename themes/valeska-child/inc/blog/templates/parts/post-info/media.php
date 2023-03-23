<div class="qodef-e-media"><!--
	--><?php
	switch ( get_post_format() ) {
		case 'gallery':
			valeska_template_part( 'blog', 'templates/parts/post-format/gallery' );
			break;
		case 'video':
			valeska_template_part( 'blog', 'templates/parts/post-format/video' );
			break;
		case 'audio':
			valeska_template_part( 'blog', 'templates/parts/post-format/audio' );
			break;
		default:
			valeska_template_part( 'blog', 'templates/parts/post-info/image' );
			break;
	}
	?><!--
--></div>
