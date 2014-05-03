<?php
$options = array(
	array(
		"name" => __("Sidebar","mandrake_theme"),
		"type" => "title"
	),
	array(
		"name" => __("Sidebar","mandrake_theme"),
		"type" => "start"
	),
		array(
			"name" => __("Generate Sidebar","mandrake_theme"),
			"desc" => __("Enter the name of sidebar you'd like to create.","mandrake_theme"),
			"id" => "sidebars",
			"default" => "",
			"type" => "sidebar"
		),
	array(
		"type" => "end"
	),
);

return array (
	'name' => "sidebar",
	'options' => $options
);

?>