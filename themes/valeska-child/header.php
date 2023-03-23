<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<style>
	@font-face {
  font-family: Monday;
  src: url(https://www.marieflanigancollection.com/fonts/Monday-RegularWEB.woff) format('woff');
  src: url(https://www.marieflanigancollection.com/fonts/Monday-RegularWEB.woff2) format('woff2');
}

@font-face {
  font-family: MondayItalic;
  src: url(https://www.marieflanigancollection.com/fonts/Monday-ItalicWEB.woff) format('woff');
  src: url(https://www.marieflanigancollection.com/fonts/Monday-ItalicWEB.woff2) format('woff2');
}

@font-face {
  font-family: Sailec;
  src: url(https://www.marieflanigancollection.com/fonts/Sailec.woff) format('woff');
}

@font-face {
  font-family: SailecItalic;
  src: url(https://www.marieflanigancollection.com/fonts/SailecItalic.woff) format('woff');
}

@font-face {
  font-family: SailecBold;
  src: url(https://www.marieflanigancollection.com/fonts/SailecBold.woff) format('woff');
}

@font-face {
  font-family: SailecBoldItalic;
  src: url(https://www.marieflanigancollection.com/fonts/SailecBoldItalic.woff) format('woff');
}
	</style>
	
	<?php wp_head(); ?>
	<script>
  (function(w, d, t, h, s, n) {
    w.FlodeskObject = n;
    var fn = function() {
      (w[n].q = w[n].q || []).push(arguments);
    };
    w[n] = w[n] || fn;
    var f = d.getElementsByTagName(t)[0];
    var v = '?v=' + Math.floor(new Date().getTime() / (120 * 1000)) * 60;
    var sm = d.createElement(t);
    sm.async = true;
    sm.type = 'module';
    sm.src = h + s + '.mjs' + v;
    f.parentNode.insertBefore(sm, f);
    var sn = d.createElement(t);
    sn.async = true;
    sn.noModule = true;
    sn.src = h + s + '.js' + v;
    f.parentNode.insertBefore(sn, f);
  })(window, document, 'script', 'https://assets.flodesk.com', '/universal', 'fd');
</script>
</head>
<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
	<?php
	// Hook to include default WordPress hook after body tag open
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	}

	// Hook to include additional content after body tag open
	do_action( 'valeska_action_after_body_tag_open' );
	?>
	<div id="qodef-page-wrapper" class="<?php echo esc_attr( valeska_get_page_wrapper_classes() ); ?>">
		<?php
		// Hook to include page header template
		do_action( 'valeska_action_page_header_template' );
		?>
		<div id="qodef-page-outer">
			<?php
			// Include title template
			get_template_part( 'title' );

			// Hook to include additional content before page inner content
			do_action( 'valeska_action_before_page_inner' );
			?>
			<div id="qodef-page-inner" class="<?php echo esc_attr( valeska_get_page_inner_classes() ); ?>">
