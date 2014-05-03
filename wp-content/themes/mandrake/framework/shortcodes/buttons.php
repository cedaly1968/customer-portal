<?php

function theme_shortcode_button($atts, $content = null) {
	extract(shortcode_atts(array(
		'link' => false,
		'size' => 'small',
		'color' => 'white',
		'target' => 'self',
	), $atts));
	return '<a'. (($link) ? ' href="'. $link .'"' : '') .' class="button '. $size .' '. $color .'" target="_'. $target .'"><span>'. do_shortcode(trim($content)) .'</span></a>';
}
add_shortcode('button','theme_shortcode_button');

function theme_shortcode_button_more($atts, $content = null) {
	extract(shortcode_atts(array(
		'link' => false,
		'target' => 'self',
	), $atts));
	return '<a'. (($link) ? ' href="'. $link .'"' : '') .' class="button more" target="_'. $target .'"><span>'. do_shortcode(trim($content)) .'</span></a>';
}
add_shortcode('button_more','theme_shortcode_button_more');

?>