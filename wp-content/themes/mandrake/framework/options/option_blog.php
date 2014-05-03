<?php
$options = array(
	array(
		"name" => __("Blog","mandrake_theme"),
		"type" => "title"
	),
	array(
		"name" => __("General","mandrake_theme"),
		"type" => "start"
	),
		array(
			"name" => __("Layout","mandrake_theme"),
			"desc" => "Select which layout to use on the blog page.",
			"id" => "theme_layout",
			"default" => "right",
			"options" => array(
				"right" => __("Right Sidebar","mandrake_theme"),
				"left" => __("Left Sidebar","mandrake_theme"),
			),
			"type" => "select"
		),
		array(
			"name" => __("Display Meta Data","mandrake_theme"),
			"desc" => "If you don't want a meta data (date, categoty etc.), un-check the button.",
			"id" => "display_meta",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Display Post Tags","mandrake_theme"),
			"desc" => "If you don't want a post tags, un-check the button.",
			"id" => "display_tags",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Display About Author","mandrake_theme"),
			"desc" => "If you don't want a about author box, un-check the button.",
			"id" => "display_author",
			"default" => 1,
			"type" => "toggle"
		),
	array(
		"type" => "end"
	)
);

return array (
	'name' => "blog",
	'options' => $options
);

?>