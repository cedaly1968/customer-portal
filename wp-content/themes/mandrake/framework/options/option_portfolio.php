<?php
$options = array(
	array(
		"name" => __("Portfolio","mandrake_theme"),
		"type" => "title"
	),
	array(
		"name" => __("General","mandrake_theme"),
		"type" => "start"
	),
		array(
			"name" => __("Display Title","mandrake_theme"),
			"desc" => "If you don't want a portfolio title, un-check the button.",
			"id" => "display_title",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Display Description","mandrake_theme"),
			"desc" => "If you don't want a portfolio description, un-check the button.",
			"id" => "display_content",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Display Filter","mandrake_theme"),
			"desc" => "If you don't want a portfolio filter, un-check the button.",
			"id" => "display_filter",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Portfolio Items Count","mandrake_theme"),
			"desc" => __("Insert how many items to show in one portfolio page.","mandrake_theme"),
			"id" => "portfolio_count",
			"default" => "8",
			"type" => "text"
		),
	array(
		"type" => "end"
	)
);

return array (
	'name' => "portfolio",
	'options' => $options
);

?>