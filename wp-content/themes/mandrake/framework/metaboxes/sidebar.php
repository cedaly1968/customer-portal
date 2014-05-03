<?php
$config = array(
	"title" => sprintf(__("%s Sidebar Options","mandrake_theme"),THEME_NAME),
	"id" => "sidebar",
	"pages" => array("page"),
	"context" => "normal",
	"priority" => "default",
);
function get_sidebar_options(){
	$sidebars = theme_get_option("sidebar","sidebars");
	if(!empty($sidebars)){
		$sidebars_array = explode(",",$sidebars);
		$options = array();
		foreach ($sidebars_array as $sidebar){
			$options[$sidebar] = $sidebar;
		}
		return $options;
	}else{
		return array();
	}
};
$options = array(
	array(
		"name" => __("Custom Sidebar","mandrake_theme"),
		"desc" => __("Select the custom sidebar that you'd like to be display.","mandrake_theme"),
		"id" => "_sidebar",
		"default" => "",
		"options" => get_sidebar_options(),
		"type" => "select"
	)
);

new metaboxBuilder($config,$options);

?>