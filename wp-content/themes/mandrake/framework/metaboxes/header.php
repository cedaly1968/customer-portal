<?php
$config = array(
	"title" => sprintf(__("%s Header Options","mandrake_theme"),THEME_NAME),
	"id" => "header",
	"pages" => array("post","page"),
	"context" => "normal",
	"priority" => "high",
);
$options = array(
	array(
		"name" => __("Header Introduce Type","mandrake_theme"),
		"desc" => __("Select which introduce text type to use on the header.","mandrake_theme"),
		"id" => "_introduce_text_type",
		"options" => array(
			"title" => "Title",
			"custom" => "Custom text",
			"disable" => "Disable",
		),
		"default" => "title",
		"type" => "radio"
	),
	array(
		"name" => __("Custom Header Introduce Text","mandrake_theme"),
		"desc" => __("If the 'custom text' option is selected any text you enter here will override your custom header text.","mandrake_theme"),
		"id" => "_custom_introduce_text",
		"default" => "",
		"type" => "textarea"		
	)
);

new metaboxBuilder($config,$options);

?>