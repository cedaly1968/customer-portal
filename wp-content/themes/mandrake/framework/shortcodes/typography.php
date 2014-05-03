<?php

function theme_shortcode_paragraph($atts, $content = null) {
   return '<p>'. do_shortcode(trim($content)) .'</p>';
}
add_shortcode('p', 'theme_shortcode_paragraph');

function theme_shortcode_dropcap1($atts, $content = null) {
   return '<span class="dropcap1">'. do_shortcode($content) .'</span>';
}
add_shortcode('dropcap1', 'theme_shortcode_dropcap1');

function theme_shortcode_dropcap2($atts, $content = null) {
   return '<span class="dropcap2">'. do_shortcode($content) .'</span>';
}
add_shortcode('dropcap2', 'theme_shortcode_dropcap2');

function theme_shortcode_blockquote($atts, $content = null) {
	extract(shortcode_atts(array(
		'align' => false,
		'cite' => false,
	), $atts));
   return '<blockquote'. ($align ? ' class="'. $align .'"' : '') .'>' . wpautop(do_shortcode(trim($content))) . ($cite ? '<p><cite>'. $cite .'</cite></p>' : '') .'</blockquote>';
}
add_shortcode('blockquote', 'theme_shortcode_blockquote');

function theme_shortcode_highlight($atts, $content = null) {
	extract(shortcode_atts(array(
		'color' => 'yellow',
	), $atts));
	return '<span class="highlight'. (($color) ? ' '. $color : '') .'">'. do_shortcode($content) .'</span>';
}
add_shortcode('highlight', 'theme_shortcode_highlight');

function theme_shortcode_list($atts, $content = null) {
	extract(shortcode_atts(array(
		'style' => false,
	), $atts));
	return str_replace('<ul>', '<ul class="'.$style.'">', do_shortcode($content));
}
add_shortcode('list', 'theme_shortcode_list');

?>