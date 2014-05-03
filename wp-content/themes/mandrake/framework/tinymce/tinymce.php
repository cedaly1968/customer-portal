<?php
class add_shortcode_button {
	
	var $pluginname = 'shortcode';
	
	function add_shortcode_button() {
		// init process for button control
		add_action('init', array(&$this, 'add_button'));
	}
	
	function add_button() {
		// Don't bother doing this stuff if the current user lacks permissions
		if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
			return;
		}
		// Add only in Rich Editor mode
		if (get_user_option('rich_editing') == 'true') {
			add_filter("mce_external_plugins", array(&$this, 'add_tinymce_plugin'));
			add_filter('mce_buttons_3', array(&$this, 'register_button'));
		}
	}
	
	function register_button($buttons) {	
		array_push($buttons, 'layout', 'divider', 'typography', 'list', 'box', 'table', 'tab', 'button', 'image', 'video', 'widget');
		return $buttons;
	}
	
	// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
	function add_tinymce_plugin($plugin_array) {
		$plugin_array[$this->pluginname] =  get_bloginfo('template_url') .'/framework/tinymce/editor_plugin.js';
		return $plugin_array;
	}
}

$tinymce_button = new add_shortcode_button();
?>
