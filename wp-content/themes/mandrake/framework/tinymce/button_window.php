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
	<title>Button</title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
    <link href="<?php echo get_template_directory_uri() ?>/framework/tinymce/tinymce.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/framework/tinymce/tinymce.js"></script>
</head>
<body>
<div class="shortcode-wrapper">
    <form name="shortcode-builder" id="button" action="#">
        <div class="description"><label for="button_url">Button URL</label></div>
        <div class="options">
        	<input type="text" id="button_url" name="button_url" />
        </div>
        
        <div class="description"><label for="button_target">Button Target</label></div>
        <div class="options">
            <select id="button_target" name="button_target">
                <option value="self">Self</option>
                <option value="blank">Blank</option>
            </select>
        </div>
        
        <div class="description"><label for="button_size">Button Size</label></div>
        <div class="options">
            <select id="button_size" name="button_size">
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
            </select>
        </div>
        
        <div class="description"><label for="button_color">Button Color</label></div>
        <div class="options">
            <select id="button_color" name="button_color">
                <option value="white">White</option>
                <option value="gray">Gray</option>
                <option value="green">Green</option>
                <option value="purple">Purple</option>
                <option value="blue">Blue</option>
                <option value="red">Red</option>
                <option value="orange">Orange</option>
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