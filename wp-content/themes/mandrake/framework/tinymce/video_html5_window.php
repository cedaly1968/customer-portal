<?php
// Load wp-load.php
require_once('../../../../../wp-load.php');
// Check for rights
if (!is_user_logged_in() || !current_user_can('edit_posts')) {
	wp_die(__("You are not allowed to be here"));
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>HTML5 Video</title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
    <link href="<?php echo get_template_directory_uri() ?>/framework/tinymce/tinymce.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/framework/tinymce/tinymce.js"></script>
</head>
<body>
<div class="shortcode-wrapper">
    <form name="shortcode-builder" id="video_html5" action="#">
        
        <div class="description"><label for="video_mp4">MP4 Video URL</label></div>
        <div class="options">
        	<input type="text" id="video_mp4" name="video_mp4" />
        </div>
        
        <div class="description"><label for="video_webm">WEBM Video URL</label></div>
        <div class="options">
        	<input type="text" id="video_webm" name="video_webm" />
        </div>
        
        <div class="description"><label for="video_ogg">OGG Video URL</label></div>
        <div class="options">
        	<input type="text" id="video_ogg" name="video_ogg" />
        </div>
        
        <div class="description"><label for="video_poster">Video Poster URL</label></div>
        <div class="options">
        	<input type="text" id="video_poster" name="video_poster" />
        </div>
        
        <div class="description"><label for="video_preload">Video Preload</label></div>
        <div class="options">
            <select id="video_preload" name="video_preload">
            	<option value="true">True</option>
                <option value="false">False</option>
            </select>
        </div>
        
        <div class="description"><label for="video_autoplay">Video Autoplay</label></div>
        <div class="options">
            <select id="video_autoplay" name="video_autoplay">
            	<option value="true">True</option>
                <option value="false">False</option>
            </select>
        </div>
        
        <div class="description"><label for="video_height">Video Height</label> (optional)</div>
        <div class="options">
            <input type="text" id="video_height" name="video_height" />
        </div>
        
        <div class="description"><label for="video_width">Video Width</label> (optional)</div>
        <div class="options">
            <input type="text" id="video_width" name="video_width" />
        </div>

        <div class="buttons">
            <div class="left"><input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();" /></div>
            <div class="right"><input type="submit" id="insert" name="insert" value="Insert" onClick="insertShortcode();" /></div>
        </div>
    </form>
</div>
</body>
</html>