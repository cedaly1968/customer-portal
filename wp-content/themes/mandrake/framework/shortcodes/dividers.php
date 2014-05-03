<?php

function theme_shortcode_divider($atts, $content = null) {
	return '<div class="divider"></div>';
}
add_shortcode('divider', 'theme_shortcode_divider');

function theme_shortcode_divider_top($atts, $content = null) {
	return '<div class="divider top"><a href="#">'. __('Top','mandrake_theme') .'</a></div>';
}
add_shortcode('divider_top', 'theme_shortcode_divider_top');

function theme_shortcode_clear($atts, $content = null) {
	return '<div class="clear"></div>';
}
add_shortcode('clear', 'theme_shortcode_clear');

?>