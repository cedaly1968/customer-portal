<?php

function theme_shortcode_video($atts){
	if(isset($atts['type'])){
		switch($atts['type']){
			case 'html5':
				return theme_video_html5($atts);
				break;
			case 'flash':
				return theme_video_flash($atts);
				break;
			case 'youtube':
				return theme_video_youtube($atts);
				break;
			case 'vimeo':
				return theme_video_vimeo($atts);
				break;
			case 'dailymotion':
				return theme_video_dailymotion($atts);
				break;
		}
	}
	return '';
}
add_shortcode('video', 'theme_shortcode_video');

function theme_video_html5($atts){
	extract(shortcode_atts(array(
		'mp4' => '',
		'webm' => '',
		'ogg' => '',
		'poster' => '',
		'width' => false,
		'height' => false,
		'preload' => false,
		'autoplay' => false,
	), $atts));
	if ($height && !$width) {
		$width = '620';
	}
	if (!$height && $width) { 
		$height = '350';
	}
	if (!$height && !$width){
		$width = '620';
		$height = '350';
	}
	if ($mp4) {
		$mp4_source = '<source src="'.$mp4.'" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\'>';
		$mp4_link = '<a href="'.$mp4.'">MP4</a>';
	}
	if ($webm) {
		$webm_source = '<source src="'.$webm.'" type=\'video/webm; codecs="vp8, vorbis"\'>';
		$webm_link = '<a href="'.$webm.'">WebM</a>';
	}
	if ($ogg) {
		$ogg_source = '<source src="'.$ogg.'" type=\'video/ogg; codecs="theora, vorbis"\'>';
		$ogg_link = '<a href="'.$ogg.'">Ogg</a>';
	}
	if ($poster) {
		$poster_attribute = 'poster="'.$poster.'"';
		$image_fallback = '<img src="'. $poster .'" width="'. $width .'" height="'. $height .'" alt="'. __("Poster Image", "mandrake_theme") .'" title="'. __("No video playback capabilities.", "mandrake_theme") .'" />';
	}
	if ($preload) {
		$preload_attribute = 'preload="auto"';
		$flow_player_preload = ',"autoBuffering":true';
	} else {
		$preload_attribute = 'preload="none"';
		$flow_player_preload = ',"autoBuffering":false';
	}
	if ($autoplay) {
		$autoplay_attribute = "autoplay";
		$flow_player_autoplay = ',"autoPlay":true';
	} else {
		$autoplay_attribute = "";
		$flow_player_autoplay = ',"autoPlay":false';
	}
	$output = '<div class="video-frame video-js-box">
		<video class="video-js" width="'. $width .'" height="'. $height .'" '. $poster_attribute .' controls '. $preload_attribute .' '. $autoplay_attribute .'>
			'. $mp4_source .'
			'. $webm_source .'
			'. $ogg_source .'
			<object class="vjs-flash-fallback" width="'. $width .'" height="'. $height .'" type="application/x-shockwave-flash"
				data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
				<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />
				<param name="allowfullscreen" value="true" />
				<param name="flashvars" value=\'config={"clip":{"url":"'. $mp4 .'" '. $flow_player_autoplay .' '. $flow_player_preload .' }}\' />
				'. $image_fallback .'
			</object>
		</video>
	</div>';
	return $output;
}


function theme_video_flash($atts) {
	extract(shortcode_atts(array(
		'src' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
	), $atts));
	if ($height && !$width) {
		$width = '620';
	}
	if (!$height && $width) { 
		$height = '350';
	}
	if (!$height && !$width){
		$width = '620';
		$height = '350';
	}
	if (!empty($src)){
		return '<div class="video-frame">
		<object width="'. $width .'" height="'. $height .'" type="application/x-shockwave-flash" data="'. $src .'">
			<param name="movie" value="'. $src .'" />
			<param name="allowFullScreen" value="true" />
			<param name="allowscriptaccess" value="always" />
			<param name="expressInstaller" value="'. THEME_DIR .'/swf/expressInstall.swf"/>
			<param name="wmode" value="opaque" />
			<embed src="'. $src .'" type="application/x-shockwave-flash" wmode="opaque" allowscriptaccess="always" allowfullscreen="true" width="'. $width .'" height="'. $height .'" />
		</object>
		</div>';
	}
}

function theme_video_vimeo($atts, $content=null) {
	extract(shortcode_atts(array(
		'id' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
	), $atts));
	if ($height && !$width) {
		$width = '620';
	}
	if (!$height && $width) { 
		$height = '350';
	}
	if (!$height && !$width){
		$width = '620';
		$height = '350';
	}
	if (!empty($id)){
		return "<div class='video-frame'><iframe src='http://player.vimeo.com/video/$id?title=0&amp;byline=0&amp;portrait=0' width='$width' height='$height' frameborder='0'></iframe></div>";
	}
}

function theme_video_youtube($atts, $content=null) {
	extract(shortcode_atts(array(
		'id' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
	), $atts));
	if ($height && !$width) {
		$width = '620';
	}
	if (!$height && $width) { 
		$height = '350';
	}
	if (!$height && !$width){
		$width = '620';
		$height = '350';
	}
	if (!empty($id)){
		return "<div class='video-frame'><iframe src='http://www.youtube.com/embed/$id' width='$width' height='$height' frameborder='0'></iframe></div>";
	}
}

function theme_video_dailymotion($atts, $content=null) {
	extract(shortcode_atts(array(
		'id' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
	), $atts));
	if ($height && !$width) {
		$width = '620';
	}
	if (!$height && $width) { 
		$height = '350';
	}
	if (!$height && !$width){
		$width = '620';
		$height = '350';
	}
	if (!empty($id)){
		return "<div class='video-frame'><iframe src=http://www.dailymotion.com/embed/video/$id?width=$width&theme=none&foreground=%23F7FFFD&highlight=%23FFC300&background=%23171D1B&start=&animatedTitle=&iframe=1&additionalInfos=0&autoPlay=0&hideInfos=0' width='$width' height='$height' frameborder='0'></iframe></div>";
	}
}

?>