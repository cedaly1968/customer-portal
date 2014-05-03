<?php 
//Make it a JavaScript file
header("Content-type: text/javascript");
if(file_exists('../../../../wp-load.php')) {
	include '../../../../wp-load.php';
}
else {
	include '../../../../../wp-load.php';
}
?>

/*-------------------------------------------------*/
/*	Post Formats
/*-------------------------------------------------*/
jQuery(document).ready(function() {
	
	/*--- All Post Formats Meta Boxes ---*/
	var all_meta_boxes = jQuery('#ml_single_image_gallery, #ml_single_link, #ml_single_quote, #ml_single_chat, #ml_single_video, #ml_single_audio');
	
	/* On Change... */
	jQuery('#post-formats-select input').change(function(){

		/*--- Aside ---*/
		if(jQuery(this).val() == 'aside') {
			all_meta_boxes.fadeOut(500);
		}
		
		/*--- Gallery ---*/
		else if(jQuery(this).val() == 'gallery') {
			all_meta_boxes.hide();
			jQuery('#ml_single_image_gallery').fadeIn(400);
		}
		
		/*--- Link ---*/
		else if(jQuery(this).val() == 'link') {
			all_meta_boxes.hide();
			jQuery('#ml_single_link').fadeIn(400);
		}
		
		/*--- Image ---*/
		else if(jQuery(this).val() == 'image') {
			all_meta_boxes.fadeOut(500);
		}
		
		/*--- Quote ---*/
		else if(jQuery(this).val() == 'quote') {
			all_meta_boxes.hide();
			jQuery('#ml_single_quote').fadeIn(400);
		}
		
		/*--- Status ---*/
		else if(jQuery(this).val() == 'status') {
			all_meta_boxes.fadeOut(500);
		}
		
		/*--- Video ---*/
		else if(jQuery(this).val() == 'video') {
			all_meta_boxes.hide();
			jQuery('#ml_single_video').fadeIn(400);
		}
		
		/*--- Audio ---*/
		else if(jQuery(this).val() == 'audio') {
			all_meta_boxes.hide();
			jQuery('#ml_single_audio').fadeIn(400);
		}
		
		/*--- Chat ---*/
		else if(jQuery(this).val() == 'chat') {
			all_meta_boxes.hide();
			jQuery('#ml_single_chat').fadeIn(400);
		}
		
		/*--- Standard ---*/
		else {
			all_meta_boxes.fadeOut(500);
		}
	});
	
	/* Show everything... */
	jQuery('#ml_single_image_gallery, #ml_single_link, #ml_single_quote, #ml_single_chat, #ml_single_video, #ml_single_audio').show();

	/* ...and hide, based on the option */
	if(jQuery('#post-format-aside').is(':checked')) {
		jQuery('#ml_single_image_gallery, #ml_single_link, #ml_single_quote, #ml_single_chat, #ml_single_video, #ml_single_audio').hide();
	}
	else if(jQuery('#post-format-gallery').is(':checked')) {
		jQuery('#ml_single_link, #ml_single_quote, #ml_single_chat, #ml_single_video, #ml_single_audio').hide();
	}
	else if(jQuery('#post-format-link').is(':checked')) {
		jQuery('#ml_single_image_gallery, #ml_single_quote, #ml_single_chat, #ml_single_video, #ml_single_audio').hide();
	}
	else if(jQuery('#post-format-image').is(':checked')) {
		jQuery('#ml_single_image_gallery, #ml_single_link, #ml_single_quote, #ml_single_chat, #ml_single_video, #ml_single_audio').hide();
	}
	else if(jQuery('#post-format-quote').is(':checked')) {
		jQuery('#ml_single_image_gallery, #ml_single_link, #ml_single_chat, #ml_single_video, #ml_single_audio').hide();
	}
	else if(jQuery('#post-format-status').is(':checked')) {
		jQuery('#ml_single_image_gallery, #ml_single_link, #ml_single_quote, #ml_single_chat, #ml_single_video, #ml_single_audio').hide();
	}
	else if(jQuery('#post-format-video').is(':checked')) {
		jQuery('#ml_single_image_gallery, #ml_single_link, #ml_single_quote, #ml_single_chat, #ml_single_audio').hide();
	}
	else if(jQuery('#post-format-audio').is(':checked')) {
		jQuery('#ml_single_image_gallery, #ml_single_link, #ml_single_quote, #ml_single_chat, #ml_single_video').hide();
	}
	else if(jQuery('#post-format-chat').is(':checked')) {
		jQuery('#ml_single_image_gallery, #ml_single_link, #ml_single_quote, #ml_single_video, #ml_single_audio').hide();
	}
	else {
		jQuery('#ml_single_image_gallery, #ml_single_link, #ml_single_quote, #ml_single_chat, #ml_single_video, #ml_single_audio').hide();
	}
	
	
	
	


	jQuery('#ml_fc_featured_content').change(function() {
		if(jQuery(this).val() == 'lightbox_image') {
			jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_embedded_video_poster, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').fadeOut(500);
		}
		if(jQuery(this).val() == 'lightbox_youtube') {
			jQuery('#tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_embedded_video_poster, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
			jQuery('#tr-ml_fc_lightbox_youtube').fadeIn(400);
		}
		if(jQuery(this).val() == 'lightbox_vimeo') {
			jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
			jQuery('#tr-ml_fc_lightbox_vimeo, #tr-ml_fc_embedded_video_poster').fadeIn(400);
		}
		if(jQuery(this).val() == 'lightbox_mov') {
			jQuery('#tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
			jQuery('#tr-ml_fc_lightbox_mov, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_video_poster').fadeIn(400);
		}
		if(jQuery(this).val() == 'lightbox_swf') {
			jQuery('#tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_mov, #tr-ml_fc_html_content, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
			jQuery('#tr-ml_fc_lightbox_swf, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_video_poster').fadeIn(400);
		}
		if(jQuery(this).val() == 'lightbox_html') {
			jQuery('#tr-ml_fc_lightbox_swf, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_mov, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
			jQuery('#tr-ml_fc_html_content, #tr-ml_fc_embedded_video_poster').fadeIn(400);
		}
		if(jQuery(this).val() == 'embedded_audio') {
			jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_embedded_video_poster, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
			jQuery('#tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga').fadeIn(400);
		}
		if(jQuery(this).val() == 'embedded_video') {
			jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
			jQuery('#tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_embedded_video_poster, #tr-ml_fc_featured_content_height').fadeIn(400);
		}
		if(jQuery(this).val() == 'embedded_html') {
			jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
			jQuery('#tr-ml_fc_html_content, #tr-ml_fc_embedded_video_poster').fadeIn(400);
		}
		if(jQuery(this).val() == 'slider') {
			jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_embedded_video_poster').hide();
			jQuery('#tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').fadeIn(400);
		}
	});


	if(jQuery('#ml_fc_featured_content option:selected').val() == 'lightbox_image') {
		jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_embedded_video_poster, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'lightbox_youtube') {
		jQuery('#tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_embedded_video_poster, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'lightbox_vimeo') {
		jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'lightbox_mov') {
		jQuery('#tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'lightbox_swf') {
		jQuery('#tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_mov, #tr-ml_fc_html_content, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'lightbox_html') {
		jQuery('#tr-ml_fc_lightbox_swf, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_mov, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'embedded_audio') {
		jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_embedded_video_poster, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'embedded_video') {
		jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'embedded_html') {
		jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_image_slider_1, #tr-ml_fc_image_slider_2, #tr-ml_fc_image_slider_3, #tr-ml_fc_image_slider_4, #tr-ml_fc_image_slider_5, #tr-ml_fc_image_slider_6, #tr-ml_fc_image_slider_7, #tr-ml_fc_image_slider_8, #tr-ml_fc_image_slider_9, #tr-ml_fc_image_slider_10,#tr-ml_fc_image_slider_1_title, #tr-ml_fc_image_slider_2_title, #tr-ml_fc_image_slider_3_title, #tr-ml_fc_image_slider_4_title, #tr-ml_fc_image_slider_5_title, #tr-ml_fc_image_slider_6_title, #tr-ml_fc_image_slider_7_title, #tr-ml_fc_image_slider_8_title, #tr-ml_fc_image_slider_9_title, #tr-ml_fc_image_slider_10_title,#tr-ml_fc_image_slider_1_caption, #tr-ml_fc_image_slider_2_caption, #tr-ml_fc_image_slider_3_caption, #tr-ml_fc_image_slider_4_caption, #tr-ml_fc_image_slider_5_caption, #tr-ml_fc_image_slider_6_caption, #tr-ml_fc_image_slider_7_caption, #tr-ml_fc_image_slider_8_caption, #tr-ml_fc_image_slider_9_caption, #tr-ml_fc_image_slider_10_caption').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'slider') {
		jQuery('#tr-ml_fc_lightbox_youtube, #tr-ml_fc_lightbox_vimeo, #tr-ml_fc_lightbox_mov, #tr-ml_fc_lightbox_swf, #tr-ml_fc_html_content, #tr-ml_fc_featured_content_width, #tr-ml_fc_featured_content_height, #tr-ml_fc_embedded_audio_mp3, #tr-ml_fc_embedded_audio_oga, #tr-ml_fc_embedded_video_m4v, #tr-ml_fc_embedded_video_ogv, #tr-ml_fc_embedded_video_poster').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'fullscreen_bg'){
		jQuery('#tr-ml_pattern_bg').hide();
	}
	if(jQuery('#ml_fc_featured_content option:selected').val() == 'pattern_bg'){
		jQuery('#tr-ml_fullscreen_bg').hide();
	}
});
