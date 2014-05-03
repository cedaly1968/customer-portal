<?php

function theme_shortcode_styled_table($atts, $content = null) {
	return '<div class="styled-table">'. do_shortcode(trim($content)) .'</div>';
}
add_shortcode('styled_table','theme_shortcode_styled_table');

function theme_shortcode_code($atts, $content = null) {
   return '<code>'. do_shortcode($content) .'</code>';
}
add_shortcode('code', 'theme_shortcode_code');

function theme_shortcode_pre($atts, $content = null) {
   return '<pre>'. do_shortcode($content) .'</pre>';
}
add_shortcode('pre', 'theme_shortcode_pre');

?>