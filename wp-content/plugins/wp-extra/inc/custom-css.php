<?php
/** Minify CSS **/
function vnex_minify_css($css){
  $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
  return $css;
}
/* CUSTOM CSS */
function vnex_custom_css() {
ob_start();
?>
<style id="custom-css" type="text/css">
<?php
$vnexoption = vnex_all_options();
if($vnexoption['vnex_html_custom_css']){
	echo '/* Custom CSS */';
	echo sanitize_text_field($vnexoption['vnex_html_custom_css']);
}
if($vnexoption['vnex_html_custom_css_tablet']){
	echo '/* Custom CSS Tablet */';
	if($vnexoption['vnex_html_custom_css_tablet_maxwidth']){
		echo '@media (max-width: '.sanitize_text_field($vnexoption['vnex_html_custom_css_tablet_maxwidth']).'){';
	} else {
		echo '@media (max-width: 849px){';
	}
	echo sanitize_text_field($vnexoption['vnex_html_custom_css_tablet']);
	echo '}';
}
if($vnexoption['vnex_html_custom_css_mobile']){
	echo '/* Custom CSS Mobile */';
	if($vnexoption['vnex_html_custom_css_mobile_maxwidth']){
		echo '@media (max-width: '.sanitize_text_field($vnexoption['vnex_html_custom_css_mobile_maxwidth']).'){';
	} else {
		echo '@media (max-width: 549px){';
	}
	echo sanitize_text_field($vnexoption['vnex_html_custom_css_mobile']);
	echo '}';
} ?>
</style>
<?php
$buffer = ob_get_clean();
echo vnex_minify_css ($buffer);
}
add_action( 'wp_head', 'vnex_custom_css', 100 );
