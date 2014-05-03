<?php 
/**
 * Include JavaScripts In Header
 */
function theme_enqueue_scripts() {
	if(!is_admin()){
		
		wp_enqueue_script('jquery-cookie', THEME_JS .'/jquery.cookie.js', array('jquery'));
		wp_enqueue_script('jquery-easing', THEME_JS .'/jquery.easing.1.3.js', array('jquery'));
		wp_enqueue_script('jquery-slidemenu', THEME_JS .'/jqueryslidemenu.js', array('jquery'));
		wp_enqueue_script('jquery-quicksand', THEME_JS .'/jquery.quicksand.js', array('jquery'));
		wp_enqueue_script('jquery-tweet', THEME_JS .'/jquery.tweet.js', array('jquery'));
		wp_enqueue_script('jquery-swfobject', THEME_JS .'/jquery.swfobject.1-1-1.min.js');
		wp_enqueue_script('jquery-colorbox', THEME_JS .'/jquery.colorbox-min.js', array('jquery'));
		wp_enqueue_script('jquery-carousel', THEME_JS .'/jquery.carousel-4.5.1.pack.js', array('jquery'));
		wp_enqueue_script('video-js', THEME_JS .'/video.js', array('jquery'));
		wp_enqueue_script('custom', THEME_JS .'/custom.js', array('jquery'));
		wp_enqueue_script('jquery-nivoslider', THEME_JS .'/jquery.nivo.slider.pack.js', array('jquery'));
		wp_enqueue_script('jquery-kwicks', THEME_JS .'/jquery.kwicks-1.5.1.pack.js', array('jquery'));
		wp_enqueue_script('jquery-anythingslider', THEME_JS .'/jquery.anythingslider.min.js', array('jquery'));
		
		if (is_singular() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
add_action('wp_print_scripts', 'theme_enqueue_scripts');
 
?>