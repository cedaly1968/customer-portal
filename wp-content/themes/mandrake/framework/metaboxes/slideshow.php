<?php
$config = array(
	"title" => __("Slideshow Item Options","mandrake_theme"),
	"id" => "slideshow",
	"pages" => array("slideshow"),
	"context" => "normal",
	"priority" => "high"
);
$options = array(
	array(
		"name" => __("URL (optional)","mandrake_theme"),
		"desc" => __("Insert the full URL (include <code>http://</code>) of your slideshow item here.","mandrake_theme"),
		"id" => "_link",
		"default" => "",
		"type" => "text"
	)
);
new metaboxBuilder($config,$options);

?>