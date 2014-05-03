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
	<title>Contact Info</title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
    <link href="<?php echo get_template_directory_uri() ?>/framework/tinymce/tinymce.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/framework/tinymce/tinymce.js"></script>
</head>
<body>
<div class="shortcode-wrapper">
    <form name="shortcode-builder" id="contact_info" action="#">
    
    	<div class="description"><label for="contact_name">Contact Name</label> (optional)</div>
        <div class="options">
        	<input type="text" id="contact_name" name="contact_name" />
        </div>
        
        <div class="description"><label for="contact_phone">Contact Phone</label> (optional)</div>
        <div class="options">
        	<input type="text" id="contact_phone" name="contact_phone" />
        </div>
        
        <div class="description"><label for="contact_cellphone">Contact Cellphone</label> (optional)</div>
        <div class="options">
        	<input type="text" id="contact_cellphone" name="contact_cellphone" />
        </div>
        
        <div class="description"><label for="contact_email">Contact Email</label> (optional)</div>
        <div class="options">
        	<input type="text" id="contact_email" name="contact_email" />
        </div>
        
        <div class="description"><label for="contact_address">Contact Address</label> (optional)</div>
        <div class="options">
        	<input type="text" id="contact_address" name="contact_address" />
        </div>

        <div class="buttons">
            <div class="left"><input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();" /></div>
            <div class="right"><input type="submit" id="insert" name="insert" value="Insert" onClick="insertShortcode();" /></div>
        </div>
    </form>
</div>
</body>
</html>