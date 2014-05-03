<?php
$config = array(
	"title" => sprintf(__("%s Portfolio Options","mandrake_theme"),THEME_NAME),
	"id" => "portfolio_category",
	"pages" => array("page"),
	"context" => "normal",
	"priority" => "default",
);
$options = array(
	array(
		"name" => __("Portfolio Category","mandrake_theme"),
		"desc" => __("Select category for portfolio page template.","mandrake_theme"),
		"id" => "_portfolio_category",
		"default" => "",
		"type" => "portfolio_category"
	)
);

new metaboxBuilder($config,$options);

?>