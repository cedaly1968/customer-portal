<?php
/**
 * All Video Shortcodes
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */

/*-------------------------------------------------------------------------------------*/
/*		1.		Vimeo Video
/*-------------------------------------------------------------------------------------*/

function dm_vimeo($atts, $content = null){
	extract(shortcode_atts(array(
	"id" => '',
	"w" => '100%',
	"h" => ''
	), $atts));
	return '<iframe src="http://player.vimeo.com/video/'.$id.'?show_title=0&amp;show_byline=0&amp;portrait=0" width="'.$w.'" height="'.$h.'" frameborder="0" class="video"></iframe>';
	}
add_shortcode("vimeo", "dm_vimeo");		

/*-------------------------------------------------------------------------------------*/
/*		2.		Youtube Video
/*-------------------------------------------------------------------------------------*/

function dm_youtube($atts, $content = null){
	extract(shortcode_atts(array(
	"id" => '',
	"w" => '100%',
	"h" => '',
	"full_screen" =>'true'
	), $atts));
	return '<object width="'.$w.'" height="'.$h.'" class="video"><param name="movie" value="http://www.youtube.com/v/'.$id.'?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$id.'?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="'.$full_screen.'" width="'.$w.'" height="'.$h.'"></embed></object>';
	}
add_shortcode("youtube", "dm_youtube");	


/*-------------------------------------------------------------------------------------*/
/*		2.		Dailymotion Video
/*-------------------------------------------------------------------------------------*/

function dm_dailymotion($atts, $content = null){
	extract(shortcode_atts(array(
	"id" => '',
	"w" => '100%',
	"h" => '',
	"full_screen" =>'true'
	), $atts));
	return '<object width="'.$w.'" height="'.$h.'" class="video"><param name="movie" value="http://www.dailymotion.com/swf/video/'.$id.'?width=&amp;theme=none&amp;foreground=%23F7FFFD&amp;highlight=%23FFC300&amp;background=%23171D1B&amp;start=&amp;animatedTitle=&amp;iframe=0&amp;additionalInfos=0&amp;autoPlay=0&amp;hideInfos=0"></param><param name="allowFullScreen" value="'.$full_screen.'"></param><param name="allowScriptAccess" value="always"></param><embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/'.$id.'?width=&amp;theme=none&amp;foreground=%23F7FFFD&amp;highlight=%23FFC300&amp;background=%23171D1B&amp;start=&amp;animatedTitle=&amp;iframe=0&amp;additionalInfos=0&amp;autoPlay=0&amp;hideInfos=0" width="'.$w.'" height="'.$h.'" allowfullscreen="'.$full_screen.'" allowscriptaccess="always"></embed></object>';
	}
add_shortcode("dailymotion", "dm_dailymotion");	


?>