<?php

function theme_shortcode_tabs($atts, $content = null) {
	if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		$output = '<div class="tabbed-menu">';
		$output .= '<ul>';
		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<li><a href="#">'. $matches[3][$i]['title'] .'</a></li>';
		}
		$output .= '</ul>';
		$output .= '</div>';
		$output .= '<div class="tabbed-content">';
		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<div class="pane">'. do_shortcode(trim($matches[5][$i])) .'</div>';
		}
		$output .= '</div>';
		return '<div class="tabbed-box">'. $output .'</div>';
	}	
}
add_shortcode('tabs','theme_shortcode_tabs');


function theme_shortcode_mini_tabs($atts, $content = null) {
	if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		$output = '<div class="tabbed-menu">';
		$output .= '<ul>';
		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<li><a href="#">'. $matches[3][$i]['title'] .'</a></li>';
		}
		$output .= '</ul>';
		$output .= '</div>';
		$output .= '<div class="tabbed-content">';
		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<div class="pane">'. do_shortcode(trim($matches[5][$i])) .'</div>';
		}
		$output .= '</div>';
		return '<div class="tabbed-box mini">'. $output .'</div>';
	}	
}
add_shortcode('mini_tabs','theme_shortcode_mini_tabs');


function theme_shortcode_accordions($atts, $content = null) {
	if (!preg_match_all("/(.?)\[(accordion)\b(.*?)(?:(\/))?\](?:(.+?)\[\/accordion\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		$output = '';
		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<div class="accordion-tab"><a href="#">'. $matches[3][$i]['title'] .'</a></div>';
			$output .= '<div class="accordion-content">'. do_shortcode(trim($matches[5][$i])) .'</div>';
		}
		return '<div class="accordion">'. $output .'</div>';
	}
}
add_shortcode('accordions', 'theme_shortcode_accordions');


function theme_shortcode_expand($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => false
	), $atts));
	return '<div class="expand-box"><div class="expand-tab"><a href="#">'. $title .'</a></div><div class="expand-content">'. do_shortcode(trim($content)) .'</div></div>';
}
add_shortcode('expand', 'theme_shortcode_expand');


function theme_shortcode_toggle($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => false
	), $atts));
	return '<div class="toggle-item"><a href="#" class="toggle-title">'. $title .'</a><div class="toggle-content">'. do_shortcode(trim($content)) .'</div></div>';
}
add_shortcode('toggle', 'theme_shortcode_toggle');

?>