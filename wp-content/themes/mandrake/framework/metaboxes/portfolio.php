<?php
$config = array(
	"title" => __("Portfolio Item Options","mandrake_theme"),
	"id" => "portfolio",
	"pages" => array("portfolio"),
	"context" => "normal",
	"priority" => "high"
);
$options = array(
	array(
		"name" => __("Portfolio Type","mandrake_theme"),
		"desc" => __("Select the portfolio type to show portfolio in the lightbox.","mandrake_theme"),
		"id" => "_type",
		"default" => "",
		"options" => array(
			"image" => __("Image","mandrake_theme"),
			"video" => __("Video","mandrake_theme"),
			"document" => __("Document","mandrake_theme"),
		),
		"type" => "select"
	),
	array(
		"name" => __("Fullsize Image for Lightbox (optional)","mandrake_theme"),
		"desc" => __("Insert the full URL of the image. If not assigned, it will use featured image instead.","mandrake_theme"),
		"id" => "_image",
		"default" => "",
		"type" => "text"
	),
	array(
		"name" => __("Video Link for Lightbox (optional)","mandrake_theme"),
		"desc" => __("Insert the full URL of the video (YouTube, Vimeo etc). Only necessary when the portfolio type is video.","mandrake_theme"),
		"id" => "_video",
		"default" => "",
		"type" => "text"
	),
	array(
		"name" => __("Document Link (optional)","mandrake_theme"),
		"desc" => __("Insert the full URL of the document. Only necessary when the portfolio type is document.","mandrake_theme"),
		"id" => "_document",
		"default" => "",
		"type" => "text"
	)
);

new metaboxBuilder($config,$options);

?>