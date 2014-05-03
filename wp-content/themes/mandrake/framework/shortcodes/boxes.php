<?php

function theme_shortcode_tip_box($atts, $content = null) {
	return '<div class="tip-box">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('tip_box','theme_shortcode_tip_box');

function theme_shortcode_error_box($atts, $content = null) {
	return '<div class="error-box">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('error_box','theme_shortcode_error_box');

function theme_shortcode_note_box($atts, $content = null) {
	return '<div class="note-box">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('note_box','theme_shortcode_note_box');

function theme_shortcode_info_box($atts, $content = null) {
	return '<div class="info-box">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('info_box','theme_shortcode_info_box');

function theme_shortcode_frame_box($atts, $content = null) {
	return '<div class="frame-box">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('frame_box','theme_shortcode_frame_box');

function theme_shortcode_tip_box_icon($atts, $content = null) {
	return '<div class="tip-box icon">'. do_shortcode($content) .'</div>';
}
add_shortcode('tip_box_icon','theme_shortcode_tip_box_icon');

function theme_shortcode_error_box_icon($atts, $content = null) {
	return '<div class="error-box icon">'. do_shortcode($content) .'</div>';
}
add_shortcode('error_box_icon','theme_shortcode_error_box_icon');

function theme_shortcode_note_box_icon($atts, $content = null) {
	return '<div class="note-box icon">'. do_shortcode($content) .'</div>';
}
add_shortcode('note_box_icon','theme_shortcode_note_box_icon');

function theme_shortcode_info_box_icon($atts, $content = null) {
	return '<div class="info-box icon">'. do_shortcode($content) .'</div>';
}
add_shortcode('info_box_icon','theme_shortcode_info_box_icon');

?>