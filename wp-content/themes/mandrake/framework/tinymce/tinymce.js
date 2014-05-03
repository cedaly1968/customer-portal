function insertShortcode() {
	
	var shortcodeText;
	
	// Blockquote
	if (document.getElementById('blockquote')) {
		var blockquote_align = document.getElementById('blockquote_align').value;
		var blockquote_cite = document.getElementById('blockquote_cite').value;
		if (blockquote_align != '0') { blockquote_align = ' align="'+ blockquote_align +'"'; } else { blockquote_align = ''; }
		if (blockquote_cite != '') { blockquote_cite = ' cite="'+ blockquote_cite +'"'; } else { blockquote_cite = ''; }
		shortcodeText = '[blockquote'+ blockquote_align + blockquote_cite +']Insert your text here[/blockquote]';
	}
	
	// Button
	if (document.getElementById('button')) {
		var button_url = document.getElementById('button_url').value;
		var button_size = document.getElementById('button_size').value;
		var button_color = document.getElementById('button_color').value;
		var button_target = document.getElementById('button_target').value;
		if (button_url != '') { button_url = ' link="'+ button_url +'"'; } else { button_url = ''; }
		shortcodeText = '[button'+ button_url +' size="'+ button_size +'" color="'+ button_color +'" target="'+ button_target +'"]Button title[/button]';
	}
	
	// Button More
	if (document.getElementById('button_more')) {
		var button_url = document.getElementById('button_url').value;
		var button_target = document.getElementById('button_target').value;
		if (button_url != '') { button_url = ' link="'+ button_url +'"'; } else { button_url = ''; }	
		shortcodeText = '[button_more'+ button_url +' target="'+ button_target +'"]Button title[/button_more]';
	}
	
	// Image
	if (document.getElementById('image')) {
		var image_size = document.getElementById('image_size').value;
		var image_title = document.getElementById('image_title').value;
		var image_url = document.getElementById('image_url').value;
		var image_icon = document.getElementById('image_icon').value;
		var image_lightbox = document.getElementById('image_lightbox').value;
		var image_group = document.getElementById('image_group').value;
		var image_align = document.getElementById('image_align').value;
		if (image_title != '') { image_title = ' title="'+ image_title +'"'; } else { image_title = ''; }
		if (image_url != '') { image_url = ' link="'+ image_url +'"'; } else { image_url = ''; }
		if (image_icon != '0') { image_icon = ' icon="'+ image_icon +'"'; } else { image_icon = ''; }
		if (image_lightbox != '0') { image_lightbox = ' lightbox="'+ image_lightbox +'"'; } else { image_lightbox = ''; }
		if (image_group != '') { image_group = ' group="'+ image_group +'"'; } else { image_group = ''; }
		if (image_align != '0') { image_align = ' align="'+ image_align +'"'; } else { image_align = ''; }
		shortcodeText = '[image size="'+ image_size +'"'+ image_title + image_url + image_icon + image_lightbox + image_group + image_align +']Your image url[/image]';
	}
	
	// Frame Image
	if (document.getElementById('frame_image')) {
		var image_title = document.getElementById('image_title').value;
		var image_align = document.getElementById('image_align').value;
		if (image_title != '') { image_title = ' title="'+ image_title +'"'; } else { image_title = ''; }
		if (image_align != '0') { image_align = ' align="'+ image_align +'"'; } else { image_align = ''; }
		shortcodeText = '[image_frame'+ image_title + image_align +']Your image url[/image_frame]';
	}
	
	// HTML5 Video
	if (document.getElementById('video_html5')) {
		var video_mp4 = document.getElementById('video_mp4').value;
		var video_webm = document.getElementById('video_webm').value;
		var video_ogg = document.getElementById('video_ogg').value;
		var video_poster = document.getElementById('video_poster').value;
		var video_preload = document.getElementById('video_preload').value;
		var video_autoplay = document.getElementById('video_autoplay').value;
		var video_height = document.getElementById('video_height').value;
		var video_width = document.getElementById('video_width').value;
		if (video_mp4 != '') { video_mp4 = ' mp4="'+ video_mp4 +'"'; } else { video_mp4 = ''; }
		if (video_webm != '') { video_webm = ' webm="'+ video_webm +'"'; } else { video_webm = ''; }
		if (video_ogg != '') { video_ogg = ' ogg="'+ video_ogg +'"'; } else { video_ogg = ''; }
		if (video_poster != '') { video_poster = ' poster="'+ video_poster +'"'; } else { video_poster = ''; }
		if (video_preload != 'false') { video_preload = ' preload="'+ video_preload +'"'; } else { video_preload = ''; }
		if (video_autoplay != 'false') { video_autoplay = ' autoplay="'+ video_autoplay +'"'; } else { video_autoplay = ''; }
		if (video_height != '') { video_height = ' height="'+ video_height +'"'; } else { video_height = ''; }
		if (video_width != '') { video_width = ' width="'+ video_width +'"'; } else { video_width = ''; }
		shortcodeText = '[video type="html5"'+ video_mp4 + video_webm + video_ogg + video_poster + video_preload + video_autoplay + video_height + video_width +'/]';
	}
	
	// Flash Video
	if (document.getElementById('video_flash')) {
		var video_src = document.getElementById('video_src').value;
		var video_height = document.getElementById('video_height').value;
		var video_width = document.getElementById('video_width').value;
		if (video_src != '') { video_src = ' src="'+ video_src +'"'; } else { video_src = ''; }
		if (video_height != '') { video_height = ' height="'+ video_height +'"'; } else { video_height = ''; }
		if (video_width != '') { video_width = ' width="'+ video_width +'"'; } else { video_width = ''; }
		shortcodeText = '[video type="flash"'+ video_src + video_height + video_width +'/]';
	}
	
	// Youtube Video
	if (document.getElementById('video_youtube')) {
		var video_id = document.getElementById('video_id').value;
		var video_height = document.getElementById('video_height').value;
		var video_width = document.getElementById('video_width').value;
		if (video_id != '') { video_id = ' id="'+ video_id +'"'; } else { video_id = ''; }
		if (video_height != '') { video_height = ' height="'+ video_height +'"'; } else { video_height = ''; }
		if (video_width != '') { video_width = ' width="'+ video_width +'"'; } else { video_width = ''; }
		shortcodeText = '[video type="youtube"'+ video_id + video_height + video_width +'/]';
	}
	
	// Vimeo Video
	if (document.getElementById('video_vimeo')) {
		var video_id = document.getElementById('video_id').value;
		var video_height = document.getElementById('video_height').value;
		var video_width = document.getElementById('video_width').value;
		if (video_id != '') { video_id = ' id="'+ video_id +'"'; } else { video_id = ''; }
		if (video_height != '') { video_height = ' height="'+ video_height +'"'; } else { video_height = ''; }
		if (video_width != '') { video_width = ' width="'+ video_width +'"'; } else { video_width = ''; }
		shortcodeText = '[video type="vimeo"'+ video_id + video_height + video_width +'/]';
	}
	
	// Dailymotion Video
	if (document.getElementById('video_dailymotion')) {
		var video_id = document.getElementById('video_id').value;
		var video_height = document.getElementById('video_height').value;
		var video_width = document.getElementById('video_width').value;
		if (video_id != '') { video_id = ' id="'+ video_id +'"'; } else { video_id = ''; }
		if (video_height != '') { video_height = ' height="'+ video_height +'"'; } else { video_height = ''; }
		if (video_width != '') { video_width = ' width="'+ video_width +'"'; } else { video_width = ''; }
		shortcodeText = '[video type="dailymotion"'+ video_id + video_height + video_width +'/]';
	}
	
	// Contact Form
	if (document.getElementById('contact_form')) {
		var contact_email = document.getElementById('contact_email').value;
		if (contact_email != '') { contact_email = ' email="'+ contact_email +'"'; } else { contact_email = ''; }
		shortcodeText = '[contact_form'+ contact_email +'/]';
	}
	
	// Contact Info
	if (document.getElementById('contact_info')) {
		var contact_name = document.getElementById('contact_name').value;
		var contact_phone = document.getElementById('contact_phone').value;
		var contact_cellphone = document.getElementById('contact_cellphone').value;
		var contact_email = document.getElementById('contact_email').value;
		var contact_address = document.getElementById('contact_address').value;
		if (contact_name != '') { contact_name = ' name="'+ contact_name +'"'; } else { contact_name = ''; }
		if (contact_phone != '') { contact_phone = ' phone="'+ contact_phone +'"'; } else { contact_phone = ''; }
		if (contact_cellphone != '') { contact_cellphone = ' cellphone="'+ contact_cellphone +'"'; } else { contact_cellphone = ''; }
		if (contact_email != '') { contact_email = ' email="'+ contact_email +'"'; } else { contact_email = ''; }
		if (contact_address != '') { contact_address = ' address="'+ contact_address +'"'; } else { contact_address = ''; }
		shortcodeText = '[contact_info'+ contact_name + contact_phone + contact_cellphone + contact_email + contact_address +'/]';
	}
	
	if(window.tinyMCE) {
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, shortcodeText);
		tinyMCEPopup.close();
	}
	return;
}
