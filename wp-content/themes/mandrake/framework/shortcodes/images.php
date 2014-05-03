<?php

function theme_shortcode_image($atts, $content = null) {
	extract(shortcode_atts(array(
		'size' => 'small',
		'link' => false,
		'icon' => 'image',
		'lightbox' => false,
		'title' => '',
		'align' => false,
		'group' => false,
	), $atts));
	if ($size == 'thumb') {
		$width = '220';
		$height = '125';
	}
	if ($size == 'small') {
		$width = '300';
		$height = '170';
	}
	if ($size == 'medium') {
		$width = '460';
		$height = '260';
	}
	if ($size == 'large') {
		$width = '620';
		$height = '350';
	}
	$content = '<img width="'.$width.'" height="'.$height.'" alt="'.$title.'" src="'.THEME_INCLUDES.'/timthumb.php?src='. $content .'&amp;h='. $height .'&amp;w='. $width .'&amp;zc=1" />';
	if (!$link) {
		return '<div class="image-holder '. $align .'"><div class="image-shadow">'. $content .'<div class="shadow"><img src="'. THEME_URI .'/images/image-shadow.png" alt="" /></div></div></div>';
	} else {
		return '<div class="image-holder '. $align .'"><div class="image-shadow"><a href="'. $link .'"'. ($group ? ' rel="' .$group. '"' : '') .' class="'. $lightbox .'" title="'. $title .'">'. $content .'<span class="zoom-'. $icon .'"></span></a><div class="shadow"><img src="'. THEME_URI .'/images/image-shadow.png" alt="" /></div></div></div>';
	}
}
add_shortcode('image', 'theme_shortcode_image');

function theme_shortcode_image_frame($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'align' => false
	), $atts));
	return '<div class="image-frame '. $align .'"><img width="120" height="140" alt="'.$title.'" src="'.THEME_INCLUDES.'/timthumb.php?src='. $content .'&amp;h=140&amp;w=120&amp;zc=1" /></div>';
}
add_shortcode('image_frame', 'theme_shortcode_image_frame');

?>