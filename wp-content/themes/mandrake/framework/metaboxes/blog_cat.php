<?php
$config = array(
	"title" => sprintf(__("%s Blog Options","mandrake_theme"),THEME_NAME),
	"id" => "blog_category",
	"pages" => array("page"),
	"context" => "normal",
	"priority" => "default",
);
$options = array(
	array(
		"name" => __("Blog Category","mandrake_theme"),
		"desc" => __("Select category for blog page template.","mandrake_theme"),
		"id" => "_blog_category",
		"default" => "",
		"type" => "blog_category"
	)
);

new metaboxBuilder($config,$options);

?>