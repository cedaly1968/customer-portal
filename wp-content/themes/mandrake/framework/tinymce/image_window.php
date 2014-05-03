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
	<title>Image</title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
    <link href="<?php echo get_template_directory_uri() ?>/framework/tinymce/tinymce.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/framework/tinymce/tinymce.js"></script>
</head>
<body>
<div class="shortcode-wrapper">
    <form name="shortcode-builder" id="image" action="#">
    
        <div class="description"><label for="image_size">Image Size</label></div>
        <div class="options">
            <select id="image_size" name="image_size">
                <option value="thumb">Thumbnail</option>
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
            </select>
        </div>
        
        <div class="description"><label for="image_title">Image Title</label> (optional)</div>
        <div class="options">
        	<input type="text" id="image_title" name="image_title" />
        </div>

        <div class="description"><label for="image_url">Image URL</label> (optional)</div>
        <div class="options">
        	<input type="text" id="image_url" name="image_url" />
        </div>
        
        <div class="description"><label for="image_icon">Image Icon</label> (optional)</div>
        <div class="options">
            <select id="image_icon" name="image_icon">
            	<option value="0">None</option>
                <option value="image">Image</option>
                <option value="video">Video</option>
                <option value="document">Document</option>
            </select>
        </div>
        
        <div class="description"><label for="image_lightbox">Lightbox</label> (optional)</div>
        <div class="options">
            <select id="image_lightbox" name="image_lightbox">
                <option value="0">None</option>
                <option value="lightbox">Lightbox Image</option>
                <option value="videobox">Lightbox Video</option>
            </select>
        </div>
        
        <div class="description"><label for="image_group">Lightbox Group</label> (optional)</div>
        <div class="options">
        	<input type="text" id="image_group" name="image_group" />
        </div>
        
        <div class="description"><label for="image_align">Image position</label> (optional)</div>
        <div class="options">
            <select id="image_align" name="image_align">
                <option value="0">None</option>
                <option value="left">Left</option>
                <option value="right">Right</option>
                <option value="center">Center</option>
            </select>
        </div>

        <div class="buttons">
            <div class="left"><input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();" /></div>
            <div class="right"><input type="submit" id="insert" name="insert" value="Insert" onClick="insertShortcode();" /></div>
        </div>
    </form>
</div>
</body>
</html>